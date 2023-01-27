jQuery(function( $ ) {
	'use strict';

	var $body = $( 'body' );

	/* -----------------------------------------
	Responsive Menus Init with mmenu
	----------------------------------------- */
	var $mainNav = $('#masthead .navigation');
	var $mobileNav = $( '#mobilemenu' );

	$mainNav.clone().removeAttr( 'id' ).removeClass().appendTo( $mobileNav );
	$mobileNav.find( 'li' ).removeAttr( 'id' );

	$mobileNav.mmenu({
		offCanvas: {
			position: 'top',
			zposition: 'front'
		},
		"autoHeight": true,
		"navbars": [
			{
				"position": "top",
				"content": [
					"prev",
					"title",
					"close"
				]
			}
		]
	});

	/* -----------------------------------------
	Main Navigation Init
	----------------------------------------- */
	$mainNav.superfish({
		delay: 300,
		animation: { opacity: 'show', height: 'show' },
		speed: 'fast',
		dropShadows: false
	});

	/* -----------------------------------------
	Menu stickiness
	----------------------------------------- */
	var $siteBar = $('.site-header').find('.sticky-head');

	if ( $siteBar.length ) {
		$siteBar.stick_in_parent({
			bottoming: false
		});
	}

	/* -----------------------------------------
	Responsive Videos with fitVids
	----------------------------------------- */
	$body.fitVids();


	/* -----------------------------------------
	Image Lightbox
	----------------------------------------- */
	$( ".ci-lightbox, a[data-lightbox^='gal']" ).magnificPopup({
		type: 'image',
		mainClass: 'mfp-with-zoom',
		gallery: {
			enabled: true
		},
		zoom: {
			enabled: true
		}
	} );

	/* -----------------------------------------
	 Zoom single product thumbnails
	 ----------------------------------------- */
	$( '.woocommerce-product-gallery--with-images' ).prepend( '<a href="#" class="woocommerce-product-gallery__trigger"><i class="fa fa-search-plus"></i></a>' );

	$body.on( 'click', '.woocommerce-product-gallery__trigger', function ( e ) {
		var images = $( '.woocommerce-product-gallery__image' ).map(function () {
			return {
				src: $( this ).find( 'a' ).attr( 'href' )
			};
		} ).get();

		var currentImageIndex = $( '.flex-active-slide' ).index();

		$.magnificPopup.open({
			type: 'image',
			gallery: {
				enabled: true,
			},
			items: images,
		}, currentImageIndex || 0);

		e.preventDefault();
	} );


	/* -----------------------------------------
	Instagram Widget
	----------------------------------------- */
	var $instagramWrap = $('.footer-widget-area');
	var $instagramWidget = $instagramWrap.find('.instagram-pics');

	if ( $instagramWidget.length ) {
		var auto  = $instagramWrap.data('auto'),
			speed = $instagramWrap.data('speed');

		$instagramWidget.slick({
			slidesToShow: 8,
			slidesToScroll: 3,
			arrows: false,
			autoplay: auto == 1,
			speed: speed,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 4
					}
				}
			]
		});
	}

	/* -----------------------------------------
	Justified Galleries
	----------------------------------------- */
	var $entryJustified = $('.entry-justified');
	if ( $entryJustified.length ) {
		$entryJustified.each(function() {
			var rowHeight = $(this).data('height');
			$(this).justifiedGallery({
				rowHeight : rowHeight,
				margins : 5,
				lastRow: 'justify'
			});
		})
	}

	/* -----------------------------------------
	Main Carousel
	----------------------------------------- */
	var homeSlider = $( '.home-slider' );

	if ( homeSlider.length ) {
		var autoplay = homeSlider.data( 'autoplay' ),
			autoplayspeed = homeSlider.data( 'autoplayspeed' ),
			fade = homeSlider.data( 'fade' );

		homeSlider.slick({
			autoplay: autoplay == 1,
			autoplaySpeed: autoplayspeed,
			fade: fade == 1
		});
	}

	$('.feature-slider').slick();

	var $window = $(window);

	$window.load(function() {
		var $equals = $("#site-content > .row > div[class^='col']");

		/* -----------------------------------------
		Masonry Layout
		----------------------------------------- */
		var $masonry = $('.entries-masonry');
		if ( $masonry.length ) {
			var grid = $masonry.isotope({
				itemSelector: '.entry-masonry',
				layoutMode: 'masonry'
			});
		}

		/* -----------------------------------------
		Equalize Content area heights
		----------------------------------------- */
		$equals.matchHeight();

	});
	
	/* -----------------------------------------
	Media Query Check
	----------------------------------------- */
	function ciResize(){
		var $entriesList = $('.entries-list');
		if ( $entriesList.length ) {
			if ( Modernizr.mq('only screen and (max-width: 768px)') ) {
				$('.entries-list .entry').removeClass('entry-list');
			}
			else {
				$('.entries-list .entry:not(:first)').addClass('entry-list');
			}
		}
	}

	$window.resize(function() {
		ciResize();
	}).resize();	

});