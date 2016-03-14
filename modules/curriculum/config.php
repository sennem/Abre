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

	$pageview=1;
	$drawerhidden=0;
	$pageorder=3;
	$pagetitle="Curriculum";
	$pageicon="layers";
	$pagepath="curriculum";
	
	require_once('permissions.php');
	
?>

	<!-- Create Topic -->
	<div id="curriculumtopic" class="modal modal-fixed-footer">
		<form class="col s12" id="form-addtopic" method="post" action="modules/curriculum/addtopic_process.php">
		<div class="modal-content">
			<h4>Topic</h4>
			<div class="row">
				<div class="input-field col s12"><input id="topic_title" name="topic_title" placeholder="Title" type="text" required></div>
				<div class="input-field col s12"><input id="topic_theme" name="topic_theme" placeholder="Theme" type="text" required></div>
			</div>
			<div class="row">
			<div class="input-field col s6">
				<select name='topic_start_time'>
				    <option value='August'>August</option>       
				    <option value='September'>September</option>       
				    <option value='October'>October</option>       
				    <option value='November'>November</option>       
				    <option value='December'>December</option> 
					<option value='January'>January</option>       
				    <option value='February'>February</option>       
				    <option value='March'>March</option>       
				    <option value='April'>April</option>       
				    <option value='May'>May</option>       
				    <option value='June'>June</option>       
				    <option value='July'>July</option>
			    </select>
			    <label>Start Time</label>
			</div>
			<div class="input-field col s6">
				<select name='topic_estimated_days'>
					<option value='1'>1</option>       
				    <option value='2'>2</option>       
				    <option value='3'>3</option>       
				    <option value='4'>4</option>       
				    <option value='5'>5</option>       
				    <option value='6'>6</option>       
				    <option value='7'>7</option>       
				    <option value='8'>8</option>       
				    <option value='9'>9</option>       
				    <option value='10'>10</option>       
				    <option value='11'>11</option>       
				    <option value='12'>12</option> 
				    <option value='13'>13</option> 
				    <option value='14'>14</option> 
				    <option value='15'>15</option> 
				    <option value='16'>16</option> 
				    <option value='17'>17</option> 
				    <option value='18'>18</option> 
				    <option value='19'>19</option> 
				    <option value='20'>20</option> 
			    </select>
			    <label>Estimated Days</label>
			</div>
			</div>
    	</div>
	    <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat blue darken-3 white-text">Save</button>
		</div>
		</form>
	</div>

<script>
	
	$(document).ready(function() {
		
	    $('select').material_select();
	});
	
	//Page Locations
	routie({
	    'curriculum': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Curriculum");
		    document.title = 'HCSD Portal - Curriculum';
			$( "#content_holder" ).load( 'modules/curriculum/curriculum.php', function() { init_page(); });
			
				<?php if($pagerestrictions==""){ ?>
					//Load Navigation
					$( "#navigation_top" ).show();
					$( "#navigation_top" ).load( "modules/curriculum/menu.php", function() {	
						$( "#navigation_top" ).show();
					});
				<?php } ?>
			
	    },
	    'curriculum/courses': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Curriculum");
		    document.title = 'HCSD Portal - All Courses';
			$( "#content_holder" ).load( 'modules/curriculum/allcourses.php', function() { init_page(); });
			
				<?php if($pagerestrictions==""){ ?>
					//Load Navigation
					$( "#navigation_top" ).show();
					$( "#navigation_top" ).load( "modules/curriculum/menu.php", function() {	
						$( "#navigation_top" ).show();
					});
				<?php } ?>
			
	    },
	    'curriculum/?:name': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Curriculum");
		    document.title = 'HCSD Portal - Pacing Guide';
			$( "#content_holder" ).load( 'modules/curriculum/pacingguide.php?id='+name, function() { 
				init_page();		
				var content = $(".mdl-layout__content");
				content.stop().animate({ scrollTop: $(".active").offset().top - 150 }, 500);	
			});		
			
				<?php if($pagerestrictions==""){ ?>
					//Load Navigation
					$( "#navigation_top" ).show();
					$( "#navigation_top" ).load( "modules/curriculum/menu.php", function() {	
						$( "#navigation_top" ).show();
					});
				<?php } ?>
			
			
	    },
	    'curriculum/lesson/?:name': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Curriculum");
		    document.title = 'HCSD Portal - Lesson';
			$( "#content_holder" ).load( 'modules/curriculum/lesson.php?id='+name, function() { init_page(); });
			
				<?php if($pagerestrictions==""){ ?>
					//Load Navigation
					$( "#navigation_top" ).show();
					$( "#navigation_top" ).load( "modules/curriculum/menu.php", function() {	
						$( "#navigation_top" ).show();
					});
				<?php } ?>
			
	    }
	});

</script>