@extends('layouts.app')

@section('title', 'Cari Definisi Kata')

@section('content')
    <!-- Search Section -->
    <section class="search-section">
        <div class="search-header">
            <h2>Cari Definisi Kata</h2>
            <p>Temukan arti, contoh penggunaan, dan tag kata yang Anda cari</p>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container">
            <input 
                type="text" 
                id="searchInput"
                placeholder="Ketik kata yang ingin dicari..."
                class="search-input"
                autocomplete="off"
            >
            <button 
                id="searchButton"
                class="search-button"
            >
                Cari
            </button>
        </div>
        
        <!-- Search Suggestions -->
        <div id="suggestions" class="suggestions"></div>
    </section>

    <!-- Loading Indicator -->
    <div id="loading" class="loading" style="display: none;">
        <div class="loading-spinner"></div>
        <p>Mencari kata...</p>
    </div>

    <!-- Search Results -->
    <section id="searchResults" class="results-section" style="display: none;">
        <h3>Hasil Pencarian</h3>
        <div id="resultsContainer" class="results-container"></div>
    </section>

    <!-- No Results Message -->
    <div id="noResults" class="no-results" style="display: none;">
        <div class="no-results-icon"></div>
        <h3>Kata tidak ditemukan</h3>
        <p>Coba kata kunci lain atau periksa ejaan Anda</p>
    </div>
@endsection

@push('scripts')
<script>
    // Define functions globally
    window.performSearch = function() {
        console.log('Search button clicked');
        const query = document.getElementById('searchInput').value.trim();
        console.log('Search query:', query);
        
        if (query === '') {
            document.getElementById('searchResults').style.display = 'none';
            document.getElementById('noResults').style.display = 'none';
            return;
        }

        // Show loading indicator
        document.getElementById('loading').style.display = 'block';
        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('noResults').style.display = 'none';

        // Make API request to search words
        fetch(`/api/search?q=${encodeURIComponent(query)}`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                console.log('Number of results:', data.success ? data.data.length : 0);
                
                // Display results
                if (data.success && data.data.length > 0) {
                    displayResults(data.data);
                    document.getElementById('searchResults').style.display = 'block';
                    document.getElementById('noResults').style.display = 'none';
                } else {
                    document.getElementById('searchResults').style.display = 'none';
                    document.getElementById('noResults').style.display = 'block';
                }

                // Clear suggestions
                document.getElementById('suggestions').style.display = 'none';
            })
            .catch(error => {
                console.error('Error searching words:', error);
                document.getElementById('searchResults').style.display = 'none';
                document.getElementById('noResults').style.display = 'block';
            })
            .finally(() => {
                // Hide loading indicator
                document.getElementById('loading').style.display = 'none';
            });
    };

    window.displayResults = function(results) {
        const resultsContainer = document.getElementById('resultsContainer');
        resultsContainer.innerHTML = '';
        
        results.forEach((result, index) => {
            const resultCard = document.createElement('div');
            resultCard.className = 'result-card';
            resultCard.style.animationDelay = `${index * 0.1}s`;
            
            // Parse tags from comma-separated string
            const tagsArray = result.tags.split(',').map(tag => tag.trim());
            
            resultCard.innerHTML = `
                <div class="result-header">
                    <h4 class="result-word">${result.kata}</h4>
                </div>
                <p class="result-definition">${result.definisi}</p>
                <div class="result-example">
                    <p class="example-label">Contoh:</p>
                    <p class="example-text">"${result.contoh}"</p>
                </div>
                <div class="result-tags">
                    ${tagsArray.map(tag => `
                        <span class="tag">#${tag}</span>
                    `).join('')}
                </div>
            `;
            
            resultsContainer.appendChild(resultCard);
        });
    };

    window.showSuggestions = function() {
        const searchInput = document.getElementById('searchInput');
        const suggestions = document.getElementById('suggestions');
        const query = searchInput.value.trim();
        
        if (query === '') {
            suggestions.style.display = 'none';
            return;
        }

        // Make API request to get suggestions
        fetch(`/api/suggestions?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.data.length > 0) {
                    suggestions.innerHTML = data.data.map(match => `
                        <div onclick="selectSuggestion('${match.kata}')">
                            <span>${match.kata}</span>
                            <span class="suggestion-desc">${match.definisi.substring(0, 50)}...</span>
                        </div>
                    `).join('');
                    suggestions.style.display = 'block';
                } else {
                    suggestions.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error getting suggestions:', error);
                suggestions.style.display = 'none';
            });
    };

    window.selectSuggestion = function(word) {
        const searchInput = document.getElementById('searchInput');
        const suggestions = document.getElementById('suggestions');
        searchInput.value = word;
        suggestions.style.display = 'none';
        performSearch();
    };

    // Add event listeners when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        
        // Get DOM elements
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const suggestions = document.getElementById('suggestions');
        
        // Add event listener for search button
        if (searchButton) {
            searchButton.addEventListener('click', performSearch);
        }
        
        // Add event listener for search input
        if (searchInput) {
            searchInput.addEventListener('input', showSuggestions);
            
            // Add event listener for Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
        }
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#searchInput') && !e.target.closest('#suggestions')) {
                suggestions.style.display = 'none';
            }
        });
    });
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush