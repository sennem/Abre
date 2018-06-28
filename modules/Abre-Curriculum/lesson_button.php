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

	if($pagerestrictionsedit == ""){

		echo "<div class='fixed-action-btn buttonpin'>";
			echo "<a class='modal-addcourse btn-floating btn-large waves-effect waves-light' style='background-color:".getSiteColor().";' id='printlesson' data-position='left' target='_blank'><i class='large material-icons'>print</i></a>";
			echo "<div class='mdl-tooltip mdl-tooltip--left' for='printlesson'>Print</div>";
		echo "</div>";

	}

?>

<script>


	$(function(){

		$("#printlesson").unbind().click(function(event) {
			event.preventDefault();
			window.print();
		});
		
	});


</script>