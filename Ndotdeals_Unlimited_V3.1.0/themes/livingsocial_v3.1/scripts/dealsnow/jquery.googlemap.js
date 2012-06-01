/*
 * 	 imGoogleMaps - A JQuery Google Maps Implementation
 * 	 @author Les Green
 * 	 Copyright (C) 2008-2009 Intriguing Minds, Inc.
 *   
 *   Version 0.9.4 - 23 Jan 2010
 *   1. Bug fix - maps weren't displaying in ie7
  
 *   
 *   Version 0.9.3 - 8 Jan 2010
 *   1. Bug fix - markers not displaying in ie
 *   2. Add images to infoWindow 
 *   
 *   
 *   Version 0.9.2 - 30 Dec 2009
 *   
 *   1. Bug fix - Print displaying null on screen
 *   2. Bug fix - Received error when clicking on infoWindow if full address was not given
 *   3. Changed infoWindow so that is does not display street view link if 
 *   	StreetViewPanorama is not available for given point. 
 *   	And Street View Overlay will not open to Street View if address not available
 *   4. Added option: geocode_request_rate. 
 *   	Geocode Requests limited to 15000 per IP address per day (which works out at
		an average of one every 5.76 seconds). Had to create delayed request - 1 every 5 seconds.
		
		The default for geocode_request_rate is 1000 (1 sec). If address amount is over 10, 
		set this at a higher rate - 5000 (5 secs) and use progress_bar option 
		
	 5.	Added progress_bar option. Uses imProgressBar plugin. Because of the delay, this will
	 	let the user know that the requests are processing.
	 	
	 6. Added phone (phone number) and desc (description) option to json record. Will be displayed in infoWindow.
 *      Phone Number style same as address. 
 *      Description - Style = span.imDescription
 *   7. Added custom_marker option - http://gmaps-utility-library.googlecode.com/svn/trunk/mapiconmaker/1.1/src/
 *   	custom_marker can optionally be added to json record - if you want each marker to have a custom color
 *   	Can also use Custom Marker that don't use the file - http://code.google.com/p/google-maps-icons/    	
 *   
 *   
 *   Version 0.9.1 - 24 Dec 2009
 *   
 *   1. Fixed bug with Street View Control. Button did not exit street view
 *   
 *   Version 0.9 - 18 Dec 2009
 *   1. Fixed manual mode bug
 *   2. Added option for manual mode - remove 'Get Directions' label and directions div.
 *   	show_directions_menu: false
 *   	
 *   	The following options are not needed when show_directions_menu == false
 *   		directions
 *   		search
 *   		button_class
 *    
 *   3. Can press enter when doing a search (if on from or to field). No longer have to click search button   
 *   4. Added Street view (Panorama)
 *   	Requires the following options:
 *   
 *    	street_view - the div that holds the street view
 *    	street_close_loc - the location of the close button for street view.
 *      
 *            
 *   5. Ability to plot multiple addresses. 
 *   	When getting multiple addresses via the data_url option, the data_type must be set to json
 *      Also added 'name' option to json record, so name and address can be displayed in infoWindow.
 *      Style = span.imBusinessName 
 *   
 *     
 *   
 *   
 *   version 1.0 - may add the following:
 *   1. http://www.geocodezip.com/mapStreetviewTabs.html - directions in tab
 *   2. Adsense for Maps - http://code.google.com/apis/maps/documentation/services.html#Advertising
 *   3. Traffic Overlay
 *   4. Microsoft Virtual Earth - http://www.mashedworld.com/DualMaps.aspx
 *  
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.

 *   Demo and Documentation can be found at:   
 *   http://www.grasshopperpebbles.com
 *   
 */
