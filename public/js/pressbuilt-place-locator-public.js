(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

	google.maps.event.addDomListener(window, 'load', function()
	{
		var geocoder = new google.maps.Geocoder();
		var latlngbounds = new google.maps.LatLngBounds();

		var map = new google.maps.Map(document.getElementById('map-canvas'), {scrollwheel: false});
		var label = 'A';
		var last_infoWindow = false;

		map.initialZoom = true;

		$.each( $('.entry-summary'), function (index, value) {

			var postId = $(value).find('meta[name="postId"]').attr("content");
			var name = $(value).find('meta[itemprop="name"]').attr("content");
			var latitude = $(value).find('meta[itemprop="latitude"]').attr("content");
			var longitude = $(value).find('meta[itemprop="longitude"]').attr("content");

			var address = '';
			address += $(value).find('span[itemprop="streetAddress"]').html();
			address += ' ' + $(value).find('span[itemprop="addressLocality"]').html();
			address += ' ' + $(value).find('span[itemprop="addressRegion"]').html();
			address += ' ' + $(value).find('span[itemprop="postalCode"]').html();

			if (latitude && longitude) {
				var latlng = new google.maps.LatLng(latitude, longitude);

				var marker = new google.maps.Marker({
					map: map,
					position: latlng,
					title: name,
					icon: "http://maps.google.com/mapfiles/marker"+label.toString()+".png"
				});

				var content = '<div id="content">';
				content += '<strong>'+name+'</strong><br>';
				content += address+'<br>';
				content += '<a href="https://maps.google.com?daddr='+encodeURIComponent(address).replace(/%20/g, "+")+'" target="_blank">Directions</a>';
				content += '</div>';

				var infoWindow = new google.maps.InfoWindow({
					content: content
				});

				google.maps.event.addListener(marker, 'click', function() {
					if (last_infoWindow) {
						last_infoWindow.close();
					}
					last_infoWindow = infoWindow;
					infoWindow.open(map, marker);
				});

				google.maps.event.addListener(map, "click", function(event) {
					infoWindow.close();
				});

				// increase the label string for the next iteration
				label = String.fromCharCode(label.charCodeAt(0) + 1);

				latlngbounds.extend(latlng);

				if (index === $('.entry-summary').length - 1) {
					map.fitBounds(latlngbounds);
				}

			} else {
				geocoder.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						var marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location,
							title: name,
							icon: "http://maps.google.com/mapfiles/marker"+label.toString()+".png"
						});

						$.ajax({
							type: 'POST',
							url: MyAjax.ajaxurl,
							data: {
								"action": "update_latlng", 
								"postId": postId,
								"latitude": results[0].geometry.location.G, 
								"longitude": results[0].geometry.location.K
							}
						});

						var content = '<div id="content">';
						content += '<strong>'+name+'</strong><br>';
						content += address+'<br>';
						content += '<a href="https://maps.google.com?daddr='+encodeURIComponent(address).replace(/%20/g, "+")+'" target="_blank">Directions</a>';
						content += '</div>';

						var infoWindow = new google.maps.InfoWindow({
							content: content
						});

						google.maps.event.addListener(marker, 'click', function() {
							if (last_infoWindow) {
								last_infoWindow.close();
							}
							last_infoWindow = infoWindow;
							infoWindow.open(map, marker);
						});

						google.maps.event.addListener(map, "click", function(event) {
							infoWindow.close();
						});

						// increase the label string for the next iteration
						label = String.fromCharCode(label.charCodeAt(0) + 1);

						latlngbounds.extend(results[0].geometry.location);

						if (index === $('.entry-summary').length - 1) {
							map.fitBounds(latlngbounds);
						}
					} else {
						console.log('Geocode was not successful for the following reason: ' + status);
					}
				});
			}

		});

		google.maps.event.addListener(map, 'zoom_changed', function() {
			var zoomChangeBoundsListener = 
				google.maps.event.addListener(map, 'bounds_changed', function(event) {
					//console.log(this.getZoom());
					if (this.getZoom() > 12 && this.initialZoom == true) {
						this.setZoom(12);
						this.initialZoom = false;
					}
				google.maps.event.removeListener(zoomChangeBoundsListener);
			});
		});

	});

})( jQuery );
