
<?php
	require('get_mood_data.php');
	//reaches
?>

<html>
	<header>
    <script>
  		function changeperiod()
  		{
  			//alert('2'); //testing
  			var periodnum=document.getElementById("Period").value;
  			window.location.assign("http://localhost:8080/modules/Abre-Moods/periodnumlog.php?periodurl=" + periodnum + "&emailurl=" + "<?php echo $email; ?>" + "&roomurl=" + "<?php echo $roomnum; ?>" + "&fromwidget=" + 1);
  		}
  		function setperiod()
  		{
  			//alert('runniong');
  			//alert('<?php //echo $period; ?>');
  			document.getElementById("Period").value = "<?php echo $period; ?>";
  		}
			function testing1(){
				alert('hit test 1');
			}
			function testing2(){
				alert('hit test 2');
			}
  	</script>
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
//echo $pagerestictions;
if ($pagerestictions=="student")
{
	//echo '<script type="text/javascript">',
	//'testing1();',
	//'</script>'
	//;
		$email = $_SESSION['useremail']; //works
		//---$con=mysqli_connect("localhost","root","password","abredb");
		$con = new mysqli("localhost","root","password","abredb");
		if (mysqli_connect_errno()) {
		  echo 'Connection Failed';
		}
		$sqlnumrows = "SELECT COUNT(*) FROM mood_table";
		$resultnumrows = mysqli_query($con,$sqlnumrows);
		$numrows = mysqli_fetch_row($resultnumrows);

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
		//no issue
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
		//no issue

		//--

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


		//-------------

		$arrlength = count($arrdates);
    $maxlength=$arrlength-1; //holds the last position able to be printed as arrays start at zero (so one less than what the count is is the pos of the last value)
		date_default_timezone_set('America/Indiana/Indianapolis');
		$getdate = date('Y-m-d');//works
		$cdate = DateTime::createFromFormat('Y-m-d', $getdate);
		$cday = $cdate->format('d'); //works //for testing
		$cmonth = $cdate->format('m'); //works //for testing
    $outputcounter=0;
		$falsecounter=0;
		//-------------
		while ($outputcounter<5 && $falsecounter<5)
	  {
			$dbdate = DateTime::createFromFormat('Y-m-d', $arrdates[$maxlength]);
		 	$dbday = $dbdate->format('d'); //works //for testing
		 	$dbmonth = $dbdate->format('m'); //works //for testing
			//echo "max=" . $maxlength;
			//echo "rsfeeling=" . $rowsfeeling[$maxlength];
			//echo '<br />';
			if (($dbday >= ($cday-4)) && ($dbmonth==$cmonth))
			{
				echo "<div>";
				if($rowsfeeling[$maxlength]==0){
					 echo '<i class="em em-laughing EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==1){
					echo '<i class="em em-smiley EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==2){
					 echo '<i class="em em-slightly_smiling_face EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==3){
					 echo '<i class="em em-weary EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==4){
					 echo '<i class="em em-cry EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==5){
					echo '<i class="em em-slightly_frowning_face EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==6){
					echo '<i class="em em-persevere EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==7){
					 echo '<i class="em em-grimacing EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				if($rowsfeeling[$maxlength]==8){
					 echo '<i class="em em-expressionless EmojiSpacingLeft" ></i> <sup style="font-size: 100%">-</sup>';
				}
				echo "<i class='EmojiSpacing'></i>" . "<sup style='font-size: 100%'>" . $dbdate->format('l') . "</sup>";
        echo '  <sup style="font-size: 100%">at</sup>  ' . '<sup style="font-size: 100%">' . $arrtimes[$maxlength] . '</sup>';
				$maxlength--;

				//<sup> because it helps make the text and such appear on same level; it is a workaround
	  	}
			$outputcounter++;

		}
}
else
{
	//echo '<script type="text/javascript">',
	//'testing2();',
	//'</script>'
	//;
	require('get_mood_data.php'); //get array data
  ?>
  <?php
	echo '<script type="text/javascript">',
	'setperiod();',
	'</script>'
	;


  echo'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <select class="mdl-textfield__input" id="Period" name="Period" >
      <option>*select a period*</option>
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
				var emailj= "<?php echo $email; ?>";
				var roomnumj= "<?php echo $roomnum; ?>";
				var widget=2;
			$.post( "/modules/Abre-Moods/periodnumlogwidget.php", { periodurl: periodnumj, emailurl: emailj, roomurl: roomnumj, fromwidget: widget})
				.done(function( data ) {
					$.post( "/modules/Abre-Moods/get_mood_data.php", {widgetid: widget})
						.done(function( data ) {
							$("#overviewdiv").html(data);
				});
			});
		});
	});

	</script>
	<?php
/*
  echo '<i class="em em-laughing EmojiSpacing" style="margin-left:15%"></i> <i class="em em-smiley EmojiSpacing"></i> <i class="em em-slightly_smiling_face EmojiSpacing"></i>:' . '<span style="margin-left: 5%">' . $percenthappy . '</span>' . '%';
  echo '<br>';
  echo '<i class="em em-weary EmojiSpacing" style="margin-left:15%"></i> <i class="em em-cry EmojiSpacing"></i> <i class="em em-slightly_frowning_face EmojiSpacing"></i>:' . '<span style="margin-left: 5%">' . $percentsad . '</span>' . '%';
  echo '<br>';
  echo '<i class="em em-persevere EmojiSpacing" style="margin-left:15%"></i> <i class="em em-grimacing EmojiSpacing"></i> <i class="em em-expressionless EmojiSpacing"></i>:' . '<span style="margin-left: 5%">' . $percentother . '</span>' . '%';
  echo '<br>';
  echo '<br>';
	*/
}

?>
