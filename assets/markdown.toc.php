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
		
		return $title;
	}

	function _doHeaders_attr($attr='',$title='') {
		if (empty($attr) && empty($title))
			return "";
		elseif(!empty($attr) && empty($title))
			return " id=\"$attr\"";
		elseif(!empty($attr) && !empty($title))
			return $attr;
		elseif(empty($attr) && !empty($title))
			return $this->_doHeaders_permalink($title);
	}

	function _doHeaders_callback_setext($matches) {
		if ($matches[3] == '-' && preg_match('{^- }', $matches[1]))
			return $matches[0];
		
		$level = $matches[3]{0} == '=' ? 1 : 2;
		$id    = & $matches[2];
		$title = & $this->runSpanGamut($matches[1]);
		
		if ($level < 3) {
			$attr  = $this->_doHeaders_attr($id ,$title);
			$block = "<h$level id=\"$attr\"><a href=\"#$attr\">".$title."</a></h$level>";
		}else {
			$attr  = $this->_doHeaders_attr($id);
			$block = "<h$level$attr>$title</a></h$level>";
		}

		return "\n" . $this->hashBlock($block) . "\n\n";
	}
	function _doHeaders_callback_atx($matches) {
		
		$level = strlen($matches[1]);
		$id    = & $matches[3];
		$title = & $this->runSpanGamut($matches[2]);

		if ($level < 3) {
			$attr  = $this->_doHeaders_attr($id, $title);
			$block = "<h$level id=\"$attr\"><a href=\"#$attr\">".$title."</a></h$level>";
		}else {
			$attr  = $this->_doHeaders_attr($id);
			$block = "<h$level$attr>".$title."</h$level>";
		}
		
		return "\n" . $this->hashBlock($block) . "\n\n";
	}

}


?>