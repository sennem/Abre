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

		//--findme-- it got rid of thing


    //Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');
	require('permissions.php');

	?>
	<div class='page_container'>
	<div class='row'>
	<?php

	//if($_SESSION['usertype']!="staff")
	//{
		//$userid=finduseridcore($_SESSION['useremail']);
		//$sql = "SELECT Book_ID, ID FROM books_libraries WHERE User_ID='$userid' ORDER BY ID DESC";
	//}
	echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Books in Library</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Select an emoticon to encapsulate feelings.</p></div>";

	<br>
	<br>
	<br>
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	<ul>
		<li><i class="em em-smiley"></i></li>
		<li><i class="em em-slightly_smiling_face"></i></li>
		<li><i class="em em-cry"></i></li>
		<li><i class="em em-angry"></i></li>
		<li><i class="em em-pensive"></i></li>
	</ul>

	?>

</div>
</div>
