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

//Display correct header  
if (file_exists('configuration.php'))
{
?>
	<!doctype html>
	<html lang='en'>
		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<?php 
			$site_description=constant("SITE_DESCRIPTION");
			echo "<meta name='description' content='$site_description'>";
			?>
			<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
			<?php
				
			//Site title
			$site_title=constant("SITE_TITLE");
			echo "<title>$site_title</title>";
			
			//Site favicon
			$site_favicon=constant("SITE_FAVICON");
			echo "<link rel='icon' type='image/png' href='$site_favicon'>";
	
			//Chrome icon
			$site_chrome_icon=constant("SITE_CHROME_ICON");
			echo "<meta name='mobile-web-app-capable' content='yes'>";
			echo "<link rel='icon' sizes='192x192' href='$site_chrome_icon'>";
	
			//iOS icon
			$site_safari_icon=constant("SITE_SAFARI_ICON");
			echo "<meta name='apple-mobile-web-app-title' content='$site_title'>";
			echo "<link rel='apple-touch-icon' href='$site_safari_icon'>";
	
			//Windows icon
			$site_windows_icon=constant("SITE_WINDOWS_ICON");
			echo "<meta name='msapplication-TileImage' content='$site_windows_icon'>";
			$site_windows_icon_color=constant("SITE_WINDOWS_ICON_COLOR");
			echo "<meta name='msapplication-TileColor' content='$site_windows_icon_color'>";
			?>
	
		    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900,100' rel='stylesheet' type='text/css'>
		    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
		    <link rel='stylesheet' href='core/css/materialize.0.97.5.min.css'>
		    <link rel='stylesheet' href='core/css/material.1.1.3.min.css'>
		    <link rel='stylesheet' href='core/css/abre.1.1.4.css'>
		    <link rel='stylesheet' href='core/css/animate.min.css'>
		    <link rel='stylesheet' href='core/css/timepicker.min.css'>
		    <link rel='stylesheet' href='modules/books/css/main.css'>
	    
		    <script src='core/js/jquery-2.1.4.min.js'></script>
		    <script src='core/js/jquery-ui.min.js'></script>
		    <script src='core/js/materialize.0.97.5.min.js'></script>
		    <script src='core/js/material.1.1.3.min.js'></script>
		    <script src='core/js/routie.min.js'></script>
		    <script src='core/js/masonry-4.0.0.pkgd.min.js'></script>
		    <script src='core/js/jquery.tablesorter.min.js'></script>
		    <script src='core/js/jquery.timepicker.min.js'></script>
		</head>
		<body>

<?php
}
else
{
?>
	<!doctype html>
	<html lang='en'>
		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
			<title>Abre Installation</title>
	
		    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900,100' rel='stylesheet' type='text/css'>
		    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
		    <link rel='stylesheet' href='core/css/materialize.0.97.5.min.css'>
		    <link rel='stylesheet' href='core/css/material.1.1.3.min.css'>
		    <link rel='stylesheet' href='core/css/abre.1.1.4.css'>
	    
		    <script src='core/js/jquery-2.1.4.min.js'></script>
		    <script src='core/js/jquery-ui.min.js'></script>
		    <script src='core/js/materialize.0.97.5.min.js'></script>
			<script src='core/js/material.1.1.3.min.js'></script>
			    
		</head>
		<body>	 
<?php
}
?>
<script>
	//$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
		//options.async = false;
	//});
</script>