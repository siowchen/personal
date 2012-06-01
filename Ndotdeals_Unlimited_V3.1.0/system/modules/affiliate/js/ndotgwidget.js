var dynLoaded = false;
// function to load jQuery...
load = function() {
	load.getScript("http://192.168.1.82:1013/affliate/js/jquery.js");
	load.tryReady(0); // This function waits until jQuery loads before using it.
}
// dynamically load a javascript file.
load.getScript = function(filename) {
	var script = document.createElement('script')
	script.setAttribute("type","text/javascript")
	script.setAttribute("src", filename)
	if (typeof script!="undefined")
	document.getElementsByTagName("head")[0].appendChild(script)
}
load.tryReady = function(time_elapsed) {
	// Continually polls to see if jQuery is loaded.
	if (typeof jQuery == "undefined") { // if jQuery isn't loaded yet...
		if (time_elapsed <= 10000) { // and we havn't given up trying...
			setTimeout("load.tryReady(" + (time_elapsed + 200) + ")", 200); // set a timer to check again in 200 ms.  
		} else {
			// alert("Timed out while loading jQuery.")
		}
	} else {
		// Any code to run after jQuery loads goes here!
		// for example:
		dynLoaded = true;
		groupon_init();
	}
}

if (typeof(jQuery) == 'undefined') {
	// jQuery isn't loaded, so we need to load it...
	load();
} else {
	groupon_init();
}

var DateDiff = function(d1, d2) {
	var t2 = d2.getTime();
	var t1 = d1.getTime();
	var wholeDays = 0;
	var wholeHours = 0;
	var wholeMinutes = 0;
	var wholeSeconds = 0;
	
	var totalSeconds = parseInt((t2-t1) / 1000);
	// 86400 seconds in 1 day
	(totalSeconds > 86400) ? wholeDays = Math.abs(parseInt(totalSeconds / (86400))) : wholeDays = 0;
	var leftAfterDays = totalSeconds - (wholeDays * 86400);
	// 3600 seconds in 1 hour
	var wholeHours = Math.abs(parseInt(leftAfterDays / 3600));
	var leftAfterHours = leftAfterDays - (wholeHours * 3600);
	// 60 seconds in 1 minute
	var wholeMinutes = Math.abs(parseInt(leftAfterHours / 60));
	var leftAfterMinutes = leftAfterHours - (wholeMinutes * 60);
	
	var breakDown = new Object();
	breakDown['days'] = wholeDays;
	if (wholeDays > 0) {
		wholeHours = wholeHours + (24*wholeDays);
	}
	breakDown['hours'] = wholeHours;
	breakDown['minutes'] = wholeMinutes;
	breakDown['seconds'] = leftAfterMinutes;
	
	return breakDown;
}
 
var niceDateDiff = '';

var coords = new Object();
coords['Chicago'] = {'lat' : 41.90, 'lng' : -87.65};
coords['Dallas'] = {'lat' : 32.90, 'lng' : -97.03};
coords['Los Angeles'] = {'lat' : 33.93, 'lng' : -118.40};
coords['Minneapolis / St. Paul'] = {'lat' : 44.9799654, 'lng' : -93.2638361 };

function groupon_niceNum(num) {
	if (typeof(num) == 'number') { 
		return num;
	} else {
		return num.substr(num, num.indexOf('.'));
	}
}
var gInterval=new Array();
function startCountdown(endDate, i) {
	gInterval[i]=setInterval(function() {
		d1 = new Date();
		niceDateDiff = DateDiff(d1, endDate);
		// $('#grouponDays' + i).text(niceDateDiff['days']);
		jQuery('#grouponHours' + i).text(niceDateDiff['hours']);
		jQuery('#grouponMinutes' + i).text(niceDateDiff['minutes']);
		jQuery('#grouponSeconds' + i).text(niceDateDiff['seconds']);
	}, 1000);
}

