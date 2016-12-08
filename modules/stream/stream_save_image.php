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
	 
	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	//Check for feed image
	if($image!="")
	{		
				
		//Make sure image is over http or https
		$url = parse_url($image);
		if($url['scheme'] == 'https' xor $url['scheme'] == 'http')
		{
			
			//Get the name and sanatize the file name
			$file_name = basename($image);
			$file_name=str_replace("+", "_", $file_name);
			$file_name=str_replace("%", "_", $file_name);
			$file_name = preg_replace('/[^a-zA-Z0-9_.]/', '', $file_name);
			$filename = $portal_path_root . '/../private/stream/cache/images/'.$date.$file_name;
			
			//If it already saved, read from local server
			if (file_exists($filename))
			{
				$imagefile=$date.$file_name;
				$fileExtension = pathinfo($image, PATHINFO_EXTENSION);
				$image = $portal_root."/modules/stream/stream_serve_image.php?file=$imagefile&ext=$fileExtension";
				if(filesize($filename)<1000)
				{
					$image="";
				}

			}
			else
			{
				//Check for 404 and 403 errors
				$file_headers = @get_headers($image);
				if((!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') or (!$file_headers || $file_headers[0] == 'HTTP/1.1 403 Forbidden') or (!$file_headers || $file_headers[0] == 'HTTP/1.0 400 Bad Request') or (!$file_headers || $file_headers[0] == 'HTTP/1.1 503 Service Unavailable'))
				{
				    $image="";
				}
				else
				{
					//Make sure file is an image
					if(@exif_imagetype($image))
					{					    
						//Save image to server
						$local_file = $portal_path_root . '/../private/stream/cache/images/'.$date.$file_name;
						$remote_file = $image;
						$ch = curl_init();
						$fp = fopen ($local_file, 'w+');
						$ch = curl_init($remote_file);
						curl_setopt($ch, CURLOPT_TIMEOUT, 50);
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt($ch, CURLOPT_ENCODING, "");
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);
					}	
					else
					{
						$image="";
					}
				}
			}

		}
	}
			
?>