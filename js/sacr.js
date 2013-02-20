var sacr = {}

sacr.map = (function($){
	var $ = jQuery;

	var pathArray = window.location.pathname.split( '/' );
	
	var mapLat = 29.894859,
		mapLong = -81.313272,
		mapStyles = [
			{
				"featureType" : "road",
				"elementType" : "geometry",
				"stylers" : [
					{ "color"      : "#FFFFFF" },
					{ "visibility" : "simplified" }
				]
			},
			{
				"featureType" : "road",
				"elementType" : "labels.text.stroke",
				"stylers" : [
					{ "visibility" : "off" }
				]
			},
			{
				"featureType" : "administrative",
				"stylers" : [
					{ "visibility" : "off" }
				]
			},
			{
				"featureType" : "poi",
				"stylers" : [
					{ "visibility" : "off" }
				]
			},
			{
				"featureType" : "transit",
				"stylers" : [
					{ "visibility" : "off" }
				]
			}
		];

	var fancyBoxSettings = {
		maxWidth   : 650,
		minWidth   : 650,
		width      : 650,
		padding    : 0,
		afterClose : function() {
			var curTitle   = document.title,
				blankTitle = curTitle.split( '-' );

			document.title = blankTitle[1]; // Backwards compat

			history.pushState( '', blankTitle[1], SACRL10n.map_url )
		}
	}

	function bindFilter() {
		$( 'input:checkbox' ).click(function() {
			runFilter();
		});
	}

	function runFilter() {
		var filters = [];

		$( 'input:checkbox:checked' ).each(function(i, checkbox) {
			filters.push( $(checkbox).val() );
		});

		if ( filters.length > 0 ) {
			$( '#map-canvas' ).gmap( 'find', 'markers', { 'property': 'category', 'value' : filters }, function(marker, found) {
				marker.setVisible(found); 
			});
		} else {
			$.each($('#map-canvas').gmap('get', 'markers'), function(i, marker) {
				marker.setVisible(false); 
			});
		}
	}

	function bindSwitcher() {
		$( '.related-point' ).click(function(e) {
			e.preventDefault();

			var point = $(this).data( 'point' );
			var title = $(this).text();

			$.fancybox.close(true);
			$.fancybox.open(
				$.extend( fancyBoxSettings, { content  : $( point ) } )
			);

			var curTitle   = document.title,
				blankTitle = curTitle.split( '-' );
				newTitle   = title + ' -' + blankTitle[1];

			document.title = newTitle; // Backwards compat

			history.pushState( '', newTitle, SACRL10n.map_url + point.replace( '#', '' ) + '/' );
		});
	}

	function bindLoader() {
		var point = $( '#' + pathArray[pathArray.length-2] );
			
		if( point.length > 0 ) {
			$.fancybox.open(
				$.extend( fancyBoxSettings, { content  : $( point ) } )
			);
		}
	}

	return {
		init : function() {
			$( '#map-canvas' ).gmap({
				styles             : mapStyles,
				zoom               : 16,
				minZoom            : 14,
				maxZoom            : 18,
				center             : new google.maps.LatLng(mapLat, mapLong),
				mapTypeId          : google.maps.MapTypeId.ROADMAP,
				panControl         : false,
				scrollwheel        : false,
				streetViewControl  : false,
				mapTypeControl     : false,
				zoomControlOptions : {
					position : google.maps.ControlPosition.LEFT_CENTER
				}
			}).bind( 'init', function(event, map) {
				for ( var i = 0, item; item = points[i++]; ) {
					var image = new google.maps.MarkerImage(
						SACRL10n.pin + item.category + '.png',
						new google.maps.Size(36, 37),
						null,
						null,
						new google.maps.Size(36, 37)
					);

					$( '#map-canvas' ).gmap( 'addMarker', {
						'id'        : '#' + item.id,
						'title'     : item.title,
						'icon'      : image,
						'position'  : new google.maps.LatLng(item.position[0], item.position[1]), 
						'category'  : item.category,
						'animation' : google.maps.Animation.DROP
					}).click(function(event, map) {
						var curTitle = document.title,
							newTitle = this.title + ' - ' + curTitle;

						document.title = newTitle; // Backwards compat

						history.pushState( '', newTitle, SACRL10n.map_url + this.id.replace( '#', '' ) + '/' );

						$.fancybox.open(
							$.extend( fancyBoxSettings, { content  : $( this.id ) } )
						);
					});
				}

				bindFilter();
				runFilter();
				bindSwitcher();
				bindLoader();
			});
		}
	}
})(jQuery);

