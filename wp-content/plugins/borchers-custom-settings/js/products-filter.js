import { categoriesData } from "./categories-data.js";

function productsFilterShortcodeCheck() {
    const productsFilterContainer = document.querySelector('#borchers-products-filter-container');
    if ( !productsFilterContainer ) {
        return;
    } else {
        document.addEventListener( 'DOMContentLoaded', function() {

            // ELEMENTS

            // Create an array to hold errors
            const errors = [];
            // Count for debugging
            let count = 0;
            // Get and set items based on url
            const rawUrl = location.pathname;
            // Need to trim and split raw url by /
            const splitUrl = rawUrl?.trim().split("/");
            // Get the third item of the result of the split example 1-/products 2/category 3/catalysts
            const processedUrl = splitUrl[3];
            //console.log("PROCESSED URL:" + processedUrl);
            // Attribute filters to keep track of what has been checked
            const activeFilters = new Set();
            // Set of product cards that match the filter
            const activeProducts = new Set();
            const inactiveProducts = new Set();
            // Need boolean that is set to true after the primary filter is selected
            let primaryFilterActive = false;

            // Get current page from window to avoid scoping issues
            window.currentPage = 1;

            // Reset filter
            const resetFilterElement = document.querySelector('#borchers-products-filter-container #reset-filter');

            // Get the product groups element and add event listener to show lis
            const productGroups = document.querySelector('#borchers-products-filter-container #filter-product-groups');
            const productGroupsUl = document.querySelector('#borchers-products-filter-container #category-filter');
            const categoryFilters = document.querySelectorAll('#category-filter li');
            // application
            const applicationGroups = document.querySelector('#borchers-products-filter-container #filter-product-applications');
            const applicationGroupsUl = document.querySelector('#borchers-products-filter-container #application-filter');
            const applicationFilters = document.querySelectorAll('#application-filter li');
            // availability
            const availabilityGroups = document.querySelector('#borchers-products-filter-container #filter-product-availability');
            const availabilityGroupsUl = document.querySelector('#borchers-products-filter-container #availability-filter');
            const availabilityFilters = document.querySelectorAll('#availability-filter li');
            // brand
            const brandGroups = document.querySelector('#borchers-products-filter-container #filter-product-brand');
            const brandGroupsUl = document.querySelector('#borchers-products-filter-container #brand-filter');
            const brandFilters = document.querySelectorAll('#brand-filter li');
            // system
            const systemGroups = document.querySelector('#borchers-products-filter-container #filter-product-system');
            const systemGroupsUl = document.querySelector('#borchers-products-filter-container #system-filter');
            const systemFilters = document.querySelectorAll('#system-filter li');
            // dc-chemistry
            const chemistryGroups = document.querySelector('#borchers-products-filter-container #filter-product-chemistry');
            const chemistryGroupsUl = document.querySelector('#borchers-products-filter-container #chemistry-filter');
            const chemistryFilters = document.querySelectorAll('#chemistry-filter li');
            // dc-metal
            const metalGroups = document.querySelector('#borchers-products-filter-container #filter-product-metal');
            const metalGroupsUl = document.querySelector('#borchers-products-filter-container #metal-filter');
            const metalFilters = document.querySelectorAll('#metal-filter li');
            // dfms-removes-foam-from
            const removesFoamFromGroups = document.querySelector('#borchers-products-filter-container #filter-product-removes-foam-from');
            const removesFoamFromGroupsUl = document.querySelector('#borchers-products-filter-container #removes-foam-from-filter');
            const removesFoamFromFilters = document.querySelectorAll('#removes-foam-from-filter li');
            // fld-additional-tags
            const additionalTagsGroups = document.querySelector('#borchers-products-filter-container #filter-product-additional-tags');
            const additionalTagsGroupsUl = document.querySelector('#borchers-products-filter-container #additional-tags-filter');
            const additionalTagsFilters = document.querySelectorAll('#additional-tags-filter li');
            // fld-chemistry
            const fldChemistryGroups = document.querySelector('#borchers-products-filter-container #filter-product-fld-chemistry');
            const fldChemistryGroupsUl = document.querySelector('#borchers-products-filter-container #fld-chemistry-filter');
            const fldChemistryFilters = document.querySelectorAll('#fld-chemistry-filter li');
            // rheology-profile
            const rheologyProfileGroups = document.querySelector('#borchers-products-filter-container #filter-product-rheology-profile');
            const rheologyProfileUl = document.querySelector('#borchers-products-filter-container #rheology-profile-filter');
            const rheologyProfileFilters = document.querySelectorAll('#rheology-profile-filter li');
            // rlgy-application-method
            const rlgyApplicationMethodGroups = document.querySelector('#borchers-products-filter-container #filter-product-rlgy-application-method');
            const rlgyApplicationMethodUl = document.querySelector('#borchers-products-filter-container #rlgy-application-method-filter');
            const rlgyApplicationMethodFilters = document.querySelectorAll('#rlgy-application-method-filter li');
            // rheology-shear-rate
            const rheologyShearRateGroups = document.querySelector('#borchers-products-filter-container #filter-product-rheology-shear-rate');
            const rheologyShearRateUl = document.querySelector('#borchers-products-filter-container #rheology-shear-rate-filter');
            const rheologyShearRateFilters = document.querySelectorAll('#rheology-shear-rate-filter li');
            // wetting-inorganic-pigments
            const wettingInorganicPigmentsGroups = document.querySelector('#borchers-products-filter-container #filter-product-wetting-inorganic-pigments');
            const wettingInorganicPigmentsUl = document.querySelector('#borchers-products-filter-container #wetting-inorganic-pigments-filter');
            const wettingInorganicPigmentsFilters = document.querySelectorAll('#wetting-inorganic-pigments-filter li');
            // wetting-organic-pigments
            const wettingOrganicPigmentsGroups = document.querySelector('#borchers-products-filter-container #filter-product-wetting-organic-pigments');
            const wettingOrganicPigmentsUl = document.querySelector('#borchers-products-filter-container #wetting-organic-pigments-filter');
            const wettingOrganicPigmentsFilters = document.querySelectorAll('#wetting-organic-pigments-filter li');
            // wetting-pigments
            const wettingPigmentsGroups = document.querySelector('#borchers-products-filter-container #filter-product-wetting-pigments');
            const wettingPigmentsUl = document.querySelector('#borchers-products-filter-container #wetting-pigments-filter');
            const wettingPigmentsFilters = document.querySelectorAll('#wetting-pigments-filter li');
            // cta image container
            const ctaTopContainer = document.querySelector('#top-products-cta');
            // cta image container
            const ctaImageTopContainer = document.querySelector('#top-cta-image');
            // cta link container
            const ctaTopLink = document.querySelector('#top-products-cta a');
            // cta bottom container
            const ctaBottomContainer = document.querySelector('#bottom-products-cta');
            // cta bottom image container
            const ctaImageBottomContainer = document.querySelector('#bottom-cta-image');
            // cta bottom link container
            const ctaBottomLink = document.querySelector('#bottom-products-cta a');
            // hero image container
            const heroImageContainer = document.querySelector('#filter-hero-container');
            // h2 for message
            //const productsHeading = document.querySelector('#borchers-products-container > h2');
            const productsHeading = document.querySelector('#filter-hero-container h2');
            // p for message
            const productsParagraph = document.querySelector('#borchers-products-container > p');
            // ul for pagination
            const paginationUl = document.querySelector('#borchers-products-container #pagination');

            // filters map for secondary filtering
            const filterMap = {
                additionalTags: additionalTagsFilters,
                applications: applicationFilters,
                availability: availabilityFilters,
                brands: brandFilters,
                chemistry: chemistryFilters,
                fldChemistry: fldChemistryFilters,
                metals: metalFilters,
                removesFoamFrom: removesFoamFromFilters,
                rheologyProfile: rheologyProfileFilters,
                rheologyShearRate: rheologyShearRateFilters,
                rlgyApplicationMethod: rlgyApplicationMethodFilters,
                system: systemFilters,
                wettingInorganicPigments: wettingInorganicPigmentsFilters,
                wettingOrganicPigments: wettingOrganicPigmentsFilters,
                wettingPigments: wettingPigmentsFilters
            }

            const ulGroups = [
                productGroupsUl,
                applicationGroupsUl,
                availabilityGroupsUl,
                brandGroupsUl,
                systemGroupsUl,
                chemistryGroupsUl,
                metalGroupsUl,
                removesFoamFromGroupsUl,
                additionalTagsGroupsUl,
                fldChemistryGroupsUl,
                rheologyProfileUl,
                rlgyApplicationMethodUl,
                rheologyShearRateUl,
                wettingInorganicPigmentsUl,
                wettingOrganicPigmentsUl,
                wettingPigmentsUl

            ]

            const attributeGroups = {
                //Key -> value: array of [ul and container]
                'filter-product-groups':[productGroups, productGroupsUl],
                'filter-product-applications':[applicationGroups, applicationGroupsUl],
                'filter-product-availability':[availabilityGroups, availabilityGroupsUl],
                'filter-product-brand':[brandGroups, brandGroupsUl],
                'filter-product-system':[systemGroups, systemGroupsUl],
                'filter-product-chemistry':[chemistryGroups, chemistryGroupsUl],
                'filter-product-metal':[metalGroups, metalGroupsUl],
                'filter-product-removes-foam-from':[removesFoamFromGroups, removesFoamFromGroupsUl],
                'filter-product-additional-tags':[additionalTagsGroups, additionalTagsGroupsUl],
                'filter-product-fld-chemistry':[fldChemistryGroups, fldChemistryGroupsUl],
                'filter-product-rheology-profile':[rheologyProfileGroups, rheologyProfileUl],
                'filter-product-rlgy-application-method':[rlgyApplicationMethodGroups, rlgyApplicationMethodUl],
                'filter-product-rheology-shear-rate':[rheologyShearRateGroups, rheologyShearRateUl],
                'filter-product-wetting-inorganic-pigments':[wettingInorganicPigmentsGroups, wettingInorganicPigmentsUl],
                'filter-product-wetting-organic-pigments':[wettingOrganicPigmentsGroups, wettingOrganicPigmentsUl],
                'filter-product-wetting-pigments':[wettingPigmentsGroups, wettingPigmentsUl]
            }
            
            // EVENT LISTENERS
            productGroups?.addEventListener('click', toggleMenu);
            applicationGroups?.addEventListener('click', toggleMenu);
            availabilityGroups?.addEventListener('click', toggleMenu);
            brandGroups?.addEventListener('click', toggleMenu);
            systemGroups?.addEventListener('click', toggleMenu);
            chemistryGroups?.addEventListener('click', toggleMenu);
            metalGroups?.addEventListener('click', toggleMenu);
            removesFoamFromGroups?.addEventListener('click', toggleMenu);
            additionalTagsGroups?.addEventListener('click', toggleMenu);
            fldChemistryGroups?.addEventListener('click', toggleMenu);
            rheologyProfileGroups?.addEventListener('click', toggleMenu);
            rlgyApplicationMethodGroups?.addEventListener('click', toggleMenu);
            rheologyShearRateGroups?.addEventListener('click', toggleMenu);
            wettingInorganicPigmentsGroups?.addEventListener('click', toggleMenu);
            wettingOrganicPigmentsGroups?.addEventListener('click', toggleMenu);
            wettingPigmentsGroups?.addEventListener('click', toggleMenu);
            resetFilterElement?.addEventListener('click', resetFilter);

            categoryFilters?.forEach(filter => {
                filter.addEventListener('click', changeCategory)
            });
            applicationFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            availabilityFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            brandFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            systemFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            chemistryFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            metalFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            removesFoamFromFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            additionalTagsFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            fldChemistryFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            rheologyProfileFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            rlgyApplicationMethodFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            rheologyShearRateFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            wettingInorganicPigmentsFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            wettingOrganicPigmentsFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            });
            wettingPigmentsFilters?.forEach(filter => {
                filter.addEventListener('click', checkEventParent)
            })


            // FUNCTIONS

            function applyAllFilters() {
                const customProductsList = document.querySelectorAll('#custom-products-list li');

                if (!customProductsList) {
                    errors.push('Validation error: Custom Products List empty.');
                    return;
                }

                // Each item is the li element of the product card
                customProductsList.forEach(item => {
                    // If no filters active → show everything
                    if (activeFilters.size === 0) {
                        // Add items to active products set to later paginate
                        customProductsList.forEach(item => {
                            activeProducts.add(item);
                            inactiveProducts.delete(item);
                        });
                    }

                    // Collect ALL terms from this product across ALL data attributes
                    const allProductTerms = new Set();

                    // Add terms from each possible data attribute
                    item.dataset.categories?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.applications?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.availability?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.brands?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.system?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.chemistry?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.metals?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.removesFoamFrom?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.additionalTags?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.fldChemistry?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.rheologyProfile?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.rlgyApplicationMethod?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.rheologyShearRate?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.wettingInorganicPigments?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.wettingOrganicPigments?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.wettingPigments?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));
                    item.dataset.productTags?.trim().split(/\s+/).forEach(t => allProductTerms.add(t));

                    
                    // Check if product has EVERY required filter term
                    const hasAllRequired = [...activeFilters].every(requiredTerm => 
                        allProductTerms.has(requiredTerm)
                    );

                    // Adds or removes products that match filter to a set for pagination
                    if (hasAllRequired) {
                        activeProducts.add(item);
                        inactiveProducts.delete(item);
                    } else {
                        activeProducts.delete(item);
                        inactiveProducts.add(item);
                    }

                });

            }

            // reset arguement can be passed to change functionality
            function applySecondaryFilters(reset) {
                
                if (primaryFilterActive === true) {

                    // This will hold all unique values for each data attribute
                    const combinedFilters = {};

                    // Loop through everything in activeProducts set
                    activeProducts.forEach(activeProduct => {

                        const data = { ...activeProduct.dataset };   // Spread into a plain object

                        // Go through each data attribute of this product
                        Object.entries(data).forEach(([key, value]) => {

                            // Split values that have spaces (like "floor-coatings-additives lubricants-greases")
                            const valuesArray = value.trim().split(/\s+/);

                            // Initialize the array for this key if it doesn't exist yet
                            if (!combinedFilters[key]) {
                                combinedFilters[key] = new Set();   // Use Set to avoid duplicates
                            }

                            // Add each value to the set
                            valuesArray.forEach(val => {
                                if (val) combinedFilters[key].add(val);
                            });

                        });

                    });

                    // Convert Sets back to sorted arrays for easier processing
                    const finalCombinedFilters = {};
                    Object.keys(combinedFilters).forEach(key => {
                        finalCombinedFilters[key] = Array.from(combinedFilters[key]).sort();
                    });

                    // Loop through all data in filterMap to process all filters at once
                    Object.entries(filterMap).forEach(([filterKey, filterElements]) => {
                        // SelectedValues is the main category term
                        const selectedValues = finalCombinedFilters[filterKey];

                        if (!Array.isArray(selectedValues)) {
                            console.warn(`Filter type "${filterKey}" is not an array. Got:`, selectedValues);
                            return;
                        }

                        // Using selectedValues allows us to process all the filter groups without repeating
                        filterElements.forEach(filterElement => {
                            const shouldShow = selectedValues.includes(filterElement.id);
                            filterElement.classList.toggle('hidden', !shouldShow);
                            if (reset === 'reset') {
                                filterElement.classList.remove('hidden');
                                // Filter element is the li we need to get the input to make sure all boxes are unchecked
                                const filterElementInput = filterElement.firstChild.nextSibling;
                                filterElementInput.checked = false;
                            }
                        });
                    });

                    // Here we need to check all the uls and if they contain lis with hidden class then hide the ul
                    ulGroups.forEach(ulGroup => {
                        //console.log('UL Group: ',ulGroup);
                        const allListItems = Array.from(ulGroup.querySelectorAll('li'));
                        const closestHeading = ulGroup.previousElementSibling;

                        // .every() returns true ONLY if every single item matches the condition
                        const allItemsHiddenBool = allListItems.every(item => 
                            item.classList.contains('hidden')
                        );
                        if (allItemsHiddenBool === true) {
                            ulGroup.classList.add('hidden');
                            closestHeading.classList.add('hidden'); 
                        }
                        if (reset === 'reset') {
                            ulGroup.classList.remove('hidden');
                            closestHeading.classList.remove('hidden');
                        }
                    })
                } 
            }

            // Takes two parameters with the first being the category selected and the second being a boolean of checked set to false by default
            function buildActiveFilters(activeCategory, isChecked = null) {

                if (!activeCategory) {
                    errors.push('Validation error: active category is empty.');
                }

                // First scenario if this was ran with a checkbox input
                if (isChecked !== null) {
                    if (isChecked) {
                        activeFilters.add(activeCategory);
                    } else {
                        activeFilters.delete(activeCategory);
                    }

                    return;
                } 

                // Second scenario function is being ran for a regular link without isChecked arguement
                if (activeCategory) {
                    activeFilters.add(activeCategory);
                    return;
                }
                
            }

            //takes the current active category and sets an appropriate class for the current nav item and its ancestors
            function setActiveNavElements(activeCategory) {
                //console.log("set active nav elements for: " + activeCategory);
                var navitems = document.getElementsByClassName('ubermenu-target-text');
                for (let i = 0; i < navitems.length; i++) {
                    if (navitems[i].textContent.replaceAll(' ', '-').toLowerCase() == activeCategory) {
                        navitems[i].closest('li').classList.add('ubermenu-current-menu-item')
                    //console.log(navitems[i]);
                        }
                }
                return;
            }


            function buildPagination(totalPages, ulElement) {
                ulElement.innerHTML = ''; // clear old state

                //console.log(`In function build pagination and window.currentPage is = ${window.currentPage}`);
                if (totalPages <= 1) return;

                // Previous
                if (window.currentPage > 1) {
                    const li = document.createElement('li');
                    const a = document.createElement('a');
                    const i = document.createElement('i');
                    li.classList.add('previous-page');
                    a.href = '#';
                    a.textContent = '';
                    a.addEventListener('click', (e) => {
                        e.preventDefault();
                        //console.log("[PAGINATION CLICK] Going to previous — was:", currentPage);
                        window.currentPage--;
                        paginateProducts(); // re-run with new page
                    });
                    i.classList.add('fa-solid');
                    i.classList.add('fa-caret-left');
                    a.appendChild(i);
                    li.appendChild(a);
                    ulElement.appendChild(li);
                }

                // Need to create a variable for getting the current page number such as 3 and then only populating page numbers 2 before and 2 after that numbers 
                let paginationStart = window.currentPage - 2;
                let paginationEnd = window.currentPage + 2;
                // Page numbers 
                for (let i = 1; i <= totalPages; i++) {
                    // Conditional if i > pagination start and < pagination end then create the actual pagination elements
                    if (i >= paginationStart && i<= paginationEnd) {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.href = '#';
                        a.textContent = i;
                        if (i === window.currentPage) {
                            li.classList.add('active');
                        }
                        a.addEventListener('click', (e) => {
                            e.preventDefault();
                            //console.log("[PAGINATION CLICK] Going to page:", i, "— was:", currentPage);
                            window.currentPage = i;
                            paginateProducts();
                        });
                        li.appendChild(a);
                        ulElement.appendChild(li);
                    }
    
                }

                // Next 
                if (window.currentPage < totalPages) {
                    const li = document.createElement('li');
                    const a = document.createElement('a');
                    const i = document.createElement('i');
                    li.classList.add('next-page');
                    a.href = '#';
                    a.textContent = '';
                    a.addEventListener('click', (e) => {
                        e.preventDefault();
                        //console.log("[PAGINATION CLICK] Going to next — was:", currentPage);
                        window.currentPage++;
                        paginateProducts();
                    });
                    i.classList.add('fa-solid');
                    i.classList.add('fa-caret-right');
                    a.appendChild(i);
                    li.appendChild(a);
                    ulElement.appendChild(li);
                }

            }


            // Handle click events for links in category filter 
            function changeCategory(event) {

                // If null function is being called from reset filter function
                if (event === null) {
                    changeCategoryDetails('default');
                    applyAllFilters();
                    paginateProducts();
                    return;
                }

                // If no event then this is the initial run and we use the processedUrl as the arguement
                if (event === undefined) {

                    if (location.pathname == '/products/') {
                        changeCategoryDetails('default');
                        applyAllFilters();
                        paginateProducts();
                        return;
                    } else {
                        primaryFilterActive = true;
                        changeCategoryDetails(processedUrl);
                        buildActiveFilters(processedUrl);
                        setActiveNavElements(processedUrl);
                        applyAllFilters();
                        applySecondaryFilters();
                        paginateProducts();
                        return;
                    }
                    
                } else if (event) {
                    let li = '';
                    let filterCategory = '';

                    li = event.currentTarget;
                    filterCategory = li.dataset.filterCategory;
                    if (filterCategory == undefined) {
                        errors.push('Validation error: filter category undefined');
                        return;
                    }

                    // Set primaryFilterActive to true so we know to change the subsequent functionality
                    primaryFilterActive = true;
                    
                    // Clear all filters so they do not stack
                    activeFilters.clear();

                    // Build active filters and change category details like image and text
                    changeCategoryDetails(filterCategory);
                    buildActiveFilters(filterCategory);
                    applyAllFilters();
                    // Reset page
                    window.currentPage = 1;
                    paginateProducts();
                }  
            }


            function changeCategoryDetails(category) {
                
                if (!category) {
                    errors.push('Validation error: category is empty.');
                    return;
                }

                productsParagraph.innerText = ''; // reset text

                let currentPathname = location.pathname; // get current pathname to compare against category data

                let currentCategory = categoriesData[category];

                if (currentCategory.name === "default") {
                    productsHeading.innerText = "Product Filter";
                }
                else {
                    productsHeading.innerText = currentCategory.name;
                }
                //productsHeading.innerText = (currentCategory.name !== "default") ? currentCategory.name : "Product Filter";
                productsParagraph.innerHTML = currentCategory.text;
                //console.log(currentCategory.text);
                

                if (ctaTopContainer && ctaImageTopContainer && ctaTopLink) {
                    ctaTopContainer.classList.remove('hide');
                    ctaImageTopContainer.src = currentCategory.ctaTopImage;
                    ctaTopLink.href = currentCategory.ctaTopLink;
                }

                if (ctaBottomContainer && ctaImageBottomContainer && ctaBottomLink) {
                    ctaBottomContainer.classList.remove('hide');
                    ctaImageBottomContainer.src = currentCategory.ctaBottomImage;
                    ctaBottomLink.href = currentCategory.ctaBottomLink;
                }

                // top image check
                let topImageCheck = currentCategory.ctaTopImage;
                if (topImageCheck === undefined) {
                    ctaTopContainer.classList.add('hide');
                }

                let bottomImageCheck = currentCategory.ctaBottomImage;
                if (bottomImageCheck === undefined) {
                    ctaBottomContainer.classList.add('hide');
                }

                if (heroImageContainer) {

                    heroImageContainer.style.setProperty(
                        "background-image",
                        `url(${currentCategory.heroImage})`,
                        "important"
                    );

                } else {
                    errors.push('Validation error : Hero image container empty.');
                }
                

                if (currentPathname !== currentCategory.url) {
                    history.replaceState(null, '', currentCategory.url);
                }

            }


            // Check parent of click event to determine which term was clicked for checkboxes
            function checkEventParent(event) {
                const li = event.currentTarget;
                const input = li.querySelector('input');
                const checked = input.checked;

                // Get the term value — works for any filter group
                let term = '';
                if (li.dataset.filterCategory) term = li.dataset.filterCategory;
                else if (li.dataset.filterApplication) term = li.dataset.filterApplication;
                else if (li.dataset.filterAvailability) term = li.dataset.filterAvailability;
                else if (li.dataset.filterBrand) term = li.dataset.filterBrand;
                else if (li.dataset.filterSystem) term = li.dataset.filterSystem;
                else if (li.dataset.filterDcChemistry) term = li.dataset.filterDcChemistry;
                else if (li.dataset.filterDcMetal) term = li.dataset.filterDcMetal;
                else if (li.dataset.filterDefmsRemovesFoamFrom) term = li.dataset.filterDefmsRemovesFoamFrom;
                else if (li.dataset.filterFldAdditionalTags) term = li.dataset.filterFldAdditionalTags;
                else if (li.dataset.filterFldChemistry) term = li.dataset.filterFldChemistry;
                else if (li.dataset.filterRheologyProfile) term = li.dataset.filterRheologyProfile;
                else if (li.dataset.filterRlgyApplicationMethod) term = li.dataset.filterRlgyApplicationMethod;
                else if (li.dataset.filterRheologyShearRate) term = li.dataset.filterRheologyShearRate;
                else if (li.dataset.filterWettingInorganicPigments) term = li.dataset.filterWettingInorganicPigments;
                else if (li.dataset.filterWettingOrganicPigments) term = li.dataset.filterWettingOrganicPigments;
                else if (li.dataset.filterWettingPigments) term = li.dataset.filterWettingPigments;

                if (!term) {
                    errors.push('Validation error: dataset term is empty or does not match.');
                    return;
                }

                // Set primaryFilterActive to true so we know to change the subsequent functionality
                primaryFilterActive = true;

                buildActiveFilters(term, checked);
                applyAllFilters();
                applySecondaryFilters();
                // Reset page
                window.currentPage = 1;
                paginateProducts();
            }


            // Should have both active and inactive product sets ready for processing now
            function paginateProducts() {
                //console.log("[paginate] Starting — currentPage:", window.currentPage);
                const productsPerPage = 10;
                const customProductsList = document.querySelectorAll('#custom-products-list li');
                //console.log("[paginate] Found", customProductsList.length, "product LIs");

                // Reset all product cards
                customProductsList?.forEach( card => {
                    // Remove classes set by pagination
                    card.classList.remove('show-filtered-products');
                    card.className = card.className.replace(/\bpage-\d+\b/g, '').trim();
                    card.style.display = 'none';
                })

                if ( activeProducts.size === 0 ) {
                    productsHeading.innerText = "No products match.";
                    paginationUl.innerHTML = ''; // clear pagination
                    return;
                }
                else {
                    if (productsHeading.innerText == "No products match.") productsHeading.innerText = "Product Filter";
                }

                // Convert set to array for easier processing
                const activeArray = Array.from(activeProducts);
                //console.log("[paginate] Active products:", activeArray.length);

                // Calculate total pages by dividing the total active products  by products per page set at 10
                const totalPages = Math.ceil(activeArray.length / productsPerPage);
                //console.log("[paginate] Total pages:", totalPages, "— showing page", currentPage);

                // Set parameters to slice the current pages 10 products
                const start = (window.currentPage -1 ) * productsPerPage;
                const end = start + productsPerPage;
                //console.log("[paginate] Slice indices:", start, "to", end - 1);

                // Gets the active group of ten active products
                const pageProducts = activeArray.slice(start, end);
                //console.log("[paginate] Showing", pageProducts.length, "products this page");

                // Now show the ten products set to currently be displayed
                pageProducts.forEach(product => {
                    product.classList.add('show-filtered-products');
                    product.style.display = 'block';
                });

                // Build pagination controls
                buildPagination(totalPages, paginationUl);
            }

            // Reset all categories and filters
            function resetFilter() {
                
                // Clear active filters
                activeFilters.clear();
                applySecondaryFilters('reset');
                primaryFilterActive = false;
                // Change category using null so the function knows its coming from reset
                changeCategory(null);
            }

            
            // Toggles filter menus based on the id of event
            function toggleMenu(event) {
                const elementId = event.currentTarget.id;

                // check the element against our menu groups
                const elements = attributeGroups[elementId];

                if (!elements) {
                    errors.push('Validation error: elements are empty.');
                    return;
                }

                const [group, ul] = elements;

                group.classList.toggle('open-menu');
                ul.classList.toggle('open-list');
            }


            // Check for errors and log if length is more than zero
            if (errors.length > 0) {
                console.group('Completed with errors:');
                errors.forEach(err => {
                    console.error(` - ${err}`);
                })
                console.groupEnd();
            }

            // INIT

            // Start by running change category
            changeCategory();
            
        })
    }
}

productsFilterShortcodeCheck();