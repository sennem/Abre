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
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php');
			
	header('Pragma: public');
	header('Cache-Control: max-age=31536000');
	header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));	
	header('Content-type: application/epub+zip');
 	$book=$_GET['book'];
	$file=dirname(__FILE__).'/../../../../private/books/'.$book.'.epub';	
	
	header('Content-Disposition: attachment; filename="'.$book.'.epub"');
	readfile($file);
	
?> 