<?php
	function isEmpty($str) {
		return preg_match("/^\s*$/u", $str) === 1;
	}
?>