<?php

  /*
  * Copyright (C) 2016-2017 Abre.io LLC
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
    require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
    require_once('permissions.php');

    if($pagerestrictions == ""){
      $code = $_GET["code"];
      $sql = "SELECT guide_activity.ID, student_email, history, active, Abre_AD.StudentID FROM guide_activity LEFT JOIN Abre_AD ON guide_activity.student_email = Abre_AD.Email WHERE activity_code = $code";
      $dbreturn = databasequery($sql);
      $count = count($dbreturn);

      foreach($dbreturn as $value){
        $active = $value["active"];
        $id = $value["ID"];
        $studentEmail = $value["student_email"];
        $historyJSON = $value["history"];
        $historyArray = json_decode($historyJSON, true);
        $Student_ID = htmlspecialchars($value["StudentID"], ENT_QUOTES);

        $sql = "SELECT FirstName, LastName, SchoolName FROM Abre_Students WHERE StudentId = '$Student_ID'";
        $query = $db->query($sql);
        $result = $query->fetch_assoc();

        $Student_FirstName = htmlspecialchars($result["FirstName"], ENT_QUOTES);
        $Student_LastName = htmlspecialchars($result["LastName"], ENT_QUOTES);
        $SchoolName = htmlspecialchars($result["SchoolName"], ENT_QUOTES);
        $StudentPicture = "/modules/".basename(__DIR__)."/image.php?student=$Student_ID";

          echo "<div class='mdl-card mdl-shadow--2dp card_stream' style='background-color:#fff; padding:30px 35px 15px 35px; float:left;'>";

            //Name
            echo "<div class='center-align'><img src='$StudentPicture' class='circle' style='width:100px; height:100px;'></div>";
            if($Student_FirstName != ""){
              echo "<h4 class='center-align'>$Student_FirstName $Student_LastName</h4>";
            }else{
              echo "<h4 class='center-align'>$studentEmail</h4>";
            }
            echo "<p class='center-align'>";
              if($SchoolName != ""){
                echo "$SchoolName<br>";
              }else{
                echo "No School Provided<br>";
              }
              if($Student_ID != ""){
                echo "ID: <span id='studentid'>$Student_ID</span>";
              }else{
                echo "No Student ID";
              }
            echo "</p>";

            echo "<div class='mdl-card__actions'>";
              echo "<a style='position:relative; color:".getSiteColor()."; float:left; font-size: 16px;' href='#guide/users/$code/$id'>Web Activity</a>";

              echo "<div class='mdl-layout-spacer'></div>";

              if($active == 0){
                echo "<i class='material-icons' style='float:right; padding-right:5px; position:relative; top:-2px;'>panorama_fish_eye</i>";
              }else{
                echo "<i class='material-icons' style='color:green; float:right; top:-2px;'>brightness_1</i>";
              }
              echo "</div>";

          echo "</div>";
      }

      echo "<div class='row center-align' id='noLessonActivityButton' style='display:none;'>";
        echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Lesson Activity</span><br><p style='font-size:16px; margin:20px 0 0 0;'>After students use your code with the Guided Learning Extension you will see usage details here.</p></div>";
        echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect refresh_activity' data-code='$code' style='background-color:".getSiteColor()."; color:#fff;'>Refresh Lesson Activity</a>";
      echo "</div>";
    }
?>

<script>

  $(function(){

    var count = <?php echo $count; ?>;

    if(count != 0){
      $("#lessonRefresh").show();
    }else{
      $("#noLessonActivityButton").show();
    }

  });

</script>