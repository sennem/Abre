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
	$pageorder=1;
	$pagetitle="Stream";
	$pageicon="dashboard";
	$pagepath="";
	$pagerestrictions="";
	
?>

<script>

//Page Locations
routie({
    '': function() {
	    //Load Streams
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Stream");
	    document.title = 'HCSD Portal - Stream';
		$( "#content_holder" ).load( "modules/stream/stream.php", function() {		
			init_page(loader);	
		});		
		
		//Load Stream Apps
		$( "#navigation_top" ).show();
		$( "#navigation_top" ).load( "modules/apps/card.php", function() {	
			$( "#navigation_top" ).show();
		});
    }
});

</script>