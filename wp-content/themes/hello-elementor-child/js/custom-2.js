

//Responsive menu
jQuery(document).ready(function () {
	jthis = jQuery(document);
	jthis.find('.responsive_menu .has-submenu').each(function () {
		var link = jQuery(this);
		if (link.find('.toggle-submenu-button').length)
			return true;
		link.prepend(jQuery('<span class="toggle-submenu-button"><i class="fas fa-angle-down"></i></span>'))
		// .click(function(){
		// jQuery(this).toggleClass('open-submenu').closest('li').find('>ul').slideToggle(300);
		// 	return false;
		// }
		// ));
	});

	jQuery('#trigger-overlay').click(function () {
		jQuery('.overlay-slidedown').addClass('open');
	});
	jQuery('.overlay-close').click(function () {
		jQuery('.overlay-slidedown').removeClass('open');
	});
	if (window.location.hash) {
    	console.log('hash: ' + window.location.hash);
		var elemToClick = document.querySelector('a[href="' + window.location.hash + '"]');
		if (elemToClick) {
			console.log("HASH FOUND");
			elemToClick.click();
		}
	}
});


 
// jQuery(document).on('click', '.search-item', function () {
// 	jQuery('.search-box').toggleClass('show');
// 	jQuery('.main-nav').toggleClass('fill');
// })
// jQuery(document).on('click', '.main-nav.fill', function(){
// 	jQuery('.search-box').removeClass('show');
// 	jQuery(this).removeClass('fill');
// })
// jQuery(document).on('click', '.search-box', function(e){
// 	e.stopPropagation();
// })

// nav pills
jQuery(document).on('click', '.info-center-main .nav-pills li a.main-pill', function () {
	if (jQuery(this).parent().find('.subs').is(':visible')) {
		//jQuery(this).parent().find('.subs').removeClass('show');
	} else {
		jQuery('.subs').slideUp('show');
		jQuery(this).parent().find('.subs').slideDown();
		var span = jQuery(this).find("span");
		var name = jQuery(this).text();
		if (span.length > 0) {
			name = span.text();
		}
		Analytics.infoCenterClick(name);
	}
})

jQuery(document).on('click', '.info-center-main .tab-content .info-content ul li a, .info-center-main .tab-content table  tr th a', function () {

	var url = jQuery(this).attr('href');
	Analytics.infoCenterDownloadFile(url);
	return true;

})
jQuery(document).on('click', '.download_datasheet', function () {

	var url = jQuery(this).attr('href');
	Analytics.downloadDatasheetClick(url);
	return true;

})
jQuery(function () {
	jQuery('.popup-modal').magnificPopup({
		type: 'inline',
		closeOnBgClick: false,
	});
	jQuery(document).on('click', '.popup-modal-dismiss', function (e) {
		e.preventDefault();
		// jQuery(this).parent().find('.video-inner video')[0].pause();
		jQuery.magnificPopup.close();
	});
});

// jQuery(document).on('click', '.subs li a', function(){
// 	var jump = jQuery(this).attr('scrollto');
// 	jQuery('html, body').animate({
// 		scrollTop: jQuery(jump).offset().top - 93
// 	}, 500);	
// })


// scrolltop
jQuery(document).on('click', '.scrolltop', function () {
	jQuery('body,html').animate({ scrollTop: 0 }, 700);
})
jQuery(document).scroll(function () {
	if (jQuery(this).scrollTop() > 300) {
		jQuery('.scrolltop').show();
	}
	else {
		jQuery('.scrolltop').hide();
	}
});

// jQuery(document).on('click', '.main-sub .toggle-submenu-button', function(){
// 	alert();
// 	// jQuery(this).parent().find('.sub-menu').slideDown(300);
// 	if(jQuery(this).parent().find('.sub-menu').is(':visible')){
// 		jQuery(this).parent().find('.sub-menu').slideUp(300);
// 	}else{
// 		jQuery('.main-sub > .toggle-submenu-button:first-child').slideUp(300);
// 		jQuery(this).parent().find('.sub-menu').slideDown(300);
// 	}
// })


