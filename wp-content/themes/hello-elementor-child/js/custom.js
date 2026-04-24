var checkUsed = function () {
	var $cart_content = $('#cart-counter').data('cart');
	var $arr = $cart_content.toString().split(',');
	$(".product").each(function () {
		var $id = $(this).attr('id');
		if (jQuery.inArray($id, $arr) > -1) {
			var $target = $(this).find('li.addcustom');
			$target.addClass('added');
			$target.find('a img').hide();
			if (!$target.find('a .fa').length) {
				$target.find('a').prepend('<i class="fa fa-check-square-o" aria-hidden="true"></i>');
			}
			$target.find('a span').text('Added To Your Sample Order');
			$(this).find('div.view-basket a').show();
		}
	});
}



//Responsive menu
$(document).ready(function () {
	jthis = $(document);
	jthis.find('.responsive_menu .has-submenu').each(function () {
		var link = $(this);
		if (link.find('.toggle-submenu-button').length)
			return true;
		link.prepend($('<span class="toggle-submenu-button"><i class="fas fa-angle-down"></i></span>'))
		// .click(function(){
		// $(this).toggleClass('open-submenu').closest('li').find('>ul').slideToggle(300);
		// 	return false;
		// }
		// ));
	});

	$('#trigger-overlay').click(function () {
		$('.overlay-slidedown').addClass('open');
	});
	$('.overlay-close').click(function () {
		$('.overlay-slidedown').removeClass('open');
	});
});


$(document).ready(function () {

	// skeletabs
	$("#skltbsResponsive").skeletabs({
		equalHeights: false,
		// animation: "fade-scale",
		updateUrl: false,
		autoplayInterval: 4500,
		responsive: {
			breakpoint: 991,
			animation: "fade-scale",
		}
	});
	// swiper
	var swiper = new Swiper('.home-container', {
		navigation: {
			nextEl: '.main-slide-next',
			prevEl: '.main-slide-prev',
		},
		pagination: {
			el: '.swiper-pagination',
			type: 'bullets',
			clickable: true
		},
		autoplay: {
			delay: 5000,
		},
		effect: 'fade',
		speed: 700,
		autoHeight: true,
	});

	var swiper = new Swiper('.application-container', {
		navigation: {
			nextEl: '.app-button-next',
			prevEl: '.app-button-prev',
		},
		slidesPerView: 3,
		spaceBetween: 33,
		loop: true,
		speed: 700,
		breakpoints: {
			991: {
				slidesPerView: 2,
				spaceBetween: 15,
			},
			767: {
				slidesPerView: 1,
				autoHeight: true,
			},
		}
	});

	var swiper = new Swiper('.family-container', {
		navigation: {
			nextEl: '.family-button-next',
			prevEl: '.family-button-prev',
		},
		slidesPerView: 4,
		spaceBetween: 100,
		loop: true,
		speed: 700,
		breakpoints: {
			991: {
				slidesPerView: 3,
				spaceBetween: 50,
			},
			767: {
				slidesPerView: 2,
				spaceBetween: 20,
			},
			520: {
				slidesPerView: 1,
			},
		}
	});

	var swiper = new Swiper('.awards-container', {
		navigation: {
			nextEl: '.awards-button-next',
			prevEl: '.awards-button-prev',
		},
		slidesPerView: 4,
		spaceBetween: 100,
		loop: true,
		speed: 700,
		breakpoints: {
			991: {
				slidesPerView: 3,
				spaceBetween: 50,
			},
			767: {
				slidesPerView: 2,
				spaceBetween: 20,
			},
			520: {
				slidesPerView: 1,
			},
		}
	});
})

$(document).on('click', '.search-item', function () {
	$('.search-box').toggleClass('show');
	$('.main-nav').toggleClass('fill');
})
// $(document).on('click', '.main-nav.fill', function(){
// 	$('.search-box').removeClass('show');
// 	$(this).removeClass('fill');
// })
// $(document).on('click', '.search-box', function(e){
// 	e.stopPropagation();
// })

// nav pills
$(document).on('click', '.info-center-main .nav-pills li a.main-pill', function () {
	if ($(this).parent().find('.subs').is(':visible')) {
		//$(this).parent().find('.subs').removeClass('show');
	} else {
		$('.subs').slideUp('show');
		$(this).parent().find('.subs').slideDown();
		var span = $(this).find("span");
		var name = $(this).text();
		if (span.length > 0) {
			name = span.text();
		}
		Analytics.infoCenterClick(name);
	}
})

