<?php

error_reporting(E_ALL);

/**
 * Tell Markdown to use our modified class, rather than its default one
 */
@define( 'MARKDOWN_PARSER_CLASS',  'MarkdownTOC_Parser' );

include 'assets/markdown.php';
include 'assets/markdown.toc.php';
include 'assets/toc.php';


/**
 * Sample Markdown Code
 */
$input = <<<END

# Level One {#level1}

## Level 2

Doolde

### Level  3      threee nenen

Stuff

### Level 3 {#level3}

Extra

## Level 2

## Level 2 {#level2}

[Linkme](http://example.com)

## Level 2

# Method: \$the Test 2

#### Level 4

#### Level 4

Stuff

### Level 3

Extra

Paragraph 


	Code
	Goes
	Here


## Level 2

Level 1
=======================


Level 2
-----------------------

END;





// Convert Markdown to HTML
$output =  markdown($input);

// Genrate Table of Contents
$toc = new TOC($output);


echo($toc->output_flat());


echo $output;

?>