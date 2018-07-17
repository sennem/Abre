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
	$pagerestrictions="student"; //so i can load the "other page" (teacher version)
	if ($pagerestrictions=="student")
	{
		$con=mysqli_connect("localhost","root","password","abredb");
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
								window.location.assign("http://localhost:8080/modules/Abre-Moods/db_submission.php?moodval=" + emojivalue + "&widget=" + 0);
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
								document.getElementById("emojizero").style.border = "";
								document.getElementById("emojione").style.border = "";
								document.getElementById("emojitwo").style.border = "";
								document.getElementById("emojithree").style.border = "";
								document.getElementById("emojifour").style.border = "";
								document.getElementById("emojifive").style.border = "";
								document.getElementById("emojisix").style.border = "";
								document.getElementById("emojiseven").style.border = "";
								document.getElementById("emojieight").style.border = "";
							}
						</script>
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
				</div>';

				?>

				<?php
					$con=mysqli_connect("localhost","root","password","abredb");
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
		require_once('get_mood_data.php');
?>

	<!--<img src="<?php //echo $picurl; ?>" width="80" height="80" alt="Mark"> <?php //echo $fname . ' ' . $lname; ?> -->
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
			//alert('2'); //testing
			var periodnum=document.getElementById("ClassPeriodSelection").value;
			window.location.assign("http://localhost:8080/modules/Abre-Moods/periodnumlog.php?periodurl=" + periodnum + "&emailurl=" + "<?php echo $email; ?>" + "&roomurl=" + "<?php echo $roomnum; ?>" + "&fromwidget=" + 0);
		}
		function setperiod()
		{
			//alert('runniong');
			//alert('<?php //echo $period; ?>');
			document.getElementById("ClassPeriodSelection").value = "<?php echo $period; ?>";
		}
	</script>

	<!--<div class='page_container' style='background-color:#2B2D4A'>-->
				<select id='ClassPeriodSelection' onchange='changeperiod()'>
						<option value='1'>Period 1</option>
						<option value='2'>Period 2</option>
						<option value='3'>Period 3</option>
						<option value='4'>Period 4</option>
						<option value='5'>Period 5</option>
						<option value='6'>Period 6</option>
						<option value='7'>Period 7</option>
				</select>
		<!--</div>-->

				<!--<input class='waves-effect waves-light btn' style='background-color: <?php //echo getSiteColor() ?>' type='submit' value="Submit!">
			</form>-->
		<!--</div>-->

		<!--<table>
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
		</table>-->

<?php
	echo '<br>';
	echo '<script type="text/javascript">',
	'setperiod();',
	'</script>'
	;
	}
?>

<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	</header>
</html>
<div class="mdl-shadow--16dp" style="background-color:#2B2D4A"
<?php
	//echo '<br>';
	$j=0;
	$objcounter=0;
	//echo '<div class="mdl-shadow--16dp" style="background-color:#2B2D4A">';
	echo '<br>';
	echo '<table>';
	echo '<tr>';
	while ($j<200)
	{
		if($arrpicresults[$j] != "")
		{
			if($objcounter==4)
			{
				echo '</tr>';
				echo '<tr>';
				$objcounter=0;
			}
			if ($arrmoodresults[$j]==0)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-laughing" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==1)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-smiley" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==2)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-slightly_smiling_face" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==3)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-weary" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==4)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-cry" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==5)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-slightly_frowning_face" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==6)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-persevere" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==7)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-grimacing" style="font-size:200%"></i></td>';
			}
			if ($arrmoodresults[$j]==8)
			{
				echo '<td> <img src="'.$arrpicresults[$j].'" width="80" height="80" alt="No Result"><span style="font-weight:bold">  '.$arrfnameresults[$j].' '.$arrlnameresults[$j].' </span><i class="em em-expressionless" style="font-size:200%"></i></td>';
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
	//echo '</div>';
	echo '<br>';

?>
