<?php
//$icon_folder = 'http://google-maps-icons.googlecode.com/files/';
$icon_folder = 'http://192.168.1.12:1020/themes/green/images/';
$json = '[';
$json .= '{link_id:"address1","address": "vadavalli, coimbatore","info" :"<img src=\"http://192.168.1.12:1020/themes/green/images/logo.png\"/>", "custom_marker": [{"type": "user_image","url" : "http://google.com", "image_loc": "' . $icon_folder . "facebook.png" . '", "width": "17", "height": "17"}]},';
$json .= '{link_id:"address2","address": "gandhipuram, coimbatore","info" :"deals 2", "custom_marker": [{"type": "user_image","url" : "http://google.com", "image_loc": "' . $icon_folder . "facebook.png" . '", "width": "17", "height": "17"}]},';
$json .= '{link_id:"address3","address": "rspuram, coimbatore", "info" :"deals 3", "custom_marker": [{"type": "user_image","url" : "http://google.com", "image_loc": "' . $icon_folder . "facebook.png" . '", "width": "17", "height": "17"}]},';
$json .= '{link_id:"address4","address": "singanallur, coimbatore", "info" :"deals 4","custom_marker": [{"type": "user_image", "url" : "http://google.com","image_loc": "' . $icon_folder . "facebook.png" . '", "width": "17", "height": "17"}]},';
$json .= '{link_id:"address5","address": "podanur, coimbatore", "info" :"deals 5","custom_marker": [{"type": "user_image","url" : "http://google.com", "image_loc": "' . $icon_folder . "facebook.png" . '", "width": "17", "height": "17"}]},';
$json .= '{link_id:"address6","address": "perur, coimbatore", "info" :"deals 6","custom_marker": [{"type": "user_image", "url" : "http://google.com","image_loc": "' . $icon_folder . "facebook.png" . '", "width": "17", "height": "17"}]}';
$json .= ']';
echo $json;
