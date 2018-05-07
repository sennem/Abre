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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

	echo "<div id='classdisplay'>";
		include "class_display.php";
	echo "</div>";

?>

<script>

	$(function(){
		$(document).off().on('click', '.resetcolors', function(){
			var csv = $('#studentcsv').text();

			$.post("modules/<?php echo basename(__DIR__); ?>/reset_colors.php", {
				csv: csv, coursegroup: "<?php echo $GroupID; ?>",
				section: "<?php echo $Section; ?>"
			})
			.done(function()
			{
				$("#classdisplay").load('modules/<?php echo basename(__DIR__); ?>/class_display.php?coursegroup=<?php echo $GroupID; ?>&section=<?php echo $Section; ?>');
			});
		});
	});

</script>