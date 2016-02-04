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

echo "<!doctype html>";
echo "<html lang='en'>";
	echo "<head>";
		echo "<meta charset='utf-8'>";
		echo "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
		$site_description=constant("SITE_DESCRIPTION");
		echo "<meta name='description' content='$site_description'>";
		echo "<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>";
		$site_title=constant("SITE_TITLE");
		echo "<title>$site_title</title>";
    
		//Favicon
		$site_favicon=constant("SITE_FAVICON");
		echo "<link rel='icon' type='image/png' href='$site_favicon'>";

		//Chrome and Android Icons
		$site_chrome_icon=constant("SITE_CHROME_ICON");
		echo "<meta name='mobile-web-app-capable' content='yes'>";
		echo "<link rel='icon' sizes='192x192' href='$site_chrome_icon'>";

		//Safari and iOS Icons
		$site_safari_icon=constant("SITE_SAFARI_ICON");
		echo "<meta name='apple-mobile-web-app-title' content='$site_title'>";
		echo "<link rel='apple-touch-icon' href='$site_safari_icon'>";

		//Windows Icon
		$site_windows_icon=constant("SITE_WINDOWS_ICON");
		echo "<meta name='msapplication-TileImage' content='$site_windows_icon'>";
		echo "<meta name='msapplication-TileColor' content='#2B2B2B'>";

		//CSS Styles
	    echo "<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900,100' rel='stylesheet' type='text/css'>";
	    echo "<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>";
	    echo "<link rel='stylesheet' href='core/css/materialize.0.97.5.min.css'>";
	    echo "<link rel='stylesheet' href='core/css/material.1.0.6.min.css'>";
	    echo "<link rel='stylesheet' href='core/css/style.css'>";
	    echo "<link rel='stylesheet' href='core/css/animate.min.css'>";
	    echo "<link rel='stylesheet' href='core/css/owl.carousel.min.css'>";
	    echo "<link rel='stylesheet' href='core/css/timepicker.min.css'>";
	    echo "<link rel='stylesheet' href='modules/books/css/main.css'>";
    
	    //Javascript
	    echo "<script src='core/js/jquery-2.1.4.min.js'></script>";
	    echo "<script src='core/js/jquery-ui.min.js'></script>";
	    echo "<script src='core/js/materialize.0.97.5.min.js'></script>";
	    echo "<script src='core/js/material.1.0.6.min.js'></script>";
	    echo "<script src='core/js/routie.min.js'></script>";
	    echo "<script src='core/js/masonry-4.0.0.pkgd.min.js'></script>";
	    echo "<script src='core/js/jquery.tablesorter.min.js'></script>";
	    echo "<script src='core/js/owl.carousel.min.js'></script>";
	    echo "<script src='core/js/jquery.timepicker.min.js'></script>";
		    
	echo "</head>";
	echo "<body>";
  
 ?>
 
<script>
	//$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
		//options.async = false;
	//});
</script>