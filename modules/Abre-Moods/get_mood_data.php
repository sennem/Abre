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

	$conroomnum=mysqli_connect("localhost","root","password","abredb");
	//$email=$_SESSION['useremail'];   USE THIS FOR ACTUAL THING, THIS IS TO GET THE LOGIN EMAIL FROM TEACHER
	$email='teacher1@gmail.com';
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sqlroomnum="SELECT Roomnum FROM teacher_data WHERE Email='$email'";
	$roomnumresult=mysqli_query($conroomnum,$sqlroomnum);
	$arrroomnumresults=array();
	while($rowroomnum = mysqli_fetch_array($roomnumresult))
	{
		$arrroomnumresults[]=$rowroomnum['Roomnum'];
	}
	foreach($arrroomnumresults as $value)
	{
		$roomnum = $value;
	}
	$conroomnum->close();

	$conperiod=mysqli_connect("localhost","root","password","abredb");
	$sqlperiod="SELECT PeriodSelection FROM teacher_data WHERE Email='$email' AND Roomnum='$roomnum'";
	$periodresult=mysqli_query($conperiod,$sqlperiod);
	$arrperiodresults=array();
	while($rowperiod = mysqli_fetch_array($periodresult))
	{
		$arrperiodresults[]=$rowperiod['PeriodSelection'];
	}
	foreach($arrperiodresults as $value)
	{
		$period = $value;
	}
	$conperiod->close();


	$conname=mysqli_connect("localhost","root","password","abredb");
	if ($period==1)
	{
		$sqlfname="SELECT Fname FROM students_schedule WHERE Period1 = '$roomnum'";
		$sqllname="SELECT Lname FROM students_schedule WHERE Period1 = '$roomnum'";
		$sqlpic="SELECT ImgUrl FROM students_schedule WHERE Period1 = '$roomnum'";
		$sqlmood="SELECT RecentFeeling FROM students_schedule WHERE Period1 = '$roomnum'";
	}
	elseif ($period==2)
	{
		$sqlfname="SELECT Fname FROM students_schedule WHERE Period2 = '$roomnum'";
		$sqllname="SELECT Lname FROM students_schedule WHERE Period2 = '$roomnum'";
		$sqlpic="SELECT ImgUrl FROM students_schedule WHERE Period2 = '$roomnum'";
		$sqlmood="SELECT RecentFeeling FROM students_schedule WHERE Period2 = '$roomnum'";
	}
	elseif ($period==3)
	{
		$sqlfname="SELECT Fname FROM students_schedule WHERE Period3 = '$roomnum'";
		$sqllname="SELECT Lname FROM students_schedule WHERE Period3 = '$roomnum'";
		$sqlpic="SELECT ImgUrl FROM students_schedule WHERE Period3 = '$roomnum'";
		$sqlmood="SELECT RecentFeeling FROM students_schedule WHERE Period3 = '$roomnum'";
	}
	elseif ($period==4)
	{
		$sqlfname="SELECT Fname FROM students_schedule WHERE Period4 = '$roomnum'";
		$sqllname="SELECT Lname FROM students_schedule WHERE Period4 = '$roomnum'";
		$sqlpic="SELECT ImgUrl FROM students_schedule WHERE Period4 = '$roomnum'";
		$sqlmood="SELECT RecentFeeling FROM students_schedule WHERE Period4 = '$roomnum'";
	}
	elseif ($period==5)
	{
		$sqlfname="SELECT Fname FROM students_schedule WHERE Period5 = '$roomnum'";
		$sqllname="SELECT Lname FROM students_schedule WHERE Period5 = '$roomnum'";
		$sqlpic="SELECT ImgUrl FROM students_schedule WHERE Period5 = '$roomnum'";
		$sqlmood="SELECT RecentFeeling FROM students_schedule WHERE Period5 = '$roomnum'";
	}
	elseif ($period==6)
	{
		$sqlfname="SELECT Fname FROM students_schedule WHERE Period6 = '$roomnum'";
		$sqllname="SELECT Lname FROM students_schedule WHERE Period6 = '$roomnum'";
		$sqlpic="SELECT ImgUrl FROM students_schedule WHERE Period6 = '$roomnum'";
		$sqlmood="SELECT RecentFeeling FROM students_schedule WHERE Period6 = '$roomnum'";
	}
	elseif ($period==7)
	{
		$sqlfname="SELECT Fname FROM students_schedule WHERE Period7 = '$roomnum'";
		$sqllname="SELECT Lname FROM students_schedule WHERE Period7 = '$roomnum'";
		$sqlpic="SELECT ImgUrl FROM students_schedule WHERE Period7 = '$roomnum'";
		$sqlmood="SELECT RecentFeeling FROM students_schedule WHERE Period7 = '$roomnum'";
	}
	$fnameresult=mysqli_query($conname,$sqlfname);
	$lnameresult=mysqli_query($conname,$sqllname);
	$picresult=mysqli_query($conname,$sqlpic);
	$moodresult=mysqli_query($conname,$sqlmood);
	$arrfnameresults=array();
	$arrlnameresults=array();
	$arrpicresults=array();
	$arrmoodresults=array();
	while($rowfname = mysqli_fetch_array($fnameresult))
	{
		$arrfnameresults[]=$rowfname['Fname'];
	}
	while($rowlname = mysqli_fetch_array($lnameresult))
	{
		$arrlnameresults[]=$rowlname['Lname'];
	}
	while($rowpic = mysqli_fetch_array($picresult))
	{
		$arrpicresults[]=$rowpic['ImgUrl'];
	}
	while($rowmood = mysqli_fetch_array($moodresult))
	{
		$arrmoodresults[]=$rowmood['RecentFeeling'];
	}
	foreach($arrfnameresults as $value)
	{
		$fname = $value; //testing to see the most recent/last result
	}
	foreach($arrlnameresults as $value)
	{
		$lname = $value; //testing to see the most recent/last result
	}
	foreach($arrpicresults as $value)
	{
		$picurl = $value; //testing to see the most recent/last result
	}
	foreach($arrmoodresults as $value)
	{
		$mood = $value; //testing to see the most recent/last result
	}
	$conname->close();

	//loop through to get totals for Emojis
	$c=0;
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
	while($arrmoodresults[$c]!="")
	{
		if ($arrmoodresults[$c]==0)
		{
			$countzero=$countzero+1;
			$counthappy=$counthappy+1;
		}
		elseif ($arrmoodresults[$c]==1)
		{
			$countone=$countone+1;
			$counthappy=$counthappy+1;
		}
		elseif ($arrmoodresults[$c]==2)
		{
			$counttwo=$counttwo+1;
			$counthappy=$counthappy+1;
		}
		elseif ($arrmoodresults[$c]==3)
		{
			$countthree=$countthree+1;
			$countsad=$countsad+1;
		}
		elseif ($arrmoodresults[$c]==4)
		{
			$countfour=$countfour+1;
			$countsad=$countsad+1;
		}
		elseif ($arrmoodresults[$c]==5)
		{
			$countfive=$countfive+1;
			$countsad=$countsad+1;
		}
		elseif ($arrmoodresults[$c]==6)
		{
			$countsix=$countsix+1;
			$countother=$countother+1;
		}
		elseif ($arrmoodresults[$c]==7)
		{
			$countseven=$countseven+1;
			$countother=$countother+1;
		}
		elseif ($arrmoodresults[$c]==8)
		{
			$counteight=$counteight+1;
			$countother=$countother+1;
		}
		$c=$c+1;
	}
	$studentcount=$c;

	$percenthappy=(round((float)$counthappy/(float)$studentcount)) *100;

	$percentsad=(round((float)$countsad/(float)$studentcount)) *100;

	$percentother=(round((float)$countother/(float)$studentcount)) *100;

	//maybe get percents and such
	//$numpeople=$c;
	//$percentzero=$cou


/*	echo $roomnum . "roomnum";
	echo '<br>';
	echo $period ."period";
	echo '<br>';
	echo $fname . "fname";
	echo '<br>';
	echo $lname . "lname";
	echo '<br>';
	echo $picurl . "picurl";
	echo '<br>';*/ //for testing retrieved data

	//for testing display of information
	//echo '<td> <img src="'.$picurl.'" width="80" height="80" alt="Mark">  '.$fname.' '.$lname.' </td>';
	//echo '<br>';
	//echo '---';

	?>
