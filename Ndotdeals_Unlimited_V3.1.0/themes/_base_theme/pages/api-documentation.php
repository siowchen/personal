<?php 
/********************************************
 * @Created on March, 2011
 * @Package: NDOTdeals 2.0 (Opensource <?php echo SITE_NAME; ?>  clone)
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?><div class="bread_com mt10">
<div class="bread_top"></div>
<div class="bread_mid">

<ul>
  <li><a href="/" title="Home"><?php echo $language["home"]; ?> </a></li>
  <li><span class="right_arrow"></span></li>
  <li><a href="javascript:;" title="API Documentaion">API Documentaion</a></li>
</ul></div>
<div class="bread_bottom"></div>
</div>
<h1><?php echo $page_title; ?></h1>
<div class="con_center1">
  <h2>API Usage</h2>
  <p><b><u>Getting Started</u></b></p>
  <p><b><u>Making a Request</u></b></p>
  <ul>
    <li>All request require your API Key to be passed on the URL as client_id=
      <your api key>
      in the params of the request: <code class="api_code clr fl">GET <?php echo $docroot;?>api?client_id=
      <your api key>
      </code></li>
    <li>All documented parameters, unless otherwise specified, are required. Optional parameters are marked in the documentations like this: my_optional_parameter (optional)</li>
  </ul>
  <p><b><u>Getting the Response</u></b></p>
  <ul>
    <li>JSON is the default response format for all requests. XML is available by specifying .xml on the end of the URL path.</li>
    <li>JSON response without .json on the request URL path <code  class="api_code clr fl">GET <?php echo $docroot;?>api?client_id=
      <your api key>
      &city=
      <city name>
      </code></li>
    <li>JSON response with .json on the request URL path <code  class="api_code clr fl">GET <?php echo $docroot;?>api?client_id=
      <your api key>
      &city=
      <city name>
      &format=json </code></li>
    <li>XML response with .xml on the request URL path <code  class="api_code clr fl">GET <?php echo $docroot;?>api?client_id=
      <your api key>
      &city=
      <city name>
      &format=xml </code></li>
    <li>The <?php echo SITE_NAME; ?> API also respects the HTTP Accepts header</li>
    <li><?php echo SITE_NAME; ?> responds with a standard error response format and a fixed set of HTTP codes.</li>
  </ul>
</div>
