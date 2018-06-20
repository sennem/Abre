
<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
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


	echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>1Record1</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Here you see your mood history.</p></div>";
	echo '2';
	$con=mysqli_connect("localhost","root","killerm111","abredb");
	// Check connection
	if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

	$sql = "SELECT COUNT(*) FROM mood_table";
	$result = mysqli_query($con,$sql);
	$numrows = mysqli_fetch_row($result);
	echo $numrows[0];

	$sql="SELECT Feeling, Daterow FROM mood_table WHERE Email='marksenne000@gmail.com'";
	$result=mysqli_query($con, $sql);
	//$sqldates="SELECT Daterow FROM mood_table WHERE Email='marksenne000@gmail.com'";
	//$resultdates=mysqli_query($con,$sqldates);
	//$rowss = array();
	//while($rowss[]=mysqli_fetch_array($resultdates));
	//echo $rowss[0]['Daterow'];
	//echo $rowss[1]['Daterow'];


	//$row=mysqli_fetch_array($result);
	echo '<br>';
	//echo $row;
	while($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{
		echo '<br>';
		//echo ($row[0]); //the row with the actual data //can remove (want to as it shows the numbers if ran)
		if ($row['Feeling']==0)
		{
			echo '<i class="em em-laughing EmojiSpacingLeft" ></i> - ';
		}
		if ($row[Feeling]==1)
		{
			echo '<i class="em em-smiley EmojiSpacingLeft" ></i> - ';
		}
		if ($row[Feeling]==2)
		{
			echo '<i class="em em-slightly_smiling_face EmojiSpacingLeft" ></i> - ';
		}
		if ($row[Feeling]==3)
		{
			echo '<i class="em em-weary EmojiSpacingLeft" ></i> - ';
		}
		if ($row[Feeling]==4)
		{
			echo '<i class="em em-cry EmojiSpacingLeft" ></i> - ';
		}
		if ($row[Feeling]==5)
		{
			echo '<i class="em em-slightly_frowning_face EmojiSpacingLeft" ></i> - ';
		}
		if ($row[Feeling]==6)
		{
			echo '<i class="em em-persevere EmojiSpacingLeft" ></i> - ';
		}
		if ($row[Feeling]==7)
		{
			echo '<i class="em em-grimacing EmojiSpacingLeft" ></i> - ';
		}
		if ($row[0]==8)
		{
			echo '<i class="em em-expressionless EmojiSpacingLeft" ></i> - ';
		}
		//echo ($row[1]); //just goes to next thing, effectively a counter //or maybe dont need??
		echo $row[0]['Daterow'];
	}
	$con->close();


	//echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Mood History</span><br><p style='font-size:16px; margin:20px 0 0 0;'>View your modd history here.</p></div>";
	//this if keeps me displaying. (it doesnt pass the if test)
	//if($pagerestrictions=="")
	//{
	//	echo "<div id='displaybooks'>"; include "inventory_display.php"; echo "</div>";
	//}

?>
