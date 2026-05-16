<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\VerificationRequest;
use App\Models\VendorBadge;
use Illuminate\Support\Facades\Storage;

class VendorVerificationService
{
    public function submitRequest(Vendor $vendor, array $data)
    {
        $idPath = $data['id_document']->store('verifications', 'public');
        $licensePath = isset($data['business_license']) ? $data['business_license']->store('verifications', 'public') : null;

        return VerificationRequest::create([
            'vendor_id' => $vendor->id,
            'id_document_path' => $idPath,
            'business_license_path' => $licensePath,
            'portfolio_link' => $data['portfolio_link'] ?? null,
            'physical_address' => $data['physical_address'] ?? null,
            'years_experience' => $data['years_experience'] ?? null,
            'reference_contact' => $data['reference_contact'] ?? null,
            'status' => 'pending',
        ]);
    }

    public function processReview(VerificationRequest $request, string $status, ?string $note = null)
    {
        $request->update([
            'status' => $status,
            'admin_note' => $note,
            'reviewed_at' => now(),
        ]);

        if ($status === 'approved') {
            $this->awardBadge($request->vendor, 'verified');
        }

        return $request;
    }

    public function awardBadge(Vendor $vendor, string $badgeType)
    {
        return VendorBadge::firstOrCreate([
            'vendor_id' => $vendor->id,
            'badge_type' => $badgeType,
        ], [
            'awarded_at' => now(),
        ]);
    }

    public function evaluatePerformanceBadges(Vendor $vendor)
    {
        // Example logic for "Top Rated"
        // In a real app, you'd check reviews/ratings here.
        // For now, let's say if they have > 5 bookings they get "Trusted"
        $bookingCount = $vendor->total_bookings;
        
        if ($bookingCount >= 5) {
            $this->awardBadge($vendor, 'trusted');
        }

        // Add more logic for fast responder etc.
    }
}
