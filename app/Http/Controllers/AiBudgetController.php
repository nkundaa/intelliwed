<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\AiBudgetService;
use Illuminate\Http\Request;

class AiBudgetController extends Controller
{
    protected $aiBudgetService;

    public function __construct(AiBudgetService $aiBudgetService)
    {
        $this->aiBudgetService = $aiBudgetService;
    }

    public function index()
    {
        return view('ai.budget-optimizer');
    }

    public function optimize(Request $request)
    {
        $request->validate([
            'total_budget' => 'required|numeric|min:100000',
            'priorities'   => 'nullable|array',
        ]);

        $optimizedBudget = $this->aiBudgetService->optimize(
            (float) $request->total_budget,
            $request->priorities ?? []
        );

        return response()->json(['success' => true, 'budget' => $optimizedBudget]);
    }

    public function planner()
    {
        return view('ai.wedding-planner');
    }

    public function planSuggest(Request $request)
    {
        $request->validate([
            'total_budget' => 'required|numeric|min:100000',
            'priorities'   => 'nullable|array',
        ]);

        $totalBudget = (float) $request->total_budget;
        $allocation  = $this->aiBudgetService->optimize($totalBudget, $request->priorities ?? []);

        $categoryMap = [
            'Venue & Catering'        => ['venue', 'catering'],
            'Attire & Beauty'         => ['attire'],
            'Photography & Video'     => ['photography'],
            'Decoration'              => ['decor'],
            'Entertainment'           => ['music'],
            'Invitations & Logistics' => ['invitations', 'transport'],
            'Emergency Fund'          => [],
        ];

        $result = [];
        foreach ($allocation as $item) {
            $dbCategories = $categoryMap[$item['category']] ?? [];
            $services = [];

            if (!empty($dbCategories)) {
                $services = Service::whereIn('category', $dbCategories)
                    ->where('status', 'active')
                    ->where('price', '<=', $item['amount'] * 1.15)
                    ->orderByRaw('ABS(price - ?) ASC', [$item['amount']])
                    ->with('vendor:id,business_name,is_verified')
                    ->limit(6)
                    ->get(['id', 'title', 'category', 'price', 'main_image', 'vendor_id'])
                    ->map(fn($s) => [
                        'id'          => $s->id,
                        'title'       => $s->title,
                        'category'    => $s->category,
                        'price'       => (int) $s->price,
                        'main_image'  => $s->main_image,
                        'vendor_name' => $s->vendor->business_name ?? 'Vendor',
                        'is_verified' => (bool) ($s->vendor->is_verified ?? false),
                    ])
                    ->values()
                    ->toArray();
            }

            $result[] = array_merge($item, ['services' => $services]);
        }

        return response()->json(['success' => true, 'plan' => $result]);
    }
}
