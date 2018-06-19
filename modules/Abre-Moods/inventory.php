
<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	</header>
</html>


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
	require(dirname(__FILE__) . '/../../configuration.php');
	//require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

	$con=mysqli_connect("localhost","root","killerm111","abredb");
	// Check connection
	if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

	$sql = "SELECT COUNT(*) FROM mood_table";
	$result = mysqli_query($con,$sql);
	$rows = mysqli_fetch_row($result);
	echo $rows[0];

	$sql="SELECT Feeling AS num FROM mood_table WHERE Email='marksenne000@gmail.com'";
	$result=mysqli_query($con, $sql);
	$row=mysqli_fetch_array($result);
	echo '<br>'
	while($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{
		  echo ($row[0]);
			echo ($row[1]);
	}
	echo '<br>'
	while($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{
	    //echo ($row[0]);
	    //echo ($row[1]);
			if ((($row[0])==0) || (($row[1])==0))
			{
				echo '<i id="EmojiSpacingLeft" class="em em-laughing"></i>';
			}
			else if ((($row[0])==1) || (($row[1])==1)){
				echo '<i id="EmojiSpacingLeft" class="em em-smiley"></i>';
			}
			else if ((($row[0])==2) || (($row[1])==2)){
				echo '<i id="EmojiSpacingLeft" class="em em-slightly_smiling_face"></i>';
			}
			else if ((($row[0])==3) || (($row[1])==3)){
				echo '<i id="EmojiSpacingLeft" class="em em-weary"></i>';
			}
			else if ((($row[0])==4) || (($row[1])==4)){
				echo '<i id="EmojiSpacingLeft" class="em em-cry"></i>';
			}
			else if ((($row[0])==5) || (($row[1])==5)){
				echo '<i id="EmojiSpacingLeft" class="em em-slightly_frowning_face"></i>';
			}
			else if ((($row[0])==6) || (($row[1])==6)){
				echo '<i id="EmojiSpacingLeft" class="em em-expressionless"></i>';
			}
			else if ((($row[0])==7) || (($row[1])==7)){
				echo '<i id="EmojiSpacingLeft" class="em em-grimacing"></i>';
			}
			else if ((($row[0])==8) || (($row[1])==8)){
				echo '<i id="EmojiSpacingLeft" class="em em-persevere"></i>';
			}
			else {
				echo 'nothing';
			}
	}
	$con->close();


	//echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Mood History</span><br><p style='font-size:16px; margin:20px 0 0 0;'>View your modd history here.</p></div>";
	//this if keeps me displaying. (it doesnt pass the if test)
	//if($pagerestrictions=="")
	//{
	//	echo "<div id='displaybooks'>"; include "inventory_display.php"; echo "</div>";
	//}

?>
