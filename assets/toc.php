<?php

/**
* Create a Table of Contents based off the specified HTML
* 
* Example:
* 
* 	$toc = new TOC( $html );
* 	echo $toc->output_flat();
* 
* 
* @author Jay Williams
*/
class TOC
{
	/**
	 * The HTML to scan when creating the Table of Contents
	 *
	 * @var string
	 */
	var $content = "";
	
	/**
	 * The the raw Table of Contents array is stored here
	 *
	 * @var array
	 * @access private
	 */
	var $toc     = array();
	
	/**
	 * The maximum header level to include in the TOC
	 *
	 * @var int
	 */
	var $maxlevel = 1;
	
	/**
	 * The minimum header level to include in the TOC
	 *
	 * @var int
	 */
	var $minlevel = 2;
	
	/**
	 * All headers will be split based off of this delimiter.
	 * If you don't want to split the headers, simply set this variable to false, or empty.
	 *
	 * @var string
	 */
	var $delimiter = ':';
	
	/**
	 * Headers will be trimmed based off of this variable.
	 * If you don't want headers to be trimmed, simply set this variable to false, or empty.
	 *
	 * @var string
	 */
	var $trim = '$ ';

	function __construct($content='',$maxlevel=1,$minlevel=2)
	{
		if (empty($content))
			return false;
		
		$this->content  = & $content;
		$this->maxlevel = & $maxlevel;
		$this->minlevel = & $minlevel;

		$this->scan();
		
		return true;
	}

	function scan()
	{
		$regex = '#<h(['."$this->maxlevel-$this->minlevel".'])(.*?id=("|\')([\w\:\-_]+)\3.*?)?>(.*?)</h\1>#';
		
		preg_replace_callback($regex, array(&$this, 'add'), $this->content);
	}
	
	
	function add($match)
	{		
		$this->toc[] = array(
						'level'=>(int)$match[1],
						'id'=>$match[4],
						'text'=>$match[5]
						);
	}
	
	function output_list()
	{
		$html = "";

	    for ($i = 0; $i < count($this->toc); $i ++) {
			
			$level = & $this->toc[$i]['level'];
			$id    = & $this->toc[$i]['id'];
			$text  = $item['text'];
			
			if (!empty($this->delimiter))
				$text = end(explode($this->delimiter,$text));
			
			if (!empty($this->trim))
				$text = trim($text,$this->trim);

	        $link = "<a href=\"#$id\">$text</a>";
	
	        if ($i == 0) {
	            $level = min($level, $this->minlevel);
	            $stack = array($level);
	            $html .= "\t<ol><li>$link";
	        } else {
	            $prev = $stack[count($stack)-1];
	            if ($level == $prev) {
	                $html .= "</li>\n\t<li>$link";
	            } elseif ($level < $prev) {
					
	                while (count($stack) > 1) {
	                    array_pop($stack);
	                    $html .= "</li></ol>";
	                    $prev = $stack[count($stack)-1];
	                    if ($level >= $prev)
	                        break;
	                }
	                $html .= "</li>\n\t<li>$link";
	            } else {
	                $stack[] = $level;
	                $html .= "\n\t<ol><li>$link";
	            }
	        }
	    }
	    while (count($stack) > 0) {
	        array_pop($stack);
	        $html .= "</li></ol>";
	    }	 
		
		return $html;
	}
	
	function output()
	{
		$html = "";
		
		foreach ($this->toc as $item) {
			
			$level = & $item['level'];
			$id    = & $item['id'];
			$text  = & $item['text'];
			
			if (!empty($this->delimiter))
				$text = end(explode($this->delimiter,$text));
			
			if (!empty($this->trim))
				$text = trim($text,$this->trim);
			
			 $link = "<a href=\"#$id\">$text</a>";
			
			if ($level == $this->maxlevel) {
				$html .= "<h4>$link</h4>\n";
			}else {
				$html .= "\t<div class=\"menu-item\">$link</div>\n";
			}
			
		}
		
		return $html;
	}	
}


?>