// responsive-menu slide
jQuery(document).on('click', '.toggle-submenu-button', function () {
	// jQuery(this).addClass('open-submenu');
	if (jQuery(this).hasClass('open-submenu')) {
		jQuery(this).removeClass('open-submenu');
	} else {
		jQuery(this).parent().siblings('.has-submenu').find('.toggle-submenu-button').removeClass('open-submenu');
		jQuery(this).addClass('open-submenu');
	}



	// jQuery(this).siblings('.sub-menu').slideDown();
	if (jQuery(this).siblings('.sub-menu').is(':visible')) {
		jQuery(this).siblings('.sub-menu').slideUp(300);
	} else {
		jQuery(this).siblings('.sub-menu').slideDown(300);
		jQuery(this).parent().siblings('.has-submenu').find('.sub-menu').slideUp(300);
	}
})

jQuery(document).on('click', '.res-menu-icon', function () {
	// jQuery(this).toggleClass('active');
	/*jQuery('.responsive_menu').slideToggle(300);*/
	jQuery('.responsive_menu').toggleClass('open');
})

// sticky header
jQuery(document).scroll(function () {
	if (jQuery(this).scrollTop() > 32) {
		jQuery('header').addClass('sticky')
		jQuery('.site-loader').addClass('sticky-loader');
	}
	else {
		jQuery('header').removeClass('sticky')
		jQuery('.site-loader').removeClass('sticky-loader');
	}
});

/*product filter*/
jQuery(document).on('click', '.filter-head', function () {
	jQuery(this).next('.sub-filter-menu, .checkbox-filters').slideToggle();
	jQuery(this).toggleClass('filter-opened')
})
jQuery(document).on('click', '.sub-filtter-arrow', function () {
	jQuery(this).next('.sub-filter-cat').slideToggle();
	jQuery(this).toggleClass('sub-filter-opened')
})
/* res search*/
jQuery(document).on('click', '.res-search', function () {
	jQuery('.search-box').toggleClass('active');
	jQuery(this).toggleClass('active');
})

/*site loader*/
jQuery(window).on('load', function () {
	jQuery('.site-loader').fadeOut(400);
	jQuery('.site-loader').addClass('closed');
	checkUsed();
});


jQuery(window).bind('beforeunload', function (e) {
	jQuery('.site-loader').fadeIn(300);
});

jQuery(document).on('click', 'li.addcustom:not(.added)', function (e) {
	e.preventDefault();
	var jQuerythisbutton = jQuery(this),
		jQueryprmain = jQuerythisbutton.closest('.product'),
		jQueryprid = jQueryprmain.attr('id');
	jQuerythisbutton.find('a img').hide();
	jQuerythisbutton.find('a').prepend('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i><i class="fa fa-check-square-o" aria-hidden="true"></i>');
	jQuerythisbutton.find('a span').text('Adding To Your Sample Order');

	var data = {
		action: 'path_ajax_add_to_cart',
		product_id: jQueryprid,
		quantity: 1
	};

	jQuery('body').trigger('adding_to_cart', [jQuerythisbutton, data]);

	jQuery.ajax({
		type: 'post',
		url: wc_add_to_cart_params.ajax_url,
		data: data,
		beforeSend: function (response) {
			jQuerythisbutton.addClass('loading');
		},
		complete: function (response) {
			jQuerythisbutton.addClass('added').removeClass('loading');
		},
		success: function (response) {

			if (response.error & response.product_url) {
				window.location = response.product_url;
				return;
			} else {
				jQuerythisbutton.find('a span').text('Added To Your Sample Order');
				jQueryprmain.find('div.view-basket a').show();
				jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
			}
		},
	});

	return false;
});

