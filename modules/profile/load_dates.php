<?php
/*
* Copyright 2015 Hamilton City School District
*
* This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.
*
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
*
  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <http://www.gnu.org/licenses/>.
  */

  require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
  require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

  $date = $_POST["year"];
  $email = $_POST["email"];

  if($_SESSION['usertype']!="student")
  {
    $sql = "SELECT * FROM profiles where email='$email'";
    $dbreturn = databasequery($sql);
    foreach ($dbreturn as $row)
    {
      $work_calendar_saved= $row['work_calendar'];
      if($work_calendar_saved != NULL)
      {
        $work_calendar_saved = json_decode($work_calendar_saved, TRUE);

        if(gettype($work_calendar_saved) == 'string'){

          $dates = str_replace("'", "", $work_calendar_saved);
          $dates = str_replace(' ', '', $dates);
          $dates=explode(",", $dates);

          $message = array("addDates"=>$dates);
          header("Content-Type: application/json");
          echo json_encode($message);

        }else{

          $dates = $work_calendar_saved[$date];

          if($dates == NULL){

            $message = array("addDates"=>'', "jsonDates"=>$work_calendar_saved);
            header("Content-Type: application/json");
            echo json_encode($message);

          }else{

            $dates = str_replace(' ', '', $dates);
            $dates=explode(",", $dates);

            $message = array("addDates"=>$dates, "jsonDates"=>$work_calendar_saved);
            header("Content-Type: application/json");
            echo json_encode($message);

          }
        }
      }else{

        //this code can be used to enable default dates if no data is stored in the database
        //this code is not used, but leaving here incase we change design decisions

        // include "calendar_default_dates.php";
        // $work_calendar_saved = json_decode($work_calendar_saved, TRUE);
        // $dates = $work_calendar_saved[$date];
        // $dates = str_replace(' ', '', $dates);
        // $dates=explode(",", $dates);

        $message = array("addDates"=>'');
        header("Content-Type: application/json");
        echo json_encode($message);

      }
    }
  }
?>
