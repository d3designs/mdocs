<?php

/**
 * Markdown + Auto Header ID Generation & Links
 *
 * @author Jay Williams
 */
class MarkdownTOC_Parser extends MarkdownExtra_Parser
{
	function _doHeaders_permalink($title='')
	{
		$title = preg_replace('/[^a-z0-9:]/','',strtolower($title));
		// $title = preg_replace('/\s+/','-',$title);
		return $title;
	}

	function _doHeaders_attr($attr,$title) {		
		if (empty($attr))
			return $this->_doHeaders_permalink($title);
	
		return $attr;
	}

	function _doHeaders_callback_setext($matches) {
		if ($matches[3] == '-' && preg_match('{^- }', $matches[1]))
			return $matches[0];
		$level = $matches[3]{0} == '=' ? 1 : 2;
		$attr  = $this->_doHeaders_attr($id =& $matches[2], $title =& $this->runSpanGamut($matches[1]));
		$block = "<h$level id=\"$attr\"><a href=\"#$attr\">".$title."</a></h$level>";
		return "\n" . $this->hashBlock($block) . "\n\n";
	}
	function _doHeaders_callback_atx($matches) {
		$level = strlen($matches[1]);
		$attr  = $this->_doHeaders_attr($id =& $matches[3], $title =& $this->runSpanGamut($matches[2]));
		$block = "<h$level id=\"$attr\"><a href=\"#$attr\">".$title."</a></h$level>";
		return "\n" . $this->hashBlock($block) . "\n\n";
	}

}


?>