function initials(doc,theme)
{



 /**Get the params from url **/
var vars = [], hash;
var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
for(var i = 0; i < hashes.length; i++)
{
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
}
var selected_deal_id = vars['deal_id'];
 /**Get the params from url **/
//document.writeln();
//imGMapObj (map object) and imStreetViewPoint (LatLng) must be set outside object 
//due to closure issue with map.getInfoWindow in Javascript call
var imGMapObj = null;
var imStreetViewPoint = null;
//used to toggle overlay
var imSVOverlay = null;
//geocode requests have a rate limit of 1.7 seconds per query
//this var will hold the setTimeout object
var imGeocodeRequestDelay = null;

function imLatLngs(lat, lng, place, bus_name, phone, desc, images, deal_info, link_id, deal_id) {
	this.lat = lat;
	this.lng = lng;
	this.place = place;
	this.bus_name = bus_name;
	this.phone = phone;
	this.desc = desc;
	this.images = images;
	this.deal_info = deal_info; //DEAL INFO
	this.link_id = link_id; //DEAL LINK ID
	this.deal_id = deal_id;
	
}
//used with custom markers loaded from json file
function imIconOptions(icon_options) {
	this.icon_options = icon_options;
}

;(function($) {
	$.fn.extend({
        imGoogleMaps: function(options) { 
        	opts = $.extend({}, $.googleMaps.defaults, options);
			return this.each(function() {
				new $.googleMaps(this, opts);
			});
        }
    });	

$.googleMaps = function(obj, opts) {
	var gdir, geocoder, gSearch, gMap, panoClient = null;
	var $this = $(obj);
	var toAddress = (opts.address);
	var aLatLng = new Array();
	var aIconOptions = new Array();
	var aRequestedAdress = '';
	init();
	
	function init() {
  		if (opts.mode == 'auto') {
			gSearch = 'dlgSearch';
			gMap = 'googleMap';
			createAuto();
		}
		else {
			if (opts.show_directions_menu) {
				gSearch = opts.search;
				$("#" + opts.directions).html(opts.address);
			}
			gMap = opts.map;
			createManual();
		}
		showMap();
		if (opts.progress_bar) {
			$this.imProgressBar({
				progress_bar: {'container': opts.progress_bar.container, 'bar_back_class' : opts.progress_bar.bar_back_class, 'bar_class': opts.progress_bar.bar_class},
				display: {'type': 'inline', 'insert_type': 'before', 'element': '#'+opts.map},
				animate_duration: 1500
			});
		}
		
		if (opts.data_url) {
		
			var d = getDataString();
			doAjax('GET', opts.data_url, d, '', loadAddress);
		}
		else 
			if (opts.address) {
				
				loadAddress(opts.address);
			}
			else 
				if (opts.lat_lng) {
					loadAddress(opts.lat_lng);
				}
				else {
					alert('Address must be specified!');
				}
	};

	function createAuto() {
		var dWidth = (parseInt($this.css("width")) - parseInt(opts.map.width) - 4) + "px";
		var bWidth = parseInt(dWidth) + parseInt(opts.map.width) + 2 + "px";
		$this.append(
			$('<div></div>')
				.css({backgroundColor: opts.menu_bar.background, color: opts.menu_bar.text, width: bWidth, height: "24px", marginBottom:"2px"})
				.append(
					$('<ul></ul>')	
						.css({listStyle: "none", marginTop:"0", marginBottom:"0", marginLeft:"3px", paddingLeft:"0", display:"block", width:"100px", float:"left"})
						.append(
							$('<li></li>').css({display: "inline", marginRight: "10px", marginTop:"0", marginBottom:"0", marginLeft:"0"}).append(getLink('Get Directions', 'showDlgSearch'))),
					$('<div></div>').css({float:"right"}).append(
						$('<ul></ul>').css({listStyle: "none", marginTop:"0", marginBottom:"0", marginLeft:"3px", paddingLeft:"0"})
							.append(
							$('<li></li>').css({display: "inline", marginRight: "10px", marginTop:"0", marginBottom:"0", marginLeft:"0"}).append(getLink('Print Map', 'printMap', 'googleMap')),
							$('<li></li>').css({display: "inline", marginRight: "10px", marginTop:"0", marginBottom:"0", marginLeft:"0"}).append(getLink('Print Directions', 'printMap', 'googleDirections'))))),	
			$('<div></div>')
				.attr("id", "dlgSearch")
				.css({float:"left", width:dWidth, minHeight:"100px", backgroundColor:opts.directions.background, color:opts.directions.text, marginBottom:"2px", display:"none", paddingTop:"0px"})
				.append(
					$('<p></p>')
						.css({float:"left", width:"15px", height:"15px", backgroundColor:"#64B949", color:"#000", border:"solid thin #000", font:"bold 11px/16px Helvitica, Arial, sans-serif", display:"block", paddingLeft:"6px", marginLeft: "12px"})
						.append('A'),
					$('<input type="text" name="googleFrom" id="googleFrom" value="" /><br /><br /><br />'),
					$('<p></p>')
						.css({float:"left", width:"15px", height:"15px", backgroundColor:"#fB7468", color:"#000", border:"solid thin #000", font:"bold 11px/16px Helvitica, Arial, sans-serif", display:"block", paddingLeft:"6px", marginLeft:"12px"})
						.append('B'),
					$('<input type="text" name="googleTo" id="googleTo" maxlength="75" value="" /><br />').val(opts.address),
					$('<input type="submit" name="btnGetDir" id="btnGetDir" value="Get Directions" />')),
			$('<div></div>')
				.attr("id", "googleMap")
				.css({float:"right", width:opts.map.width, height:opts.map.height, marginRight:"2px", color:"#000000"}),
			$('<div></div>')
				.attr("id", "googleDirections")
				.css({float:"left", width:dWidth, height:opts.map.height, backgroundColor:opts.directions.background, color:opts.directions.text, marginRight:"2px", overflow: "auto"})
				.html(opts.address));
		$("input", $("#dlgSearch")).css({float:"left", margin:"8px 0 0 3px", fontSize:"11px", width:"175px", padding:"0px"})
								   .keypress(function (e) {
										if (e.which == '13') {
											e.preventDefault();
											doSearch();
										}
									});
		$(":submit", $("#dlgSearch")).css({float:"right", margin: "8px 15px 3px 0", width:"95px"});
		$('#btnGetDir').click(function() {
			doSearch(dWidth);
		});
	};
		
	function createManual() {
		var getDir = (opts.show_directions_menu) ? $('<li></li>').append(getLink('Get Directions', 'showDlgSearch')) : $('<li></li>');
		var printDir = (opts.show_directions_menu) ? $('<li></li>').append(getLink('Print Directions', 'printMap', opts.directions)) : $('<li></li>'); 
		/*$this.prepend(
			$('<div></div>')
				.addClass(opts.menu_class)
				.append($('<ul></ul>').append($(getDir)),
					$('<div></div>').addClass(opts.print_class).append(
						$('<ul></ul>').append(
							$(printDir),
							$('<li></li>').append(getLink('Print Map', 'printMap', opts.map))))));*/
		if (opts.show_directions_menu) {
			$this.append(						
				$('<div></div>')
					.attr("id", opts.search)
					.append(
						$('<p></p>')
							.css({float:"left", width:"15px", height:"15px", backgroundColor:"#64B949", color:"#000", border:"solid thin #000", font:"bold 11px/16px Helvitica, Arial, sans-serif", display:"block", paddingLeft:"6px", marginLeft: "12px"})
							.append('A'),
						$('<input type="text" name="googleFrom" id="googleFrom" value="" /><br /><br /><br />'),
						$('<p></p>')
							.css({float:"left", width:"15px", height:"15px", backgroundColor:"#fB7468", color:"#000", border:"solid thin #000", font:"bold 11px/16px Helvitica, Arial, sans-serif", display:"block", paddingLeft:"6px", marginLeft:"12px"})
							.append('B'),
						$('<input type="text" name="googleTo" id="googleTo" maxlength="75" value="" /><br />').val(opts.address),
						$('<input type="submit" name="btnGetDir" id="btnGetDir" value="Get Directions" />').addClass(opts.button_class)),	
				$('<div></div>')
					.attr("id", opts.map),
				$('<div></div>')
					.attr("id", opts.directions)
					.html(opts.address));
			var dWidth = (parseInt($this.css("width")) - parseInt($('#'+opts.map).css('width'))) + "px";		
			$('#btnGetDir').click(function() {
				doSearch(dWidth);
			});
			$('#googleTo, #googleFrom').keypress(function (e) {
				if (e.which == '13') {
					e.preventDefault();
					doSearch();
				}
			});		
		} else {
			$this.append($('<div></div>').attr("id", opts.map));
		}	
		
		if (opts.street_view) {
			$('<div></div>').attr("id", "imStreetViewClose")
						.append($('<a></a>').attr({
							"id": "imStreetCloseBtn",
							'title': 'Exit Street View'
						}).append($('<img></img>').attr('src', opts.street_close_loc))).insertAfter("#"+opts.map);
			$('<div></div>').attr("id", opts.street_view).insertAfter("#imStreetViewClose");			
			$('#imStreetCloseBtn').click(function() {
				imStreetView.toggleStreetView(false);
			});
			
		}	
	};	
	
	function showDlgSearch() {
		var d = ($("#"+gSearch).css("display") == "none") ? "block" : "none";
		$("#"+gSearch).css("display", d);
		if (d == "block") {
			$("#"+gMap).css("height", "525px");
		} else {
			$("#"+gMap).css("height", opts.map.height);
		}
		GUnload();
		showMap();
		loadAddress(toAddress);
	};
	
	function doSearch(dWidth) {
		if (($("#googleFrom").val() != '') && ($("#googleTo").val() != '')) {
			toAddress = $("#googleTo").val();
			if (opts.mode == 'auto') {
				$("#googleDirections").html('').css("width", parseInt(dWidth) - 10);
			} else {
				$("#"+opts.directions).html('');
			}	
			gdir.load("from: " + $("#googleFrom").val() + " to: " + toAddress);
		} else {
			alert("From and To addresses must be entered");	
		}
	};
	
	function showMap() {
		var w,h,dir = null;
    	if (GBrowserIsCompatible()) {
			dir = (opts.mode == 'auto') ? 'googleDirections' : opts.directions;
			w = (opts.mode == 'auto') ? parseInt(opts.map.width) : parseInt($("#"+opts.map).css("width"));
			h = (opts.mode == 'auto') ? parseInt($("#googleMap").css("height")) : parseInt($("#"+opts.map).css("height"));
			//map = new GMap2(document.getElementById(gMap),{size:new GSize(w,h)});
			//what is logo passive?*****************
			imGMapObj = new GMap2(document.getElementById(gMap),{size:new GSize(w,h), logoPassive: true});
			geocoder = new GClientGeocoder();
			if (opts.street_view) {
				panoClient = new GStreetviewClient();
			}
			//imGMapObj.addControl(new GSmallMapControl());
			//imGMapObj.addControl(new GMapTypeControl());
			imGMapObj.setUIToDefault();
        	if (opts.street_view) {
				imGMapObj.addControl(new imStreetViewControl());
				GEvent.addListener(imGMapObj, "click", function(overlay, point) {
	                if (point) {
						panoClient.getNearestPanorama(point, function(reply) {
				            if (reply.code == 200) {
				            	if (reply.Location) {
					                //svp.remove();
					                //svp.setLocationAndPOVFromServerResponse(reply);
									//panoClient.getNearestPanorama(point, initPanorama2);
									imStreetViewPoint = point;
									imStreetView.init(opts.map,opts.street_view, true);
				              	} else {
				                	imGMapObj.openInfoWindowHtml(point,"Street View Panorama not available for this location");
				              	}
				            } else {
				              	alert("Error : "+reply.code);
				            }
			          	});
	                }
	            });
	             
			}
			
			/*baseIcon = new GIcon(G_DEFAULT_ICON);
			baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
			baseIcon.iconSize = new GSize(20, 34);
			baseIcon.shadowSize = new GSize(37, 34);
			baseIcon.iconAnchor = new GPoint(9, 34);
			baseIcon.infoWindowAnchor = new GPoint(9, 2);*/
			
			if ((opts.show_directions_menu) && (opts.directions)) {
				gdir = new GDirections(imGMapObj, document.getElementById(dir));
				//gdir = new GDirections(imGMapObj, $('#'+dir));
			  //	GEvent.addListener(gdir, "load", onGDirectionsLoad);
    			GEvent.addListener(gdir, "error", handleErrors);
			}
			
    	}
    };
	
	/*function getAdrLocationOld(adr, adr_cnt, cnt, bn) {
		geocoder.getLocations(adr, function(response) {
			if (!response || response.Status.code != 200) {
	    		alert("Sorry, we are unable to gecode address: " + adr);
		  	} else { 
		    	var place = response.Placemark[0];
				aLatLng[cnt] = new imLatLngs(place.Point.coordinates[1], place.Point.coordinates[0], place, bn);
				if (aLatLng.length == adr_cnt) {
					mapAddress();
				}
		  	}
		});
	};*/
	
	function getAdrLocation(cnt) {
		var adr, bName, phone, desc, img, adr_cnt, iOptions = '';
		/*DEAL INFO FROM JSON*/
		if(typeof(aRequestedAdress[cnt]) !== 'undefined')
		{
		var deal_info = aRequestedAdress[cnt].info;
		var link_id = aRequestedAdress[cnt].link_id;
		var deal_id = aRequestedAdress[cnt].deal_id;
		if (aRequestedAdress.lat) {
			adr = new GLatLng(aRequestedAdress.lat, aRequestedAdress.lng);
			adr_cnt = 1; 
		} 
		else if(aRequestedAdress[0])
		{
		        if (aRequestedAdress[0].address) {
			        adr_cnt  = aRequestedAdress.length;
			        adr = aRequestedAdress[cnt].address;
			        bName = (aRequestedAdress[cnt].name) ? aRequestedAdress[cnt].name : '';
			        phone = (aRequestedAdress[cnt].phone) ? aRequestedAdress[cnt].phone : '';
			        desc = (aRequestedAdress[cnt].desc) ? aRequestedAdress[cnt].desc : '';
			        img = (aRequestedAdress[cnt].images) ? aRequestedAdress[cnt].images : '';
			        iOptions = (aRequestedAdress[cnt].custom_marker) ? aRequestedAdress[cnt].custom_marker : '';
		        } else if (aRequestedAdress[0].lat) {
			        adr_cnt  = aRequestedAdress.length;
			        adr = new GLatLng(aRequestedAdress[cnt].lat, aRequestedAdress[cnt].lng);
		        }
		        else {
			        adr = aRequestedAdress;
			        adr_cnt = 1;
		        }
		}
		 else {
			adr = aRequestedAdress;
			adr_cnt = 1;
		}
		geocoder.getLocations(adr, function(response) {
			if (!response || response.Status.code != 200) {
	    		//alert("Sorry, we are unable to gecode address: " + adr);
		  	} else { 
		    	var place = response.Placemark[0];
				aLatLng[cnt] = new imLatLngs(place.Point.coordinates[1], place.Point.coordinates[0], place, bName, phone, desc, img, deal_info, link_id, deal_id);
				if (iOptions) {
					aIconOptions[cnt] = iOptions;
				}
				cnt++;
				if (opts.progress_bar) {
					$(window).trigger('updateProgress');
				}
				if (cnt < adr_cnt) {
					//gecode has a rate limit for requests
					imGeocodeRequestDelay = setTimeout (function() {
						getAdrLocation(cnt);
					}, opts.geocode_request_rate);
				} else {
					clearTimeout(imGeocodeRequestDelay);
					mapAddress();
				}
		  	}
		});
		}
		else
		{
			adr = aRequestedAdress;
			adr_cnt = 1;
			/******************/
			geocoder.getLocations(adr, function(response) {
			if (!response || response.Status.code != 200) {
	    		//alert("Sorry, we are unable to gecode address: " + adr);
		  	} else { 
		    	var place = response.Placemark[0];
				aLatLng[cnt] = new imLatLngs(place.Point.coordinates[1], place.Point.coordinates[0], place, bName, phone);
				if (iOptions) {
					aIconOptions[cnt] = iOptions;
				}
				cnt++;
				if (opts.progress_bar) {
					$(window).trigger('updateProgress');
				}
				if (cnt < adr_cnt) {
					//gecode has a rate limit for requests
					imGeocodeRequestDelay = setTimeout (function() {
						getAdrLocation(cnt);
					}, opts.geocode_request_rate);
				} else {
					clearTimeout(imGeocodeRequestDelay);
					mapAddress();
				}
		  	}
		});
			/******************/
			
		}
	};
	
	function getAddressCount(address) {

		var adr_cnt = 0;
		if (address.lat) {
			adr_cnt = 1; 
		}
		else if(address[0])
		{
			if (address[0].address) {
			adr_cnt  = address.length;
			} else if (address[0].lat) {
				adr_cnt  = address.length;
			}
			else {
			adr_cnt = 1;
		}
		}else {
			adr_cnt = 1;
		}
		return adr_cnt;
	};
	
	function loadAddress(address) {
		
		if (geocoder) {
		
			var total_recs = getAddressCount(address);
			
			aRequestedAdress = address; 
			//initialize progress bar
			if (opts.progress_bar) {
				$(window).trigger('startProgress', [total_recs]);
			}
			getAdrLocation(0);
			//resizeMap();
		}				
	};
	
	/*function getLatLngsOld(address) {
		var bName = '';
		if (geocoder) {
			var place, adr_cnt;
			if (address.lat) {
				place = new GLatLng(address.lat, address.lng);
				getAdrLocation(place, 1, 0);
				//getAdrLocation(place, 1, 0, '');
			}
			else 
				if (address[0].address) {
					adr_cnt  = address.length;
					
					getAdrLocation(address, adr_cnt, 0);
					$.each(address, function(i, itm){
						bName = (itm.name) ? itm.name : '';
						//getAdrLocation(itm.address, adr_cnt, i, bName);
						
					});
				}
				else 
					if (address[0].lat) {
						adr_cnt  = address.length;
						//gecode has a rate limit for requests
						setTimeout ('findPromoCode(document.form1.promoCode.value)', 5000);
						$.each(address, function(i, itm){
							place = new GLatLng(itm.lat, itm.lng);
							getAdrLocation(place, adr_cnt, i, '');
						});
					}
					else {
						getAdrLocation(address, 1, 0, '');
					}
		}
	};*/
	
	function mapAddress() {
		//set bounds	
		bounds = new GLatLngBounds();
		$.each(aLatLng, function(i, itm){
	    	bounds.extend(new GLatLng(itm.lat, itm.lng));
	    });
	    var latSpan = bounds.toSpan().lat();
	    imGMapObj.setCenter(bounds.getCenter(), imGMapObj.getBoundsZoomLevel(bounds));
	    var newBounds = imGMapObj.getBounds();
	    var newLatSpan = newBounds.toSpan().lat();
	    if (latSpan/newLatSpan > .90) { imGMapObj.zoomOut(); }
		
		$.each(aLatLng, function(i, itm){
			var point = new GLatLng(itm.lat, itm.lng);
			var marker = createMarker(point, i, itm.place, itm.bus_name, itm.phone, itm.desc, itm.images, itm.deal_info, itm.link_id, itm.deal_id);
	      	
			//var latlng = marker.getLatLng();
	      	//var pixel = map.fromLatLngToDivPixel(latlng);
	      	//if (Math.abs(pixel.x - clickedX) < 12 && Math.abs(pixel.y - clickedY) < 20) {
	        	//GEvent.trigger(marker, 'click');
	      	//}

	      	imGMapObj.addOverlay(marker);
	      	imGMapObj.setZoom(14);
	      	imGMapObj.disableScrollWheelZoom();
	      		      	        
	      	if(gMap == 'googMap1')
	      	{
	      	        imGMapObj.panDirection(0, +1);
	      	        imGMapObj.disableScrollWheelZoom();
	      	}
	      	if(gMap == 'googMap')
	      	{
	      	        imGMapObj.panDirection(0, +1.5);

	      	       /* imGMapObj.panDirection(0, +1);
	      	        imGMapObj.panDirection(0, +1);
	      	        imGMapObj.panDirection(0, +1);*/
	      	        imGMapObj.disableScrollWheelZoom();
	      	}
	      	if(gMap == 'googMapside')
	      	imGMapObj.setZoom(12);
	        imGMapObj.disableScrollWheelZoom();
		});	
    };

	function createMarker(point, index, place, bus_name, phone, desc, images, deal_info, link_id, deal_id) {
		// Create a lettered icon for this point using our icon class
		var icon = getIconOptions(index);
		//var letter = String.fromCharCode("A".charCodeAt(0) + index);
		//var letteredIcon = new GIcon(baseIcon);
		//letteredIcon.image = "http://www.google.com/mapfiles/marker" + letter + ".png";
	
	  	// Set up our GMarkerOptions object
	  	markerOptions = { icon: icon, draggable:opts.draggable};
	  	var mrkr = new GMarker(point, markerOptions);
	  	
	  	//mrkr.setImage("http://nhw.pl/images/cancel.png");
		GEvent.addListener(mrkr, "click", function() {
			//var adr = place.address;
			var addr;
			/*if ((place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare) && (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea) && (place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName)) {
				var str = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare.ThoroughfareName;
				var cty = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName;
				var ste = place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
				var zip = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber;
				addr = str + '<br />' + cty + ', ' + ste + ' ' + zip;
			} else {
				addr = place.address;
			}
			if ((opts.show_directions_menu) && (opts.directions)) {
				$("#googleTo").val(place.address);
			}
			if (phone) {
				addr += '<br />' + phone;
			}
			if (desc) {
				addr += '<br /><span class="imDescription">' + desc +'</span>';
			}*/
		        if(deal_info)
		        {
		                var ff = "dsf";
		                addr = deal_info;
		        }
			var mhtml = '<a href="javascript:void(0)" class="infowindowclose" onclick="imGMapObj.closeExtInfoWindow();" title="close"><img src="'+doc+'themes/'+theme+'/images/dealsnow/close.gif" alt="close"></a><p class="infoWindowStreetAddress">';
			mhtml += (bus_name) ? '<span class="imBusinessName">'+bus_name+'</span><br />'+addr : addr;
			if (images) {
				var im = '';
				var theImage = '';
				$.each(images, function(i, itm){
					var cls = (itm.class_name) ? 'class="'+itm.class_name+'" ' : '';
					theImage = '<img ' + cls + 'src="'+ itm.image_loc + '" width='+itm.width+' height='+itm.height+' />';
					im += (itm.url) ? '<a href="' + itm.url + '" target="_blank">' + theImage + '</a>' : theImage;	
					if (itm.new_line) {
						im += '<br />';
					}
				});
				mhtml += '<br />' + im;
			}
			//var mhtml = '<p style="color:#000; font-size:11px;">' + address;
			if (opts.street_view) {
				panoClient.getNearestPanorama(point, function(reply){
					if (reply.code == 200) {
						if (reply.Location) {
							//svp.remove();
							//svp.setLocationAndPOVFromServerResponse(reply);
							//panoClient.getNearestPanorama(point, initPanorama2);
							imStreetViewPoint = point;
							mhtml += '<br /><a href="javascript:void(0)" onclick="imStreetView.init(opts.map,opts.street_view,true);">Street View</a></p>';
							//imGMapObj.openInfoWindowHtml(point, mhtml);
						}
					} else {
						alert("Error : " + reply.code);
					}
				});
			//imStreetViewPoint = point;
			//mhtml += '<br /><a href="javascript:void(0)" onclick="imStreetView.init(opts.map,opts.street_view,true);">Street View</a>';
			} else {
				mhtml += '</p>';
				//imGMapObj.openInfoWindowHtml(point, mhtml);
			}
			//mhtml+='<a class="fl clr" href="#closeExtInfoWindow">Close</a>';
			
			/*mrkr.openExtInfoWindow(
                              imGMapObj,
                              "simple_example_window",
                              mhtml,
                              {beakOffset: 3}
                            ); */
                            
                         /*   var tabs = [];
                        // Create tabs and add them to the array
                        tabs.push(new GInfoWindowTab('Tab 1', 'Content of tab 1'));
                        tabs.push(new GInfoWindowTab('Tab 2', 'Content of tab 2'));
                        // Add tabs to the InfowWindow
                        mrkr.openInfoWindowTabsHtml(tabs);*/
                            /*    mrkr.openExtInfoWindow(
                      imGMapObj,
                      "extInfoWindow_coolBlues",
                      "<div>With some clever use of gradients, widths, and the "+
                      "GIcon.infoWindowAnchor position, we can make a cool info window "+
                      "with a beak pointing to the Lat / Lon on the map</div>",
                      {beakOffset: 1}
                    ); */
                        if(gMap == 'googMap2')
                        {
                                mrkr.openExtInfoWindow(
                                imGMapObj,
                                "custom_info_window_red",
                                "<p>Loading Tabs...</p>",
                                {beakOffset: 3, ajaxUrl: doc+'dealnow_popup.php?id='+deal_id}

                                );
                        }
                        else if(gMap == 'googMapside')
                        {
                                window.location = doc+'dealsnow.html';
                        }
                     
		});
		
		
		
	    /*******************************/
	    GEvent.addDomListener(imGMapObj, 'extinfowindowupdate',function(){
            var windowContent = document.getElementById("custom_info_window_red_contents");
            var tabs = new Array(document.getElementById("tab0"),document.getElementById("tab1"));
            if( tabs.length > 0 ){
              var tabContentsArray = new Array(tabs.length);
              for( i=0; i < tabs.length; i++){
                tabContentsArray[i] = document.getElementById("tab"+i+"_content");
                if( i > 0){
                  hide(tabContentsArray[i]);
                }
                tabs[i].setAttribute("name", i.toString());
              
                GEvent.addDomListener(tabs[i],"click",function(){
                  var tabIndex = this.getAttribute("name");
                  
                  for(tabContentIndex=0; tabContentIndex < tabs.length; tabContentIndex++){
                    if( tabContentIndex == tabIndex ){
                        var aelement = document.getElementById("tab"+tabContentIndex);
                        aelement.className += " active_tab";
                      show(tabContentsArray[tabContentIndex]);
                    }else{
                      var aelement = document.getElementById("tab"+tabContentIndex);
                        aelement.className = " tab";
                      hide(tabContentsArray[tabContentIndex]);
                    }
                  }
                  imGMapObj.getExtInfoWindow().resize();
                });
              }
            }
          });
          imGMapObj.addOverlay(mrkr);
         /**
       * Helper function to hide the given DOM element
       * @param {Object} element The DOM element that should be hidden
       */
      function hide(element){
        element.style.display = "none";
        element.style.position = "absolute";
      }
      /**
       * Helper function to show the given DOM element
       * @param {Object} element The DOM element that should be displayed
       */
      function show(element){
        element.style.display = "block";
        element.style.position = "relative";
      }
		/*******************************/
		
		
		
		
		/*GEvent.addListener(mrkr, "mouseover", function() {
		imGMapObj.closeExtInfoWindow();
			//var adr = place.address;
			var addr;
			if ((place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare) && (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea) && (place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName)) {
				var str = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare.ThoroughfareName;
				var cty = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName;
				var ste = place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
				var zip = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber;
				addr = str + '<br />' + cty + ', ' + ste + ' ' + zip;
			} else {
				addr = place.address;
			}
			if ((opts.show_directions_menu) && (opts.directions)) {
				$("#googleTo").val(place.address);
			}
			if (phone) {
				addr += '<br />' + phone;
			}
			if (desc) {
				addr += '<br /><span class="imDescription">' + desc +'</span>';
			}
		        if(deal_info)
		        {
		                addr = deal_info;
		        }
			var mhtml = '<a href="javascript:void(0)" class="infowindowclose" onclick="imGMapObj.closeExtInfoWindow();" title="close"><img src="http://192.168.1.7:1011/themes/green/images/close.gif" alt="close"></a><p class="infoWindowStreetAddress">';
			mhtml += (bus_name) ? '<span class="imBusinessName">'+bus_name+'</span><br />'+addr : addr;
			if (images) {
				var im = '';
				var theImage = '';
				$.each(images, function(i, itm){
					var cls = (itm.class_name) ? 'class="'+itm.class_name+'" ' : '';
					theImage = '<img ' + cls + 'src="'+ itm.image_loc + '" width='+itm.width+' height='+itm.height+' />';
					im += (itm.url) ? '<a href="' + itm.url + '" target="_blank">' + theImage + '</a>' : theImage;	
					if (itm.new_line) {
						im += '<br />';
					}
				});
				mhtml += '<br />' + im;
			}
			//var mhtml = '<p style="color:#000; font-size:11px;">' + address;
			if (opts.street_view) {
				panoClient.getNearestPanorama(point, function(reply){
					if (reply.code == 200) {
						if (reply.Location) {
							//svp.remove();
							//svp.setLocationAndPOVFromServerResponse(reply);
							//panoClient.getNearestPanorama(point, initPanorama2);
							imStreetViewPoint = point;
							mhtml += '<br /><a href="javascript:void(0)" onclick="imStreetView.init(opts.map,opts.street_view,true);">Street View</a></p>';
							//imGMapObj.openInfoWindowHtml(point, mhtml);
						}
					} else {
						alert("Error : " + reply.code);
					}
				});
			//imStreetViewPoint = point;
			//mhtml += '<br /><a href="javascript:void(0)" onclick="imStreetView.init(opts.map,opts.street_view,true);">Street View</a>';
			} else {
				mhtml += '</p>';
				//imGMapObj.openInfoWindowHtml(point, mhtml);
			}
			//mhtml+='<a class="fl clr" href="#closeExtInfoWindow">Close</a>';
			
			mrkr.openExtInfoWindow(
                              imGMapObj,
                              "simple_example_window",
                              mhtml,
                              {beakOffset: 3}
                            ); 
		});
		
		*/
		
		/*****************************/
		$("#"+link_id).click(function(){
		var addr;
			/*if ((place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare) && (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea) && (place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName)) {
				var str = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare.ThoroughfareName;
				var cty = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName;
				var ste = place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
				var zip = place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber;
				addr = str + '<br />' + cty + ', ' + ste + ' ' + zip;
			} else {
				addr = place.address;
			}
			if ((opts.show_directions_menu) && (opts.directions)) {
				$("#googleTo").val(place.address);
			}
			if (phone) {
				addr += '<br />' + phone;
			}
			if (desc) {
				addr += '<br /><span class="imDescription">' + desc +'</span>';
			}*/
		        if(deal_info)
		        {
		                addr = deal_info;
		        }
			var mhtml = '<a href="javascript:void(0)" class="infowindowclose" onclick="imGMapObj.closeExtInfoWindow();" title="close"><img src="'+doc+'themes/'+theme+'/images/close.gif" alt="close"></a><p class="infoWindowStreetAddress">';
			mhtml += (bus_name) ? '<span class="imBusinessName">'+bus_name+'</span><br />'+addr : addr;
			if (images) {
				var im = '';
				var theImage = '';
				$.each(images, function(i, itm){
					var cls = (itm.class_name) ? 'class="'+itm.class_name+'" ' : '';
					theImage = '<img ' + cls + 'src="'+ itm.image_loc + '" width='+itm.width+' height='+itm.height+' />';
					im += (itm.url) ? '<a href="' + itm.url + '" target="_blank">' + theImage + '</a>' : theImage;	
					if (itm.new_line) {
						im += '<br />';
					}
				});
				mhtml += '<br />' + im;
			}
			//var mhtml = '<p style="color:#000; font-size:11px;">' + address;
			if (opts.street_view) {
				panoClient.getNearestPanorama(point, function(reply){
					if (reply.code == 200) {
						if (reply.Location) {
							//svp.remove();
							//svp.setLocationAndPOVFromServerResponse(reply);
							//panoClient.getNearestPanorama(point, initPanorama2);
							imStreetViewPoint = point;
							//mhtml += '<br /><a href="javascript:void(0)" onclick="imStreetView.init(opts.map,opts.street_view,true);">Street View</a></p>';
							//imGMapObj.openInfoWindowHtml(point, mhtml);
						}
					} else {
						alert("Error : " + reply.code);
					}
				});
			//imStreetViewPoint = point;
			//mhtml += '<br /><a href="javascript:void(0)" onclick="imStreetView.init(opts.map,opts.street_view,true);">Street View</a>';
			} else {
				mhtml += '</p>';
				//imGMapObj.openInfoWindowHtml(point, mhtml);
				
			}
			/*mrkr.openExtInfoWindow(
                              imGMapObj,
                              "simple_example_window",
                              mhtml,
                              {beakOffset: 3}
                            ); */
                        if(gMap == 'googMap2')
                        {
							
                                mrkr.openExtInfoWindow(
                                imGMapObj,
                                "custom_info_window_red",
                                "<p>Loading Tabs...</p>",
                                {beakOffset: 3, ajaxUrl: doc+'dealnow_popup.php?id='+deal_id}

                                );
                        }
						else if(gMap == 'googMapside')
                        {
                                window.location = doc+'dealsnow.html';
                        }
		});
		
		/*****************************/
		if(selected_deal_id)
		{
		        if(gMap == 'googMap2')
                        {
                                mrkr.openExtInfoWindow(
                                imGMapObj,
                                "custom_info_window_red",
                                "<p>Loading Tabs...</p>",
                                {beakOffset: 3, ajaxUrl: doc+'dealnow_popup.php?id='+selected_deal_id}

                                );
                        }
                        else if(gMap == 'googMapside')
                        {
                                window.location = doc+'dealsnow.html';
                        }
		}
	  	return mrkr;
	};
	
	function getIconOptions(index) {
	
		var iconOptions = {};
		var icon, mOptions;
		if ((!opts.custom_marker) && (aIconOptions.length == 0)) {
			//regular marker
			//icon = new GIcon(baseIcon);
		        var letter = String.fromCharCode("A".charCodeAt(0) + index);
			icon = new GIcon(G_DEFAULT_ICON);
			icon.image = "http://www.google.com/mapfiles/marker" + letter + ".png";
			icon.shadow = "http://www.google.com/mapfiles/shadow50.png";
			icon.iconSize = new GSize(20, 34);
			icon.shadowSize = new GSize(37, 34);
			icon.iconAnchor = new GPoint(9, 34);
			icon.infoWindowAnchor = new GPoint(9, 2);
		} else {
		
			if (opts.custom_marker) {
				mOptions = opts.custom_marker;
			} else if (aIconOptions.length != 0) {
				mOptions = aIconOptions[index][0];
			}
			if (mOptions.type == 'marker') {
				iconOptions.width = (mOptions.width) ? mOptions.width : 32;
				iconOptions.height = (mOptions.height) ? mOptions.height : 32;
				iconOptions.primaryColor = (mOptions.primaryColor) ? mOptions.primaryColor : '#FD766A';
				iconOptions.cornerColor = (mOptions.cornerColor) ? mOptions.cornerColor : '#FFFFFF';
				iconOptions.strokeColor = (mOptions.strokeColor) ? mOptions.strokeColor : "#000000";
				icon = MapIconMaker.createMarkerIcon(iconOptions);
			} else if (mOptions.type == 'labeledmarker') {
				iconOptions.primaryColor = (mOptions.primaryColor) ? mOptions.primaryColor : '#FD766A';
				iconOptions.strokeColor = (mOptions.strokeColor) ? mOptions.strokeColor : "#000000";
				iconOptions.label = String.fromCharCode("A".charCodeAt(0) + index);
				iconOptions.labelColor = (mOptions.labelColor) ? mOptions.labelColor : "#000000";
				if (mOptions.starPrimaryColor) {
					iconOptions.addStar = true;
					iconOptions.starPrimaryColor = mOptions.starPrimaryColor;
					iconOptions.starStrokeColor = mOptions.starStrokeColor;
				}
				icon = MapIconMaker.createLabeledMarkerIcon(iconOptions);
			} else if (mOptions.type == 'flat') {
				iconOptions.width = (mOptions.width) ? mOptions.width : 32;
				iconOptions.height = (mOptions.height) ? mOptions.height : 32;
				iconOptions.primaryColor = (mOptions.primaryColor) ? mOptions.primaryColor : '#FD766A';
				iconOptions.label = String.fromCharCode("A".charCodeAt(0) + index);
				iconOptions.labelSize = (mOptions.labelSize) ? mOptions.labelSize : 14;
				iconOptions.labelColor = (mOptions.labelColor) ? mOptions.labelColor : "#000000";
				iconOptions.shape = (mOptions.shape) ? mOptions.shape : "circle"; //roundrect
				icon = MapIconMaker.createFlatIcon(iconOptions);
			} else if (mOptions.type == 'user_image') {
				icon = new GIcon();
				var letter = String.fromCharCode("A".charCodeAt(0) + index);
				
				icon.image = doc+"themes/"+theme+"/images/dealsnow/stamps/stamp_" + letter + ".png";

		               // icon.image = mOptions.image_loc;
		                icon.iconSize = new GSize(mOptions.width, mOptions.height);
		                icon.iconAnchor = new GPoint(mOptions.width/2, mOptions.height/2);
			        icon.infoWindowAnchor = new GPoint(mOptions.width/2, mOptions.height/2);
			}
		} 
		return icon;	
	};
	
	function getIconOptionsOld(index) {
		var iconOptions = {};
		var icon;
		if (opts.custom_marker) {
			if (opts.custom_marker.type == 'marker') {

				iconOptions.width = (opts.custom_marker.width) ? opts.custom_marker.width : 32;
				iconOptions.height = (opts.custom_marker.height) ? opts.custom_marker.height : 32;
				iconOptions.primaryColor = (opts.custom_marker.primaryColor) ? opts.custom_marker.primaryColor : '#FD766A';
				iconOptions.cornerColor = (opts.custom_marker.cornerColor) ? opts.custom_marker.cornerColor : '#FFFFFF';
				iconOptions.strokeColor = (opts.custom_marker.strokeColor) ? opts.custom_marker.strokeColor : "#000000";
				//icon = MapIconMaker.createMarkerIcon(iconOptions);
			} else if (opts.custom_marker.type == 'labeledmarker') {
				iconOptions.primaryColor = (opts.custom_marker.primaryColor) ? opts.custom_marker.primaryColor : '#FD766A';
				iconOptions.strokeColor = (opts.custom_marker.strokeColor) ? opts.custom_marker.strokeColor : "#000000";
				iconOptions.labelColor = (opts.custom_marker.labelColor) ? opts.custom_marker.labelColor : "#000000";
				if (opts.custom_marker.starPrimaryColor) {
					iconOptions.addStar = true;
					iconOptions.starPrimaryColor = opts.custom_marker.starPrimaryColor;
					iconOptions.starStrokeColor = opts.custom_marker.starStrokeColor;
				}
				//icon = MapIconMaker.createMarkerIcon(iconOptions);
			} else if (opts.custom_marker.type == 'flat') {
				iconOptions.width = (opts.custom_marker.width) ? opts.custom_marker.width : 32;
				iconOptions.height = (opts.custom_marker.height) ? opts.custom_marker.height : 32;
				iconOptions.primaryColor = (opts.custom_marker.primaryColor) ? opts.custom_marker.primaryColor : '#FD766A';
				iconOptions.labelSize = (opts.custom_marker.labelSize) ? opts.custom_marker.labelSize : 14;
				iconOptions.labelColor = (opts.custom_marker.labelColor) ? opts.custom_marker.labelColor : "#000000";
				iconOptions.shape = (opts.custom_marker.shape) ? opts.custom_marker.shape : "circle"; //roundrect
				//icon = MapIconMaker.createMarkerIcon(iconOptions);
			}
		} else if (aIconOptions.length != 0) {
			if (aIconOptions[index][0].type == 'marker') {
				iconOptions.width = (aIconOptions[index][0].width) ? aIconOptions[index][0].width : 32;
				iconOptions.height = (aIconOptions[index][0].height) ? aIconOptions[index][0].height : 32;
				iconOptions.primaryColor = (aIconOptions[index][0].primaryColor) ? aIconOptions[index][0].primaryColor : '#FD766A';
				iconOptions.cornerColor = (aIconOptions[index][0].cornerColor) ? aIconOptions[index][0].cornerColor : '#FFFFFF';
				iconOptions.strokeColor = (aIconOptions[index][0].strokeColor) ? aIconOptions[index][0].strokeColor : "#000000";
				//icon = MapIconMaker.createMarkerIcon(iconOptions);
			} else if (aIconOptions[index][0].type == 'labeledmarker') {
				iconOptions.primaryColor = (aIconOptions[index][0].primaryColor) ? aIconOptions[index][0].primaryColor : '#FD766A';
				iconOptions.strokeColor = (aIconOptions[index][0].strokeColor) ? aIconOptions[index][0].strokeColor : "#000000";
				iconOptions.labelColor = (aIconOptions[index][0].labelColor) ? aIconOptions[index][0].labelColor : "#000000";
				if (aIconOptions[index][0].starPrimaryColor) {
					iconOptions.addStar = true;
					iconOptions.starPrimaryColor = aIconOptions[index][0].starPrimaryColor;
					iconOptions.starStrokeColor = aIconOptions[index][0].starStrokeColor;
				}
				//icon = MapIconMaker.createMarkerIcon(iconOptions);
			} else if (aIconOptions[index][0].type == 'flat') {
				iconOptions.width = (aIconOptions[index][0].width) ? aIconOptions[index][0].width : 32;
				iconOptions.height = (aIconOptions[index][0].height) ? aIconOptions[index][0].height : 32;
				iconOptions.primaryColor = (aIconOptions[index][0].primaryColor) ? aIconOptions[index][0].primaryColor : '#FD766A';
				iconOptions.labelSize = (aIconOptions[index][0].labelSize) ? aIconOptions[index][0].labelSize : 14;
				iconOptions.labelColor = (aIconOptions[index][0].labelColor) ? aIconOptions[index][0].labelColor : "#000000";
				iconOptions.shape = (aIconOptions[index][0].shape) ? aIconOptions[index][0].shape : "circle"; //roundrect
				//icon = MapIconMaker.createMarkerIcon(iconOptions);
			}
		}
	};
		
	function handleErrors(){
		var gError = gdir.getStatus().code;
		switch(gError) {
			case G_GEO_UNKNOWN_ADDRESS:
				alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gError);
				break;
			case G_GEO_UNAVAILABLE_ADDRESS:
				alert("The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.\n Error code: " + gError);
			case G_GEO_SERVER_ERROR: 
				alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gError);
				break;
			case G_GEO_MISSING_QUERY:
				alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gError);
				break;
			case G_GEO_BAD_KEY:
				alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gError);
				break;
			case G_GEO_BAD_REQUEST:
				alert("A directions request could not be successfully parsed.\n Error code: " + gError);
				break;
			default:
				alert("An unknown error occurred.");
		}
	};
	
	function getDataString() {
		var str = '';
		if (opts.data) {
			$.each(opts.data, function(i, itm) {
				str += itm.name + "=" + itm.value + "&";							
			});
			//remove last "&"
			str = str.substr(0, (str.length-1));
		}
		return str;
	};
		
	function doAjax(t, u, d, fnBefore, fnSuccess) {
		//alert(u);
		$.ajax({
			type: t,
			url: u,
			data: d,
			dataType: opts.data_type,
			beforeSend: fnBefore, 
			success: fnSuccess
	 	}); //close $.ajax(
	};
	
	function getLink(t, f, p) {
		var a = document.createElement('a');
		$(a)
		//$('<a></a>)')
			.attr("href", "#")
			.append(t)
			.click(function() {
				var fn = eval(f);
				if (p) {
					fn(p);
				} else {
					fn();
				}
				return false;
			});
			if (opts.mode == 'auto') $(a).css({"color": opts.menu_bar.text, lineHeight: "26px", marginLeft: "5px", textDecoration: "none"});
		return a;
	};
	
	function printMap(div) {
		//var w = (opts.mode == 'auto') ? parseInt(opts.map.width) : $('#'+opts.map).css('width');
		//var h = (opts.mode == 'auto') ? parseInt(opts.map.height) : $('#'+opts.map).css('height');
		//var w = window.open('','','width='+w+',height='+h);
		var w = window.open();
		//w.document.open("text/html");
		w.document.write($('#'+div).html());
		w.print();		
		//w.document.close();
		w.close();
	};
};
	
