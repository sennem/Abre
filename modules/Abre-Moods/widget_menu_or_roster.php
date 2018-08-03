<?php
require(dirname(__FILE__) . '/../../configuration.php');
require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
require_once('functions.php');
require('permissions.php');
$pagerestrictions="staff";
//if($_SESSION['usertype'] == "staff")
if ($pagerestrictions=="student")
{
  //--------------
  echo "<hr class='widget_hr'>";
  echo "<div class='widget_holder'>";
    echo "<div class='widget_container widget_body' style='color:#666;'>Go Back<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>arrow_back</i></div>";
  echo "</div>";
  //--------------

  $con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $email = $_SESSION['useremail'];
  $studentid=1; //HARDCODED STUDENT ID
  $sql="SELECT Feeling FROM mood_table mt1 WHERE mt1.StudentID = '$studentid' AND mt1.ID = (SELECT MAX(mt2.ID) FROM mood_table mt2 WHERE mt2.StudentID = mt1.StudentID)";
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
  				margin-bottom:5%;
          font-size: 150%;
  			}
  			.EmojiSpacingLeft
  			{
  				margin-left:22%;
          font-size: 150%;
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
  			function alterdisp(emojival) //makes the black border ring around selected mood
  			{
  				var emojivalue3 = emojival;
  				if (emojivalue3==0)
  				{
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

  			function resetdisp() //gets rid of the black border ring around selected mood
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

        function submitandupdate(emojivalue) //logs the user's new mood selection and refreshes/updates the GUI
  			{
  				alert("Respone submitted");submitandupdate
          var studentid="<?php echo $studentid; ?>";
          $(document).ready(function(){
              $.post( "/modules/Abre-Moods/mood_table_submission.php", { moodval: emojivalue, stuid: studentid})
                .done(function( data ) {
                  resetdisp();
                  alterdisp(emojivalue);
              });
          });
        }
  		</script>


  	</header>
  </html>

  <script type="text/javascript">
  //getting the most recent mood selection and sending it as adparam to alterdisp function to "highlight" it on GUI
    var adparam=("<?php echo $rows[0]; ?>");
    alterdisp(adparam);
  </script>

  <?php

      //the mood menu
  		echo '
  		<div>
  			<ul>
  				<li>
  				<i id="emojizero" class="em em-laughing EmojiSpacingLeft" onclick="submitandupdate(0)"></i>
  				<i id="emojione" class="em em-smiley EmojiSpacing" onclick="submitandupdate(1)"></i>
  				<i id="emojitwo" class="em em-slightly_smiling_face EmojiSpacing" onclick="submitandupdate(2)"></i>
  			</li>
  			<li>
  				<i id="emojithree" class="em em-weary EmojiSpacingLeft" onclick="submitandupdate(3)"></i>
  				<i id="emojifour" class="em em-cry EmojiSpacing" onclick="submitandupdate(4)"></i>
  				<i id="emojifive" class="em em-slightly_frowning_face EmojiSpacing" onclick="submitandupdate(5)"></i>
  			</li>
  			<li>
  				<i id="emojisix" class="em em-persevere EmojiSpacingLeft" onclick="submitandupdate(6)"></i>
  				<i id="emojiseven" class="em em-grimacing EmojiSpacing" onclick="submitandupdate(7)"></i>
  				<i id="emojieight" class="em em-expressionless EmojiSpacing" onclick="submitandupdate(8)"></i>
  				</li>
  			</ul>
  		</div>';


  ?>


  <?php
    $email = $_SESSION['useremail'];
  	$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);
    //get the date from most recent entry of a certain student
    //alter this to work with studentid instead of email
  	$sql="SELECT * FROM mood_table mt1 WHERE mt1.Email = '$email' AND mt1.Daterow = (SELECT MAX(mt2.Daterow) FROM mood_table mt2 WHERE mt2.Email = mt1.Email)";
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
  	$dbdate = DateTime::createFromFormat('Y-m-d', $maxdate);
  	date_default_timezone_set('America/Indiana/Indianapolis');
  	$getdate = date('Y-m-d');//works
  	$cdate = DateTime::createFromFormat('Y-m-d', $getdate);

  	if (($dbdate->format('d')) != ($cdate->format('d')))
  	{
  		//not the same day (erase "highlight" on menu)
  		echo '<script type="text/javascript">',
  		'resetdisp();',
  		'</script>'
  		;
  	}
  	elseif ((($dbdate->format('d')) == ($cdate->format('d'))) && (($dbdate->format('m')) != ($cdate->format('m'))))
  	{
  		//same day but different month (erase "highlight" on menu)
  		echo '<script type="text/javascript">',
  		'resetdisp();',
  		'</script>'
  		;
  	}

    echo '<br>';

}
else
{
  ?>

  <html>
  	<head>
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
        }
        .w_img{
          border-radius: 50%;
    			height: 50px;
    			width: auto;
          margin-right: 10px;
        }
  		</style>
      <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	</head>
  </html>


  <hr class='widget_hr'>
  <div class='widget_holder'>
    <div class='widget_container widget_body' style='color:#666;'>Go Back<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>arrow_back</i></div>
  </div>

  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <select class="mdl-textfield__input" id="SelPeriod" name="Period">
      <option>*select a period*</option>
      <option value="1">Period 1</option>
      <option value="2">Period 2</option>
      <option value="3">Period 3</option>
      <option value="4">Period 4</option>
      <option value="5">Period 5</option>
      <option value="6">Period 6</option>
      <option value="7">Period 7</option>
    </select>
  </div>
  <br />
  <div id="rosterdiv" ></div>

  <script type="text/javascript">
  $(document).ready(function(){
      $("#SelPeriod").change(function(){
        var periodnumj=document.getElementById("SelPeriod").value;
        var emailj= "<?php echo $email; ?>";
        var roomnumj= "<?php echo $roomnum; ?>";
        var location=1;
        var id=109; //HARDCODED STAFF ID
        $.post( "/modules/Abre-Moods/mood_data_retrieval_and_output.php", {locationid: location, periodsel: periodnumj, staffid: id})
          .done(function( data ) {
            $("#rosterdiv").html(data);
        });
    });
  });

  </script>


<?php
}
?>
