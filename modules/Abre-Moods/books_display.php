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
				echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Mood Menu</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Select an emoji that encapsulates your mood.</p></div>";
			?>

			<!--links to CSS Stylesheet for emojis && contains CSS for columns on emojis-->
			<html>
				<header>
					<style>
						.3col
						{
							-webkit-column-count: 3; /* Chrome, Safari, Opera */
    					-moz-column-count: 3; /* Firefox */
							column-count: 3;
						}
					</style>
					<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
				</header>
			</html>

			<?php
			echo '
			<div class="3col">
				<ul>
					<li><div text-align:left><i class="em em-smiley"></i></div> <div text-align:center><i class="em em-smiley"></i></div> <div text-align:right><i class="em em-smiley"></i></div></li>
					<li><i class="em em-slightly_smiling_face"></i></li>
					<li><i class="em em-cry"></i></li>
					<li><i class="em em-angry"></i></li>
					<li><i class="em em-anguished"></i></li>
					<li><i class="em em-astonished"></i></li>

				</ul>
			</div>'

					//<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Books in Library</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' in the bottom right to add a book to your library.</p></div> ";
			?>

		</div>
	</div>