$.googleMaps.defaults = {
	mode: 'auto',//manual
	data_url: '',
	data: '',
	data_type: 'text',
	address: '',
	map: {"width": "400px", "height": "400px"},

	directions: {"background": "#fff", "text": "#000"},
	menu_bar: {"background": "#3366cc", "text": "#fff"},
	search: '',
	print_class: '',
	button_class: '',
	lat_lng: '',
	show_directions_menu: true,
	draggable: false, //whether markers are draggable
        scrollwheel: true,
	street_view: '',
	street_close_loc: '',
	progress_bar: '',//{container: 'imProgBarCntnr', bar_back_class: '', bar_class: ''},
	geocode_request_rate: 500,
	custom_marker: ''//{'type': 'labeledmarker', 'width': '32', 'height': '32', 'primaryColor': '#FFD766A', 'strokeColor': '#000000', 'labelColor': '#000000', 'starPrimaryColor': '', 'starStrokeColor': '', 'cornerColor': '#FFFFFF', 'shape': 'circle'} 
};

})(jQuery);		


function imStreetViewControl() {}

imStreetViewControl.prototype = new GControl();

imStreetViewControl.prototype.initialize = function(imGMapObj) {
  var streetViewBtn = document.createElement("div");
  streetViewBtn.style.textDecoration = "none";
  streetViewBtn.style.color = "#000000";
  streetViewBtn.style.backgroundColor = "white";
  streetViewBtn.style.font = "small Arial";
  streetViewBtn.style.fontSize = "11px";
  streetViewBtn.style.fontWeight = "bold";
  streetViewBtn.style.border = "1px solid black";
  streetViewBtn.style.padding = "2px";
  streetViewBtn.style.marginBottom = "3px";
  streetViewBtn.style.textAlign = "center";
  streetViewBtn.style.width = "6em";
  streetViewBtn.style.cursor = "pointer";
  //container.appendChild(streetViewBtn);
  streetViewBtn.appendChild(document.createTextNode("Street view"));
  GEvent.addDomListener(streetViewBtn, "click", function() {
  	if (!imSVOverlay) {
		imSVOverlay = new GStreetviewOverlay();
		imGMapObj.addOverlay(imSVOverlay);
	} else {
		imGMapObj.removeOverlay(imSVOverlay);
		imSVOverlay = null;
	}	
  });

  imGMapObj.getContainer().appendChild(streetViewBtn);
  return streetViewBtn;
}

