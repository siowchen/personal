<?php 
/********************************************
 * @Created on March, 2011
 * @Package: NDOTdeals 2.0 (Opensource <?php echo SITE_NAME; ?>  clone)
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
 
?>

<div class="brad_com">
  <ul>
    <li><a href="/" title="Home"><?php echo $language["home"]; ?> </a></li>
    <li><span class="right_arrow"></span></li>
    <li><a href="javascript:;" title="API Deals">API Deals</a></li>
  </ul>
</div>
<h1><?php echo $page_title; ?></h1>
<div class="con_center1">
  <h2>Available Requests</h2>
  <ul>
    <li>GET /api/city/</li>
    <ul>
      <li>Show a list of all launched cities.</li>
    </ul>
    <li>GET api/deal/
      <id>
    </li>
    <ul>
      <li>Shows a random deal for a city</li>
    </ul>
    <li>GET /api</li>
    <ul>
      <li>Show a list of all deals for a city</li>
    </ul>
  </ul>
  <h2>GET /city/</h2>
  <p>Show a list of all launched cities.</p>
  <h2>URL</h2>
  <code class="api_code clr fl" ><?php echo $docroot;?>api/city/</code>
  <h2>Formats</h2>
  <p>JSON (default)</p>
  <p>XML</p>
  <h2>Authentication Required</h2>
  <p>No</p>
  <h2>URL Parameters</h2>
  <ul>
    <li><strong>client_id</strong>
      <p>The api key that identifies your client</p>
      <p>Example: cee15b12a7518bdf220a92234996195db4639614</p>
    </li>
    <li><strong>format</strong>
      <p>The response type</p>
      <p>Example: xml</p>
    </li>
  </ul>
  <h2 >Sample JSON Request</h2>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/city/?client_id=abcd1234567890</code>
  <p>OR</p>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/city/?client_id=abcd1234567890&format=json</code>
  <h2>Sample JSON Response</h2>
  <code class="api_code"> {"cities":[{"city":{"cityid":"1","cityname":"Florida","cityurl":"florida","country":"USA"}}, {"city":{"cityid":"2","cityname":"Illinois","cityurl":"illinois","country":"USA"}}, {"city":{"cityid":"3","cityname":"Kansas","cityurl":"kansas","country":"USA"}},{"city":{"cityid":"4","cityname":"New Jersey","cityurl":"new-jersey","country":"USA"}}, {"city":{"cityid":"5","cityname":"New York","cityurl":"new-york","country":"USA"}}, {"city":{"cityid":"6","cityname":"California","cityurl":"california","country":"USA"}}, {"city":{"cityid":"7","cityname":"Alaska","cityurl":"alaska","country":"USA"}}, {"city":{"cityid":"8","cityname":"Michigan","cityurl":"michigan","country":"USA"}}, {"city":{"cityid":"9","cityname":"Mississippi","cityurl":"mississippi","country":"USA"}}, {"city":{"cityid":"10","cityname":"Hawaii","cityurl":"hawaii","country":"USA"}}]} </code>
  <h2>Sample XML Request</h2>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/city/?client_id=abcd1234567890&format=xml</code>
  <h2>Sample XML Response</h2>
  <code class="clr fl api_code"> &lt;?xml version="1.0"?&gt;<br />
  &lt;response&gt;<br />
  &lt;cities&gt;<br />
  &lt;city&gt;<br />
  &lt;cityid&gt;1&lt;/cityid&gt;<br />
  &lt;cityname&gt;Florida&lt;/cityname&gt;<br />
  &lt;cityurl&gt;florida&lt;/cityurl&gt;<br />
  &lt;country&gt;USA&lt;/country&gt;<br />
  &lt;/city&gt;<br />
  &lt;city&gt;<br />
  &lt;cityid&gt;2&lt;/cityid&gt;<br />
  &lt;cityname&gt;Illinois&lt;/cityname&gt;<br />
  &lt;cityurl&gt;illinois&lt;/cityurl&gt;<br />
  &lt;country&gt;USA&lt;/country&gt;<br />
  &lt;/city&gt;<br />
  &lt;city&gt;<br />
  &lt;cityid&gt;3&lt;/cityid&gt;<br />
  &lt;cityname&gt;Kansas&lt;/cityname&gt;<br />
  &lt;cityurl&gt;kansas&lt;/cityurl&gt;<br />
  &lt;country&gt;USA&lt;/country&gt;<br />
  &lt;/city&gt;<br />
  &lt;city&gt;<br />
  &lt;cityid&gt;4&lt;/cityid&gt;<br />
  &lt;cityname&gt;New Jersey&lt;/cityname&gt;<br />
  &lt;cityurl&gt;new-jersey&lt;/cityurl&gt;<br />
  &lt;country&gt;USA&lt;/country&gt;<br />
  &lt;/city&gt;<br/>
  &lt;city&gt;<br/>
  &lt;cityid&gt;5&lt;/cityid&gt;<br/>
  &lt;cityname&gt;New York&lt;/cityname&gt;<br/>
  &lt;cityurl&gt;new-york&lt;/cityurl&gt;<br/>
  &lt;country&gt;USA&lt;/country&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;city&gt;<br/>
  &lt;cityid&gt;6&lt;/cityid&gt;<br/>
  &lt;cityname&gt;California&lt;/cityname&gt;<br/>
  &lt;cityurl&gt;california&lt;/cityurl&gt;<br/>
  &lt;country&gt;USA&lt;/country&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;city&gt;<br/>
  &lt;cityid&gt;7&lt;/cityid&gt;<br/>
  &lt;cityname&gt;Alaska&lt;/cityname&gt;<br/>
  &lt;cityurl&gt;alaska&lt;/cityurl&gt;<br/>
  &lt;country&gt;USA&lt;/country&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;city&gt;<br/>
  &lt;cityid&gt;8&lt;/cityid&gt;<br/>
  &lt;cityname&gt;Michigan&lt;/cityname&gt;<br/>
  &lt;cityurl&gt;michigan&lt;/cityurl&gt;<br/>
  &lt;country&gt;USA&lt;/country&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;city&gt;<br/>
  &lt;cityid&gt;9&lt;/cityid&gt;<br/>
  &lt;cityname&gt;Mississippi&lt;/cityname&gt;<br/>
  &lt;cityurl&gt;mississippi&lt;/cityurl&gt;<br/>
  &lt;country&gt;USA&lt;/country&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;city&gt;<br/>
  &lt;cityid&gt;10&lt;/cityid&gt;<br/>
  &lt;cityname&gt;Hawaii&lt;/cityname&gt;<br/>
  &lt;cityurl&gt;hawaii&lt;/cityurl&gt;<br/>
  &lt;country&gt;USA&lt;/country&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;/cities&gt;<br/>
  &lt;/response&gt;<br/>
  </code>
  <h2>GET /deal/</h2>
  <p>Shows detailed information about a specified deal</p>
  <h2>URL</h2>
  <code class="api_code clr fl"><?php echo $docroot;?>api/deal/</code>
  <h2>Formats</h2>
  <p>JSON (default)</p>
  <p>XML</p>
  <h2>Authentication Required</h2>
  <p>No</p>
  <h2>URL Parameters</h2>
  <ul>
    <li><strong>client_id</strong>
      <p>The api key that identifies your client</p>
      <p>Example: cee15b12a7518bdf220a92234996195db4639614</p>
    </li>
    <li><strong>city</strong>
      <p>The city name from which deal should be displayed</p>
      <p>Example: alaska</p>
    </li>
    <li><strong>format</strong>
      <p>The response type</p>
      <p>Example: xml</p>
    </li>
  </ul>
  <h2>Sample JSON Request</h2>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/deal?client_id=abcd1234567890&city=alaska</code>
  <p>OR</p>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/deal?client_id=abcd1234567890&city=alaska&format=json</code>
  <h2>Sample JSON Response</h2>
  <code class="api_code fl clr" > {"deals":[{"id":"sample-deal-post", "title":"Sample deal post", "city":{"name":"Chennai"}, "imgurl":"http:\/\/groupon.ndot.in\/themes\/green\/images\/no image.jpg", "sidebarImageUrl":"http:\/\/groupon.ndot.in\/", "status":"open", "isSoldOut":false, "soldQuantity":null, "dealUrl":"http:\/\/groupon.ndot.in\/deals\/sample-deal-post_28.html", "options":{"option":{"id":"28", "title":"Sample deal post", "price":{"amount":99, "currencyCode":"USD", "formattedAmount":"$99"}, "value":{"amount":"100", "currencyCode":"USD", "formattedAmount":"$100"}, "discount":{"amount":1, "currencyCode":"USD", "formattedAmount":"$"}, "discountPercent":"1", "isLimitedQuantity":true, "minimumPurchaseQuantity":"1", "maximumPurchaseQuantity":"4", "expiresAt":"2011-02-24 23:05:06", "details":{"detail":{"description":"The wide, well-groomed lanes of Adrenaline Adventures' tubing hill offer rubber-donut wranglers a long, smooth ride down from the snowy summit. With today's deal, patrons pressed for time can pack a plethora of heart-pumping slope-slips into a two-hour snow session during sunny weekend mornings, dog-day afternoons, or any other time the hill is open. Creatures of the night and hard-working life-insurance salesmen can opt for a four-hour evening pass, cloaking activities under a cover of darkness and over less crowded slopes. Helmets protect riders' vulnerable noggins from bruises, yeti bites, and other common tubing injuries, and, after each descent, an energy-saving rope tow pulls lackadaisical loop-sitters up the hill for another ride."}}, "highlights":"Scientists agree that lower limbs should be permanently tucked away in a snow tube's central cavity to prevent spontaneous ", "fineprints":"Scientists agree that lower limbs should be permanently tucked away in a snow tube's central cavity to prevent spontaneous ", "redemptionLocations":{"redemptionLocation":{"lng":"15.456987",  "city":"Chennai", "name":"Domino's Pizza Corner", "streetAddress":"T.Nagar, Chennai, Tamilnadu.", "lat":"10.456987"}}, "buyUrl":"http:\/\/groupon.ndot.in\/purchase.html?cid=28"}}, "startAt":"2011-02-02 22:05:06", "endAt":"2011-02-24 23:05:06"}]} </code>
  <h2>Sample XML Request</h2>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/deal?client_id=abcd1234567890&city=alaska&format=xml</code>
  <h2>Sample XML Response</h2>
  <code class="api_code fl clr"> &lt;?xml version="1.0"?&gt;<br/>
  &lt;response&gt;<br/>
  &lt;deals&gt;<br/>
  &lt;deal&gt;<br/>
  &lt;id&gt;best-deals&lt;/id&gt;<br/>
  &lt;title&gt;<?php echo SITE_NAME; ?> &lt;/title&gt;<br/>
  &lt;city&gt;<br/>
  &lt;name&gt;Chennai&lt;/name&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;imgurl&gt;<?php echo $docroot;?>themes/green/images/no_image.jpg&lt;/imgurl&gt;<br/>
  &lt;sidebarImageUrl&gt;<?php echo $docroot;?>&lt;/sidebarImageUrl&gt;<br/>
  &lt;status&gt;open&lt;/status&gt;<br/>
  &lt;isSoldOut&gt;false&lt;/isSoldOut&gt;<br/>
  &lt;soldQuantity&gt;&lt;/soldQuantity&gt;<br/>
  &lt;dealUrl&gt;<?php echo $docroot;?>deals/best-deals_52.html&lt;/dealUrl&gt;<br/>
  &lt;options&gt;<br/>
  &lt;option&gt;<br/>
  &lt;id&gt;52&lt;/id&gt;<br/>
  &lt;title&gt;<?php echo SITE_NAME; ?> &lt;/title&gt;<br/>
  &lt;price&gt;<br/>
  &lt;amount&gt;5&lt;/amount&gt;<br/>
  &lt;currencyCode&gt;USD&lt;/currencyCode&gt;<br/>
  &lt;formattedAmount&gt;$5&lt;/formattedAmount&gt;<br/>
  &lt;/price&gt;<br/>
  &lt;value&gt;<br/>
  &lt;amount&gt;50&lt;/amount&gt;<br/>
  &lt;currencyCode&gt;USD&lt;/currencyCode&gt;<br/>
  &lt;formattedAmount&gt;$50&lt;/formattedAmount&gt;<br/>
  &lt;/value&gt;<br/>
  &lt;discount&gt;<br/>
  &lt;amount&gt;45&lt;/amount&gt;<br/>
  &lt;currencyCode&gt;USD&lt;/currencyCode&gt;<br/>
  &lt;formattedAmount&gt;$&lt;/formattedAmount&gt;<br/>
  &lt;/discount&gt;<br/>
  &lt;discountPercent&gt;90&lt;/discountPercent&gt;<br/>
  &lt;isLimitedQuantity&gt;true&lt;/isLimitedQuantity&gt;<br/>
  &lt;minimumPurchaseQuantity&gt;4&lt;/minimumPurchaseQuantity&gt;<br/>
  &lt;maximumPurchaseQuantity&gt;10&lt;/maximumPurchaseQuantity&gt;<br/>
  &lt;expiresAt&gt;2011-02-28 13:35:31&lt;/expiresAt&gt;<br/>
  &lt;details&gt;<br/>
  &lt;detail&gt;<br/>
  &lt;description&gt;Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...&lt;/description&gt;<br/>
  &lt;/detail&gt;<br/>
  &lt;/details&gt;<br/>
  &lt;highlights&gt;Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...&lt;/highlights&gt;<br/>
  &lt;fineprints&gt;Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...&lt;/fineprints&gt;<br/>
  &lt;redemptionLocations&gt;<br/>
  &lt;redemptionLocation&gt;<br/>
  &lt;lng&gt;43&lt;/lng&gt;<br/>
  &lt;city&gt;Chennai&lt;/city&gt;<br/>
  &lt;name&gt;Apple iPhone Service Centre&lt;/name&gt;<br/>
  &lt;streetAddress&gt;Dsidc complex Mata sundri Road New Delhi (near the lalit hotel)&lt;/streetAddress&gt;<br/>
  &lt;lat&gt;23&lt;/lat&gt;<br/>
  &lt;/redemptionLocation&gt;<br/>
  &lt;/redemptionLocations&gt;<br/>
  &lt;buyUrl><?php echo $docroot;?>purchase.html?cid=52&lt;/buyUrl&gt;<br/>
  &lt;/option&gt;<br/>
  &lt;/options&gt;<br/>
  &lt;startAt&gt;2011-02-16 12:35:31&lt;/startAt&gt;<br/>
  &lt;endAt&gt;2011-02-28 13:35:31&lt;/endAt&gt;<br/>
  &lt;/deal&gt;<br/>
  &lt;/deals&gt;<br/>
  &lt;/response&gt;<br/>
  </code>
  <h2>GET api/</h2>
  <p>Shows detailed information about a specified deal</p>
  <h2>URL</h2>
  <code class="api_code clr fl"><?php echo $docroot;?>api/</code>
  <h2>Formats</h2>
  <p>JSON (default)</p>
  <p>XML</p>
  <h2>Authentication Required</h2>
  <p>No</p>
  <h2>URL Parameters</h2>
  <ul>
    <li><strong>client_id</strong>
      <p>The api key that identifies your client</p>
      <p>Example: cee15b12a7518bdf220a92234996195db4639614</p>
    </li>
    <li><strong>city</strong>
      <p>The city name from which deal should be displayed</p>
      <p>Example: alaska</p>
    </li>
    <li><strong>format</strong>
      <p>The response type</p>
      <p>Example: xml</p>
    </li>
  </ul>
  <h2>Sample JSON Request</h2>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/?client_id=abcd1234567890&city=alaska</code>
  <p>OR</p>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/?client_id=abcd1234567890&city=alaska&format=json</code>
  <h2>Sample JSON Response</h2>
  <code class="api_code fl clr" style="width:600px;"> {"deals":[{"id":"grand-feast", "title":"grand feast...", "city":{"name":"Chennai"}, "imgurl":"http:\/\/groupon.ndot.in\/themes\/green\/images\/no image.jpg", "sidebarImageUrl":"http:\/\/groupon.ndot.in\/", "status":"open","isSoldOut":false,"soldQuantity":null,"dealUrl":"http:\/\/groupon.ndot.in\/deals\/grand-feast_51.html", "options":{"option":{"id":"51", "title":"grand feast...", "price":{"amount":5,"currencyCode":"USD","formattedAmount":"$5"}, "value":{"amount":"50", "currencyCode":"USD", "formattedAmount":"$50"}, "discount":{"amount":45, "currencyCode":"USD", "formattedAmount":"$"}, "discountPercent":"90", "isLimitedQuantity":true, "minimumPurchaseQuantity":"5", "maximumPurchaseQuantity":"10", "expiresAt":"2011-02-28 13:34:20", "details":{"detail":{"description":"The vouchers issued in the promotion shall expire on January 28, 2011"}}, "highlights":"The vouchers issued in the promotion shall expire on January 28, 2011", "fineprints":"The vouchers issued in the promotion shall expire on January 28, 2011", "redemptionLocations":{"redemptionLocation":{"lng":"43", "city":"Chennai", "name":"Apple iPhone Service Centre", "streetAddress":"Dsidc complex Mata sundri Road New Delhi (near the lalit hotel)", "lat":"23"}}, "buyUrl":"http:\/\/groupon.ndot.in\/purchase.html?cid=51"}}, "startAt":"2011-02-16 12:34:20", "endAt":"2011-02-28 13:34:20"}]} </code>
  <h2>Sample XML Request</h2>
  <code class="api_code clr fl">GET <?php echo $docroot;?>api/?client_id=abcd1234567890&city=alaska&format=xml</code>
  <h2>Sample XML Response</h2>
  <code class="api_code fl clr"> &lt;?xml version="1.0"?&gt;<br/>
  &lt;response&gt;<br/>
  &lt;deals&gt;<br/>
  &lt;deal&gt;<br/>
  &lt;id&gt;best-deals&lt;/id&gt;<br/>
  &lt;title&gt;<?php echo SITE_NAME; ?> &lt;/title&gt;<br/>
  &lt;city&gt;<br/>
  &lt;name&gt;Chennai&lt;/name&gt;<br/>
  &lt;/city&gt;<br/>
  &lt;imgurl&gt;<?php echo $docroot;?>themes/green/images/no_image.jpg&lt;/imgurl&gt;<br/>
  &lt;sidebarImageUrl&gt;<?php echo $docroot;?>&lt;/sidebarImageUrl&gt;<br/>
  &lt;status&gt;open&lt;/status&gt;<br/>
  &lt;isSoldOut&gt;false&lt;/isSoldOut&gt;<br/>
  &lt;soldQuantity&gt;&lt;/soldQuantity&gt;<br/>
  &lt;dealUrl&gt;<?php echo $docroot;?>deals/best-deals_52.html&lt;/dealUrl&gt;<br/>
  &lt;options&gt;<br/>
  &lt;option&gt;<br/>
  &lt;id&gt;52&lt;/id&gt;<br/>
  &lt;title&gt;<?php echo SITE_NAME; ?> &lt;/title&gt;<br/>
  &lt;price&gt;<br/>
  &lt;amount&gt;5&lt;/amount&gt;<br/>
  &lt;currencyCode&gt;USD&lt;/currencyCode&gt;<br/>
  &lt;formattedAmount&gt;$5&lt;/formattedAmount&gt;<br/>
  &lt;/price&gt;<br/>
  &lt;value&gt;<br/>
  &lt;amount&gt;50&lt;/amount&gt;<br/>
  &lt;currencyCode&gt;USD&lt;/currencyCode&gt;<br/>
  &lt;formattedAmount&gt;$50&lt;/formattedAmount&gt;<br/>
  &lt;/value&gt;<br/>
  &lt;discount&gt;<br/>
  &lt;amount&gt;45&lt;/amount&gt;<br/>
  &lt;currencyCode&gt;USD&lt;/currencyCode&gt;<br/>
  &lt;formattedAmount&gt;$&lt;/formattedAmount&gt;<br/>
  &lt;/discount&gt;<br/>
  &lt;discountPercent&gt;90&lt;/discountPercent&gt;<br/>
  &lt;isLimitedQuantity&gt;true&lt;/isLimitedQuantity&gt;<br/>
  &lt;minimumPurchaseQuantity&gt;4&lt;/minimumPurchaseQuantity&gt;<br/>
  &lt;maximumPurchaseQuantity&gt;10&lt;/maximumPurchaseQuantity&gt;<br/>
  &lt;expiresAt&gt;2011-02-28 13:35:31&lt;/expiresAt&gt;<br/>
  &lt;details&gt;<br/>
  &lt;detail&gt;<br/>
  &lt;description&gt;Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...&lt;/description&gt;<br/>
  &lt;/detail&gt;<br/>
  &lt;/details&gt;<br/>
  &lt;highlights&gt;Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...&lt;/highlights&gt;<br/>
  &lt;fineprints&gt;Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is ...&lt;/fineprints&gt;<br/>
  &lt;redemptionLocations&gt;<br/>
  &lt;redemptionLocation&gt;<br/>
  &lt;lng&gt;43&lt;/lng&gt;<br/>
  &lt;city&gt;Chennai&lt;/city&gt;<br/>
  &lt;name&gt;Apple iPhone Service Centre&lt;/name&gt;<br/>
  &lt;streetAddress&gt;Dsidc complex Mata sundri Road New Delhi (near the lalit hotel)&lt;/streetAddress&gt;<br/>
  &lt;lat&gt;23&lt;/lat&gt;<br/>
  &lt;/redemptionLocation&gt;<br/>
  &lt;/redemptionLocations&gt;<br/>
  &lt;buyUrl><?php echo $docroot;?>purchase.html?cid=52&lt;/buyUrl&gt;<br/>
  &lt;/option&gt;<br/>
  &lt;/options&gt;<br/>
  &lt;startAt&gt;2011-02-16 12:35:31&lt;/startAt&gt;<br/>
  &lt;endAt&gt;2011-02-28 13:35:31&lt;/endAt&gt;<br/>
  &lt;/deal&gt;<br/>
  &lt;/deals&gt;<br/>
  &lt;/response&gt;<br/>
  </code> </div>
