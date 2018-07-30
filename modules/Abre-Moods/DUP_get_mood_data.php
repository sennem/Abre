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
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		<script>alert('hello');</script>
	<?php
	//-----------------------------------------------
	$widgetid=$_POST['widgetid'];
	$period=$_POST['periodsel'];
	$staffid=$_POST['staffid'];
	$conname=mysqli_connect($db_host,$db_user,$db_password,$db_name);
	$sqlfname="SELECT FirstName FROM abre_studentschedules WHERE Period='$period' AND StaffID='$staffid'";
	$sqllname="SELECT LastName FROM abre_studentschedules WHERE Period='$period' AND StaffID='$staffid'";
	$sqlid="SELECT StudentID FROM abre_studentschedules WHERE Period='$period' AND StaffID='$staffid'";
	$fnameresult=mysqli_query($conname,$sqlfname);
	$lnameresult=mysqli_query($conname,$sqllname);
	$idresult=mysqli_query($conname,$sqlid);
	$arrfnameresults=array();
	$arrlnameresults=array();
	$arridresults=array();
	while($rowfname = mysqli_fetch_array($fnameresult))
	{
		$arrfnameresults[]=$rowfname['FirstName'];
	}
	while($rowlname = mysqli_fetch_array($lnameresult))
	{
		$arrlnameresults[]=$rowlname['LastName'];
	}
	while($rowid = mysqli_fetch_array($idresult))
	{
		$arridresults[]=$rowid['StudentID'];
	}

	foreach($arrfnameresults as $value)
	{
		$lastfname = $value; //testing to see the most recent/last result
	}
	foreach($arrlnameresults as $value)
	{
		$lastlname = $value; //testing to see the most recent/last result
	}
	foreach($arridresults as $value)
	{
		$lastid = $value; //testing to see the most recent/last result
	}
	$conname->close();
	//-----------------------------------------------

	//-----------------------------------------------
	/*$studentid=1;
	$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
	$sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.StudentID = '$studentid' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.StudentID = mt1.StudentID)";
	//$sql="SELECT Feeling FROM mood_table WHERE ID = (SELECT MAX(ID) FROM mood_table)";
	//$sql="SELECT RecentFeeling FROM student_schedule WHERE Email='$email'";
	$result=mysqli_query($con,$sql);
	$rows = mysqli_fetch_row($result);
	$con->close();*/


	if ($widgetid==1){
		$numstudents = count($arrfnameresults);
	  $numstudents--;
	  $counter=0;
	  echo "<div style='margin-left: 30px;'>";
	  echo "<table style='width:80%'>";
	  while($counter<=$numstudents)
	  {
			$studentid=$arridresults[$counter];
			$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
			$sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.StudentID = '$studentid' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.StudentID = mt1.StudentID)";
			$result=mysqli_query($con,$sql);
			$rows = mysqli_fetch_row($result);
			//print_r($rows);
			$con->close();
			if ($rows[0]==0){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-laughing EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==1){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-smiley EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==2){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-slightly_smiling_face EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==3){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-weary EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==4){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-cry EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==5){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-slightly_frowning_face EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==6){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-persevere EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==7){
				echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-grimacing EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
			if ($rows[0]==8){
				 echo "<tr>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . ' ' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-expressionless EmojiSpacing" ></i>' . '</td>' . '</tr>';
			}
	    $counter++;
	  }
	  echo "</table>";
	  echo "</div>";



	}
	elseif($widgetid==2)
	{

		$counter=0;
		$countzero=0;
		$countone=0;
		$counttwo=0;
		$countthree=0;
		$countfour=0;
		$countfive=0;
		$countsix=0;
		$countseven=0;
		$counteight=0;
		$counthappy=0;
		$countsad=0;
		$countother=0;
		while($arridresults[$counter]!="")
		{
			$studentid=$arridresults[$counter];
			$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
			$sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.StudentID = '$studentid' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.StudentID = mt1.StudentID)";
			$result=mysqli_query($con,$sql);
			$rows = mysqli_fetch_row($result);
			$con->close();
			if ($rows[0]==0){
				$countzero++;
				$counthappy++;
			}
			if ($rows[0]==1){
				$countone++;
			 	$counthappy++;
			}
			if ($rows[0]==2){
				$counttwo++;
			 	$counthappy++;
			}
			if ($rows[0]==3){
				$countthree++;
			 	$countsad++;
			}
			if ($rows[0]==4){
				$countfour++;
			 	$countsad++;
			}
			if ($rows[0]==5){
				$countfive++;
			 	$countsad++;
			}
			if ($rows[0]==6){
				$countsix++;
			 	$countother++;
			}
			if ($rows[0]==7){
				$countseven++;
			 	$countother++;
			}
			if ($rows[0]==8){
				$counteight++;
			 $countother++;
			}
			$counter++;
		}
		$emojicount=count($arridresults);

		$percenthappy=((float)$counthappy/(float)$emojicount) *100;

		$percentsad=((float)$countsad/(float)$emojicount) *100;

		$percentother=((float)$countother/(float)$emojicount) *100;
		echo '<div style="text-align: center;" >';
			echo '<i class="em em-laughing EmojiSpacing" style="margin-left:15%"></i> <i class="em em-smiley EmojiSpacing"></i> <i class="em em-slightly_smiling_face EmojiSpacing"></i>:' . '<span style="margin-left: 5%">' . $percenthappy . '</span>' . '%';
		  echo '<br>';
		  echo '<i class="em em-weary EmojiSpacing" style="margin-left:15%"></i> <i class="em em-cry EmojiSpacing"></i> <i class="em em-slightly_frowning_face EmojiSpacing"></i>:' . '<span style="margin-left: 5%">' . $percentsad . '</span>' . '%';
		  echo '<br>';
		  echo '<i class="em em-persevere EmojiSpacing" style="margin-left:15%"></i> <i class="em em-grimacing EmojiSpacing"></i> <i class="em em-expressionless EmojiSpacing"></i>:' . '<span style="margin-left: 5%">' . $percentother . '</span>' . '%';
		  echo '<br>';
		  echo '<br>';
		echo '</div>';



	}
	elseif($widgetid==3)
	{
		$j=0;
		$objcounter=0;
		echo '<br>';
		echo '<table>';
		echo '<tr>';

		//displays all returned students and their info
		while ($j<200)
		{
			if($arrfnameresults[$j] != "")
			{
				$studentid=$arridresults[$j];
				$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
				$sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.StudentID = '$studentid' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.StudentID = mt1.StudentID)";
				$result=mysqli_query($con,$sql);
				$rows = mysqli_fetch_row($result);
				//print_r($rows);
				$con->close();
				//done to only allow 4 people in a row, then it automatically makes a new row
				if($objcounter==4)
				{
					echo '</tr>';
					echo '<tr>';
					$objcounter=0;
				}
				if ($rows[0]==0)
				{
					echo '<td<span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-laughing" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==1)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-smiley" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==2)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-slightly_smiling_face" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==3)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-weary" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==4)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-cry" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==5)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-slightly_frowning_face" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==6)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-persevere" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==7)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-grimacing" style="font-size:200%"></i></td>';
				}
				if ($rows[0]==8)
				{
					echo '<td><span style="font-weight:bold; margin-right: 15px;">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-expressionless" style="font-size:200%"></i></td>';
				}
				//echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </td>';
				$objcounter=$objcounter+1;
			}
			else
			{
				break;
			}
			$j=$j+1;
		}
		echo '</tr>';
		echo '</table>';
		echo '</div>';
		echo '<br>';



	}
	elseif($widgetid==4)
	{
		$counter=0;
		$countzero=0;
		$countone=0;
		$counttwo=0;
		$countthree=0;
		$countfour=0;
		$countfive=0;
		$countsix=0;
		$countseven=0;
		$counteight=0;
		$counthappy=0;
		$countsad=0;
		$countother=0;
		while($arridresults[$counter]!="")
		{
			$studentid=$arridresults[$counter];
			$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
			$sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.StudentID = '$studentid' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.StudentID = mt1.StudentID)";
			$result=mysqli_query($con,$sql);
			$rows = mysqli_fetch_row($result);
			$con->close();
			if ($rows[0]==0){
				$countzero++;
				$counthappy++;
			}
			if ($rows[0]==1){
				$countone++;
			 	$counthappy++;
			}
			if ($rows[0]==2){
				$counttwo++;
			 	$counthappy++;
			}
			if ($rows[0]==3){
				$countthree++;
			 	$countsad++;
			}
			if ($rows[0]==4){
				$countfour++;
			 	$countsad++;
			}
			if ($rows[0]==5){
				$countfive++;
			 	$countsad++;
			}
			if ($rows[0]==6){
				$countsix++;
			 	$countother++;
			}
			if ($rows[0]==7){
				$countseven++;
			 	$countother++;
			}
			if ($rows[0]==8){
				$counteight++;
			 $countother++;
			}
			$counter++;
		}
		$emojicount=count($arridresults);

		$percenthappy=((float)$counthappy/(float)$studentcount) *100;

		$percentsad=((float)$countsad/(float)$studentcount) *100;

		$percentother=((float)$countother/(float)$studentcount) *100;

		echo "
		<br />
		<br />
		<div class='grid'>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-laughing' style='font-size:50%'></i>:" . $countzero . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-smiley' style='font-size:50%'></i>:" . $countone . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-slightly_smiling_face' style='font-size:50%'></i>:" . $counttwo . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-weary' style='font-size:50%'></i>:" . $countthree . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-cry' style='font-size:50%'></i>:" . $countfour . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-slightly_frowning_face' style='font-size:50%'></i>:" . $countfive . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-persevere' style='font-size:50%'></i>:" . $countsix . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-grimacing' style='font-size:50%'></i>:" . $countseven . "</span>
			</div>
			<div class='cell centercell'>
				<span class='center-align truncate' style='font-size:70px; line-height:80px;'><i class='em em-expressionless' style='font-size:50%'></i>:" . $counteight . "</span>
			</div>
		</div>";
	}
	
	?>
