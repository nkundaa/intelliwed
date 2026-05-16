<?php

namespace App\Services;

use App\Models\Service;
use App\Models\BudgetPlan;
use Illuminate\Support\Facades\DB;

class BudgetPlannerService
{
    // Service categories and their typical price ranges
    protected $serviceCategories = [
        'venue' => ['min' => 1000000, 'max' => 10000000, 'priority' => 1, 'name' => 'Venue'],
        'catering' => ['min' => 500000, 'max' => 5000000, 'priority' => 2, 'name' => 'Catering'],
        'photography' => ['min' => 500000, 'max' => 3000000, 'priority' => 3, 'name' => 'Photography'],
        'decoration' => ['min' => 300000, 'max' => 2000000, 'priority' => 4, 'name' => 'Decoration'],
        'music' => ['min' => 200000, 'max' => 1500000, 'priority' => 5, 'name' => 'Music/Entertainment'],
        'attire' => ['min' => 200000, 'max' => 2000000, 'priority' => 6, 'name' => 'Wedding Attire'],
        'invitations' => ['min' => 100000, 'max' => 500000, 'priority' => 7, 'name' => 'Invitations'],
        'transport' => ['min' => 150000, 'max' => 800000, 'priority' => 8, 'name' => 'Transportation'],
        'hair_makeup' => ['min' => 100000, 'max' => 500000, 'priority' => 9, 'name' => 'Hair & Makeup'],
        'cake' => ['min' => 100000, 'max' => 400000, 'priority' => 10, 'name' => 'Wedding Cake'],
    ];

    public function suggestServices($budget)
    {
        $suggestions = [];
        $remainingBudget = $budget;
        $totalEstimated = 0;

        // Sort by priority (most important first)
        $sortedCategories = collect($this->serviceCategories)
            ->sortBy('priority')
            ->toArray();

        foreach ($sortedCategories as $category => $details) {
            if ($remainingBudget >= $details['min']) {
                // Calculate suggested amount for this category
                $suggestedAmount = min($details['max'], $remainingBudget * 0.3);
                $suggestedAmount = max($details['min'], $suggestedAmount);
                
                // Get actual services from database within budget
                $services = Service::where('category', $category)
                    ->where('price', '<=', $suggestedAmount)
                    ->where('price', '>=', $details['min'] * 0.8)
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();

                if ($services->count() > 0 || $suggestedAmount >= $details['min']) {
                    $suggestions[] = [
                        'category' => $category,
                        'category_name' => $details['name'],
                        'suggested_budget' => $suggestedAmount,
                        'min_price' => $details['min'],
                        'max_price' => $details['max'],
                        'priority' => $details['priority'],
                        'services' => $services,
                        'can_afford' => $remainingBudget >= $details['min']
                    ];
                    
                    $totalEstimated += $suggestedAmount;
                    $remainingBudget -= $suggestedAmount;
                    
                    if ($remainingBudget < 100) break;
                }
            }
        }

        // Create package tiers based on budget
        $packages = $this->createPackages($budget);

        return [
            'total_budget' => $budget,
            'total_estimated' => $totalEstimated,
            'remaining' => $budget - $totalEstimated,
            'suggestions' => $suggestions,
            'packages' => $packages,
            'can_book_manually' => $budget >= 500,
            'can_auto_book' => $budget >= 1000
        ];
    }

