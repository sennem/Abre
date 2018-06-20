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
	//require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');
	require('permissions.php');


	$con=mysqli_connect("localhost","root","killerm111","abredb");
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql="SELECT Feeling FROM mood_table WHERE ID = (SELECT MAX(ID) FROM mood_table)";
	$result=mysqli_query($con,$sql);
	$rows = mysqli_fetch_row($result);
	$con->close();
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
						function alterdisp(emojivalue2)
						{
							if (emojivalue2==0)
							{
								document.getElementById("emojizero").style.backgroundColor = "red";
							}
							if (emojivalue2==1)
							{
								document.getElementById("emojione").style.backgroundColor = "red";
							}
							if (emojivalue2==2)
							{
								document.getElementById("emojitwo").style.backgroundColor = "red";
							}
							if (emojivalue2==3)
							{
								document.getElementById("emojithree").style.backgroundColor = "red";
							}
							if (emojivalue2==4)
							{
								document.getElementById("emojifour").style.backgroundColor = "red";
							}
							if (emojivalue2==5)
							{
								document.getElementById("emojifive").style.backgroundColor = "red";
							}
							if (emojivalue2==6)
							{
								document.getElementById("emojisix").style.backgroundColor = "red";
							}
							if (emojivalue2==7)
							{
								document.getElementById("emojiseven").style.backgroundColor = "red";
							}
							if (emojivalue2==8)
							{
								document.getElementById("emojieight").style.backgroundColor = "red";
							}
						}
						function alterdispreload()
						{
							var spge = '<?php echo $rows[0] ;?>';
							if (spge==2)
							{
								alert ('yup');
							}
						}
					</script>
					<style>
						.EmojiSpacing
						{
							margin:35px;
						}
						.EmojiSpacingLeft
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

		<script type="text/javascript">
    	alterdispreload();
		</script>

			<?php
			echo '
			<div>
				<ul>
					<li>
						<i id="emojizero" class="em em-laughing EmojiSpacingLeft" onclick="testfunc(0); alterdisp(0);"></i>
						<i id="emojione" class="em em-smiley EmojiSpacing" onclick="testfunc(1); alterdisp(1);"></i>
						<i id="emojitwo" class="em em-slightly_smiling_face EmojiSpacing" onclick="testfunc(2); alterdisp(2);"></i>
					</li>
					<li>
						<i id="emojithree" class="em em-weary EmojiSpacingLeft" onclick="testfunc(3); alterdisp(3);"></i>
						<i id="emojifour" class="em em-cry EmojiSpacing" onclick="testfunc(4); alterdisp(4);"></i>
						<i id="emojifive" class="em em-slightly_frowning_face EmojiSpacing" onclick="testfunc(5); alterdisp(5);"></i>
					</li>
					<li>
						<i id="emojisix" class="em em-persevere EmojiSpacingLeft" onclick="testfunc(6); alterdisp(6);"></i>
						<i id="emojiseven" class="em em-grimacing EmojiSpacing" onclick="testfunc(7); alterdisp(7);"></i>
						<i id="emojieight" class="em em-expressionless EmojiSpacing" onclick="testfunc(8); alterdisp(8);"></i>
					</li>
				</ul>
			</div>'

			?>

		</div>
	</div>
