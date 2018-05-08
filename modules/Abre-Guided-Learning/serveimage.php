<?php
	
	/*
	* Copyright (C) 2016-2017 Abre.io LLC
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	
	$img=$_GET['file'];
	$img=preg_replace('/[^A-Za-z0-9\-._]/', '', $img);
	$img=$portal_path_root.'/../private/guide/'.$img;
	
	
	header('Pragma: public');
	header('Cache-Control: max-age=31536000');
	header("Expires: Mon, 1 Jan 2099 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header('Content-Type: image/jpeg');
	if (file_exists($img))
	{
		$img = file_get_contents($img);
		echo($img);
		exit();
	}
	else
	{
		$img = file_get_contents($portal_root.'/modules/'.basename(__DIR__).'/background.png');
		echo($img);
		exit();		
	}
	
	
	  
?>