function displayGrouponAd(APIKEY, size, location, color1, showpreloader, pid, aid, title) {
	ASSETDOMAIN = 'http://192.168.1.82:1013';
	//ASSETDOMAIN = 'http://localhost:3000/'
	CSSURL = new String();
	CSSURL = ASSETDOMAIN + '/stylesheets/widget/ad' + size + '.css';
	jQuery('HEAD').append('<link id="grouponCSS" rel="stylesheet" type="text/css" href="' + CSSURL + '" />');
	IMGURL = ASSETDOMAIN + '/uploads/coupons/';
	APIURL = 'http://192.168.1.82:1013/affliate/js/deals.json?apikey='+APIKEY+'&callback=?';
	if (location.length) {
		var latLon = location.split(',');
		APIURL += '&lat=' + latLon[0];
		APIURL += '&lng=' + latLon[1];
	}
	jQuery('<div id="grouponAdContainer"></div>').insertAfter('#grouponAd');
	sizeSplit = size.split('.');
	if (showpreloader) {
		jQuery('#grouponAdContainer').html('<div style="text-align: center; font: 10px arial normal; width: ' + sizeSplit[0] + '"><img width="64" height="64" src="http://192.168.1.82:1013/images/loader.gif" align="center" /><br>Loading Groupon</div>');
	}
	jQuery.getJSON(APIURL, function(data) {
		var d1 = new Date();
		var theDate = data.deals[0].end_date;
		var safeDateTime = theDate.split('T');
		var safeDate = safeDateTime[0].replace(/-/g,"/");
		var safeTime = safeDateTime[1].replace(/Z/g,"");
		
		var d2 = new Date(safeDate + ' ' + safeTime);
		var nicePrice = '$' + groupon_niceNum(data.deals[0].price);
		jQuery('#grouponAdContainer').html('');
		//adding code to not loop through to side-deal if there isnt one
		if(data.deals[1]==undefined){var lE=1;}else{var lE=2;}
		//and if the color doesnt have hashtag, we'll add one
		if(color1.indexOf("#")<0){color1="#"+color1;}
		//prepend CJ information to the clickthru
		var cjprepend='http://192.168.1.82:1013/click-'+pid+'-'+aid+'?url=';
		switch (size) {
			case '300.250':
				var cityDiv = '<div id="grouponCity"> Today\'s daily deal: <strong>' + data.deals[0].division_name + '</strong></div>'
				jQuery('#grouponAdContainer').append(cityDiv);
				var descriptionDiv = '<div id="grouponDescription"><p>' + data.deals[0].title.replace("&","and") + '</p></div>';
				jQuery('#grouponAdContainer').append(descriptionDiv);
				var valueChart = '<div id="grouponValueChart"><table><tr><th>value</th><th>discount</th><th>save</th></tr><tr><td>$' + groupon_niceNum(data.deals[0].value) + '</td><td>' + data.deals[0].discount_percent + '%</td><td>$' + groupon_niceNum(data.deals[0].discount_amount) + '</td></table></div>';
				var countdown = '<div id="grouponCountdown"><div id="grouponCountContainer"><span class="countdownTime">H<br><span id="grouponHours">0</span></span><span class="grouponColon">:</span><span class="countdownTime">M<br><span id="grouponMinutes">0</span></span><span class="grouponColon">:</span><span class="countdownTime">S<br><span id="grouponSeconds">0</span></span></div></div>';
				var buyButton = '<div id="grouponBuyButton"></div>';
				var midLeftContent = buyButton + valueChart + countdown;
				var midContent = '<div id="grouponMidContainer"><div id="grouponMidLeft">' + midLeftContent + '</div><div id="grouponImage"><img id="grouponIMG" src="' + data.deals[0].large_image_url + '"></div></div>';
				jQuery('#grouponAdContainer').append(midContent);
				// $('#grouponImage').css('background-image','url(' + data.deals[0].large_image_url + ')');
				var poweredByDiv = '<div id="grouponPoweredBy">Powered by Groupon</div>';
				var footer = '<div id="grouponFooter"><p>' + data.deals[0].quantity_sold + ' Bought</p>' + poweredByDiv + '</div>';
				jQuery('#grouponAdContainer').append(footer);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContainer').css('background-color', color1);
				}
				break;
			case '88.31':
				thisTitle = data.deals[0].title.replace("&","and");
				var grouponAd = '<div id="grouponAdContents"><a title="' + thisTitle.replace(/\"/g, '&quot;') + '" href="' + cjprepend+data.deals[0].deal_url + '"><img src="http://192.168.1.82:1013/images/banner.88.31.png"></a></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				// change color of border... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
				}
				break;
			case '120.60':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '120.90.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.deals[0].division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','10px');
					jQuery('#grouponCity').css('top','6px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '120.90':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity"><p>Your Daily Deal</p></div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="70" height="42" src="' + data.deals[0].medium_image_url + '" /></div>';
				jQuery('#grouponAdContents').append(imgDiv);
				var tagDiv = '<div id="grouponTag">' + nicePrice + '</div>';
				jQuery('#grouponAdContents').append(tagDiv);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('background-color', color1);
				}
				if (typeof(color2) != 'undefined') {
					jQuery('#grouponCity').css('color', color2);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '125.125.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.deals[0].division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','11px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponAdContents .grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponAdContents .grouponTableRight').html(groupon_niceNum(data.deals[0].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[0].discount_amount));
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '125.125':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Your Daily Deal</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="71" height="42" src="' + data.deals[0].medium_image_url + '" /></div>';
				jQuery('#grouponAdContents').append(imgDiv);
				var tagDiv = '<div id="grouponTag"><a href="' + cjprepend+data.deals[0].deal_url + '">' + nicePrice + '</a></div>';
				jQuery('#grouponAdContents').append(tagDiv);
				var discountDiv = '<div id="grouponDiscount">' + data.deals[0].discount_percent + '%<br>Discount</div>';
				jQuery('#grouponAdContents').append(discountDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('background-color', color1);
				}
				if (typeof(color2) != 'undefined') {
					jQuery('#grouponCity').css('color', color2);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
					jQuery('#grouponCity').autoEllipsis();
				}, 200);
				break;
			case '180.150.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Daily Deal:' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var discountDiv = '<div id="grouponDiscount"><div>DISCOUNT:</div>'+groupon_niceNum(data.deals[0].discount_percent)+'%<div>SAVE:</div>$'+groupon_niceNum(data.deals[0].discount_amount)+'</div>';
				jQuery('#grouponAdContents').append(discountDiv);
				var imgDiv = '<div id="grouponImage"><img width="113" height="66" src="' + data.deals[0].medium_image_url + '" /></div>';
				jQuery('#grouponAdContents').append(imgDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '180.150':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity"><p>Daily Deal: ' + data.deals[0].division_name + '!</p></div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="93" height="56" src="' + data.deals[0].medium_image_url + '" /></div>';
				jQuery('#grouponAdContents').append(imgDiv);
				var tagDiv = '<div id="grouponTag"><p>' + nicePrice + '</p></div>';
				jQuery('#grouponAdContents').append(tagDiv);
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Value<br>Discount<br>You Save');
				jQuery('#grouponTableRight').html('$' + groupon_niceNum(data.deals[0].value) + '<br>' + data.deals[0].discount_percent + '%<br>$' + groupon_niceNum(data.deals[0].discount_amount));
				jQuery('#grouponAdContents').append(discountDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('background-color', color1);
				}
				if (typeof(color2) != 'undefined') {
					jQuery('#grouponCity').css('color', color2);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '234.60.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Daily Deal: ' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.deals[0].division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','10px');
					jQuery('#grouponCity').css('top','6px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_small_lofi.gif"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '250.250.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Today\'s Deal: ' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				if (data.deals[0].division_name.length > 14) {
					jQuery('#grouponCity').css('font-size','13px');
				}
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="153" height="87" src="' + data.deals[0].large_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponTableRight').html(groupon_niceNum(data.deals[0].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[0].discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var boughtDiv = '<div id="grouponBought"><strong>' + data.deals[0].quantity_sold + '</strong> Bought</div>';
				jQuery('#grouponAdContents').append(boughtDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var countdown = '<div id="grouponCountdown"><div id="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds">0</span><br>S</span></div></div>';
				jQuery('#grouponAdContents').append(countdown);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '250.250.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					if ((title != null) && (title != '') && (title!='undefined')) {
						cityText = title;
					} else {
						cityText = 'Today\'s Deal: ' + data.deals[i].division_name;
					}
					var cityDiv = '<div class="grouponCity">'+cityText+'</div>';
					jQuery(thisDeal).append(cityDiv);
					if (data.deals[i].division_name.length > 14) {
						jQuery(thisDeal+' .grouponCity').css('font-size','13px');
					}
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="153" height="87" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://192.168.1.82:1013/images/showsidedeal_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://192.168.1.82:1013/images/showdailydeal_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=250'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[1].deal_url);
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=250'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[0].deal_url);
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '300.250.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					if (data.deals[i].division_name.length > 14) {
						jQuery(thisDeal+' .grouponCity').css('font-size','13px');
					}
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="190" height="108" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://192.168.1.82:1013/images/showsidedeal_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://192.168.1.82:1013/images/showdailydeal_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=300'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[1].deal_url);
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=300'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[1].deal_url);
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '300.250.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Today\'s Deal: ' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="192" height="113" src="' + data.deals[0].large_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Price:<br>Value:<br>Save:');
				jQuery('#grouponTableRight').html('$' + groupon_niceNum(data.deals[0].price) + '<br>$' + groupon_niceNum(data.deals[0].value) + '<br>$' + groupon_niceNum(data.deals[0].discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var boughtDiv = '<div id="grouponBought"><strong>' + data.deals[0].quantity_sold + '</strong> Bought</div>';
				jQuery('#grouponAdContents').append(boughtDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var countdown = '<div id="grouponCountdown"><div id="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds">0</span><br>S</span></div></div>';
				jQuery('#grouponAdContents').append(countdown);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '336.280.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					if (data.deals[i].division_name.length > 14) {
						jQuery(thisDeal+' .grouponCity').css('font-size','13px');
					}
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="223" height="129" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://192.168.1.82:1013/images/showsidedeal_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="28" height="126" src="http://192.168.1.82:1013/images/showdailydeal_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left<br>to buy</span><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=336'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[1].deal_url);
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=336'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[0].deal_url);
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '468.60.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Daily Deal: ' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="93" height="55" src="' + data.deals[0].medium_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponTableRight').html(groupon_niceNum(data.deals[0].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[0].discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_small_h_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '728.90.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Daily Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="137" height="80" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="126" height="26" src="http://192.168.1.82:1013/images/showsidedeal_h_medium.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="126" height="26" src="http://192.168.1.82:1013/images/showdailydeal_h_medium.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><span class="countdownText">Time left to buy </span> <span class="countdownTime"><span id="grouponHours'+i+'">0</span>:H</span> <span class="countdownTime"><span id="grouponMinutes'+i+'">0</span>:M</span> <span class="countdownTime"><span id="grouponSeconds'+i+'">0</span>:S</span></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=728'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[1].deal_url);
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=728'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[0].deal_url);
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '728.90.lofi':
				var grouponAd = '<div id="grouponAdContents"></div>';
				jQuery('#grouponAdContainer').append(grouponAd);
				var cityDiv = '<div id="grouponCity">Today\'s Deal: ' + data.deals[0].division_name + '</div>';
				jQuery('#grouponAdContents').append(cityDiv);
				var titleDiv = '<div id="grouponTitle">' + data.deals[0].title.replace("&","and") + '</div>';
				jQuery('#grouponAdContents').append(titleDiv);
				var imgDiv = '<div id="grouponImage"><img width="137" height="80" src="' + data.deals[0].medium_image_url + '" /></div>';
				var tableDiv = '<div id="grouponTable"><div id="grouponTableLeft"></div><div id="grouponTableRight"></div>';
				jQuery('#grouponAdContents').append(tableDiv);
				jQuery('#grouponTableLeft').html('Discount:<br>You Save:');
				jQuery('#grouponTableRight').html(groupon_niceNum(data.deals[0].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[0].discount_amount));
				jQuery('#grouponAdContents').append(imgDiv);
				var boughtDiv = '<div id="grouponBought"><strong>' + data.deals[0].quantity_sold + '</strong> Bought</div>';
				jQuery('#grouponAdContents').append(boughtDiv);
				var getDiv = '<div id="grouponGet">Get It!</div>';
				jQuery('#grouponAdContents').append(getDiv);
				var countdown = '<div id="grouponCountdown"><span class="countdownText">Time left to buy </span> <span class="countdownTime"><span id="grouponHours">0</span>:H</span> <span class="countdownTime"><span id="grouponMinutes">0</span>:M</span> <span class="countdownTime"><span id="grouponSeconds">0</span>:S</span></div>';
				jQuery('#grouponAdContents').append(countdown);
				setInterval(function() {
					d1 = new Date();
					niceDateDiff = DateDiff(d1, d2);
					jQuery('#grouponHours').text(niceDateDiff['hours']);
					jQuery('#grouponMinutes').text(niceDateDiff['minutes']);
					jQuery('#grouponSeconds').text(niceDateDiff['seconds']);
				}, 1000);
				var poweredByDiv = '<div id="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_lofi.png"></div>';
				jQuery('#grouponAdContents').append(poweredByDiv);
				// change color of text... 
				if (typeof(color1) != 'undefined') {
					jQuery('#grouponAdContents').css('border-color', color1);
					jQuery('#grouponCity').css('color', color1);
					jQuery('#grouponGet').css('color', color1);
				}
				setTimeout(function() {
					jQuery('#grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '120.600.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="112" height="64" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="112" height="27" src="http://192.168.1.82:1013/images/showsidedeal_h_small.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="112" height="27" src="http://192.168.1.82:1013/images/showdailydeal_h_small.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
				  }
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left to buy</span><div class="timeShim"></div><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_c_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=120'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[1].deal_url);
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=120'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[0].deal_url);
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
			case '160.600.lofimulti':
				for (i=0; i<lE; i++) {
					thisDeal = '#grouponAdContents' + i;
					var grouponAd = '<div id="grouponAdContents'+i+'" class="grouponAdContents"></div>';
					jQuery('#grouponAdContainer').append(grouponAd);
					var cityDiv = '<div class="grouponCity">Today\'s Deal: ' + data.deals[i].division_name + '</div>';
					jQuery(thisDeal).append(cityDiv);
					var titleDiv = '<div class="grouponTitle">' + data.deals[i].title.replace("&","and") + '</div>';
					jQuery(thisDeal).append(titleDiv);
					var imgDiv = '<div class="grouponImage"><img width="151" height="87" src="' + data.deals[i].large_image_url + '" /></div>';
					jQuery(thisDeal).append(imgDiv);
					if(lE==2){
					  if (i == 0) {
						  thisButtonID = 'grouponShowSide'
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="148" height="32" src="http://192.168.1.82:1013/images/showsidedeal_h_large.png" /></div>';
					  } else {
						  thisButtonID = 'grouponShowDaily';
						  var otherDealDiv = '<div id="'+thisButtonID+'"><img width="148" height="32" src="http://192.168.1.82:1013/images/showdailydeal_h_large.png" /></div>';
					  }
					  jQuery(thisDeal).append(otherDealDiv);
					}
					var tableDiv = '<div class="grouponTable"><div class="grouponTableLeft"></div><div class="grouponTableRight"></div>';
					jQuery(thisDeal).append(tableDiv);
					jQuery(thisDeal+' .grouponTableLeft').html('Discount:<br>You Save:');
					jQuery(thisDeal+' .grouponTableRight').html(groupon_niceNum(data.deals[i].discount_percent) + '%<br>$' + groupon_niceNum(data.deals[i].discount_amount));
					var boughtDiv = '<div class="grouponBought"><strong>' + data.deals[i].quantity_sold + '</strong> Bought</div>';
					jQuery(thisDeal).append(boughtDiv);
					var getDiv = '<div class="grouponGet">Get It!</div>';
					jQuery(thisDeal).append(getDiv);
					var countdown = '<div class="grouponCountdown"><div class="grouponCountContainer"><span class="countdownText">Time left to buy</span><div class="timeShim"></div><span class="countdownTime"><span id="grouponHours'+i+'">0</span><br>H</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponMinutes'+i+'">0</span><br>M</span><span class="grouponColon">:</span><span class="countdownTime"><span id="grouponSeconds'+i+'">0</span><br>S</span></div></div>';
					jQuery(thisDeal).append(countdown);
					if(typeof(gInterval)!='undefined'){
  			    clearInterval(gInterval[i]); 
  			  }
					startCountdown(d2, i);
					var poweredByDiv = '<div class="grouponPoweredBy"><img src="http://192.168.1.82:1013/images/poweredby_large_c_lofi.gif"></div>';
					jQuery(thisDeal).append(poweredByDiv);
					// change color of text... 
					if (typeof(color1) != 'undefined') {
						jQuery(thisDeal).css('border-color', color1);
						jQuery('.grouponCity').css('color', color1);
						jQuery('.grouponGet').css('color', color1);
					}
				}
				jQuery('#grouponShowSide').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '-=160'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[1].deal_url);
						});
					});
					return false;
				});
				jQuery('#grouponShowDaily').click(function(e) {
					e.preventDefault();
					jQuery('#grouponAdContents0, #grouponAdContents1').animate({ left: '+=160'}, 1000, function() {
						// animation complete...
						jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
              window.open(cjprepend+data.deals[0].deal_url);
						});
					});
					return false;
				});
				setTimeout(function() {
					jQuery('.grouponTitle').autoEllipsis();
				}, 200);
				break;
		}
		jQuery('#grouponAdContainer').css('cursor','pointer').click(function() {
      window.open(cjprepend+data.deals[0].deal_url);
		});
	});
}