    public function createPackages($budget)
    {
        $packages = [];
        
        // Economy Package (from RWF 1,500,000)
        if ($budget >= 1500000) {
            $packages['economy'] = [
                'name' => 'Economy Package',
                'price' => 1500000,
                'services' => ['venue', 'catering', 'photography'],
                'description' => 'Perfect for intimate weddings with essential services: Venue, Catering, Photography',
                'savings' => '15%'
            ];
        }
        
        // Standard Package (from RWF 3,500,000)
        if ($budget >= 3500000) {
            $packages['standard'] = [
                'name' => 'Standard Package',
                'price' => 3500000,
                'services' => ['venue', 'catering', 'photography', 'decoration', 'music'],
                'description' => 'Most popular choice: Essential services + Decoration and Music',
                'savings' => '20%'
            ];
        }
        
        // Premium Package (from RWF 8,000,000)
        if ($budget >= 8000000) {
            $packages['premium'] = [
                'name' => 'Premium Package',
                'price' => 8000000,
                'services' => array_keys($this->serviceCategories),
                'description' => 'All 10 service categories included for a complete experience',
                'savings' => '25%'
            ];
        }
        
        // Deluxe Package (Full Budget)
        if ($budget >= 10000000) {
            $packages['deluxe'] = [
                'name' => 'Deluxe Package',
                'price' => $budget,
                'services' => array_keys($this->serviceCategories),
                'description' => 'Ultimate wedding experience with premium vendors and extras',
                'savings' => '30%',
                'extras' => ['Honeymoon Suite', 'Wedding Coordinator', 'Spa Package']
            ];
        }
        
        return $packages;
    }

    public function autoBookServices($userId, $budget, $selectedPackage = null)
    {
        DB::beginTransaction();
        
        try {
            $suggestions = $this->suggestServices($budget);
            
            if ($selectedPackage && isset($suggestions['packages'][$selectedPackage])) {
                $package = $suggestions['packages'][$selectedPackage];
                // Create booking for the package
                $booking = $this->createPackageBooking($userId, $package);
            } else {
                // Create individual bookings based on suggestions
                $booking = $this->createIndividualBookings($userId, $suggestions['suggestions']);
            }
            
            // Save budget plan if BudgetPlan model exists
            if (class_exists('App\Models\BudgetPlan')) {
                BudgetPlan::create([
                    'user_id' => $userId,
                    'total_budget' => $budget,
                    'remaining_budget' => $suggestions['remaining'],
                    'allocations' => json_encode($suggestions['suggestions']),
                    'status' => 'active'
                ]);
            }
            
            DB::commit();
            return ['success' => true, 'booking' => $booking, 'message' => 'Services booked successfully!'];
            
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Failed to book services: ' . $e->getMessage()];
        }
    }

    protected function createPackageBooking($userId, $package)
    {
        // Create parent booking
        $booking = \App\Models\Booking::create([
            'user_id' => $userId,
            'booking_date' => now()->addDays(60), // Default to 2 months from now
            'total_price' => $package['price'],
            'status' => 'pending',
            'notes' => 'Auto-booked: ' . $package['name'],
            'is_auto_booked' => true
        ]);

        // In a real scenario, we would find best services for each category in the package
        // and create BookingItems. For now, we'll associate some services if available.
        foreach ($package['services'] as $category) {
            $service = \App\Models\Service::where('category', $category)
                ->orderBy('price', 'asc')
                ->first();
            
            if ($service) {
                \App\Models\BookingItem::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service->id,
                    'price' => $service->price
                ]);
            }
        }

        return $booking;
    }

    protected function createIndividualBookings($userId, $suggestions)
    {
        $selectedServices = [];
        $total = 0;

        foreach ($suggestions as $suggestion) {
            if ($suggestion['can_afford'] && count($suggestion['services']) > 0) {
                // Pick a random service from the candidates to ensure variety
                $service = collect($suggestion['services'])->random();
                $selectedServices[] = $service;
                $total += $service['price'];
            }
        }

        $booking = \App\Models\Booking::create([
            'user_id' => $userId,
            'booking_date' => now()->addDays(60),
            'total_price' => $total,
            'status' => 'pending',
            'notes' => 'Auto-booked: Individual Services (Varied Selection)',
            'is_auto_booked' => true
        ]);

        foreach ($selectedServices as $service) {
            \App\Models\BookingItem::create([
                'booking_id' => $booking->id,
                'service_id' => $service['id'],
                'price' => $service['price']
            ]);
        }
        
        return $booking;
    }
}