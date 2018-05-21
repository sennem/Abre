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
    require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
    require_once('permissions.php');

    if($pagerestrictions == ""){
      $code = $_GET["code"];
      $id = $_GET["id"];

      echo "<div class='page_container' style='text-align:center;'>";

        $sql = "SELECT StudentID, student_email FROM guide_activity LEFT JOIN Abre_AD ON guide_activity.student_email = Abre_AD.Email WHERE guide_activity.activity_code = '$code' AND guide_activity.ID = '$id' LIMIT 1";
        $query = $db->query($sql);
        $return = $query->fetch_assoc();

        $studentEmail = $return["student_email"];
        $Student_ID = htmlspecialchars($return["StudentID"], ENT_QUOTES);

        $sql = "SELECT FirstName, LastName, SchoolName FROM Abre_Students WHERE StudentId = '$Student_ID'";
        $query = $db->query($sql);
        $result = $query->fetch_assoc();

        $Student_FirstName = htmlspecialchars($result["FirstName"], ENT_QUOTES);
        $Student_LastName = htmlspecialchars($result["LastName"], ENT_QUOTES);
        $SchoolName = htmlspecialchars($result  ["SchoolName"], ENT_QUOTES);
        $StudentPicture = "/modules/".basename(__DIR__)."/image.php?student=$Student_ID";

        echo "<div class='mdl_card mdl-shadow--2dp' style='background-color:#fff; padding:30px 35px 15px 35px;'>";

          //Student Info
          echo "<div class='center-align'><img src='$StudentPicture' class='circle' style='width:100px; height:100px;'></div>";
          if($Student_FirstName != ""){
            echo "<h4 class='center-align'>$Student_FirstName $Student_LastName</h4>";
          }else{
            echo "<h4 class='center-align'>$studentEmail</h4>";
          }
          echo "<p class='center-align'>";
            if($SchoolName != ""){
              echo "$SchoolName<br>";
            }
            if($Student_ID != ""){
              echo "ID: <span id='studentid'>$Student_ID</span>";
            }
          echo "</p>";

          //table of internet history
          echo "<div id='tableHolder'></div>";
        echo "</div>";
      echo "</div>";
    }

?>

<script>

  $(function() {

    //load in table of web activity
    $.post( "modules/<?php echo basename(__DIR__); ?>/activitydetails.php", { id: <?php echo $id ?> })
    .done(function(data){
      $( "#tableHolder" ).html(data);
    });

    //when clicking pagination button reload table with next page's results
    $('#tableHolder').off('.pagebutton').on('click', '.pagebutton', function(){
      event.preventDefault();
      $('.mdl-layout__content').animate({scrollTop:0}, 0);
      var CurrentPage = $(this).data('page');
      $.post( "modules/<?php echo basename(__DIR__); ?>/activitydetails.php", { id: <?php echo $id ?>, page: CurrentPage })
      .done(function(data){
        $("#tableHolder").html(data);
      });
    });

    //on refresh click update student activity results and stay on same page
    $(document).unbind().on("click", ".refresh_studentHistory", function(){
      $("#loader").show();
      var CurrentPage = $(this).data('pagenumber');
      $.post( "modules/<?php echo basename(__DIR__); ?>/activitydetails.php", { id: <?php echo $id ?>, page: CurrentPage })
      .done(function(data){
        $("#loader").hide();
        $( "#tableHolder" ).html(data);
    });
  });

  });

</script>