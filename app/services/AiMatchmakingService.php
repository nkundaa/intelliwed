<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class AiMatchmakingService
{
    /**
     * Matches vendors based on user preferences and budget.
     */
    public function match(array $preferences)
    {
        $query = Service::query()->where('status', 'active')->with('vendor.badges');

        // Budget matching
        if (isset($preferences['budget'])) {
            $maxBudget = (float) $preferences['budget'];
            // Allow 10% flexibility
            $query->where('price', '<=', $maxBudget * 1.1);
        }

        // Category matching
        if (isset($preferences['categories']) && !empty($preferences['categories'])) {
            $query->whereIn('category', $preferences['categories']);
        }

        // Fetch services
        $services = $query->get();

        // Calculate match score for each
        $matches = $services->map(function ($service) use ($preferences) {
            $score = 0;

            // Base score: 50
            $score += 50;

            // Vendor verification bonus
            if ($service->vendor->is_verified) {
                $score += 20;
            }

            // Top rated badge bonus
            if ($service->vendor->badges->where('badge_type', 'top_rated')->isNotEmpty()) {
                $score += 15;
            }

            // Price proximity (closer to budget target is better, but under is best)
            if (isset($preferences['budget'])) {
                $diff = abs($service->price - $preferences['budget']);
                $proximityBonus = max(0, 15 - ($diff / $preferences['budget'] * 50));
                $score += $proximityBonus;
            }

            $service->match_score = min(100, round($score));
            return $service;
        });

        return $matches->sortByDesc('match_score')->values();
    }
}
