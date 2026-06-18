/**
 * Advanced Search Widget JavaScript
 *
 * @package Happy_Addons_Pro
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Advanced Search Widget Class
     */
    class AdvancedSearchWidget {
        constructor($element) {
            this.$element = $element;
            this.$wrap = $element.find('.ha-advanced-search-wrap');
            this.$searchBox = $element.find('.ha_search_box');
            this.$input = $element.find('.ha_search_input');
            this.$button = $element.find('.ha_search_button');
            this.$clearButton = $element.find('.ha_clear_button');
            this.$resultsContainer = $element.find('.ha_results_container');
            this.$resultsList = $element.find('.ha_results_list');
            this.$searchTermDisplay = $element.find('[id^="ha-search-term-display-"]');
            this.$categorySelect = $element.find('.ha_category_select');
            this.$popularKeywords = $element.find('.ha-keyword');
            
            this.searchTerm = '';
            this.selectedCategory = 'all';
            this.currentPage = 1;
            this.totalPages = 1;
            this.searchTimeout = null;
            
            // Get widget settings from data attributes
            this.settings = {
                postTypes: JSON.parse(this.$wrap.attr('data-post-types') || '["post", "page"]'),
                initialResultsCount: parseInt(this.$wrap.attr('data-initial-results-count')) || 5,
                showCategoryList: this.$wrap.attr('data-show-category-list') === 'true',
                showCategoryResult: this.$wrap.attr('data-show-category-result') === 'true',
                showPopularKeyword: this.$wrap.attr('data-show-popular-keyword') === 'true',
                showContentImage: this.$wrap.attr('data-show-content-image') === 'true',
                popularSearchText: this.$wrap.attr('data-popular-search-text') || 'Popular Searches',
                categorySearchText: this.$wrap.attr('data-category-search-text') || 'Search in Category',
                loadMoreText: this.$wrap.attr('data-load-more-text') || 'Load More',
                notFoundText: this.$wrap.attr('data-not-found-text') || 'No results found'
            };
            
            this.init();
        }

        init() {
            this.bindEvents();
        }

        bindEvents() {
            // Search input events
            this.$input.on('input', $.proxy(this.onSearchInput, this));
            this.$input.on('keypress', $.proxy(this.onSearchKeypress, this));
            
            // Search button click
            this.$button.on('click', $.proxy(this.onSearchClick, this));
            
            // Clear button click
            this.$clearButton.on('click', $.proxy(this.onClearClick, this));
            
            // Category selection change
            this.$categorySelect.on('change', $.proxy(this.onCategoryChange, this));
            
            // Popular keyword clicks
            this.$popularKeywords.on('click', $.proxy(this.onKeywordClick, this));
            
            // Close results when clicking outside
            $(document).on('click', $.proxy(this.onDocumentClick, this));
            
            // Focus/blur events for search box
            this.$searchBox.on('focusin', $.proxy(this.onFocusIn, this));
            this.$searchBox.on('focusout', $.proxy(this.onFocusOut, this));
        }

        onSearchInput(e) {
            this.searchTerm = $(e.currentTarget).val().trim();
            
            // Show/hide clear button
            if (this.searchTerm.length > 0) {
                this.$clearButton.show();
            } else {
                this.$clearButton.hide();
            }
            
            // Clear previous timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            
            // Debounce search
            this.searchTimeout = setTimeout(() => {
                if (this.searchTerm.length >= 2) {
                    this.performSearch();
                } else {
                    this.hideResults();
                }
            }, 300);
        }

        onSearchKeypress(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                this.performSearch();
            }
        }

        onSearchClick(e) {
            e.preventDefault();
            this.performSearch();
        }

        onClearClick(e) {
            e.preventDefault();
            this.$input.val('');
            this.searchTerm = '';
            this.hideResults();
            this.$clearButton.hide();
        }

        onCategoryChange(e) {
            this.selectedCategory = $(e.currentTarget).val();
            this.currentPage = 1;
            if (this.searchTerm) {
                this.performSearch();
            }
        }

        onKeywordClick(e) {
            e.preventDefault();
            const keyword = $(e.currentTarget).text();
            this.$input.val(keyword);
            this.searchTerm = keyword;
            this.performSearch();
            
            // Track keyword usage
            this.trackKeyword(keyword);
        }

        onDocumentClick(e) {
            if (!$(e.target).closest('.ha-advanced-search-wrap').length) {
                this.hideResults();
            }
        }

        onFocusIn() {
            if (this.searchTerm && this.$resultsList.children().length > 0) {
                this.showResults();
            }
        }

        onFocusOut() {
            // Small delay to allow clicking on results
            setTimeout(() => {
                if (!this.$searchBox.find(':focus').length) {
                    this.hideResults();
                }
            }, 200);
        }

        performSearch() {
            if (!this.searchTerm) return;
            
            // Show loading state
            this.$button.prop('disabled', true);
            
            // Update search term display
            this.$searchTermDisplay.text(this.searchTerm);
            
            // Prepare AJAX data
            const data = {
                action: 'ha_advanced_search',
                nonce: haAdvancedSearch.nonce,
                search_term: this.searchTerm,
                post_types: this.settings.postTypes,
                page: this.currentPage,
                initial_results_count: this.settings.initialResultsCount,
                show_category_result: this.settings.showCategoryResult,
                show_content_image: this.settings.showContentImage
            };
            
            // Add category filter if selected
            if (this.selectedCategory !== 'all') {
                data.category = this.selectedCategory;
            }
            
            // Perform AJAX request
            $.ajax({
                url: haAdvancedSearch.ajax_url,
                type: 'POST',
                data: data,
                success: $.proxy(this.onSearchSuccess, this),
                error: $.proxy(this.onSearchError, this),
                complete: $.proxy(this.onSearchComplete, this)
            });
        }

        onSearchSuccess(response) {
            if (response.success) {
                const results = response.data.results;
                const found = response.data.found;
                const pages = response.data.pages;
                
                this.totalPages = pages;
                this.currentPage = 1;
                
                // Clear previous results
                this.$resultsList.empty();
                
                if (results.length > 0) {
                    // Render results
                    results.forEach(result => {
                        this.renderResultItem(result);
                    });
                    
                    // Show results container
                    this.showResults();
                    
                    // Update view all link
                    const viewAllLink = this.$resultsContainer.find('.ha_view_all_link');
                    const searchUrl = new URL(window.location.href);
                    searchUrl.searchParams.set('s', this.searchTerm);
                    if (this.selectedCategory !== 'all') {
                        searchUrl.searchParams.set('cat', this.selectedCategory);
                    }
                    viewAllLink.attr('href', searchUrl.toString());
                } else {
                    // Show no results message
                    this.$resultsList.html(`<div class="ha_no_results">${this.settings.notFoundText}</div>`);
                    this.showResults();
                }
            }
        }

        onSearchError(xhr, status, error) {
            console.error('Search error:', error);
            this.$resultsList.html(`<div class="ha_no_results">${haAdvancedSearch.strings.no_results}</div>`);
        }

        onSearchComplete() {
            this.$button.prop('disabled', false);
        }

        renderResultItem(result) {
            const itemHtml = `
                <a href="${result.permalink}" class="ha_result_item">
                    <div class="ha_result_icon_wrapper">
                        ${result.image ? 
                            `<img src="${result.image}" alt="${result.title}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;" />` :
                            `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: #9ca3af;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 0114 0z"></path>
                            </svg>`
                        }
                    </div>
                    <div class="ha_result_content">
                        <div class="ha_result_name">${result.title}</div>
                        <div class="ha_result_category">${result.post_type}</div>
                        ${result.excerpt ? `<div class="ha_result_excerpt" style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">${result.excerpt}</div>` : ''}
                    </div>
                </a>
            `;
            this.$resultsList.append(itemHtml);
        }

        showResults() {
            this.$resultsContainer.addClass('ha_visible');
        }

        hideResults() {
            this.$resultsContainer.removeClass('ha_visible');
        }

        trackKeyword(keyword) {
            $.ajax({
                url: haAdvancedSearch.ajax_url,
                type: 'POST',
                data: {
                    action: 'ha_track_keyword',
                    nonce: haAdvancedSearch.nonce,
                    keyword: keyword
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Keyword tracked:', keyword);
                    }
                }
            });
        }
    }

    /**
     * Initialize Advanced Search Widgets
     */
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function($scope) {
            if ($scope.find('.ha-advanced-search-wrap').length > 0) {
                $scope.find('.ha-advanced-search-wrap').each(function() {
                    new AdvancedSearchWidget($(this).closest('.elementor-widget-container'));
                });
            }
        });
    });

})(jQuery);
