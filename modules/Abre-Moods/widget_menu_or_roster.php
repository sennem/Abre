<?php
$pagerestrictions=="student";
if ($pagerestrictions=="staff")
{
  //--------------
  echo "<hr class='widget_hr'>";
  echo "<div class='widget_holder'>";
    echo "<div class='widget_container widget_body' style='color:#666;'>Go Back<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>arrow_back</i></div>";
    //echo '---';
    //echo $widgetchoice;
    //echo '---';

  echo "</div>";
  //--------------

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

    echo '<br>';

}
else
{
  require("get_mood_data.php");
  ?>

  <html>
  	<head>
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
        tr
        {
          border-bottom: 5px solid DeepSkyBlue;
          /*the color thing is messing up, wont change from what it is (it's not even DeepSkyBlue)*/
        }
  		</style>
  	</head>
  </html>

  <?php
  echo '<script type="text/javascript">',
	'setperiod();',
	'</script>'
	;

  echo "<hr class='widget_hr'>";
  echo "<div class='widget_holder'>";
    echo "<div class='widget_container widget_body' style='color:#666;'>Go Back<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>arrow_back</i></div>";
  echo "</div>";

  echo'<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <select class="mdl-textfield__input" id="Period" name="Period" onchange="changeperiod()">
      <option></option>
      <option value="1">Period 1</option>
      <option value="2">Period 2</option>
      <option value="3">Period 3</option>
      <option value="4">Period 4</option>
      <option value="5">Period 5</option>
      <option value="6">Period 6</option>
      <option value="7">Period 7</option>
    </select>
  </div>';

  echo "<br />";
  $numstudents = count($arrfnameresults);
  $numstudents--;
  $counter=0;
  echo "<div style='margin-left: 30px;'>";
  echo "<table style='width:80%'>";
  while($counter<=$numstudents)
  {
    if($arrmoodresults[$counter]==0)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;' />" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-laughing EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==1)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-smiley EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==2)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-slightly_smiling_face EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==3)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-weary EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==4)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-cry EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==5)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-slightly_frowning_face EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==6)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-persevere EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==7)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-grimacing EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }
    if($arrmoodresults[$counter]==8)
    {
      echo "<tr>" . "<td>". "<img src='" . $arrpicresults[$counter] . "' width='35' height='35' style='border-radius: 50%;'/>" . "</td>" . "<td>" . $arrfnameresults[$counter] . '</td>' . ' ' . '<td>' . $arrlnameresults[$counter] . '</td>' . '<td>' . '<span style="margin-left: 15%">-</span>' . '</td>' . '<td style="text-align: right">' . '<i class="em em-slightly_frowning_face EmojiSpacing" ></i>' . '</td>' . '</tr>';
    }

    //echo "<br />";


    $counter++;
  }
  echo "</table>";
  echo "</div>";
}
?>
