<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		<style>
			.EmojiSpacingLeft
			{
				margin-left: 15%;
        margin-right: 5%;
        margin-bottom: 5%;
			}
      .EmojiSpacing
			{
				margin: 5%;
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
	require_once('get_mood_data.php'); //get array data


    //--------------
    echo "<hr class='widget_hr'>";
    echo "<div class='widget_holder'>";
      echo "<div class='widget_container widget_body' style='color:#666;'>Go Back<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>arrow_back</i></div>";
    echo "</div>";
    //--------------

		$email = $_SESSION['useremail'];
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
    $outputcounter=0;
		for($i=0;$i<$arrlength;$i++)
		{
      if ($outputcounter>=5)
      {
        break; //done for widget as to only show the past 5 entries
      }
			$dbdate = DateTime::createFromFormat('Y-m-d', $arrdates[$i]);
			$dbday = $dbdate->format('d'); //works //for testing
			$dbmonth = $dbdate->format('m'); //works //for testing
			if(($dbday >= ($cday-4)) && ($dbmonth == $cmonth)) //show feelings for the last 5 days
			{
        $outputcounter=$outputcounter+1;
				echo '<br>';
				if($rowsfeeling[$i]==0)
				{
					 echo '<i class="em em-laughing EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==1)
				{
					 echo '<i class="em em-smiley EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==2)
				{
					 echo '<i class="em em-slightly_smiling_face EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==3)
				{
					 echo '<i class="em em-weary EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==4)
				{
					 echo '<i class="em em-cry EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==5)
				{
					 echo '<i class="em em-slightly_frowning_face EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==6)
				{
					 echo '<i class="em em-persevere EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==7)
				{
					 echo '<i class="em em-grimacing EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$i]==8)
				{
					 echo '<i class="em em-expressionless EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				echo "<i class='EmojiSpacing'></i>" . "<sup style='font-size: 100%'>" . $dbdate->format('l') . "</sup>";
				echo '  <sup style="font-size: 100%">at</sup>  ' . '<sup style="font-size: 100%">' . $arrtimes[$i] . '</sup>';
			}
		}

		$con->close();
		echo '<br>';
    echo '<br>';