function groupon_init() {
	// ellipsis plugin
	// <reference path="jquery-1.3.2-vsdoc.js"/>
	/*
		by Homam Hosseini
		http://abstractform.wordpress.com
		bluesnowball@gmail.com

	*/

  
	jQuery.fn.autoEllipsis = function(options) {
		var get_AutoEllipsisScroller = function(id) {
			var aeScrollerId = "WingooliAutoEllipsisScroller_" + id
			if (!document.getElementById(aeScrollerId)) {
				var div = document.createElement("div");
				div.id = aeScrollerId + "_Container";
				div.innerHTML = "<span id=\"" + aeScrollerId + "\" style=\"overflow: visible; position: absolute; top: -2000px; color: orange\"></span>";
				document.body.appendChild(div);
			}
			return document.getElementById(aeScrollerId);
		};

		var StringEllipsesByMaxLetters = function(element, originalText, maxLettersAllowed) {
			element.title = "";
			var text = originalText;
			if (text == null || text == "") text = element.innerHTML;
			var maxAllowedLatterIndex = text.length - maxLettersAllowed;
			if (maxAllowedLatterIndex > 0) {
				element.title = text;
				if (originalText == null)
					originalText = text;
				element.innerHTML = text.substr(0, maxLettersAllowed - 2) + "&hellip;";
			} else {
				element.innerHTML = text;
			}
		};

		var _this = this;

		var settings = jQuery.extend({}, options);
		this.each(function(i) {
			var aeScroller = get_AutoEllipsisScroller(i);
			saeScroller = jQuery(aeScroller);
			sthis = jQuery(this);
			saeScroller.text(sthis.text());

			var origText = sthis.html();

			var element = this;
			var elementBounds = { width: element.offsetWidth, height: element.offsetHeight };
    
			var jAeScroller = jQuery(aeScroller);
			var jElement = jQuery(element);

			var props = ["font-size", "font-weight", "font-family", "font-style", "padding"];

			for (var i = 0; i < props.length; i++) {
				try {
					jAeScroller.css(props[i], jElement.css(props[i]));
				} catch (ex) { }
			}
			jElement.css("overflow", "visible");

			jAeScroller.width(jElement.innerWidth());

			var isIe = (document.all != undefined);
			var scrollerWidth = jAeScroller.innerWidth();
			var scrollerHeight = jAeScroller.innerHeight();
			var fitText = saeScroller.text();

			while (scrollerHeight > elementBounds.height && fitText != "") {
				fitText = fitText.substr(0, fitText.length - 2);
				var autoScrollerInnerHTML = fitText + "&hellip;";
				saeScroller.html(autoScrollerInnerHTML);
				scrollerHeight = jAeScroller.innerHeight();
			}
			if (fitText == "") {
				fitText = origText;
				saeScroller.html(fitText);
				jElement.css("whiteSpace", "nowrap");
				jAeScroller.width("");
				var scrollerWidth = jAeScroller.width();
			}
			while (scrollerWidth > elementBounds.width && fitText != "") {
				fitText = fitText.substr(0, fitText.length - 2);
				var autoScrollerInnerHTML = fitText + "&hellip;";
				saeScroller.html(autoScrollerInnerHTML);
				scrollerWidth = jAeScroller.innerWidth();
			}
			var scrollerHeight = aeScroller.offsetHeight;
			var r = (Math.ceil(elementBounds.height / scrollerHeight) - 1);
			r += (r == 0) ? 1 : 0;
			var maxLettersAllowed = fitText.length * r;

			StringEllipsesByMaxLetters(element, origText, maxLettersAllowed + (r + 1));
		});
	}
	// initialize with options...
	if ((typeof(_gwparam) != 'undefined') && (typeof(_gwparam['size']) != 'undefined')) {
		displayGrouponAd(_gwparam['APIKEY'] ,_gwparam['size'], _gwparam['location'], _gwparam['bgcolor'], true, _gwparam['PID'], _gwparam['AID'], _gwparam['title'] );
	}
}


