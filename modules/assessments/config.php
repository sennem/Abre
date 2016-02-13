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
	
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 

	$pageview=1;
	$drawerhidden=0;
	$pageorder=4;
	$pagetitle="Assessments";
	$pageicon="assessment";
	$pagepath="assessments";
	$pagerestrictions="staff, students";
	
	
	include "core/abre_dbconnect.php";
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and (superadmin='1' or superadmin='2')";
	$result = $db->query($sql);
	$superadmin=0;
	while($row = $result->fetch_assoc())
	{
		$pagerestrictions="";
	}
	
?>

<script>

//Page Locations
routie({
    'assessments': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Assessments");
	    document.title = 'HCSD Portal - Assessments';
		$( "#content_holder" ).load( 'modules/assessments/assessments.php', function() { init_page(); });
    },
    'assessments/?:name': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Curriculum");
	    document.title = 'HCSD Portal - Pacing Guide';
		$( "#content_holder" ).load( 'modules/curriculum/pacingguide.php?id='+name, function() { 
			
			init_page();
			//Go to Unit Based on Active Month
			var content = $(".mdl-layout__content");
			content.stop().animate({ scrollTop: $(".active").offset().top - 150 }, 500);
		
		});
    }
});

</script>