/*jQuery(document).on('change', '#country', function (e) {
	e.preventDefault();
	loadSaftyData('language');
});
jQuery(document).on('change', '#language', function (e) {
	e.preventDefault();
	loadSaftyData('sheet');
});*/


/*jQuery(document).ready(function() {
	if(jQuery('#country').val()!='') {
		loadSaftyData('language');	
	}
	
});*/
var firstLoad = 0;
function loadSaftyData(type) {
	country = jQuery('#country').val();
	productID = jQuery('#productID').val();
	language = jQuery('#language').val();

	var data = {
		action: 'get_language',
		type: type,
		country: country,
		language: language,
		productID: productID,
		firstLoad: firstLoad,
	};
	jQuery.ajax({
		type: 'post',
		url: wc_add_to_cart_params.ajax_url,
		data: data,
		dataType: "json",
		beforeSend: function (response) {
			jQuery('.sheet_loading').show();
			if (type == 'language') {
				jQuery('.sheet_details').hide();
				jQuery('.language').hide();

			}
			else if (type == 'sheet') {
				jQuery('.sheet_details').hide();
			}
		},
		complete: function (response) {
			jQuery('.sheet_loading').hide();
		},
		success: function (response) {

			if (type == 'language') {
				console.log(response);
				jQuery('.language').show();
				jQuery('.sheet_details').hide()
				jQuery('.language_list').mCustomScrollbar("destroy");
				jQuery('.language_list').html(response.result_set);
				jQuery(".language_list").mCustomScrollbar();
				if (response.language_default == 1) {
					jQuery('#language').val('English');
					jQuery('.language .sel-title span').html('English');
				}
				if (firstLoad == 0) {
					loadSaftyData('sheet');
				}

			}
			else if (type == 'sheet') {
				firstLoad++;
				jQuery('.sheet_details').show().html(response.result_set);

			}
		},
	});

	return false;
}

jQuery(document).ready(function () {
	jQuery('body').on('click', '.mCSB_draggerContainer', function (event) {
		event.preventDefault();
		event.stopImmediatePropagation();
	});
});

jQuery(document).ajaxComplete(function () {
	checkUsed();
});

/*custom product select */
jQuery(document).on("click", ".sel-title", function (event) {

	event.stopPropagation();
	if (jQuery(this).next().is(":visible")) {
		jQuery(this).next().slideUp(10);
	} else {
		jQuery(".sel-list").slideUp(10);
		jQuery(this).next().slideDown(10);
	}

	if (jQuery(this).parents(".custom-sel-dropdown").hasClass("open")) {
		jQuery(this).parents(".custom-sel-dropdown").removeClass("open")
	} else {
		jQuery(".custom-sel-dropdown").removeClass("open")
		jQuery(this).parents(".custom-sel-dropdown").addClass("open")
	}
})


jQuery(document).on("click", ".sel-list li a", function () {
	let val = jQuery(this).html();
	jQuery(".sel-list").slideUp(10);
	current = jQuery(this).data('types');
	if (current == 'country') {
		jQuery('.language .sel-title span').html('Select Language');
		jQuery('#country').val(jQuery(this).data('country'));
		jQuery('#language').val('');
		loadSaftyData('language');
	}
	else if (current == 'language') {
		jQuery('#language').val(jQuery(this).data('language'));
		loadSaftyData('sheet');
	}

	jQuery(this).parents(".custom-sel-dropdown").find(".sel-title span").html(val);
	jQuery(".custom-sel-dropdown").removeClass("open")
})

jQuery(window).on("load", function () {
	jQuery(".mCustomScrollbar.country-list").mCustomScrollbar();
})

/*remove custom sel class outside click*/
var outside = false;


jQuery(document).on("click", "body", function () {
	outside = true;
	if (outside) {
		jQuery(".custom-sel-dropdown").removeClass("open");
		jQuery(".sel-list").slideUp(10);
	}
})


jQuery(document).on("click", ".custom-sel-dropdown", function () {
	outside = false;
})


