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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if($pagerestrictionsedit=="")
	{
?>

		<div class='fixed-action-btn buttonpin'>
			<a class='modal-addcourse btn-floating btn-large waves-effect waves-light' style='background-color: <?php echo getSiteColor(); ?>' id="createcourse" data-grade='blank' data-subject='blank' data-position='left' data-title='' data-learncourse='0' data-restrictions='' data-description='' data-tags='' data-sequential='0' data-image='' data-imagelink='' href='#curriculumcourse'><i class='large material-icons'>add</i></a>
			<div class="mdl-tooltip mdl-tooltip--left" for="createcourse">Create Course</div>
		</div>

<?php
	}
?>

<script>

	$(function()
	{

    	$('.modal-addcourse').leanModal({
	    	in_duration: 0,
				out_duration: 0,
	    	ready: function() { $("#course_title").focus(); }
    	});

  	});

</script>