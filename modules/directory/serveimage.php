<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	$fileextention=$_GET['ext'];
	$img=$_GET['file'];
	
	header('Pragma: public');
	header('Cache-Control: max-age=31536000');
	header("Expires: Mon, 1 Jan 2099 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	if($fileextention=='.jpg' or $fileextention=='.JPG'){ header('Content-Type: image/jpeg'); }
	if($fileextention=='.jpeg' or $fileextention=='.JPEG'){ header('Content-Type: image/jpeg'); }
	if($fileextention=='.png' or $fileextention=='.PNG'){ header('Content-Type: image/png'); }
	if($fileextention=='.gif' or $fileextention=='.GIF'){ header('Content-Type: image/gif'); }
	if($fileextention=='.tif' or $fileextention=='.TIF'){ header('Content-Type: image/tif'); }
	if($fileextention=='.bmp' or $fileextention=='.BMP'){ header('Content-Type: image/bmp'); }
	$img=$portal_path_root.'/../private/directory/images/employees/'.$img;
	$img = file_get_contents($img);
	echo($img);
	exit();
	  
?>