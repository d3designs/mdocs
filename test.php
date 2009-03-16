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




echo $menu->output();


echo $toc->output_flat();



echo $output;

?>