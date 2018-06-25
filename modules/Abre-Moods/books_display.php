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
						function alterdisp()
						{
							//alert('running'); for testing
							var emojivalue3 = '<?php echo $rows[0] ;?>';
							//alert(emojivalue3); for testing
							if (emojivalue3==0)
							{
								document.getElementById("emojizero").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==1)
							{
								document.getElementById("emojione").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==2)
							{
								document.getElementById("emojitwo").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==3)
							{
								document.getElementById("emojithree").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==4)
							{
								document.getElementById("emojifour").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==5)
							{
								document.getElementById("emojifive").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==6)
							{
								document.getElementById("emojisix").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==7)
							{
								document.getElementById("emojiseven").style.backgroundColor = "DeepSkyBlue";
							}
							if (emojivalue3==8)
							{
								document.getElementById("emojieight").style.backgroundColor = "DeepSkyBlue";
							}
						}
						function resetdisp()
						{
							alert("PLEASE WORK!");
							document.getElementById("emojizero").style.backgroundColor = "";
							document.getElementById("emojione").style.backgroundColor = "";
							document.getElementById("emojitwo").style.backgroundColor = "";
							document.getElementById("emojithree").style.backgroundColor = "";
							document.getElementById("emojifour").style.backgroundColor = "";
							document.getElementById("emojifive").style.backgroundColor = "";
							document.getElementById("emojisix").style.backgroundColor = "";
							document.getElementById("emojiseven").style.backgroundColor = "";
							document.getElementById("emojieight").style.backgroundColor = "";
						}
					</script>
					<style>
						.EmojiSpacing
						{
							font-size: 150%;
							margin:35px;
						}
						.EmojiSpacingLeft
						{
							font-size: 150%;
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
    	alterdisp(); //calls the func that "highlights" an emoji
		</script>

			<?php

			echo '
			<div>
				<ul>
					<li>
						<i id="emojizero" class="em em-laughing EmojiSpacingLeft" onclick="testfunc(0)"></i>
						<i id="emojione" class="em em-smiley EmojiSpacing" onclick="testfunc(1)"></i>
						<i id="emojitwo" class="em em-slightly_smiling_face EmojiSpacing" onclick="testfunc(2)"></i>
					</li>
					<li>
						<i id="emojithree" class="em em-weary EmojiSpacingLeft" onclick="testfunc(3)"></i>
						<i id="emojifour" class="em em-cry EmojiSpacing" onclick="testfunc(4)"></i>
						<i id="emojifive" class="em em-slightly_frowning_face EmojiSpacing" onclick="testfunc(5)"></i>
					</li>
					<li>
						<i id="emojisix" class="em em-persevere EmojiSpacingLeft" onclick="testfunc(6)"></i>
						<i id="emojiseven" class="em em-grimacing EmojiSpacing" onclick="testfunc(7)"></i>
						<i id="emojieight" class="em em-expressionless EmojiSpacing" onclick="testfunc(8)"></i>
					</li>
				</ul>
			</div>'

			?>

			<?php
				$con=mysqli_connect("localhost","root","killerm111","abredb");
				$sql="SELECT Daterow FROM mood_table WHERE ID = (SELECT MAX(ID) FROM mood_table)";
				$result=mysqli_query($con,$sql);
				$arrrowresults=array();
				while($rowrow = mysqli_fetch_array($result))
				{
					$arrrowresults[]=$rowrow['Daterow'];
				}
				foreach($arrrowresults as $value)
				{
					$maxdate = $value;
				}
				//echo 'Vvalue=' . $maxdate; //for testing
				//echo '<br>'; //for testing
				$dbdate = DateTime::createFromFormat('Y-m-d', $maxdate);
				//echo $dbdate->format('d'); //works //for testing
				//echo $dbdate->format('m'); //works //for testing
				date_default_timezone_set('America/Indiana/Indianapolis');
				$getdate = date('Y-m-d');//works //for testing
				$cdate = DateTime::createFromFormat('Y-m-d', $getdate);
				//echo $cdate->format('d'); //works //for testing
				//echo $cdate->format('m'); //works //for testing

				if (($dbdate->format('d')) != ($cdate->format('d')))
				{
					//not the same day
					echo '<script type="text/javascript">',
     			'resetdisp();',
     			'</script>'
		 			;
				}
				elseif ((($dbdate->format('d')) == ($cdate->format('d'))) && (($dbdate->format('m')) != ($cdate->format('m'))))
				{
					//same day but different month
					echo '<script type="text/javascript">',
     			'resetdisp();',
     			'</script>'
		 			;
				}
			?>






		</div>
	</div>
