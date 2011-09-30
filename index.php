<?php

/**
 * Load the mDocs system
 */
include 'mdocs.php';


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>	
  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  		<title>mDocs - <?php echo $file; ?></title>
  		<link rel="stylesheet" type="text/css" media="all" href="assets/css/mdocs.css">
  </head>
  <body>
  		<div id="container">
  		  <aside id="aside-left">
    			<div id="menu">
    				<?php echo $menu; ?>
    			</div>
  			</aside>
  			
  			<div id="doc">
  				<?php echo $doc; ?>
  			</div>
  			
  			<aside id="aside-right">
    			<div id="toc">
    				<?php echo $toc; ?>
    			</div>
    		</aside>
  			
  			<div id="footer">
  				<p>This documentation is released under a <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Attribution-NonCommercial-ShareAlike 3.0</a> License.</p>
  			</div>
  		</div>
  		<script type="text/javascript" src="assets/js/jquery-1.6.4.min.js"></script>
  		<script type="text/javascript" src="assets/js/jquery.smooth-scroll-1.4.min.js"></script>
  		<script type="text/javascript" src="assets/js/jquery.floating-widget-0.9.1.js"></script>
  		<script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>