$(document).on('click', '.info-center-main .tab-content .info-content ul li a, .info-center-main .tab-content table  tr th a', function () {

	var url = $(this).attr('href');
	Analytics.infoCenterDownloadFile(url);
	return true;

})
$(document).on('click', '.download_datasheet', function () {

	var url = $(this).attr('href');
	Analytics.downloadDatasheetClick(url);
	return true;

})
$(function () {
	$('.popup-modal').magnificPopup({
		type: 'inline',
		closeOnBgClick: false,
	});
	$(document).on('click', '.popup-modal-dismiss', function (e) {
		e.preventDefault();
		// $(this).parent().find('.video-inner video')[0].pause();
		$.magnificPopup.close();
	});
});

// $(document).on('click', '.subs li a', function(){
// 	var jump = $(this).attr('scrollto');
// 	$('html, body').animate({
// 		scrollTop: $(jump).offset().top - 93
// 	}, 500);	
// })


// scrolltop
$(document).on('click', '.scrolltop', function () {
	$('body,html').animate({ scrollTop: 0 }, 700);
})
$(document).scroll(function () {
	if ($(this).scrollTop() > 300) {
		$('.scrolltop').show();
	}
	else {
		$('.scrolltop').hide();
	}
});

// $(document).on('click', '.main-sub .toggle-submenu-button', function(){
// 	alert();
// 	// $(this).parent().find('.sub-menu').slideDown(300);
// 	if($(this).parent().find('.sub-menu').is(':visible')){
// 		$(this).parent().find('.sub-menu').slideUp(300);
// 	}else{
// 		$('.main-sub > .toggle-submenu-button:first-child').slideUp(300);
// 		$(this).parent().find('.sub-menu').slideDown(300);
// 	}
// })


// responsive-menu slide
$(document).on('click', '.toggle-submenu-button', function () {
	// $(this).addClass('open-submenu');
	if ($(this).hasClass('open-submenu')) {
		$(this).removeClass('open-submenu');
	} else {
		$(this).parent().siblings('.has-submenu').find('.toggle-submenu-button').removeClass('open-submenu');
		$(this).addClass('open-submenu');
	}



	// $(this).siblings('.sub-menu').slideDown();
	if ($(this).siblings('.sub-menu').is(':visible')) {
		$(this).siblings('.sub-menu').slideUp(300);
	} else {
		$(this).siblings('.sub-menu').slideDown(300);
		$(this).parent().siblings('.has-submenu').find('.sub-menu').slideUp(300);
	}
})

$(document).on('click', '.res-menu-icon', function () {
	// $(this).toggleClass('active');
	/*$('.responsive_menu').slideToggle(300);*/
	$('.responsive_menu').toggleClass('open');
})

// sticky header
$(document).scroll(function () {
	if ($(this).scrollTop() > 32) {
		$('header').addClass('sticky')
		$('.site-loader').addClass('sticky-loader');
	}
	else {
		$('header').removeClass('sticky')
		$('.site-loader').removeClass('sticky-loader');
	}
});

/*product filter*/
$(document).on('click', '.filter-head', function () {
	$(this).next('.sub-filter-menu, .checkbox-filters').slideToggle();
	$(this).toggleClass('filter-opened')
})
$(document).on('click', '.sub-filtter-arrow', function () {
	$(this).next('.sub-filter-cat').slideToggle();
	$(this).toggleClass('sub-filter-opened')
})
/* res search*/
$(document).on('click', '.res-search', function () {
	$('.search-box').toggleClass('active');
	$(this).toggleClass('active');
})

/*site loader*/
$(window).on('load', function () {
	$('.site-loader').fadeOut(400);
	$('.site-loader').addClass('closed');
	checkUsed();
});


$(window).bind('beforeunload', function (e) {
	$('.site-loader').fadeIn(300);
});

$(document).on('click', 'li.addcustom:not(.added)', function (e) {
	e.preventDefault();
	var $thisbutton = $(this),
		$prmain = $thisbutton.closest('.product'),
		$prid = $prmain.attr('id');
	$thisbutton.find('a img').hide();
	$thisbutton.find('a').prepend('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i><i class="fa fa-check-square-o" aria-hidden="true"></i>');
	$thisbutton.find('a span').text('Adding To Your Sample Order');

	var data = {
		action: 'path_ajax_add_to_cart',
		product_id: $prid,
		quantity: 1
	};

	$('body').trigger('adding_to_cart', [$thisbutton, data]);

	$.ajax({
		type: 'post',
		url: wc_add_to_cart_params.ajax_url,
		data: data,
		beforeSend: function (response) {
			$thisbutton.addClass('loading');
		},
		complete: function (response) {
			$thisbutton.addClass('added').removeClass('loading');
		},
		success: function (response) {

			if (response.error & response.product_url) {
				window.location = response.product_url;
				return;
			} else {
				$thisbutton.find('a span').text('Added To Your Sample Order');
				$prmain.find('div.view-basket a').show();
				$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
			}
		},
	});

	return false;
});

