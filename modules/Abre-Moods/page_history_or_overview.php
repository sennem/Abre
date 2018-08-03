
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
	.grid {
		display: flex;                       /* establish flex container */
		flex-wrap: wrap;                     /* enable flex items to wrap */
		justify-content: space-around;

	}
	.cell {
		flex: 0 0 32%;                       /* don't grow, don't shrink, width */
		height: 100px;
		width: 100px;
		margin-bottom: 15px;
		background-color: #3e4066;
		border-radius: 25px;
	}
	/*.cell:nth-child(3n) {
		background-color: red;
	}*/
	.centercell{
		text-align: center;
	}
	.emojistyle{
		margin-top: 30px;
		font-size: 200%;
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
require_once('permissions.php');
$pagerestrictions = "staff"; //for testing
//if($_SESSION['usertype'] == "student") <-- need in "launch" version
if ($pagerestrictions=="student") //run code meant for students
{
	echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Record</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Here you see your mood history.</p></div>";
	echo '<br>';

	$email = $_SESSION['useremail'];
	$studentid=1; //HARDCODED STUDENT ID
	$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
	if (mysqli_connect_errno()) {
		echo 'Connection Failed';
	}
	$sqlnumrows = "SELECT COUNT(*) FROM mood_table";
	$resultnumrows = mysqli_query($con,$sqlnumrows);
	$numrows = mysqli_fetch_row($resultnumrows);

	//------------Get the all mood selections for a certain student------------
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
	//get the dates of mood selections
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


//get the time of mood selections
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
	//gets the current date to compare againt dates in database
	$cdate = DateTime::createFromFormat('Y-m-d', $getdate);
	$cday = $cdate->format('d');
	$cmonth = $cdate->format('m');
	$cyear = $cdate->format('Y');
	$outputcounter=0;
	//-------------
	//output the 5 most recent moods within the last 5 days
	while ($outputcounter<5)
	{
		//database dates
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
			echo "<i class='EmojiSpacing'></i>" . $dbdate->format('l');
			echo '  at  ' . $arrtimes[$maxlength];
			echo ' <br />';
			echo ' <br />';
			$maxlength--;

		}
		$outputcounter++;

	}

	echo '<br>';
	echo '<div style="padding-top:30px; text-align:center; width:100%;"><footer style="background-color: #2B2D4A"><p style="font-size: 8px">Abre</p></footer></div>';
}
else
{
	?>

	<html>
		<head>
			<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		</head>


		<select id='ClassPeriodSelectionInv2' >
				<option value='0'>*select an option*</option>
				<option value='1'>Period 1</option>
				<option value='2'>Period 2</option>
				<option value='3'>Period 3</option>
				<option value='4'>Period 4</option>
				<option value='5'>Period 5</option>
				<option value='6'>Period 6</option>
				<option value='7'>Period 7</option>
		</select>
	</html>
	<script>
		document.getElementById('ClassPeriodSelectionInv2').value=0;
	</script>
	<html>
		<br />
		<div id="PageEmojiTotals"></div>
	</html>

<script type="text/javascript">
$(document).ready(function(){
		$("#ClassPeriodSelectionInv2").change(function(){
			var periodnumj=document.getElementById("ClassPeriodSelectionInv2").value;
			var location=4;
			var id=109; //HARDCODED STAFF ID
			$.post( "/modules/Abre-Moods/mood_data_retrieval_and_output.php", {locationid: location, periodsel: periodnumj, staffid: id})
				.done(function( data ) {
					$("#PageEmojiTotals").html(data);
		});
	});
});

</script>
<?php
	}
?>
