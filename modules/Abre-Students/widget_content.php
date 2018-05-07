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
  require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	if($_SESSION['usertype'] == 'parent'){

    $authStudentArray = explode(",", $_SESSION['auth_students']);

    if(empty($authStudentArray)){
      echo "<hr class='widget_hr'>";
      echo "<div class='widget_holder pointer'>";
        echo "<div class='widget_container widget_body truncate' style='color:#666;'>No Authorized Students <i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Students/widget_content.php' data-reload='true'>refresh</i></div>";
      echo "</div>";
    }else{
      echo "<hr class='widget_hr'>";
      echo "<div class='widget_holder'>";
        echo "<div class='widget_container widget_body' style='color:#666;'>Your Authorized Students <i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Students/widget_content.php' data-reload='true'>refresh</i></div>";
      echo "</div>";

      if($db->query("SELECT * FROM Abre_Students LIMIT 1")){
        foreach($authStudentArray as $studentID){
          $sql = "SELECT FirstName, LastName FROM Abre_Students WHERE StudentId = '$studentID' LIMIT 1";
          $query = $db->query($sql);
          $row = $query->fetch_assoc();

          $firstName = $row['FirstName'];
          $lastName = $row['LastName'];
          $link = $portal_root .'/#mystudents/'.$studentID;

          echo "<hr class='widget_hr'>";
            echo "<div class='widget_holder widget_holder_link pointer' data-link='$link' data-reload='false'>";
            echo "<div class='widget_container widget_heading_h1 truncate'>$firstName $lastName</div>";
          echo "</div>";
        }
      }
      $db->close();
    }
	}

?>