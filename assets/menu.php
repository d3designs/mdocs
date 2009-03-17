<?php

/**
* Document Navigation Menu
* 
* Example:
* 	$menu = new menu();
* 	echo $menu->generate();
* 
*/
class Menu
{
	var $dir;
	var $filetype;
	
	function __construct($dir='docs/',$filetype='.md')
	{
		$this->dir = & $dir;
		$this->filetype = & $filetype;
	}
	
	/**
	 * Recursive glob()
	 *
	 * @param int $pattern
	 * the pattern passed to glob()
	 * @param int $flags
	 * the flags passed to glob()
	 * @param string $path 
	 * the path to scan
	 * @return array
	 * an array of files in the given path matching the pattern.
	 */
	function rglob($pattern='*', $flags = 0, $path='')
	{
	    $paths  = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
	    $files  = glob($path.$pattern, $flags);
		$length = strlen($path);

	    foreach ($paths as $path) { 
			$files[substr($path,$length,-1)] = $this->rglob($pattern, $flags, $path); 
		}

	    return $files;
	}

	/**
	 * Generate the documentation navigation menu
	 *
	 * @return string $html
	 */
	function generate()
	{
		$files = $this->rglob('*'.$this->filetype,0,$this->dir);

		$html = "";

		foreach ($files as $group => $files) {

			$html .= "<h4>$group</h4>\n";

			foreach ($files as $file) {
				$file  = pathinfo($file);
				$url   = "?file=$group/$file[filename]";
				$html .= "\t<div><a href=\"$url\">$file[filename]</a></div>\n";
			}

		}

		return $html;
	}

}


?>