<?php

/**
* Document Navigation Menu
*
* Example:
* 	$menu = new menu( 'docs/', '.md' );
* 	echo $menu->generate();
*
*/
class Menu
{
	var $dir;
	var $filetype;
	var	$html;

	function __construct($dir='docs/',$filetype='.md')
	{
		$this->dir = & $dir;
		$this->filetype = & $filetype;
	}

	function __toString()
	{
		return $this->html;
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

		$this->html = "";

		$this->_list_files($files);

		return $this->html;
	}

	/**
	 * List all files in HTML format
	 * Used by generate()
	 *
	 * @param array $files Multi-dimensional array of files
	 * @param string $parent Parent path, used for sub directories
	 * @param int $depth Folder depth, used for heading tags
	 * @return null
	 */
	function _list_files($files, $parent='', $depth=0)
	{
		$path = $parent;

		if(empty($files))
			return;

		foreach($files as $group => $file)
		{
			if(!is_int($group))
			{
				$h = $depth + 4;
				$this->html .= "<h$h>$group</h$h>\n";
				$path = $parent . $group . '/';
			}

			if(is_array($file))
			{
				$this->_list_files($file, $path, $depth+1);
				continue;
			}

			$file        = pathinfo($file);
			$url         = "?file=$path$file[filename]";
			$this->html .= "\t<div><a href=\"$url\">$file[filename]</a></div>\n";
		}
	}

}


?>