<?php

error_reporting(E_ALL);

/**
 * Tell Markdown to use our modified class, rather than its default one
 */
@define( 'MARKDOWN_PARSER_CLASS',  'MarkdownTOC_Parser' );

include 'assets/markdown.php';
include 'assets/markdown.toc.php';
include 'assets/toc.php';
include 'assets/menu.php';


$input = file_get_contents('./docs/Core/Core.md');


// Convert Markdown to HTML
$output =  markdown($input);

// Genrate Table of Contents
$toc = new TOC($output);

// Generate Documentation Menu
$menu = new menu();



/**
 * @todo Apply GESHI syntax highlighting
 * @todo Create a clean way to specify source code language type in the Markdown file.
 * @todo Add some fancy CSS to make the page look similar to the MooTools Docs Page
 */


echo $menu->output();


echo $toc->output();



echo $output;

?>