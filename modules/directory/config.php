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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 

	$pageview=1;
	$drawerhidden=0;
	$pageorder=5;
	$pagetitle="Directory";
	$pageicon="people";
	$pagepath="directory";
	$pagerestrictions="student";
	
	require_once('permissions.php');
		
?>

<script>

//Page Locations
routie({
    'directory': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/directory.php', function() { init_page(); $("#searchquery").focus(); });
		
			<?php if($pageaccess==1){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/directory/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>

		
    },
    'directory/archived': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/archieved.php', function() { init_page(); });
		
			<?php if($pageaccess==1){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/directory/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>
		
    },
    'directory/export': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/export.php', function() { init_page(); });
		
			<?php if($pageaccess==1){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/directory/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>
		
    },
    'directory/?:name': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/profile.php?id='+name, function() { init_page(); $("#firstname").focus(); });
    }
});

</script>