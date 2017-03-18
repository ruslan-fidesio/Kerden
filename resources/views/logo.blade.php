<?php
// Instantiate new DOMDocument object
$svg = new DOMDocument();
// Load SVG file from public folder
$svg->load('http://kerden.fr/images/kerden-logo.svg');
// Add CSS class (you can omit this line)
$svg->documentElement->setAttribute("style", "width:80px");
// Echo XML without version element
echo $svg->saveXML($svg->documentElement);
?>