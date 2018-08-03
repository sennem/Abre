

<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		<style>
			.EmojiSpacingLeft
			{
				margin-left: 15%;
        margin-right: 5%;
        margin-bottom: 5%;
				margin-top: 5%;
			}
      .EmojiSpacing
			{
				margin: 5%;
			}
			.TSpacing{
				padding: 5%;
			}
			.TSpacingLeft{
				padding-left: 15%;
				padding-right: 5%;
				padding-bottom: 5%;
				padding-top: 5%;
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
	//reaches
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
    //--------------
    echo "<hr class='widget_hr'>";
    echo "<div class='widget_holder'>";
      echo "<div class='widget_container widget_body' style='color:#666;'>Go Back<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>arrow_back</i></div>";
		echo "</div>";
    //--------------

$pagerestictions="staff";
//if($_SESSION['usertype'] == "student")
if ($pagerestictions=="student")
{
	$email = $_SESSION['useremail'];
	$studentid=1; //HARDCODED STUDENT ID
	$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
	if (mysqli_connect_errno()) {
		echo 'Connection Failed';
	}
	$sqlnumrows = "SELECT COUNT(*) FROM mood_table";
	$resultnumrows = mysqli_query($con,$sqlnumrows);
	$numrows = mysqli_fetch_row($resultnumrows);

	$sqlfeeling ="SELECT Feeling FROM mood_table WHERE StudentID='$studentid'";
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

	$sqldate ="SELECT Daterow FROM mood_table WHERE StudentID='$studentid'";
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

	$sqltime = "SELECT Timerow FROM mood_table WHERE StudentID='$studentid'";
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


	//-------------

	$arrlength = count($arrdates);
	$maxlength=$arrlength-1; //holds the last position able to be printed as arrays start at zero (so one less than what the count is is the pos of the last value)
	date_default_timezone_set('America/Indiana/Indianapolis');
	$getdate = date('Y-m-d');
	//get the current year, month, and day to compare to database dates
	$cdate = DateTime::createFromFormat('Y-m-d', $getdate);
	$cday = $cdate->format('d');
	$cmonth = $cdate->format('m');
	$cyear = $cdate->format('Y');
	$outputcounter=0;
	$falsecounter=0;
	//-------------
	while ($outputcounter<5 && $falsecounter<5)
	{
		//output 5 most recenet moods over the last 5 days
		$dbdate = DateTime::createFromFormat('Y-m-d', $arrdates[$maxlength]);
		$dbday = $dbdate->format('d');
		$dbmonth = $dbdate->format('m');
		$dbyear = $dbdate->format('Y');
		//output 5 most recent moods within the last 5 days (and in the same month and year)
		if (($dbday >= ($cday-4)) && ($dbmonth==$cmonth) && ($dbyear==$cyear))
		{
			echo "<div>";
			if($rowsfeeling[$maxlength]==0){
				 echo '<i class="em em-laughing EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==1){
				echo '<i class="em em-smiley EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==2){
				 echo '<i class="em em-slightly_smiling_face EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==3){
				 echo '<i class="em em-weary EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==4){
				 echo '<i class="em em-cry EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==5){
				echo '<i class="em em-slightly_frowning_face EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==6){
				echo '<i class="em em-persevere EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==7){
				 echo '<i class="em em-grimacing EmojiSpacingLeft" ></i> -';
			}
			if($rowsfeeling[$maxlength]==8){
				 echo '<i class="em em-expressionless EmojiSpacingLeft" ></i> -';
			}
			echo "<i class='EmojiSpacing'></i>" .  $dbdate->format('l');
			echo '  at  ' . $arrtimes[$maxlength];
			$maxlength--;

		}
		$outputcounter++;

	}
}
else
{
	//set period selection to = "*select a period*"
	echo '<script type="text/javascript">',
	'document.getElementById("Period").value=0;',
	'</script>'
	;


  echo'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <select class="mdl-textfield__input" id="Period" name="Period" >
      <option value="0">*select a period*</option>
      <option value="1">Period 1</option>
      <option value="2">Period 2</option>
      <option value="3">Period 3</option>
      <option value="4">Period 4</option>
      <option value="5">Period 5</option>
      <option value="6">Period 6</option>
      <option value="7">Period 7</option>
    </select>
  </div>';

	echo'<div id="overviewdiv"></div>';
	?>
	<script type="text/javascript">
	$(document).ready(function(){
			$("#Period").change(function(){
				var periodnumj=document.getElementById("Period").value;
				var location=2;
				var id=109; //HARDCODED STAFF ID
				$.post( "/modules/Abre-Moods/mood_data_retrieval_and_output.php", {locationid: location, periodsel: periodnumj, staffid: id})
					.done(function( data ) {
						$("#overviewdiv").html(data);
			});
		});
	});

	</script>
	<?php

}

?>
