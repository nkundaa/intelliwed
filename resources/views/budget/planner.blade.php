{{-- resources/views/budget/planner.blade.php --}}
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Smart Wedding Budget Planner
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Tell us your budget, and we'll help you plan the perfect wedding - either choose services yourself or let us automatically book everything for you!
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Option 1: Manual Booking -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">📋 Book Yourself</h2>
                        <p class="text-blue-100 text-sm">Choose services manually based on recommendations</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Total Budget (RWF)</label>
                            <input type="number" id="manual-budget" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your total budget">
                        </div>
                        
                        <div id="manual-suggestions" class="space-y-4 mb-6"></div>
                        
                        <button onclick="getSuggestions('manual')" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-md">
                            Get Service Suggestions
                        </button>
                    </div>
                </div>

                <!-- Option 2: Auto Booking -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">🤖 Let Us Plan For You</h2>
                        <p class="text-purple-100 text-sm">We'll automatically book the best services for your budget</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Total Budget (RWF)</label>
                            <input type="number" id="auto-budget" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Enter your total budget">
                        </div>
                        
                        <div id="auto-suggestions" class="space-y-4 mb-6"></div>
                        
                        <button onclick="getSuggestions('auto')" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-md">
                            Get AI Suggestions
                        </button>
                    </div>
                </div>
            </div>

            <!-- Package Comparison -->
            <div id="packages-container" class="mt-10 hidden">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Recommended Packages</h2>
                <div id="packages-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"></div>
            </div>
        </div>
    </div>

    <script>
        async function getSuggestions(type) {
            const budgetInput = document.getElementById(`${type}-budget`);
            const budget = budgetInput.value;
            
            if (!budget || budget < 100) {
                alert('Please enter a valid budget (minimum 100 RWF)');
                return;
            }
            
            const suggestionsDiv = document.getElementById(`${type}-suggestions`);
            suggestionsDiv.innerHTML = '<div class="text-center py-4">Loading suggestions...</div>';
            
            try {
                const response = await fetch('/budget/calculate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ budget: budget })
                });
                
                const data = await response.json();
                displaySuggestions(type, data);
                
                // Show packages if using auto
                if (type === 'auto') {
                    displayPackages(data.packages, budget);
                }
                
            } catch (error) {
                suggestionsDiv.innerHTML = '<div class="text-red-500 text-center">Error loading suggestions. Please try again.</div>';
            }
        }
        
        function displaySuggestions(type, data) {
            const container = document.getElementById(`${type}-suggestions`);
            
            if (!data.suggestions || data.suggestions.length === 0) {
                container.innerHTML = '<div class="text-center text-gray-500">No suggestions available for this budget.</div>';
                return;
            }
            
            let html = `
                <div class="bg-gradient-to-r from-green-50 to-blue-50 p-4 rounded-xl mb-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Total Budget:</span>
                        <span class="font-bold text-green-600">RWF ${data.total_budget.toLocaleString()}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">Estimated Total:</span>
                        <span>RWF ${data.total_estimated.toLocaleString()}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">Remaining:</span>
                        <span class="text-orange-600">RWF ${data.remaining.toLocaleString()}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <h4 class="font-semibold text-gray-800">Suggested Services:</h4>
            `;
            
            data.suggestions.forEach(suggestion => {
                html += `
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <span class="font-medium">${suggestion.category_name}</span>
                            <div class="text-xs text-gray-500">RWF ${suggestion.suggested_budget.toLocaleString()}</div>
                        </div>
                        <button onclick="bookService('${suggestion.category}', ${suggestion.suggested_budget}, '${type}')" 
                                class="px-3 py-1 ${type === 'auto' ? 'bg-purple-500' : 'bg-blue-500'} text-white text-sm rounded-lg hover:opacity-80">
                            Select
                        </button>
                    </div>
                `;
            });
            
            html += `</div>`;
            
            if (type === 'auto') {
                html += `
                    <button onclick="autoBookServices()" class="w-full mt-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold py-2 rounded-lg">
                        Book All Services Automatically
                    </button>
                `;
            }
            
            container.innerHTML = html;
        }
        
        function displayPackages(packages, budget) {
            const container = document.getElementById('packages-container');
            const grid = document.getElementById('packages-grid');
            
            if (!packages || Object.keys(packages).length === 0) {
                container.classList.add('hidden');
                return;
            }
            
            container.classList.remove('hidden');
            let html = '';
            
            Object.entries(packages).forEach(([key, pkg]) => {
                html += `
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all">
                        <div class="text-center mb-4">
                            <div class="text-3xl mb-2">${key === 'economy' ? '💍' : key === 'standard' ? '🎉' : key === 'premium' ? '👑' : '✨'}</div>
                            <h3 class="text-xl font-bold text-gray-800">${pkg.name}</h3>
                            <div class="text-2xl font-bold text-blue-600 mt-2">RWF ${pkg.price.toLocaleString()}</div>
                            <div class="text-sm text-green-600">Save ${pkg.savings}</div>
                        </div>
                        <p class="text-sm text-gray-600 text-center mb-4">${pkg.description}</p>
                        <div class="space-y-2 mb-6">
                            ${pkg.services.map(service => `<div class="text-sm text-gray-700">✓ ${service}</div>`).join('')}
                            ${pkg.extras ? pkg.extras.map(extra => `<div class="text-sm text-purple-600">✨ ${extra}</div>`).join('') : ''}
                        </div>
                        <button onclick="bookPackage('${key}', ${pkg.price})" 
                                class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold py-2 rounded-lg hover:shadow-lg transition">
                            Choose This Package
                        </button>
                    </div>
                `;
            });
            
            grid.innerHTML = html;
        }
        
        function bookService(category, price, type) {
            if (confirm(`Book ${category} service for RWF ${price.toLocaleString()}?`)) {
                alert('Service added to cart! You can review it in your bookings page.');
                // Implement actual booking logic here
            }
        }
        
        function bookPackage(packageName, price) {
            if (confirm(`Book ${packageName.toUpperCase()} package for RWF ${price.toLocaleString()}? This will automatically book all services for you.`)) {
                alert('Package booked successfully! Check your bookings page for details.');
                // Implement actual package booking logic here
            }
        }
        
        function autoBookServices() {
            const budget = document.getElementById('auto-budget').value;
            if (confirm(`Book all suggested services for RWF ${parseInt(budget).toLocaleString()}?`)) {
                alert('All services have been booked successfully! You can view them in your bookings page.');
                window.location.href = '/bookings';
            }
        }
    </script>
</x-app-layout>