/*$(document).on('change', '#country', function (e) {
	e.preventDefault();
	loadSaftyData('language');
});
$(document).on('change', '#language', function (e) {
	e.preventDefault();
	loadSaftyData('sheet');
});*/


/*$(document).ready(function() {
	if($('#country').val()!='') {
		loadSaftyData('language');	
	}
	
});*/
var firstLoad = 0;
function loadSaftyData(type) {
	country = $('#country').val();
	productID = $('#productID').val();
	language = $('#language').val();

	var data = {
		action: 'get_language',
		type: type,
		country: country,
		language: language,
		productID: productID,
		firstLoad: firstLoad,
	};
	$.ajax({
		type: 'post',
		url: wc_add_to_cart_params.ajax_url,
		data: data,
		dataType: "json",
		beforeSend: function (response) {
			$('.sheet_loading').show();
			if (type == 'language') {
				$('.sheet_details').hide();
				$('.language').hide();

			}
			else if (type == 'sheet') {
				$('.sheet_details').hide();
			}
		},
		complete: function (response) {
			$('.sheet_loading').hide();
		},
		success: function (response) {

			if (type == 'language') {
				console.log(response);
				$('.language').show();
				$('.sheet_details').hide()
				$('.language_list').mCustomScrollbar("destroy");
				$('.language_list').html(response.result_set);
				$(".language_list").mCustomScrollbar();
				if (response.language_default == 1) {
					$('#language').val('English');
					$('.language .sel-title span').html('English');
				}
				if (firstLoad == 0) {
					loadSaftyData('sheet');
				}

			}
			else if (type == 'sheet') {
				firstLoad++;
				$('.sheet_details').show().html(response.result_set);

			}
		},
	});

	return false;
}

$(document).ready(function () {
	$('body').on('click', '.mCSB_draggerContainer', function (event) {
		event.preventDefault();
		event.stopImmediatePropagation();
	});
});

$(document).ajaxComplete(function () {
	checkUsed();
});

/*custom product select */
$(document).on("click", ".sel-title", function (event) {

	event.stopPropagation();
	if ($(this).next().is(":visible")) {
		$(this).next().slideUp(10);
	} else {
		$(".sel-list").slideUp(10);
		$(this).next().slideDown(10);
	}

	if ($(this).parents(".custom-sel-dropdown").hasClass("open")) {
		$(this).parents(".custom-sel-dropdown").removeClass("open")
	} else {
		$(".custom-sel-dropdown").removeClass("open")
		$(this).parents(".custom-sel-dropdown").addClass("open")
	}
})


$(document).on("click", ".sel-list li a", function () {
	let val = $(this).html();
	$(".sel-list").slideUp(10);
	current = $(this).data('types');
	if (current == 'country') {
		$('.language .sel-title span').html('Select Language');
		$('#country').val($(this).data('country'));
		$('#language').val('');
		loadSaftyData('language');
	}
	else if (current == 'language') {
		$('#language').val($(this).data('language'));
		loadSaftyData('sheet');
	}

	$(this).parents(".custom-sel-dropdown").find(".sel-title span").html(val);
	$(".custom-sel-dropdown").removeClass("open")
})

$(window).on("load", function () {
	$(".mCustomScrollbar.country-list").mCustomScrollbar();
})

/*remove custom sel class outside click*/
var outside = false;


$(document).on("click", "body", function () {
	outside = true;
	if (outside) {
		$(".custom-sel-dropdown").removeClass("open");
		$(".sel-list").slideUp(10);
	}
})


$(document).on("click", ".custom-sel-dropdown", function () {
	outside = false;
})


/*formualtion links */
$(document).on("click", ".formulation-category", function (event) {

	event.stopPropagation();
	var id = $(this).data("id");
	var imageUrl = $(this).data("image-url");
	$(".formulation-grp.category-tiles").hide();
	$(".formulation-category-container").hide();
	$(".formulation-category").removeClass("selected");
	$("#" + id).show();
	$("a[data-id=" + id).addClass("selected");
	$(".formulations-filters input").each(function () {
		$(this).prop("checked", false);
	});
	prepareFilters1(id);
	applyFormualtionsFilters();
})
var checkUrlParameter = function () {

}