imStreetViewControl.prototype.getDefaultPosition = function() {
  return new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(210, 7));
}

var imStreetView = new imStreetView();

function imStreetView() {
	this.mapDiv = '';
	this.streetDiv = '';
	this.streetClose = 'imStreetViewClose';
	this.point = '';
	this.init = function(mapDiv, streetDiv, bShow) {
		this.mapDiv = mapDiv;
		this.streetDiv = streetDiv;
		this.point = imStreetViewPoint;
		this.toggleStreetView(bShow);
	};
	
	this.toggleStreetView = function(bShow) {
		if (bShow) {
			document.getElementById( this.streetDiv ).style.display = 'block';
			document.getElementById( this.streetClose ).style.display = 'block';
            document.getElementById( this.mapDiv ).style.display = 'none'
            var myPano = new GStreetviewPanorama( document.getElementById( this.streetDiv ));
			GEvent.addListener(myPano, "error", this.handleNoFlash);
			myPano.setLocationAndPOV(this.point);
		} else {
			document.getElementById( this.streetDiv ).style.display = 'none';
			document.getElementById( this.streetClose ).style.display = 'none';
            document.getElementById( this.mapDiv ).style.display = 'block';
			
		}	
	};
	
	this.handleNoFlash = function(errorCode) {
		if (errorCode == 603) {
		   alert("Error: Flash doesn't appear to be supported by your browser");
		   return;
		}
	}; 
}
}
