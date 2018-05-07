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
	    
	    //Find the name of the lesson given the code
		$sql = "SELECT Title FROM guide_boards WHERE Code = $code";
	    $dbreturn = databasequery($sql);
	    foreach($dbreturn as $value){
		    
			$Title = $value["Title"];
		    
		}

		echo "<div class='page_container'>";
		
			//Title and Button
		    echo "<div class='row center-align'>";
		    
		    	//Lesson Title
				echo "<div class='col s12'>";
					echo "<h5>$Title</h5>";
					echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect refresh_activity' id='lessonRefresh' data-code='$code' style='background-color:".getSiteColor()."; color:#fff; display:none;'>Refresh Activity</a>";
			  	echo "</div>";
			  	
		    echo "</div>";
	
			//Activity
		    echo "<div id='activityContent'>";
				include "lessonactivity_content.php";
			echo "</div>";
			
	    echo "</div>";
	    
	}
    
?>

<script>

  $(function(){

    $(document).off().on("click", ".refresh_activity", function(){
      $("#loader").show();
      event.preventDefault();
      var code = $(this).data('code');
      $("#activityContent").load("modules/<?php echo basename(__DIR__); ?>/lessonactivity_content.php?code="+code, function(){
        $("#loader").hide();
      })
    });

  });



</script>