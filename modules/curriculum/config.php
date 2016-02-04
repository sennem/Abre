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
	
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php'); 

	$pageview=1;
	$drawerhidden=0;
	$pageorder=3;
	$pagetitle="Curriculum";
	$pageicon="view_agenda";
	$pagepath="curriculum";
	$pagerestrictions="staff, students";
	
	
	include "core/portal_dbconnect.php";
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and (superadmin='1' or superadmin='2')";
	$result = $db->query($sql);
	$superadmin=0;
	while($row = $result->fetch_assoc())
	{
		$pagerestrictions="";
	}
	
?>

	<!-- Book Code Modal -->
	<div id="addcourse" class="modal">
		<form class="col s12" id="form-addcourse" method="post" action="modules/curriculum/addcourse_process.php">
		<div class="modal-content">
			<h4>Search Courses</h4>
			<?php
			//Search
			echo "<form id='course-search' method='post' action='modules/directory/searchresults.php'>";

					echo "<div class='input-field col s12'>";
						echo "<input placeholder='Search' id='coursesearch' name='coursesearch' type='text'>";
					echo "</div>";
 
			echo "</form>";	
			?>
    	</div>
	    <div class="modal-footer">

		</div>
		</form>
	</div>

<script>

//Page Locations
routie({
    'curriculum': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Curriculum");
	    document.title = 'HCSD Portal - Curriculum';
		$( "#content_holder" ).load( 'modules/curriculum/curriculum.php', function() { init_page(); });
    },
    'curriculum/?:name': function(name) {
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
    },
    'curriculum/lesson/?:name': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("Curriculum");
	    document.title = 'HCSD Portal - Lesson';
		$( "#content_holder" ).load( 'modules/curriculum/lesson.php?id='+name, function() { init_page(); });
    }
});

</script>