/*formualtion links */
jQuery(document).on("click", ".formulation-category", function (event) {

	event.stopPropagation();
	var id = jQuery(this).data("id");
	var imageUrl = jQuery(this).data("image-url");
	jQuery(".formulation-grp.category-tiles").hide();
	jQuery(".formulation-category-container").hide();
	jQuery(".formulation-category").removeClass("selected");
	jQuery("#" + id).show();
	jQuery("a[data-id=" + id).addClass("selected");
	jQuery(".formulations-filters input").each(function () {
		jQuery(this).prop("checked", false);
	});
	prepareFilters1(id);
	applyFormualtionsFilters();
})
var checkUrlParameter = function () {

}

jQuery(document).ready(function () {
	if (window.location.href.indexOf("starting-point-formulations") > -1) {
		jQuery(".tab-pane").removeClass("active");
		jQuery("#tab_b1.tab-pane").addClass("active");
		jQuery(".info-sidebar li a").removeClass("active");
		var menuLink = jQuery("a.spf");
		menuLink.addClass("active");
		var subs = menuLink.parent().find(".subs");
		subs.show();
	}
});

var selectStartingPointFormulationsTab = function () {
	jQuery(".formulation-category").removeClass("selected");
	jQuery(".formulations-filters input").each(function () {
		jQuery(this).attr("disabled", "disabled");
		jQuery(this).prop("checked", false);
	});
	jQuery(".formulation-grp.category-tiles").show();
	jQuery(".formulation-category-container").hide();
}
jQuery(document).on("click", "a[href='#tab_b1']", function (event) {

	event.stopPropagation();
	selectStartingPointFormulationsTab();
})
var prepareFilters = function (categoryId) {
	var regionFilter = [];
	var systemFilter = [];
	var chemistryFilter = [];
	jQuery("#" + categoryId).find("table.tablesaw tr.formulation-row:not(.hide)").each(function () {

		var row = jQuery(this);
		var region = row.data("availability").toString();
		var system = row.data("system").toString();
		var chemistry = row.data("chemistry").toString();
		if (!regionFilter.includes(region)) regionFilter.push(region);
		if (!systemFilter.includes(system)) systemFilter.push(system);
		if (!chemistryFilter.includes(chemistry)) chemistryFilter.push(chemistry);
	});
	setCheckboxVisibility(regionFilter, "availability");
	setCheckboxVisibility(systemFilter, "system");
	setCheckboxVisibility(chemistryFilter, "chemistry");


}
var prepareFilters1 = function (categoryId) {
	var regionFilter = getChecked("availability");
	var systemFilter = getChecked("system");
	var chemistryFilter = getChecked("chemistry");

	jQuery(".formulations-filters input[name=" + "availability" + "]").each(function () {
		var value = jQuery(this).val();
		var any = false;
		for (var i = 0; i < systemFilter.length; i++) {
			for (var j = 0; j < chemistryFilter.length; j++) {

				any |= isAnyRowMatching(categoryId, value, systemFilter[i], chemistryFilter[j]);
			}
		}
		setEnable(jQuery(this), any);
	});

	jQuery(".formulations-filters input[name=" + "system" + "]").each(function () {
		var value = jQuery(this).val();
		var any = false;
		for (var i = 0; i < regionFilter.length; i++) {
			for (var j = 0; j < chemistryFilter.length; j++) {

				any |= isAnyRowMatching(categoryId, regionFilter[i], value, chemistryFilter[j]);
			}
		}
		setEnable(jQuery(this), any);
	});
	jQuery(".formulations-filters input[name=" + "chemistry" + "]").each(function () {
		var value = jQuery(this).val();
		var any = false;
		for (var i = 0; i < regionFilter.length; i++) {
			for (var j = 0; j < systemFilter.length; j++) {

				any |= isAnyRowMatching(categoryId, regionFilter[i], systemFilter[j], value);
			}
		}
		setEnable(jQuery(this), any);
	});

}
var isAnyRowMatching = function (categoryId, availabilityVal, systemVal, chemistryVal) {
	var mathingRows = jQuery("#" + categoryId).find("tr.formulation-row[data-availability*=" + availabilityVal + "][data-system*=" + systemVal + "][data-chemistry*=" + chemistryVal + "]");
	return mathingRows.length > 0;
}
var setEnable = function (checkbox, isEnable) {
	if (isEnable) {
		checkbox.removeAttr("disabled");
	}
	else {

		checkbox.attr("disabled", "disabled");
		checkbox.prop("checked", false);
	}
}
var getChecked = function (name) {
	var filterList = [];
	var fullList = [];
	jQuery(".formulations-filters input[name=" + name + "]").each(function () {
		var value = jQuery(this).val();
		fullList.push(value);
		if (jQuery(this).is(':checked')) {
			filterList.push(value);
		}
	});
	if (filterList.length > 0) {
		return filterList;
	}
	return fullList;
}
var setCheckboxVisibility = function (array, name) {
	jQuery(".formulations-filters input[name=" + name + "]").each(function () {
		var value = jQuery(this).val();
		if (array.includes(value)) {
			jQuery(this).removeAttr("disabled");
		}
		else {
			jQuery(this).attr("disabled", "disabled");
			jQuery(this).prop("checked", false);
		}
	});
}

