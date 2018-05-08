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
    $id = $_POST["id"];
    if(isset($_POST["page"])){
      if($_POST["page"] == ""){
        $PageNumber = 1;
      }else{
        $PageNumber = $_POST["page"];
      }
    }else{
      $PageNumber = 1;
    }

    $PerPage = 10;

    $LowerBound = $PerPage * ($PageNumber - 1);
    $UpperBound = $PerPage * $PageNumber;

    $sql = "SELECT history FROM guide_activity WHERE ID='$id'";
    $query = $db->query($sql);
    $result = $query->fetch_assoc();

    $historyArray = json_decode($result["history"], true);

    //refresh activity button that we want to show regardless
    echo "<div class='row'>";
      echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect refresh_studentHistory' data-pagenumber='$PageNumber' style='background-color:".getSiteColor()."; color:#fff;'>Refresh Activity</a>";
    echo "</div>";

    //only show table of activity if the array of history is larger 0 (not empty)
    $arraySize = sizeof($historyArray);
    if($arraySize > 0){
      echo "<table class='tablesorter bordered center-align'>";
        echo "<tr>";
          echo "<th>Website Title</th>";
          echo "<th>Last Visit Time</th>";
        echo "</tr>";

        date_default_timezone_set('EST');
        for($i = $LowerBound; $i < $UpperBound; $i++){
          if($i >= $arraySize){
            break;
          }
          $website = "";
          $title = "";
          $url = "";
          $formattedDate = "";
          $website = $historyArray[$i];

          if(isset($website['title']) && $website['title'] != ""){
            $title = $website['title'];
          }else{
            $title = substr($website['url'], 0, 100);
          }

          $url = $website['url'];
          $lastVisitTime = $website['lastVisitTime'] / 1000;
          if($lastVisitTime < strtotime('-7 days')){
            $formattedDate = date( "F j", $lastVisitTime)." at ".date("g:i A", $lastVisitTime);
          }else{
            $formattedDate = date( "l", $lastVisitTime)." at ".date("g:i A", $lastVisitTime);
          }

          echo "<tr>";
            echo "<td><a href='$url' style='color:".getSiteColor().";' target=_blank>$title</td>";
            echo "<td>$formattedDate</td>";
          echo "</tr>";
        }
      echo "</table>";

      $totalpossibleresults = count($historyArray);

      //Paging
      $totalpages = ceil($totalpossibleresults / $PerPage);
      if($totalpossibleresults > $PerPage){
        $previouspage = $PageNumber-1;
        $nextpage = $PageNumber+1;
        if($PageNumber > 5){
          if($totalpages > $PageNumber + 5){
            $pagingstart = $PageNumber - 5;
            $pagingend = $PageNumber + 5;
          }else{
            $pagingstart = $PageNumber - 5;
            $pagingend = $totalpages;
          }
        }else{
          if($totalpages >= 10){ $pagingstart = 1; $pagingend = 10; }else{ $pagingstart = 1; $pagingend = $totalpages; }
        }

        echo "<div class='row'><br>";
        echo "<ul class='pagination center-align'>";
          if($PageNumber != 1){ echo "<li class='pagebutton' data-page='$previouspage'><a href='#'><i class='material-icons'>chevron_left</i></a></li>"; }
          for($x = $pagingstart; $x <= $pagingend; $x++){
            if($PageNumber == $x){
              echo "<li class='active pagebutton' style='background-color: ".getSiteColor().";' data-page='$x'><a href='#'>$x</a></li>";
            }else{
              echo "<li class='waves-effect pagebutton' data-page='$x'><a href='#'>$x</a></li>";
            }
          }
          if($PageNumber != $totalpages){ echo "<li class='waves-effect pagebutton' data-page='$nextpage'><a href='#'><i class='material-icons'>chevron_right</i></a></li>"; }
        echo "</ul>";
        echo "</div>";
      }
    }else{
      //show the no activity text.
      echo "<div style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Browsing History</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Students browsing history will populate here when it becomes available.</p></div>";
    }
  }

?>

<script>

  $(function(){

  });

</script>