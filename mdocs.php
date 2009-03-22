<?php

error_reporting(E_ALL);

/**
 * @todo Create A GitHub update hook file, to keep the docs in sync with GitHub
 * 
 * @todo Add a "clean url" (mod_rewrite) option to the Menu class
 */


/**
 * SETTINGS
 */

$config = new stdClass();
$config->path      = 'docs/';
$config->extension = '.md';
$config->index     = 'Core/Core';
$config->language  = 'javascript';

$config->maxlevel  = 1;
$config->minlevel  = 2;



/**
 * @todo Possibly move this ugly logic code into a class or function
 */

// Determine the file to load:
$file = (isset($_GET['file']) && !empty($_GET['file']))? clean_filename($_GET['file']) : $config->index;

$config->filename  = $config->path.$file.$config->extension;

if (!(file_exists($config->filename) && is_readable($config->filename))){
	/**
	 * @todo Possibly show a 404 page
	 */
	die('ERROR: Document not found.');
}

$doc = file_get_contents($config->filename);


// Get the classes:
require_once 'assets/markdown.php';
require_once 'assets/markdown.mdocs.php';
require_once 'assets/toc.php';
require_once 'assets/menu.php';
require_once 'assets/geshi.php';
require_once 'assets/geshi.mdocs.php';


// Initialize Markdown
$markdown = new MarkdownExtra_Parser_mDocs();
$markdown->maxlevel = & $config->maxlevel;
$markdown->minlevel = & $config->minlevel;

// Initialize Table of Contents
$toc = new TOC();
$toc->content   = & $doc;
$toc->maxlevel  = & $config->maxlevel;
$toc->minlevel  = & $config->minlevel;
$toc->delimiter = ':';
$toc->trim      = '$ ';

// Initialize Docs Menu
$menu = new menu();
$menu->dir      = & $config->path;
$menu->filetype = & $config->extension;

// Initialize GeSHi (Syntax Highlighting)
$geshi = new GeSHi_mDocs();
$geshi->default_language = & $config->language;


// Apply Markdown Syntax:
$doc = $markdown->transform($doc);

// Apply GeSHi Syntax Highlighting:
$doc = $geshi->parse_codeblocks($doc);

// Create Menu:
$menu->generate();

// Create TOC:
$toc->generate();


/**
 * Helper Functions:
 * @todo Possibly move this to a separate file
 */


/**
 * Clean Filename Path
 * 
 * Yes, it's overkill, but why not, it's fun!
 * This function restricts allows only the following characters 
 * to pass: 	A-Z a-z 0-9 - _ . /
 * 
 * It also goes into great detail to make sure that troublesome 
 * slash and period characters are not abused by would be hackers.
 * So because of this, you can't read any file or folder that starts 
 * or ends with a period, but then again, you shouldn't have public 
 * files named like that in the first place, right?
 *
 * @param string $file 
 * @return void
 * @author Jay Williams
 */
function clean_filename($filename='')
{
	$patern[] = '/[^\w\.\-\_\/]/';
	$replacement[] = '';

	$patern[] = '/\.+/';
	$replacement[] = '.';

	$patern[] = '/\/+/';
	$replacement[] = '/';

	$patern[] = '/(\/\.|\.\/)/';
	$replacement[] = '/';

	$patern[] = '/\.+/';
	$replacement[] = '.';

	$patern[] = '/\/+/';
	$replacement[] = '/';

	$filename = preg_replace($patern,$replacement,$filename);
	$filename = trim($filename,' ./\\');
	
	return $filename;
}

?>