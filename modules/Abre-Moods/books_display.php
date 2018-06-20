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
					<script>
						function testfunc(emojivalue)
						{
							alert("Respone submitted");
							window.location.assign("http://localhost:8080/modules/Abre-Moods/db_submission.php?moodval=" + emojivalue);
						}
					</script>
					<style>
						#EmojiSpacing
						{
							margin:35px;
						}
						#EmojiSpacingLeft
						{
							margin-left:40%;
							margin-right:35px;
						}
						ul
						{
							justify-content: center;
						}
						ul li
						{
							padding: 0 8px;
						}
					</style>
					<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
				</header>
			</html>


			<?php



			echo '
			<div>
				<ul>
					<li>
						<i id="EmojiSpacingLeft" class="em em-laughing" onclick="testfunc(0); alterdisp(0);"></i>
						<i id="EmojiSpacing" class="em em-smiley" onclick="testfunc(1); alterdisp(1);"></i>
						<i id="EmojiSpacing" class="em em-slightly_smiling_face" onclick="testfunc(2); alterdisp(2);"></i>
					</li>
					<li>
						<i id="EmojiSpacingLeft" class="em em-weary" onclick="testfunc(3); alterdisp(3);"></i>
						<i id="EmojiSpacing" class="em em-cry" onclick="testfunc(4); alterdisp(4);"></i>
						<i id="EmojiSpacing" class="em em-slightly_frowning_face" onclick="testfunc(5); alterdisp(5);"></i>
					</li>
					<li>
						<i id="EmojiSpacingLeft" class="em em-grimacing" onclick="testfunc(6); alterdisp(6);"></i>
						<i id="EmojiSpacing" class="em em-expressionless" onclick="testfunc(7); alterdisp(7);"></i>
						<i id="EmojiSpacing" class="em em-persevere" onclick="testfunc(8); alterdisp(8);"></i>
					</li>
				</ul>
			</div>'

			//$urldbvar=$_GET['dbchange'];
			//if ($urldbvar==1)
			//{
			//	echo "<div style='padding:30px; text-align:center; width:100%;'><br><p style='font-size:16px; margin:20px 0 0 0;'>Respone submitted.</p></div>";
			//}

			?>

		</div>
	</div>
