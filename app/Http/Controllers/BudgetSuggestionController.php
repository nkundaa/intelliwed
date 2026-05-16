<?php

namespace App\Http\Controllers;

use App\Services\BudgetPlannerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetSuggestionController extends Controller
{
    protected $budgetPlanner;

    public function __construct(BudgetPlannerService $budgetPlanner)
    {
        $this->budgetPlanner = $budgetPlanner;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('budget.planner');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'budget' => 'required|numeric|min:100|max:100000'
        ]);

        try {
            $budget = (float) $validated['budget'];

            $suggestions = $this->budgetPlanner->suggestServices($budget);

            return response()->json([
                'success' => true,
                'data' => $suggestions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate suggestions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function autoBook(Request $request)
    {
        $validated = $request->validate([
            'budget' => 'required|numeric|min:100',
            'package' => 'nullable|string'
        ]);

        try {
            $userId = Auth::id();

            if (!$userId) {
                return redirect()->back()->with('error', 'User not authenticated');
            }

            $budget = (float) $validated['budget'];
            $package = $validated['package'] ?? null;

            $result = $this->budgetPlanner->autoBookServices(
                $userId,
                $budget,
                $package
            );

            if (!empty($result['success']) && $result['success']) {
                return redirect()->route('bookings.index')
                    ->with('success', $result['message'] ?? 'Booking successful');
            }

            return back()->with('error', $result['message'] ?? 'Booking failed');

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function compare(Request $request)
    {
        $validated = $request->validate([
            'manual_budget' => 'required|numeric|min:100',
            'auto_budget' => 'required|numeric|min:100'
        ]);

        try {
            $manualBudget = (float) $validated['manual_budget'];
            $autoBudget = (float) $validated['auto_budget'];

            $manualSuggestions = $this->budgetPlanner->suggestServices($manualBudget);
            $autoSuggestions = $this->budgetPlanner->suggestServices($autoBudget);

            return view('budget.compare', compact(
                'manualSuggestions',
                'autoSuggestions',
                'manualBudget',
                'autoBudget'
            ));

        } catch (\Exception $e) {
            return back()->with('error', 'Comparison failed: ' . $e->getMessage());
        }
    }
}