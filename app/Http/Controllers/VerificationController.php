<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use App\Services\VendorVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    protected $verificationService;

    public function __construct(VendorVerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user->isVendor()) {
            abort(403);
        }

        $vendor = $user->vendor;
        $requests = $vendor->verificationRequests()->latest()->get();
        $badges = $vendor->badges;

        return view('verification.index', compact('vendor', 'requests', 'badges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'business_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'portfolio_link' => 'nullable|url|max:255',
            'physical_address' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'reference_contact' => 'nullable|string|max:255',
        ]);

        $vendor = Auth::user()->vendor;
        
        // Prevent multiple pending requests
        if ($vendor->verificationRequests()->where('status', 'pending')->exists()) {
            return redirect()->back()->with('error', 'You already have a pending verification request.');
        }

        $this->verificationService->submitRequest($vendor, $request->all());

        return redirect()->back()->with('success', 'Detailed verification request submitted successfully.');
    }

    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $requests = VerificationRequest::with('vendor.user')->where('status', 'pending')->latest()->get();

        return view('verification.admin-review', compact('requests'));
    }

    public function adminReview(Request $request, VerificationRequest $verificationRequest)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $this->verificationService->processReview($verificationRequest, $request->status, $request->admin_note);

        return redirect()->back()->with('success', 'Request processed successfully.');
    }
}
