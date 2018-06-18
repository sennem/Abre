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
						#EmojiSpacing
						{
							margin:35px;
						}
					</style>
					<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
				</header>
			</html>

			<!-- make function for onclick -->
			<script>
				function testfunc()
				{
					alert("You selected an emoji");
				}
			</script>

			<?php
			echo '
			<div>
				<ul>

					<li>
						<i id="EmojiSpacing" class="em em-laughing" onclick="testfunc()"></i>
						<i id="EmojiSpacing" class="em em-smiley" onclick="testfunc()"></i>
						<i id="EmojiSpacing" class="em em-slightly_smiling_face" onclick="testfunc()"></i>
					</li>
					<li>
						<i id="EmojiSpacing" class="em em-weary" onclick="testfunc()"></i>
						<i id="EmojiSpacing" class="em em-cry" onclick="testfunc()"></i>
						<i id="EmojiSpacing" class="em em-slightly_frowning_face" onclick="testfunc()"></i>
					</li>
					<li>
						<i id="EmojiSpacing" class="em em-expressionless" onclick="testfunc()"></i>
						<i id="EmojiSpacing" class="em em-grimacing" onclick="testfunc()"></i>
						<i id="EmojiSpacing" class="em em-perservere" onclick="testfunc()"></i>
					</li>

				</ul>
			</div>'

					//<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Books in Library</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' in the bottom right to add a book to your library.</p></div> ";
			?>

		</div>
	</div>
