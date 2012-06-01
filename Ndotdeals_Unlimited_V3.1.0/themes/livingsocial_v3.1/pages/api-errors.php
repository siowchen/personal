<?php 
/********************************************
 * @Created on March, 2011
 * @Package: NDOTdeals 2.0 (Opensource <?php echo SITE_NAME; ?>  clone)
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>

<ul>
  <li><a href="/" title="Home"><?php echo $language["home"]; ?> </a></li>
  <li><span class="right_arrow"></span></li>
  <li><a href="javascript:;" title="API Errors">API Errors</a></li>
</ul>
<h1><?php echo $page_title; ?></h1>
<div class="con_center1">
  <h2>Error Response Format</h2>
  <p>All error responses contain at least the top level error object with httpCode and message</p>
  <ul>
    <li>httpCode - HTTP status code</li>
    <li>message - Human readable message indicating why the api request failed</li>
  </ul>
  <h2>Sample Invalid JSON Requests</h2>
  <code class="api_code fl clr">GET <?php echo $docroot;?>api?city=themoon&client_id=5cd27f66bac85fb6a1a1ee9e1b7f311d53811c74&format=json</code>
  <h2>Sample JSON Error Response</h2>
  <code class="api_code fl clr">HTTP/1.1 400 Bad Request
  {
  "error":
  {
  "httpCode":400,
  "message":"Unable to find city"
  }
  } </code>
  <h2>Sample Invalid XML Request</h2>
  <code class="api_code fl clr">GET <?php echo $docroot;?>api?city=themoon&client_id=5cd27f66bac85fb6a1a1ee9e1b7f311d53811c74&format=xml</code>
  <h2>Sample XML Error Response</h2>
  <code class="api_code fl clr">HTTP/1.1 400 Bad Request<br/>
  &lt;?xml version="1.0"?&gt;<br/>
  &lt;response&gt;<br/>
  &nbsp;&nbsp;&lt;error&gt;<br/>
  &nbsp;&nbsp; &nbsp;&lt;httpCode&gt;<br/>
  400<br/>
  &nbsp;&lt;/httpCode&gt;<br/>
  &nbsp;&nbsp; &nbsp;&lt;message&gt;<br/>
  Unable to find city<br/>
  &lt;/message&gt;<br/>
  &nbsp;&nbsp;&lt;/error&gt;<br/>
  &lt;/response&gt;</code> </div>
