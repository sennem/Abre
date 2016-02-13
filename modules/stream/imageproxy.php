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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	//Check for Image
	if($image!="")
	{		
		
		//Check for Existing HTTPS   
		$url = parse_url($image);
		if($url['scheme'] == 'https' xor $url['scheme'] == 'http')
		{
			
			//Get the Name of the File
			$file_name = basename($image);
			//Replace + with _ (Apache has trouble with +)
			$file_name=str_replace("+", "_", $file_name);
			//Replace % with _ (Apache has trouble with %)
			$file_name=str_replace("%", "_", $file_name);
			//Replace all Special Characters
			$file_name = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_name);
			$filename = $portal_path_root . '/../private/stream/cache/images/'.$date.$file_name;
			
			//If it Exists, Read it from Cache
			if (file_exists($filename))
			{
				$imagefile=$date.$file_name;
				$fileExtension = pathinfo($image, PATHINFO_EXTENSION);
				$image = $portal_root."/modules/stream/serveimage.php?file=$imagefile&ext=$fileExtension";
			}
			else
			{
				//Write the File to Cache
				if(@exif_imagetype($image))
				{
					if (!copy($image, $portal_path_root . '/../private/stream/cache/images/'.$date.$file_name)) {
					    $image="";
					}
					else
					{
						$image=$portal_path_root.'/../private/stream/cache/images/'.$date.$file_name;
					}
				}
				else
				{
					$image="";
				}
			}

		}
	}
			
?>