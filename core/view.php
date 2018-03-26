<?php
namespace test1;
class View
{
	
	function generate($contentView, $stampView, $title, $data = null)
	{
		$contentView = $contentView . '.php';
		include '../view/' . $stampView . '.php';
	}
}
