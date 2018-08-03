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
require(dirname(__FILE__) . '/../../configuration.php');
require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
require_once('functions.php');
require('permissions.php');
$pagerestrictions="staff";
//if($_SESSION['usertype'] == "student")
if ($pagerestrictions=="student") //this is the student view ()
{
	$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$email = $_SESSION['useremail'];
	$studentid=1; //HARDCODED STUDENT ID
	//get the most recent feeling/mood entry for a certain student
	$sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.Email = '$email' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.Email = mt1.Email)";
	$result=mysqli_query($con,$sql);
	$rows = mysqli_fetch_row($result);
	$con->close();
	?>

	<div class='page_container'>
		<div class='row'>
			<?php
			echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Mood Menu</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Select an emoji that encapsulates your mood.</p></div>";
			?>


			<html>
			<header>
				<script>
				function alterdisp(emojival) //makes the black border ring around selected mood
				{
					var emojivalue3=emojival;
					if (emojivalue3==0)
					{
						document.getElementById("emojizerodiv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==1)
					{
						document.getElementById("emojionediv").style.border = "solid 5px black";
						document.getElementById("emojizerodiv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==2)
					{
						document.getElementById("emojitwodiv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojizerodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==3)
					{
						document.getElementById("emojithreediv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojizerodiv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==4)
					{
						document.getElementById("emojifourdiv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojizerodiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==5)
					{
						document.getElementById("emojifivediv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojizerodiv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==6)
					{
						document.getElementById("emojisixdiv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojizerodiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==7)
					{
						document.getElementById("emojisevendiv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojizerodiv").style.border = "";
						document.getElementById("emojieightdiv").style.border = "";
					}
					if (emojivalue3==8)
					{
						document.getElementById("emojieightdiv").style.border = "solid 5px black";
						document.getElementById("emojionediv").style.border = "";
						document.getElementById("emojitwodiv").style.border = "";
						document.getElementById("emojithreediv").style.border = "";
						document.getElementById("emojifourdiv").style.border = "";
						document.getElementById("emojifivediv").style.border = "";
						document.getElementById("emojisixdiv").style.border = "";
						document.getElementById("emojisevendiv").style.border = "";
						document.getElementById("emojizerodiv").style.border = "";
					}
				}

				function resetdisp() //gets rid of the black border ring around selected mood
				{
					//yes, I realize this function is kinda redundant cause of what I have in alterdisp func but....
					document.getElementById("emojizerodiv").style.border = "";
					document.getElementById("emojionediv").style.border = "";
					document.getElementById("emojitwodiv").style.border = "";
					document.getElementById("emojithreediv").style.border = "";
					document.getElementById("emojifourdiv").style.border = "";
					document.getElementById("emojifivediv").style.border = "";
					document.getElementById("emojisixdiv").style.border = "";
					document.getElementById("emojisevendiv").style.border = "";
					document.getElementById("emojieightdiv").style.border = "";
				}

				function submitandupdate(emojivalue) //logs the user's new mood selection and refreshes/updates the GUI
				{
					alert("Respone submitted");
					var studentid = "<?php echo $studentid; ?>";
					$(document).ready(function(){
						$.post( "/modules/Abre-Moods/mood_table_submission.php", { moodval: emojivalue, stuid: studentid})
						.done(function( data ) {
							resetdisp();
							alterdisp(emojivalue);
						});
					});
				}
				</script>
				<style>
				.grid {
					display: flex;                       /* establish flex container */
					flex-wrap: wrap;                     /* enable flex items to wrap */
					justify-content: center;

				}
				.cell {
					flex: 0 0 15%;                       /* don't grow, don't shrink, width */
					height: 100px;
					width: 100px;
					margin-bottom: 15px;
					background-color: #3e4066;
					margin-right: 15px;
				}
				/*.cell:nth-child(3n) {
				//alters third cell. Not used for anything but it's something I find interesting
				}*/
				.centercell{
					text-align: center;
				}
				.emojistyle{
					margin-top: 30px;
					font-size: 240%;
				}
				.br50{
					border-radius: 50%;
				}
				</style>
				<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
			</header>
			</html>

			<script type="text/javascript">
			var adparam=("<?php echo $rows[0]; ?>");
			alterdisp(adparam); //calls the func that "highlights" an emoji
			</script>

			<!-- the mood menu -->
			<div class="grid">
				<span style="display: inline;"><div class="cell centercell br50" id="emojizerodiv"><i id="emojizero" class="em em-laughing emojistyle" onclick="submitandupdate(0)"></i></div>
					<div class="cell centercell br50" id="emojionediv"><i id="emojione" class="em em-smiley emojistyle" onclick="submitandupdate(1)"></i></div>
					<div class="cell centercell br50" id="emojitwodiv"><i id="emojitwo" class="em em-slightly_smiling_face emojistyle" onclick="submitandupdate(2)"></i></div>
				</span>
				<span style="display: inline;"><div class="cell centercell br50" id="emojithreediv"><i id="emojithree" class="em em-weary emojistyle" onclick="submitandupdate(3)"></i></div>
					<div class="cell centercell br50" id="emojifourdiv"><i id="emojifour" class="em em-cry emojistyle" onclick="submitandupdate(4)"></i></div>
					<div class="cell centercell br50" id="emojifivediv"><i id="emojifive" class="em em-slightly_frowning_face emojistyle" onclick="submitandupdate(5)"></i></div>
				</span>
				<span style="display: inline;"><div class="cell centercell br50" id="emojisixdiv"><i id="emojisix" class="em em-persevere emojistyle" onclick="submitandupdate(6)"></i></div>
					<div class="cell centercell br50" id="emojisevendiv"><i id="emojiseven" class="em em-grimacing emojistyle" onclick="submitandupdate(7)"></i></div>
					<div class="cell centercell br50" id="emojieightdiv"><i id="emojieight" class="em em-expressionless emojistyle" onclick="submitandupdate(8)"></i></div>
				</span>
			</div>

						<?php
						$email = $_SESSION['useremail'];
						$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
						//gets the date from the most recent entry from a user (in order to check if they made a submission "today")
						//this query should probably be updated to use studentid and not email
						$sql="SELECT * FROM mood_table mt1 WHERE mt1.Email = '$email' AND mt1.Daterow = (SELECT MAX(mt2.Daterow) FROM mood_table mt2 WHERE mt2.Email = mt1.Email)";
						$result=mysqli_query($con,$sql);
						$con->close();
						$arrrowresults=array();
						while($rowrow = mysqli_fetch_array($result))
						{
							$arrrowresults[]=$rowrow['Daterow'];
						}
						foreach($arrrowresults as $value)
						{
							$maxdate = $value;
						}

						$dbdate = DateTime::createFromFormat('Y-m-d', $maxdate);

						date_default_timezone_set('America/Indiana/Indianapolis');
						$getdate = date('Y-m-d');//works
						$cdate = DateTime::createFromFormat('Y-m-d', $getdate);


						if (($dbdate->format('d')) != ($cdate->format('d')))
						{
							//not the same day (erase visual selection)
							echo '<script type="text/javascript">',
							'resetdisp();',
							'</script>'
							;
						}
						elseif ((($dbdate->format('d')) == ($cdate->format('d'))) && (($dbdate->format('m')) != ($cdate->format('m'))))
						{
							//same day but different month (erase visual selection)
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
?>


				<style>
				img
				{
					border-radius: 50%;
					margin-bottom: 20px;
					height: 80px;
					width: auto;
				}
				</style>


				<select id='ClassPeriodSelection' >
					<option value='0'>*select a period*</option>
					<option value='1'>Period 1</option>
					<option value='2'>Period 2</option>
					<option value='3'>Period 3</option>
					<option value='4'>Period 4</option>
					<option value='5'>Period 5</option>
					<option value='6'>Period 6</option>
					<option value='7'>Period 7</option>
				</select>



				<br />
				<script>
					document.getElementById('ClassPeriodSelection').value=0;
				</script>

				<html>
					<header>
						<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
					</header>
				</html>

				<div class="mdl-shadow--16dp" id="bigrosterdiv" style="background-color:#3e4066">

					<script type="text/javascript">
					//if a period selection is made then run code in mood_data_retrieval_and_output
					//	to update the roster of kids in the period)
					$(document).ready(function(){
						$("#ClassPeriodSelection").change(function(){
							var periodnumj=document.getElementById("ClassPeriodSelection").value;
							var emailj= "<?php echo $email; ?>";
							var roomnumj= "<?php echo $roomnum; ?>";
							var location=3; //tells mood_data_retrieval_and_output what code to run depending on where the code is displayed (widget, page, staff, student)
							var id=109; //HARDCODED STAFF ID
							$.post( "/modules/Abre-Moods/mood_data_retrieval_and_output.php", {locationid: location, periodsel: periodnumj, staffid: id})
							.done(function( data ) {
								$("#bigrosterdiv").html(data);
							});
						});
					});
					</script>

					<?php
					echo '</div>';
					echo '<br>';
				}

				?>