var checkIfContains = function (filterArray, attr) {
	var values = attr.split(',');
	for (var i = 0; i < values.length; i++) {
		var value = values[i].trim();
		if (filterArray.includes(value)) {
			return true;
		}
	}

	return false;
}

var checkRowVisibility = function (colorCategoryContainer, regionFilter, systemFilter, chemistryFilter) {

	var rows = colorCategoryContainer.find("table.tablesaw tr.formulation-row");
	var showTitle = false;
	rows.each(function () {
		var visible = true;
		var row = jQuery(this);
		if (regionFilter.length > 0) {
			var region = row.data("availability").toString();
			visible &= checkIfContains(regionFilter, region);
		}
		if (systemFilter.length > 0) {
			var system = row.data("system").toString();
			visible &= checkIfContains(systemFilter, system);
		}
		if (chemistryFilter.length > 0) {
			var chemistry = row.data("chemistry").toString();
			visible &= checkIfContains(chemistryFilter, chemistry);
		}
		if (visible) {
			row.removeClass("hide");
			showTitle = true;
		}
		else {
			row.addClass("hide");
		}
	});
	var title = colorCategoryContainer.find("h4");
	if (showTitle) {
		title.show();
	}
	else {
		title.hide();
	}
}

var applyFormualtionsFilters = function () {
	var regionFilter = [];
	jQuery(".formulations-filters input[name=availability]:checked").each(function () {
		regionFilter.push(jQuery(this).val());
	});
	var systemFilter = [];
	jQuery(".formulations-filters input[name=system]:checked").each(function () {
		systemFilter.push(jQuery(this).val());
	});
	var chemistryFilter = [];
	jQuery(".formulations-filters input[name=chemistry]:checked").each(function () {
		chemistryFilter.push(jQuery(this).val());
	});

	var colorCategories = jQuery(".color-category");

	colorCategories.each(function () {
		var colorCategoryContainer = jQuery(this);
		checkRowVisibility(colorCategoryContainer, regionFilter, systemFilter, chemistryFilter);
	});

	var activeCategoryId = jQuery(".formulation-category.selected").data("id");
	prepareFilters1(activeCategoryId);

}

jQuery(document).on('change', '.formulations-filters input[type=checkbox]', function (event) {
	event.stopPropagation();
	applyFormualtionsFilters();
});

jQuery(document).on("click", ".formulations-filters h6.sub-header", function (event) {
	event.stopPropagation();
	jQuery(this).closest(".formulations-filters").toggleClass("expanded");
})