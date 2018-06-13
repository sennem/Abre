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

	if($pagerestrictions=="")
	{
		echo "<div id='displayguide'>"; include "pacingguide_display.php"; echo "</div>";
	}
?>


	<script>

		$(function()
		{

			//Open Topic Text (Used for Creating and Editing)
			$(document).on("click", ".modal-texttopic", function ()
			{
				event.preventDefault();

					var Resource_ID= $(this).data('resourceid');
				    $(".modal-content #resourceID").val(Resource_ID);
					var Text_Type= $(this).data('texttype');
				    $(".modal-content #topic_text_category").val(Text_Type);
				    var Text_Title= $(this).data('texttitle');
				    $(".modal-content #topic_text_title").val(Text_Title);
				    var Text_Text= $(this).data('texttext');
				    $(".modal-content #topic_text_content").val(Text_Text);

				$('#texttotopic').openModal({ in_duration: 0, out_duration: 0, ready: function() { } });
			});

			//Open Model Lesson (Used for Creating and Editing)
			$(document).on("click", ".modal-lessontopic", function ()
			{
				event.preventDefault();
				$('#lessontotopic').openModal({ in_duration: 0, out_duration: 0, ready: function()
				{
					$('#lessonmodalcontentholder').scrollTop(0);
				},
				complete: function() {  },
				});
			});

		});

	</script>
