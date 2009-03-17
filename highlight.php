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

/**
 * Tell Markdown to use our modified class, rather than its default one
 */
@define( 'MARKDOWN_PARSER_CLASS',  'MarkdownExtra_Parser_mDocs' );

include 'assets/markdown.php';
include 'assets/markdown.mdocs.php';
include 'assets/toc.php';
include 'assets/menu.php';
include 'assets/geshi.php';





/**
* 
*/
class GeSHi_mDocs extends GeSHi
{
	/**
	 * The default language to use, if one isn't 
	 * specified manually in the code block.
	 *
	 * @var string
	 */
	var $default_language = 'javascript';
	
	function __construct($source = '', $language = '', $path = '')
	{
		if (empty($language))
			$language = $this->default_language;
		else
			$this->default_language = $language;
		
		$this->GeSHi($source,$language,$path);

		$this->enable_classes();
		$this->set_overall_style('');
		$this->enable_keyword_links(false);
	}
	
	
	function parse_codeblocks($input)
	{
		$regex = '/<pre( (class|id)="([\w\-\_]+)")?><code>(.*)<\/code><\/pre>/sU';
		
		$input = & html_entity_decode($input);
		
		$input = preg_replace_callback($regex, array(&$this, '_parse_codeblocks_match'), $input);

		return $input;

	}
	
	private function _parse_codeblocks_match($match)
	{	
		$source   = trim($match[4]);
		$language = ($match[2]=='class' && !empty($match[3]))? $match[3] : $this->default_language;

		$this->set_source($source);
		$this->set_language($language);

		return $this->parse_code();
	}
	


}


$geshi = new GeSHi_mDocs();
// $geshi->enable_classes();
// $geshi->set_overall_style('');
// $geshi->enable_keyword_links(false);


$input = file_get_contents('./docs/Core/Core.md');

// Convert Markdown to HTML
$output =  markdown($input);

// Genrate Table of Contents
$toc = new TOC($output);

// Generate Documentation Menu
$menu = new menu();



// $source = 'alert(\'hi\');';


// $language = 'javascript';




/**
 * @todo Apply GESHI syntax highlighting
 * @todo Create a clean way to specify source code language type in the Markdown file.
 * @todo Add some fancy CSS to make the page look similar to the MooTools Docs Page
 */


// echo $menu->output();


// echo $toc->output();


$output = $geshi->parse_codeblocks($output);


echo $output;




?>