<style type="text/css" media="screen">

.kw1 {
	color: #1b609a;
}

.kw2 {
	color: #9a6f1b;
}

.me1 {
	color: #666;
}

.kw3, .re0, .sc1 {
	color: #784e0c;
}

.br0 {
	color: #444;
}

.st0 {
	color: #489a1b;
}

.co1, .coMULTI {
	color: #888;
}

.nu0 {
	color: #70483d;
}

</style>
<?php

error_reporting(E_ALL);

include 'assets/geshi.php';


$geshi = new GeSHi();
$geshi->enable_classes();
$geshi->set_overall_style('');
$geshi->enable_keyword_links(false);


$source = <<<END
var result = \$try(function(){
	return some.made.up.object;
}, function(){
	return jibberish.that.doesnt.exists;
}, function(){
	return false;
});

//result is false

var failure, success;

\$try(function(){
	some.made.up.object = 'something';
	success = true;
}, function(){
	failure = true;
});

if (success) alert('yey!');
END;


$language = 'javascript';

$geshi->set_source($source);
$geshi->set_language($language);

echo $geshi->parse_code();

?>