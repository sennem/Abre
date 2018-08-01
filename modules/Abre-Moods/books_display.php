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
	$pagerestrictions="staff"; //so i can load the "other page" (teacher version)
	//if($_SESSION['usertype'] == "student")
	if ($pagerestrictions=="student")
	{
		$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$email = $_SESSION['useremail'];
		$studentid=1;
		//$sql ="SELECT RecentFeeling FROM students_schedule WHERE Email='$email'";
		$sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.Email = '$email' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.Email = mt1.Email)";
		//$sql="SELECT Feeling FROM mood_table WHERE ID = (SELECT MAX(ID) FROM mood_table)";
		//$sql="SELECT RecentFeeling FROM student_schedule WHERE Email='$email'";
		$result=mysqli_query($con,$sql);
		$rows = mysqli_fetch_row($result);
		$con->close();
		?>
		<script>
	    alert('widgetfq=' + '<?php echo $rows[0]; ?>');
	  </script>

		<div class='page_container'>
			<div class='row'>

				<?php
					echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Mood Menu</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Select an emoji that encapsulates your mood.</p></div>";
				?>

				<!--links to CSS Stylesheet for emojis && contains CSS for columns on emojis-->
				<html>
					<header>
						<script>
							function alterdisp(emojival)
							{
								var emojivalue3=emojival;
								//alert("em3=" + emojivalue3 + " em=" + emojival);
								if (emojivalue3==0)
			  				{
			  					//document.getElementById("emojizero").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojizero").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==1)
			  				{
			  					//document.getElementById("emojione").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojione").style.border = "solid thin black";
			            document.getElementById("emojizero").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==2)
			  				{
			  					//document.getElementById("emojitwo").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojitwo").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojizero").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==3)
			  				{
			  					//document.getElementById("emojithree").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojithree").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojizero").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==4)
			  				{
			  					//document.getElementById("emojifour").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojifour").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojizero").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==5)
			  				{
			  					//document.getElementById("emojifive").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojifive").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojizero").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==6)
			  				{
			  					//document.getElementById("emojisix").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojisix").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojizero").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==7)
			  				{
			  					//document.getElementById("emojiseven").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojiseven").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojizero").style.border = "";
			            document.getElementById("emojieight").style.border = "";
			  				}
			  				if (emojivalue3==8)
			  				{
			  					//document.getElementById("emojieight").style.backgroundColor = "DeepSkyBlue";
			  					document.getElementById("emojieight").style.border = "solid thin black";
			            document.getElementById("emojione").style.border = "";
			            document.getElementById("emojitwo").style.border = "";
			            document.getElementById("emojithree").style.border = "";
			            document.getElementById("emojifour").style.border = "";
			            document.getElementById("emojifive").style.border = "";
			            document.getElementById("emojisix").style.border = "";
			            document.getElementById("emojiseven").style.border = "";
			            document.getElementById("emojizero").style.border = "";
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

							function testfunc(emojivalue)
							{
								alert("Respone submitted");
								var studentid = "<?php echo $studentid; ?>";
								//window.location.assign("http://localhost:8080/modules/Abre-Moods/db_submission.php?moodval=" + emojivalue + "&widget=" + 0);
								$(document).ready(function(){
										$.post( "/modules/Abre-Moods/db_submission.php", { moodval: emojivalue, stuid: studentid})
											.done(function( data ) {
												resetdisp();
												alterdisp(emojivalue);
										});
								});
							}
						</script>
						<style>
							/*.EmojiSpacing
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
							}*/
							/*---------------------*/
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
							  background-color: #3e4066;
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
	    	//alterdisp(); //calls the func that "highlights" an emoji
			</script>
			<script type="text/javascript">
				var adparam=("<?php echo $rows[0]; ?>");
				alterdisp(adparam); //calls the func that "highlights" an emoji
			</script>

				<?php

				/*echo '
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
				</div>';*/
				?>
				<div class="grid">
				  <span style="display: inline;"><div class="cell centercell br50"><i id="emojizero" class="em em-laughing emojistyle" onclick="testfunc(0)"></i></div>
				  <div class="cell centercell br50"><i id="emojione" class="em em-smiley emojistyle" onclick="testfunc(1)"></i></div>
				  <div class="cell centercell br50"><i id="emojitwo" class="em em-slightly_smiling_face emojistyle" onclick="testfunc(2)"></i></div></span>
				  <span style="display: inline;"><div class="cell centercell br50"><i id="emojithree" class="em em-weary emojistyle" onclick="testfunc(3)"></i></div>
				  <div class="cell centercell br50"><i id="emojifour" class="em em-cry emojistyle" onclick="testfunc(4)"></i></div>
				  <div class="cell centercell br50"><i id="emojifive" class="em em-slightly_frowning_face emojistyle" onclick="testfunc(5)"></i></div></span>
				  <span style="display: inline;"><div class="cell centercell br50"><i id="emojisix" class="em em-persevere emojistyle" onclick="testfunc(6)"></i></div>
				  <div class="cell centercell br50"><i id="emojiseven" class="em em-grimacing emojistyle" onclick="testfunc(7)"></i></div>
				  <div class="cell centercell br50"><i id="emojieight" class="em em-expressionless emojistyle" onclick="testfunc(8)"></i></div></span>
				</div>

				<?php
					$email = $_SESSION['useremail'];
					$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
					//$sql="SELECT Daterow FROM mood_table WHERE ID = (SELECT MAX(ID) FROM mood_table)";
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
?>


	<style>
		img
		{
			border-radius: 50%;
			margin-bottom: 20px;
			height: 30px;
			width: auto;
		}
	</style>
	<script>
		function changeperiod()
		{
			var periodnum=document.getElementById("ClassPeriodSelection").value;
			window.location.assign("http://localhost:8080/modules/Abre-Moods/periodnumlog.php?periodurl=" + periodnum + "&emailurl=" + "<?php echo $email; ?>" + "&roomurl=" + "<?php echo $roomnum; ?>" + "&fromwidget=" + 0);
		}
		function setperiod()
		{
			document.getElementById("ClassPeriodSelection").value = "<?php echo $period; ?>";
		}
	</script>

				<select id='ClassPeriodSelection' >
						<option value='0'>*select an option*</option>
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
	$(document).ready(function(){
			$("#ClassPeriodSelection").change(function(){
				var periodnumj=document.getElementById("ClassPeriodSelection").value;
				var emailj= "<?php echo $email; ?>";
				var roomnumj= "<?php echo $roomnum; ?>";
				var widget=3;
				var id=109;
			$.post( "/modules/Abre-Moods/periodnumlogwidget.php", { periodurl: periodnumj, emailurl: emailj, roomurl: roomnumj, fromwidget: widget})
				.done(function( data ) {
					$.post( "/modules/Abre-Moods/DUP_get_mood_data.php", {widgetid: widget, periodsel: periodnumj, staffid: id})
						.done(function( data ) {
							$("#bigrosterdiv").html(data);
				});
			});
		});
	});

	</script>
<?php
		echo '</div>';
		echo '<br>';
	}

?>
