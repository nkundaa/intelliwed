@extends('layouts.front')

@section('title', 'Smart Budget Planner | IntelliWed')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 5rem 0; color: white;">
    <div class="container" style="max-width: 900px; text-align: center;">
        <h1 style="font-size: 2.8rem; margin-bottom: 1rem; font-weight: bold;">Smart Wedding Budget Planner</h1>
        <p style="font-size: 1.1rem; opacity: 0.95;">Tell us your total budget and choose: Let us suggest services or book manually</p>
    </div>
</div>

<div class="container" style="padding: 4rem 2rem; max-width: 1000px;">
    <!-- Budget Input Section -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem; margin-bottom: 3rem;">
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <h2 style="margin-bottom: 1.5rem; color: #333;">Step 1: Enter Your Budget</h2>
            
            <div style="display: grid; gap: 1.5rem;">
                <div>
                    <label for="budget" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555;">Total Budget (RWF)</label>
                    <input 
                        type="number" 
                        id="budget" 
                        placeholder="e.g., 5000000" 
                        min="100000" 
                        style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem;"
                    >
                    <small style="color: #999; display: block; margin-top: 0.5rem;">Minimum budget: 100,000 RWF</small>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <button 
                        onclick="suggestPackages()" 
                        style="padding: 0.9rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem; transition: transform 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.transform='translateY(0)'"
                    >
                        🎯 Get Suggestions
                    </button>
                    
                    <button 
                        onclick="manualBooking()" 
                        style="padding: 0.9rem; background: #f0f0f0; color: #333; border: 2px solid #ddd; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem; transition: all 0.2s;"
                        onmouseover="this.style.borderColor='#667eea'; this.style.color='#667eea'"
                        onmouseout="this.style.borderColor='#ddd'; this.style.color='#333'"
                    >
                        👤 Manual Booking
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loading" style="display: none; text-align: center; padding: 2rem;">
        <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f0f0f0; border-top: 4px solid #667eea; border-radius: 50%; animation: spin 1s linear infinite;"></div>
        <p style="color: #666; margin-top: 1rem;">Analyzing your budget...</p>
    </div>

    <!-- Suggestions Results Section -->
    <div id="results" style="display: none;">
        <!-- Budget Overview -->
        <div id="budgetOverview" style="background: #f8f9ff; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; border-left: 4px solid #667eea;">
            <h3 style="margin-bottom: 1rem; color: #333;">💰 Budget Overview</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                <div>
                    <p style="color: #999; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Budget</p>
                    <p id="totalBudget" style="font-size: 1.5rem; font-weight: bold; color: #667eea;">0 RWF</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Allocated</p>
                    <p id="totalAllocated" style="font-size: 1.5rem; font-weight: bold; color: #764ba2;">0 RWF</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 0.9rem; margin-bottom: 0.5rem;">Remaining</p>
                    <p id="remaining" style="font-size: 1.5rem; font-weight: bold; color: #27ae60;">0 RWF</p>
                </div>
            </div>
        </div>

        <!-- Packages Section -->
        <div id="packagesSection" style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1.5rem; color: #333;">📦 Recommended Packages</h3>
            <div id="packagesContainer" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <!-- Packages will be populated here -->
            </div>
        </div>

        <!-- Services Breakdown -->
        <div id="servicesSection" style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1.5rem; color: #333;">🎁 Suggested Services by Category</h3>
            <div id="servicesContainer" style="display: grid; gap: 1.5rem;">
                <!-- Services will be populated here -->
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;">
            <button 
                onclick="confirmAutoBook()" 
                style="padding: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;"
            >
                ✅ Auto-Book Suggested Services
            </button>
            <button 
                onclick="location.reload()" 
                style="padding: 1rem; background: #f0f0f0; color: #333; border: 2px solid #ddd; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;"
            >
                ⬅️ Back
            </button>
        </div>
    </div>
</div>

