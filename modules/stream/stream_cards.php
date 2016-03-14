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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
		
	include "feeds.php";
		
?>

<script>
	
	$(document).ready(function(){	
		
		<?php
			if(studentaccess()==true){
		?>
			function loadMail() {
				$('#mail').load("modules/mail/card.php", function () {	
					$('.grid').masonry( 'reloadItems' );
					$('.grid').masonry( 'layout' );
					mdlregister();
				});
			}
			loadMail();
		<?php
			}
		?>
		
		function loadDrive() {
			$('#drive').load("modules/drive/card.php", function () {	
				$('.grid').masonry( 'reloadItems' );
				$('.grid').masonry( 'layout' );
				mdlregister();
			});
		}
		loadDrive();
		
		function loadCalendar() {
			$('#calendar').load("modules/calendar/card.php", function () {	
				$('.grid').masonry( 'reloadItems' );
				$('.grid').masonry( 'layout' );
				mdlregister();
			});
		}
		loadCalendar();
		
		function loadClassroom() {
			$('#classroom').load("modules/classroom/card.php", function () {	
				$('.grid').masonry( 'reloadItems' );
				$('.grid').masonry( 'layout' );
				mdlregister();
			});
		}
		loadClassroom();
		
		$('body').on('click', 'a.emailclick', function() {
			loadMail();
		});

		
	});
	
</script>