$(document).ready(function () {
	if (window.location.href.indexOf("starting-point-formulations") > -1) {
		$(".tab-pane").removeClass("active");
		$("#tab_b1.tab-pane").addClass("active");
		$(".info-sidebar li a").removeClass("active");
		var menuLink = $("a.spf");
		menuLink.addClass("active");
		var subs = menuLink.parent().find(".subs");
		subs.show();
	}
});

var selectStartingPointFormulationsTab = function () {
	$(".formulation-category").removeClass("selected");
	$(".formulations-filters input").each(function () {
		$(this).attr("disabled", "disabled");
		$(this).prop("checked", false);
	});
	$(".formulation-grp.category-tiles").show();
	$(".formulation-category-container").hide();
}
$(document).on("click", "a[href='#tab_b1']", function (event) {

	event.stopPropagation();
	selectStartingPointFormulationsTab();
})
var prepareFilters = function (categoryId) {
	var regionFilter = [];
	var systemFilter = [];
	var chemistryFilter = [];
	$("#" + categoryId).find("table.tablesaw tr.formulation-row:not(.hide)").each(function () {

		var row = $(this);
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

	$(".formulations-filters input[name=" + "availability" + "]").each(function () {
		var value = $(this).val();
		var any = false;
		for (var i = 0; i < systemFilter.length; i++) {
			for (var j = 0; j < chemistryFilter.length; j++) {

				any |= isAnyRowMatching(categoryId, value, systemFilter[i], chemistryFilter[j]);
			}
		}
		setEnable($(this), any);
	});

	$(".formulations-filters input[name=" + "system" + "]").each(function () {
		var value = $(this).val();
		var any = false;
		for (var i = 0; i < regionFilter.length; i++) {
			for (var j = 0; j < chemistryFilter.length; j++) {

				any |= isAnyRowMatching(categoryId, regionFilter[i], value, chemistryFilter[j]);
			}
		}
		setEnable($(this), any);
	});
	$(".formulations-filters input[name=" + "chemistry" + "]").each(function () {
		var value = $(this).val();
		var any = false;
		for (var i = 0; i < regionFilter.length; i++) {
			for (var j = 0; j < systemFilter.length; j++) {

				any |= isAnyRowMatching(categoryId, regionFilter[i], systemFilter[j], value);
			}
		}
		setEnable($(this), any);
	});

}
var isAnyRowMatching = function (categoryId, availabilityVal, systemVal, chemistryVal) {
	var mathingRows = $("#" + categoryId).find("tr.formulation-row[data-availability*=" + availabilityVal + "][data-system*=" + systemVal + "][data-chemistry*=" + chemistryVal + "]");
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
	$(".formulations-filters input[name=" + name + "]").each(function () {
		var value = $(this).val();
		fullList.push(value);
		if ($(this).is(':checked')) {
			filterList.push(value);
		}
	});
	if (filterList.length > 0) {
		return filterList;
	}
	return fullList;
}
var setCheckboxVisibility = function (array, name) {
	$(".formulations-filters input[name=" + name + "]").each(function () {
		var value = $(this).val();
		if (array.includes(value)) {
			$(this).removeAttr("disabled");
		}
		else {
			$(this).attr("disabled", "disabled");
			$(this).prop("checked", false);
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
		var row = $(this);
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
	$(".formulations-filters input[name=availability]:checked").each(function () {
		regionFilter.push($(this).val());
	});
	var systemFilter = [];
	$(".formulations-filters input[name=system]:checked").each(function () {
		systemFilter.push($(this).val());
	});
	var chemistryFilter = [];
	$(".formulations-filters input[name=chemistry]:checked").each(function () {
		chemistryFilter.push($(this).val());
	});

	var colorCategories = $(".color-category");

	colorCategories.each(function () {
		var colorCategoryContainer = $(this);
		checkRowVisibility(colorCategoryContainer, regionFilter, systemFilter, chemistryFilter);
	});

	var activeCategoryId = $(".formulation-category.selected").data("id");
	prepareFilters1(activeCategoryId);

}

$(document).on('change', '.formulations-filters input[type=checkbox]', function (event) {
	event.stopPropagation();
	applyFormualtionsFilters();
});

$(document).on("click", ".formulations-filters h6.sub-header", function (event) {
	event.stopPropagation();
	$(this).closest(".formulations-filters").toggleClass("expanded");
})