<!-- Auto-book Modal -->
<div id="autoBookModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 1rem; color: #333;">Confirm Auto-Booking</h3>
        <p style="color: #666; margin-bottom: 1.5rem;">You're about to book services based on our suggestions. You can modify or cancel at any time.</p>
        
        <div style="background: #f8f9ff; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <p style="margin: 0.5rem 0; color: #555;"><strong>Selected Package:</strong> <span id="selectedPackageName">-</span></p>
            <p style="margin: 0.5rem 0; color: #555;"><strong>Estimated Cost:</strong> <span id="selectedPackagePrice">0 RWF</span></p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <button 
                onclick="closeModal()" 
                style="padding: 0.75rem; background: #f0f0f0; color: #333; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;"
            >
                Cancel
            </button>
            <button 
                onclick="proceedWithAutoBook()" 
                style="padding: 0.75rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;"
            >
                Proceed
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .package-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 2px solid transparent;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .package-card:hover {
        border-color: #667eea;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
        transform: translateY(-4px);
    }
    
    .package-card.selected {
        border-color: #667eea;
        background: #f8f9ff;
    }
    
    .service-item {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        border-left: 4px solid #667eea;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<script>
    let currentBudget = 0;
    let currentSuggestions = null;
    let selectedPackage = null;

    function suggestPackages() {
        const budget = parseFloat(document.getElementById('budget').value);
        
        if (!budget || budget < 100000) {
            alert('Please enter a valid budget (minimum 100,000 RWF)');
            return;
        }

        currentBudget = budget;
        document.getElementById('loading').style.display = 'block';
        document.getElementById('results').style.display = 'none';

        fetch("{{ route('suggest.services') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ budget: budget })
        })
        .then(response => response.json())
        .then(data => {
            currentSuggestions = data;
            displayResults(data, budget);
            document.getElementById('loading').style.display = 'none';
            document.getElementById('results').style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching suggestions. Please try again.');
            document.getElementById('loading').style.display = 'none';
        });
    }

    function displayResults(data, budget) {
        // Update budget overview
        document.getElementById('totalBudget').textContent = formatCurrency(budget);
        document.getElementById('totalAllocated').textContent = formatCurrency(data.total_estimated || budget);
        document.getElementById('remaining').textContent = formatCurrency(data.remaining || 0);

        // Display packages
        const packagesContainer = document.getElementById('packagesContainer');
        packagesContainer.innerHTML = '';

        if (data.packages && Object.keys(data.packages).length > 0) {
            Object.entries(data.packages).forEach(([key, pkg]) => {
                const card = createPackageCard(key, pkg);
                packagesContainer.appendChild(card);
            });
        } else {
            packagesContainer.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #999;">No packages available for this budget.</p>';
        }

        // Display services
        const servicesContainer = document.getElementById('servicesContainer');
        servicesContainer.innerHTML = '';

        if (data.suggestions && data.suggestions.length > 0) {
            data.suggestions.forEach(suggestion => {
                const serviceDiv = document.createElement('div');
                serviceDiv.style.cssText = 'background: white; border-radius: 8px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #667eea;';
                
                let servicesHTML = `<h4 style="margin: 0 0 0.5rem 0; color: #333;">${suggestion.category_name}</h4>
                    <p style="margin: 0 0 1rem 0; color: #999; font-size: 0.9rem;">Suggested Budget: <strong>${formatCurrency(suggestion.suggested_budget)}</strong></p>`;
                
                if (suggestion.services && suggestion.services.length > 0) {
                    servicesHTML += '<div style="display: grid; gap: 0.5rem;">';
                    suggestion.services.forEach(service => {
                        servicesHTML += `<div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>${service.name}</span>
                            <span style="font-weight: bold; color: #667eea;">${formatCurrency(service.price)}</span>
                        </div>`;
                    });
                    servicesHTML += '</div>';
                } else {
                    servicesHTML += '<p style="color: #999; font-size: 0.9rem;">No services available in this category within your budget.</p>';
                }
                
                serviceDiv.innerHTML = servicesHTML;
                servicesContainer.appendChild(serviceDiv);
            });
        }
    }

    function createPackageCard(key, pkg) {
        const card = document.createElement('div');
        card.className = 'package-card';
        card.onclick = () => selectPackage(key, pkg);
        
        card.innerHTML = `
            <h4 style="margin: 0 0 0.5rem 0; color: #333;">${pkg.name}</h4>
            <p style="margin: 0 0 1rem 0; color: #999; font-size: 0.9rem;">${pkg.description}</p>
            <p style="margin: 0.5rem 0; color: #667eea; font-weight: bold; font-size: 1.3rem;">${formatCurrency(pkg.price)}</p>
            <p style="margin: 0.5rem 0; color: #27ae60; font-size: 0.9rem;">💰 Save ${pkg.savings}</p>
        `;
        
        return card;
    }

    function selectPackage(key, pkg) {
        selectedPackage = { key, package: pkg };
        
        // Update UI
        document.querySelectorAll('.package-card').forEach(card => card.classList.remove('selected'));
        event.target.closest('.package-card').classList.add('selected');
        
        // Update modal
        document.getElementById('selectedPackageName').textContent = pkg.name;
        document.getElementById('selectedPackagePrice').textContent = formatCurrency(pkg.price);
    }

    function confirmAutoBook() {
        if (!selectedPackage) {
            alert('Please select a package first');
            return;
        }
        
        document.getElementById('autoBookModal').style.display = 'flex';
    }

    function proceedWithAutoBook() {
        const bookData = {
            budget: currentBudget,
            package: selectedPackage.key
        };

        fetch("{{ route('auto.book') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(bookData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Services booked successfully!');
                window.location.href = "{{ route('dashboard') }}";
            } else {
                alert('❌ Error: ' + (data.message || 'Failed to book services'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error booking services. Please try again.');
        });
    }

    function closeModal() {
        document.getElementById('autoBookModal').style.display = 'none';
    }

    function manualBooking() {
        window.location.href = "{{ route('services.index') }}";
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('en-RW', {
            style: 'currency',
            currency: 'RWF',
            minimumFractionDigits: 0
        }).format(value);
    }

    // Close modal when clicking outside
    document.getElementById('autoBookModal').addEventListener('click', (e) => {
        if (e.target.id === 'autoBookModal') {
            closeModal();
        }
    });
</script>
@endsection
