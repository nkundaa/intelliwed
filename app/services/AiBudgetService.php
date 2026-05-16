<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AiBudgetService
{
    /**
     * Categorizes and optimizes the budget based on the total amount and priorities.
     */
    public function optimize(float $totalBudget, array $priorities = [])
    {
        // Allocation percentages based on typical Rwandan wedding costs
        // Adjusted by priorities if provided
        $baseAllocation = [
            'Venue & Catering' => 0.45,
            'Attire & Beauty' => 0.15,
            'Photography & Video' => 0.10,
            'Decoration' => 0.12,
            'Entertainment' => 0.08,
            'Invitations & Logistics' => 0.05,
            'Emergency Fund' => 0.05,
        ];

        // Apply priorities (e.g., if Photography is high priority, increase its share)
        if (!empty($priorities)) {
            foreach ($priorities as $category => $weight) {
                // simple weight adjustment logic
                if (isset($baseAllocation[$category])) {
                    if ($weight == 'high') {
                        $baseAllocation[$category] *= 1.3;
                    } elseif ($weight == 'low') {
                        $baseAllocation[$category] *= 0.7;
                    }
                }
            }
            
            // Normalize back to 1.0
            $totalWeight = array_sum($baseAllocation);
            foreach ($baseAllocation as $category => $weight) {
                $baseAllocation[$category] = $weight / $totalWeight;
            }
        }

        $optimizedBudget = [];
        foreach ($baseAllocation as $category => $percentage) {
            $amount = $totalBudget * $percentage;
            $optimizedBudget[] = [
                'category' => $category,
                'percentage' => round($percentage * 100, 1),
                'amount' => round($amount, -3), // Round to nearest 1000 RWF
                'tips' => $this->getTipsForCategory($category, $amount),
            ];
        }

        return $optimizedBudget;
    }

    private function getTipsForCategory($category, $amount)
    {
        $tips = [
            'Venue & Catering' => [
                'Consider hotels in non-prime areas for better rates.',
                'Buffet style is usually more cost-effective than plated service.',
            ],
            'Photography & Video' => [
                'Book a package that includes both for a discount.',
                'Ask for a smaller digital-only package if physical albums are too expensive.',
            ],
            'Decoration' => [
                'In-season flowers can save you up to 30%.',
                'Minimalist lighting can create a premium feel without high costs.',
            ],
            'Entertainment' => [
                'A versatile DJ can often handle both ceremony and reception.',
            ],
        ];

        return $tips[$category] ?? ['Monitor your spending closely in this category.'];
    }
}
