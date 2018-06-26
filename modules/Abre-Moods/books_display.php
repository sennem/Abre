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
	$pagerestrictions="staff"; //so i can load the "other page"
	if ($pagerestrictions=="")
	{
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
					echo '10';
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
									//document.getElementById("emojizero").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojizero").style.border = "solid thin black";
								}
								if (emojivalue3==1)
								{
									//document.getElementById("emojione").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojione").style.border = "solid thin black";
								}
								if (emojivalue3==2)
								{
									//document.getElementById("emojitwo").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojitwo").style.border = "solid thin black";
								}
								if (emojivalue3==3)
								{
									//document.getElementById("emojithree").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojithree").style.border = "solid thin black";
								}
								if (emojivalue3==4)
								{
									//document.getElementById("emojifour").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojifour").style.border = "solid thin black";
								}
								if (emojivalue3==5)
								{
									//document.getElementById("emojifive").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojifive").style.border = "solid thin black";
								}
								if (emojivalue3==6)
								{
									//document.getElementById("emojisix").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojisix").style.border = "solid thin black";
								}
								if (emojivalue3==7)
								{
									//document.getElementById("emojiseven").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojiseven").style.border = "solid thin black";
								}
								if (emojivalue3==8)
								{
									//document.getElementById("emojieight").style.backgroundColor = "DeepSkyBlue";
									document.getElementById("emojieight").style.border = "solid thin black";
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
					$getdate = date('Y-m-d');//works
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


<?php
	}
	else
	{
		echo $_SESSION['period'];
		//set session room num
		$conroomnum=mysqli_connect("localhost","root","killerm111","abredb");
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
		echo $roomnum;
		echo '---|';
		$period=$_GET['periodnumber'];
		echo $period;
		echo '|---';
?>
	<style>
		img
		{
			border-radius: 50%;
			margin-bottom: 20px;
		}
	</style>
	<script>
		function changeperiod()
		{
			alert('yupp');
			var periodnum=document.getElementById("ClassPeriodSelection").value;
			window.location.assign("http://localhost:8080/modules/Abre-Moods/periodnumlog.php?periodnumber=" + periodnum);
		}
	</script>

	<div class='page_container'>
		<div class='row'>
			<!--<form method='POST'>-->
				<select id='ClassPeriodSelection' onchange='changeperiod()'>
						<option value='1'>Period 1</option>
						<option value='2'>Period 2</option>
						<option value='3'>Period 3</option>
						<option value='4'>Period 4</option>
						<option value='5'>Period 5</option>
						<option value='6'>Period 6</option>
						<option value='7'>Period 7</option>
				</select>
				<!-- LOOK INTO USING ONCHANGE IN SELECT TAG -->

				<!--<input class='waves-effect waves-light btn' style='background-color: <?php echo getSiteColor() ?>' type='submit' value="Submit!">
			</form>-->
		</div>

		<table>
			<tr>
				<td><img src="https://masonhackclub.com/images/staff/mark.jpg" width="80" height="80" alt="Mark">Mark Senne</td>
				<td><img src="https://cincyhacks.com/assets/images/staff/annie-wang.jpg" width="80" height="80" alt="Annie">Annie Wang</td>
				<td><img src="https://masonhackclub.com/images/staff/dalton.jpg" width="80" height="80" alt="Dalton">Dalton Craven</td>
				<td><img src="https://masonhackclub.com/images/staff/megan.jpg" width="80" height="80" alt="Megan">Megan Cui</td>
			</tr>
			<tr>
				<td><img src="https://masonhackclub.com/images/staff/will.jpg" width="80" height="80" alt="Will">Will Mechler</td>
				<td><img src="https://cincyhacks.com/assets/images/staff/scott-shepherd.jpg" width="80" height="80" alt="Scott">Scott Shepherd</td>
				<td><img src="https://cincyhacks.com/assets/images/staff/vikram-deepak.jpg" width="80" height="80" alt="Vikram">Vikram Depak</td>
				<td><img src="https://cincyhacks.com/assets/images/staff/alan-guo.jpg" width="80" height="80" alt="Alan">Alan Guo</td>
			</tr>
		</table>

<?php
	}
?>
