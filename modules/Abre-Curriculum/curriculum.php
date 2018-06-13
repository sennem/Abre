<?php

	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once('permissions.php');

	if(CONSTANT('SITE_MODE') == "DEMO"){
		echo "<div style='padding:30px; text-align:center; width:100%;'>";
			echo "<div class='row'>";
				echo "<span style='font-size: 22px; font-weight:700'>Learn more about the Curriculum App!</span>";
			echo "</div>";
			echo "<div class='row center-align'>";
				echo "<iframe id='curriculumDemoVideo' src='https://player.vimeo.com/video/257970224' width='640' height='400' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<p style='font-size:16px; margin:20px 0 0 0;'>For more information about the Abre Platform visit <a href='https://www.abre.io/' style='color:".getSiteColor().";' target='_blank'>our website</p>";
			echo "</div>";
		echo "</div>";
	}else{
		if($pagerestrictions=="")
		{
			echo "<div id='displaylibrary'>"; include "curriculum_display.php"; echo "</div>";
		}
	}
?>

	<script>

		$(function() {

			//Remove Course from Library
			$('#displaylibrary').on('click','.removecourse',function()
			{
				event.preventDefault();
				var address = $(this).find("a").attr("href");
				$.ajax({
					type: 'POST',
					url: address,
					data: '',
				})

				//Show the notification
				.done(function(response)
				{
					$( "#displaylibrary" ).load( "modules/<?php echo basename(__DIR__); ?>/curriculum_display.php", function()
					{

						//Register MDL Components
						mdlregister();

						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response };
						notification.MaterialSnackbar.showSnackbar(data);
					});
				})
			});

		});

	</script>
