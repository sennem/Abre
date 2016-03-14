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
	require(dirname(__FILE__) . '/../../configuration.php'); 
	$pageview=1;
	$drawerhidden=1;
	$pagetitle="Apps";
	$pagepath="apps";
	
?>

<script>

	//Page locations
	routie({
	    'apps': function() {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $( "#loader" ).show();
		    <?php
			    if($_SESSION['usertype']=="staff")
			    {
				    ?> $( "#titletext" ).text("Staff Apps"); <?php
			    }
			    if($_SESSION['usertype']=="student")
			    {
				    ?> $( "#titletext" ).text("Student Apps"); <?php
			    }
			?>
		    document.title = 'HCSD Portal - Apps';
			$( "#content_holder" ).load( 'modules/apps/apps.php', function() { init_page(); });
	    },
	    'apps/student': function() {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Student Apps");
		    document.title = 'HCSD Portal - Apps';
			$( "#content_holder" ).load( 'modules/apps/apps.php?mode=student', function() { init_page(); });
	    }
	});

</script>