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

	$pageview=1;
	$drawerhidden=0;
	$pageorder=5;
	$pagetitle="Directory";
	$pageicon="people";
	$pagepath="directory";
	$pagerestrictions="student";
	
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
		$( "#content_holder" ).load( 'modules/directory/directory.php', function() { init_page(); });
    },
    'directory/maintenance': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/maintenance.php', function() { init_page(); });
    },
    'directory/?:name': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/profile.php?id='+name, function() { init_page(); });
    }
});

</script>