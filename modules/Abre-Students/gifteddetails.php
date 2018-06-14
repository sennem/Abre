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
require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
require_once('permissions.php');

if($pagerestrictions == ""){

  $studentID = $_GET['studentID'];

  $giftedCategories = array();
  $giftedCategories["Superior Cognitive Ability"] = "cognitive";
  $giftedCategories["Specific Academic Ability - Math"] = "math";
  $giftedCategories["Specific Academic Ability - Science"] = "science";
  $giftedCategories["Specific Academic Ability - Reading/Writing"] = "readingWriting";
  $giftedCategories["Specific Academic Ability - Social Studies"] = "socialStudies";
  $giftedCategories["Creative Thinking Ability"] = "creativeThinking";
  $giftedCategories["Visual/Performing Arts"] = "visualPerArts";

  if($db->query("SELECT * FROM Abre_Gifted LIMIT 1")){
    $sql = "SELECT * FROM Abre_Gifted WHERE StudentID = '$studentID'";
    $query = $db->query($sql);
    $count = $query->num_rows;
    if($count > 0){
      echo "<table class='bordered' id='giftedTable'>";
      $result = $query->fetch_assoc();

      $cognitiveScreening = $result['Cognitive_Screening'];
      $cognitiveAssessment = $result['Cognitive_Assessment'];
      $cognitiveServed = $result['Cognitive_Served'];
      $cognitiveIdentified = $result['Cognitive_Identified'];

      $creativeThinkingScreening = $result['CreativeThinking_Screening'];
      $creativeThinkingAssessment = $result['CreativeThinking_Assessment'];
      $creativeThinkingServed = $result['CreativeThinking_Served'];
      $creativeThinkingIdentified = $result['CreativeThinking_Identified'];

      $mathScreening = $result['Math_Screening'];
      $mathAssessment = $result['Math_Assessment'];
      $mathServed = $result['Math_Served'];
      $mathIdentified = $result['Math_Identified'];

      $readingWritingScreening = $result['ReadingWriting_Screening'];
      $readingWritingAssessment = $result['ReadingWriting_Assessment'];
      $readingWritingServed = $result['ReadingWriting_Served'];
      $readingWritingIdentified = $result['ReadingWriting_Identified'];

      $socialStudiesScreening = $result['SocialStudies_Screening'];
      $socialStudiesAssessment = $result['SocialStudies_Assessment'];
      $socialStudiesServed = $result['SocialStudies_Served'];
      $socialStudiesIdentified = $result['SocialStudies_Identified'];

      $scienceScreening = $result['Science_Screening'];
      $scienceAssessment = $result['Science_Assessment'];
      $scienceServed = $result['Science_Served'];
      $scienceIdentified = $result['Science_Identified'];

      $visualPerArtsScreening = $result['VisualPerfArts_Screening'];
      $visualPerArtsAssessment = $result['VisualPerfArts_Assessment'];
      $visualPerArtsServed = $result['VisualPerfArts_Served'];
      $visualPerArtsIdentified = $result['VisualPerfArts_Identified'];

        echo "<thead>";
          echo "<tr>";
            echo "<th></th>";
            echo "<th class='center-align'>Screening</th>";
            echo "<th class='center-align'>Assessment</th>";
            echo "<th class='center-align'>Identified</th>";
            echo "<th class='center-align hide-on-small-only'>Served</th>";
          echo "</tr>";
        echo "</thead>";
        foreach($giftedCategories as $key => $value){
          echo "<tr>";
            echo "<td>$key</td>";
            echo "<td>";
              if(${$value."Screening"} == "Y"){ echo "<div class='center-align'><i class='material-icons'>check</i></div>"; }
            echo "</td>";
            echo "<td>";
              if(${$value."Assessment"} == "Y"){ echo "<div class='center-align'><i class='material-icons'>check</i></div>"; }
            echo "</td>";
            echo "<td>";
              if(${$value."Identified"} == "Y"){ echo "<div class='center-align'><i class='material-icons'>check</i></div>"; }
            echo "</td>";
            echo "<td>";
              if(${$value."Served"} == "Y"){ echo "<div class='center-align hide-on-small-only'><i class='material-icons'>check</i></div>"; }
            echo "</td>";
          echo "</tr>";
        }
        echo "</tr>";
      echo "</table>";
    }else{
      echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Gifted Details Found</span><br><p style='font-size:16px; margin:20px 0 0 0;'></p></div>";
    }
  }else{
    echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Gifted Details Found</span><br><p style='font-size:16px; margin:20px 0 0 0;'></p></div>";
  }
}

?>