sacr.timeline = (function($) {
	var $ = jQuery;

	return {
		init : function() {
			//this.preAdjustItems();

			$( '.timeline-month-list' ).masonry({
				itemSelector : '.timeline-item',
				columnWidth  : 450,
				gutterWidth  : 40
			});

			this.adjustItems();
			this.adjustAnchors();
			this.selectActive();
		},

		preAdjustItems : function() {
			$( '.timeline-item' ).each(function(index){
				var item   = $( this );

				if ( ( item.data( 'day' ) < item.prev().data( 'day' ) ) && parseInt( item.css( 'margin-top' ), 10 ) <  parseInt( item.prev().css( 'margin-top' ), 10 ) ) {
					var diff = item.prev().data( 'day' ) - item.data( 'day' );

					item.css( 'margin-top', parseInt( item.prev().css( 'margin-top' ), 10 ) + ( diff * 10 ) );
				}
			});
		},

		adjustItems : function() {
			$( '.timeline-item' ).each(function(index){
				var item   = $( this ),
					offset = parseInt( item.css( 'left' ), 10 );

				if ( offset > 0 )
					item.addClass( 'right' );
				else
					item.addClass( 'left' );

				/*if ( item.prev().hasClass( 'left' ) ) {
					console.log( item.prev().css( 'margin-top' ) + $(this).css( 'margin-top' ) );
					item.css( 'margin-top', parseInt( item.prev().css( 'margin-top' ), 10 ) + parseInt( $(this).css( 'margin-top' ), 10 ) );
				}*/
			});
		},

		adjustAnchors : function() {
			var $window = $(window);

			$window.load(function(){
				if ( window.location.hash ) {
					$(window.location.hash).addClass( 'active' );
					$window.scrollTop( $( window.location.hash ).offset().top - 50 );
				}
			});
		},

		selectActive : function() {
			$( '.timeline-item' ).click(function(e) {
				e.preventDefault();

				$( '.timeline-item' ).removeClass( 'active' );
				$(this).addClass( 'active' );
				window.location.hash = $(this).attr( 'id' );
			});
		}
	}
}(jQuery));

sacr.ui = (function($) {
	var $ = jQuery;

	return {
		init : function() {
			if ( SACRL10n.is_home )
				this.home();
		},

		/**
		 * Centers any set of elements passed vertically
		 * and horizontally. This assumes the element already has
		 * been positioned absolute with a left and top at 50%;
		 */
		center : function(els, vert, hor) {
			jQuery.each( els, function( index, value ) {
				$.each( $(value), function(index, value ) {
					var el = $( value ),
					    h  = el.height(),
					    w  = el.width();

					if ( vert )
						el.css({
							'margin-top'  : -(h / 2)
						});

					if ( hor )
						el.css({
							'margin-left' : -(w / 2)
						});
				});
			});
		},

		home : function() {
			if ( $.backstretch )
				$( '.hero-slider li' ).each(function(index){
					$(this).backstretch( $(this).data( 'backstretch-image' ) );
				});

			$( '.rslides' ).responsiveSlides({
				nav       : true,
				namespace : 'large-btns',
				prevText  : '',
				nextText  : ''
			});
		}
	}
}(jQuery));

jQuery(document).ready(function($) {
	sacr.ui.init();
	sacr.ui.center([ $( '.slider-title' ) ], true, false);

	if ( SACRL10n.is_map )
		sacr.map.init();

	if ( SACRL10n.is_timeline )
		sacr.timeline.init();
});