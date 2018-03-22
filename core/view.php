<?php
namespace test1;
class View
{
	
	function generate($contentView, $stampView, $title, $data = null)
	{
		include 'view/'.$stampView;
	}
}
