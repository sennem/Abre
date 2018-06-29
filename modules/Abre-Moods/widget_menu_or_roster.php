<?php

//--------------
echo "<hr class='widget_hr'>";
echo "<div class='widget_holder'>";
  echo "<div class='widget_container widget_body' style='color:#666;'>Go Back<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>arrow_back</i></div>";
  //echo '---';
  //echo $widgetchoice;
  //echo '---';

echo "</div>";
//--------------

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

<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		<style>
			.EmojiSpacing
			{
				margin-left:10%;
				margin-top:5%;
				margin-bottom:5%
			}
			.EmojiSpacingLeft
			{
				margin-left:25%;
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

		<script>
			function testfunc(emojivalue)
			{
				alert("Respone submitted");
				window.location.assign("http://localhost:8080/modules/Abre-Moods/db_submission.php?moodval=" + emojivalue + "&widget=" + 1);
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

  echo '<br>';
?>
