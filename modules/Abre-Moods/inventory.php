
<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		<style>
			.EmojiSpacing
			{
				font-size: 200%;
				margin:35px;
			}
			.EmojiSpacingLeft
			{
				font-size: 200%;
				margin-left:40%;
				margin-right:70px;
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
	$pagerestrictions = "";
	if ($pagerestrictions!="")
	{
		echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Record</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Here you see your mood history.</p></div>";
		//echo '26'; //testing to identify if the page is running off of new saved code
		echo '<br>';
		$email = $_SESSION['useremail'];
		//---$con=mysqli_connect("localhost","root","killerm111","abredb");
		$con = new mysqli("localhost","root","killerm111","abredb");
		if (mysqli_connect_errno()) {
		  echo 'Connection Failed';
		}

		$sqlnumrows = "SELECT COUNT(*) FROM mood_table";
		$resultnumrows = mysqli_query($con,$sqlnumrows);
		$numrows = mysqli_fetch_row($resultnumrows);
		//echo $numrows[0]; //outputs total number of rows in the data table
		//echo '<br>';

		//---$sql="SELECT Feeling, Daterow FROM mood_table WHERE Email='marksenne000@gmail.com'";
		$sqlfeeling ="SELECT Feeling FROM mood_table WHERE Email='$email'";
		$resultfeeling=mysqli_query($con, $sqlfeeling);
		if (!$resultfeeling)
		{
	  	echo 'NO FEELING RESULTS';
		}
		$rowsfeeling=array();
		while($rowfeeling = mysqli_fetch_array($resultfeeling))
		{
			$rowsfeeling[] = $rowfeeling['Feeling'];
		}
		/*foreach($rowsfeeling as $value)
		{
			 echo '<br>';
			 if($value==0)
			 {
				 	echo '<i class="em em-laughing EmojiSpacingLeft" ></i> -';
			 }
			 if($value==1)
			 {
				 	echo '<i class="em em-smiley EmojiSpacingLeft" ></i> -';
			 }
			 if($value==2)
			 {
				 	echo '<i class="em em-slightly_smiling_face EmojiSpacingLeft" ></i> -';
			 }
			 if($value==3)
			 {
				 	echo '<i class="em em-weary EmojiSpacingLeft" ></i> -';
			 }
			 if($value==4)
			 {
				 	echo '<i class="em em-cry EmojiSpacingLeft" ></i> -';
			 }
			 if($value==5)
			 {
				 	echo '<i class="em em-slightly_frowning_face EmojiSpacingLeft" ></i> -';
			 }
			 if($value==6)
			 {
				 	echo '<i class="em em-persevere EmojiSpacingLeft" ></i> -';
			 }
			 if($value==7)
			 {
				 	echo '<i class="em em-grimacing EmojiSpacingLeft" ></i> -';
			 }
			 if($value==8)
			 {
				 	echo '<i class="em em-expressionless EmojiSpacingLeft" ></i> -';
			 }
		}
		*/

		$sqldate ="SELECT Daterow FROM mood_table WHERE Email='$email'";
		$resultdate=mysqli_query($con, $sqldate);
		if (!resultdate)
		{
	  	echo 'NO MOOD RESULTS';
		}
		$arrdates=array();
		while($daterow = mysqli_fetch_array($resultdate))
		{
			$arrdates[]=$daterow['Daterow'];
		}
		/*foreach($arrdates as $value)
		{
			echo '<br>';
			echo $value;
		}*/

		$sqltime = "SELECT Timerow FROM mood_table WHERE Email='$email'";
		$resulttime=mysqli_query($con, $sqltime);
		if (!resulttime)
		{
			echo 'NO TIME RESULTS';
		}
		$arrtimes=array();
		while($timerow = mysqli_fetch_array($resulttime))
		{
			$arrtimes[]=$timerow['Timerow'];
		}
		/*foreach($arrtimes as $value)
		{
			echo '<br>';
			echo $value;
		}*/

		$arrlength = count($arrdates);
		date_default_timezone_set('America/Indiana/Indianapolis');
		$getdate = date('Y-m-d');//works
		$cdate = DateTime::createFromFormat('Y-m-d', $getdate);
		$cday = $cdate->format('d'); //works //for testing
		$cmonth = $cdate->format('m'); //works //for testing
		for($i=0;$i<$arrlength;$i++)
		{
			$dbdate = DateTime::createFromFormat('Y-m-d', $arrdates[$i]);
			$dbday = $dbdate->format('d'); //works //for testing
			$dbmonth = $dbdate->format('m'); //works //for testing
			if(($dbday >= ($cday-4)) && ($dbmonth == $cmonth)) //show feelings for the last 5 days
			{
				echo '<br>';
				if($rowsfeeling[$i]==0)
				{
					 echo '<i class="em em-laughing EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==1)
				{
					 echo '<i class="em em-smiley EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==2)
				{
					 echo '<i class="em em-slightly_smiling_face EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==3)
				{
					 echo '<i class="em em-weary EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==4)
				{
					 echo '<i class="em em-cry EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==5)
				{
					 echo '<i class="em em-slightly_frowning_face EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==6)
				{
					 echo '<i class="em em-persevere EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==7)
				{
					 echo '<i class="em em-grimacing EmojiSpacingLeft" ></i> -';
				}
				if($rowsfeeling[$i]==8)
				{
					 echo '<i class="em em-expressionless EmojiSpacingLeft" ></i> -';
				}
				//echo "<i class='EmojiSpacing'></i>" . $arrdates[$i];
				echo "<i class='EmojiSpacing'></i>" . $dbdate->format('l');
				echo '  at  ' . $arrtimes[$i];
			}
		}

		//----------UNCOMMENT FOR PRIOR VERSION
		/*
		while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
		{
			echo '<br>';
			//echo ($row[0]); //the row with the actual data //can remove (want to as it shows the numbers if ran)
			if ($row[0]['Feeling']==0)
			{
				echo '<i class="em em-laughing EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==1)
			{
				echo '<i class="em em-smiley EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==2)
			{
				echo '<i class="em em-slightly_smiling_face EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==3)
			{
				echo '<i class="em em-weary EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==4)
			{
				echo '<i class="em em-cry EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==5)
			{
				echo '<i class="em em-slightly_frowning_face EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==6)
			{
				echo '<i class="em em-persevere EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==7)
			{
				echo '<i class="em em-grimacing EmojiSpacingLeft" ></i> - ';
			}
			if ($row[0]['Feeling']==8)
			{
				echo '<i class="em em-expressionless EmojiSpacingLeft" ></i> - ';
			}
			//echo ($row[1]); //just goes to next thing, effectively a counter //or maybe dont need??
			echo "<i class='EmojiSpacing'></i>" . $row['Daterow'];
		}
		*/
		//-------------
		$con->close();
	}
	else
	{
		echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Suummary</span><br><p style='font-size:16px; margin:20px 0 0 0;'>View mood breakdown.</p></div>";
		echo '<br>';

		echo 	"<div class='row'>";

			//echo "<div class='col m6 s12'>";
				echo "<div class='mdl-card mdl-shadow--2dp' style='width:45%; color:#fff; padding-top:45px; margin-bottom:10px; background-color:#2B2D4A'>";
					echo "<span class='center-align truncate' style='font-size:70px; line-height:80px;'>Testing</span>";
				echo "</div>";
			//echo "</div>";

			//echo "<div class='col m6 s12'>";
				echo "<div class='mdl-card mdl-shadow--2dp' style='width:45%; color:#fff; padding-top:45px; margin-bottom:10px; background-color:#2B2D4A'>";
					echo "<span class='center-align truncate' style='font-size:70px; line-height:80px;'>Testing</span>";
				echo "</div>";
			//echo "</div>";

			//echo "<div class='col m6 s12'>";
				echo "<div class='mdl-card mdl-shadow--2dp' style='width:45%; color:#fff; padding-top:45px; margin-bottom:10px; background-color:#2B2D4A'>";
					echo "<span class='center-align truncate' style='font-size:70px; line-height:80px;'>Testing</span>";
				echo "</div>";
			//echo "</div>";

		echo "</div>";
	}

	//echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Mood History</span><br><p style='font-size:16px; margin:20px 0 0 0;'>View your modd history here.</p></div>";
	//this if keeps me displaying. (it doesnt pass the if test)
	//if($pagerestrictions=="")
	//{
	//	echo "<div id='displaybooks'>"; include "inventory_display.php"; echo "</div>";
	//}


	//LEFT OFF HERE -- code is in a txt doc on desktop look at it + notebook

?>
