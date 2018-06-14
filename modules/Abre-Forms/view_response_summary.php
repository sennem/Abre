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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('../../core/abre_functions.php');
	require_once('functions.php');


  if(isset($_GET['id'])){ $formid = $_GET['id']; }else{ $formid = ""; }

	if(($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator()) && (hasEditAccess($formid) || hasResponseAccess($formid))){
	  $sql = "SELECT FormFields FROM forms WHERE ID = $formid";
	  $query = $db->query($sql);
	  $row = $query->fetch_assoc();
	  $formFieldsJSON = $row['FormFields'];
	  $formFieldsArray = json_decode($formFieldsJSON, true);

	  $resultsSummaryArray = array();
	  $sql = "SELECT Response FROM forms_responses WHERE FormID = $formid";
	  $query = $db->query($sql);
	  while($row = $query->fetch_assoc()){
	    $resultsJSON = $row["Response"];
	    $resultsArray = json_decode($resultsJSON, true);
	    foreach($resultsArray as $key => $value){
	      $index = "";
	      $keyOriginal = $key;
	      if(strpos($key, '[]') !== false){
	        $key = str_replace("[]", "", $key);
	      }

	      $index = array_search($key, array_column($formFieldsArray, 'name'));
	      switch ($formFieldsArray[$index]["type"]){
					case "textarea":
					case "radio-group":
					case "select":
	        case "text":
	            if(array_key_exists($keyOriginal, $resultsSummaryArray)){
	              if(array_key_exists($value, $resultsSummaryArray[$keyOriginal])){
	                $resultsSummaryArray[$keyOriginal][$value]++;
	              }else{
	                $resultsSummaryArray[$keyOriginal][$value] = 1;
	              }
	              $resultsSummaryArray[$keyOriginal]["totalAnswers"]++;
	            }else{
	              $resultsSummaryArray[$keyOriginal] = array();
	              $resultsSummaryArray[$keyOriginal]["type"] = $formFieldsArray[$index]["type"];
	              $resultsSummaryArray[$keyOriginal][$value] = 1;
	              $resultsSummaryArray[$keyOriginal]["totalAnswers"] = 1;
	            }
	            break;
	        case "checkbox-group":
	            if(array_key_exists($keyOriginal, $resultsSummaryArray)){
	              if(gettype($value) == "string"){
	                if(array_key_exists($value, $resultsSummaryArray[$keyOriginal])){
	                  $resultsSummaryArray[$keyOriginal][$value]++;
	                }else{
	                  $resultsSummaryArray[$keyOriginal][$value] = 1;
	                }
	                $resultsSummaryArray[$keyOriginal]["totalAnswers"]++;
	              }else{
	                //its an array
	                foreach($value as $response){
	                  if(array_key_exists($response, $resultsSummaryArray[$keyOriginal])){
	                    $resultsSummaryArray[$keyOriginal][$response]++;
	                  }else{
	                    $resultsSummaryArray[$keyOriginal][$response] = 1;
	                  }
	                }
									$resultsSummaryArray[$keyOriginal]["totalAnswers"]++;
	              }
	            }else{
	              $resultsSummaryArray[$keyOriginal] = array();
	              $resultsSummaryArray[$keyOriginal]["totalAnswers"] = 0;
	              if(gettype($value) == "string"){
	                $resultsSummaryArray[$keyOriginal][$value] = 1;
	                $resultsSummaryArray[$keyOriginal]["totalAnswers"]++;
	              }else{
	                foreach($value as $response){
	                  $resultsSummaryArray[$keyOriginal][$response] = 1;
	                }
									$resultsSummaryArray[$keyOriginal]["totalAnswers"]++;
	              }
	              $resultsSummaryArray[$keyOriginal]["type"] = $formFieldsArray[$index]["type"];
	            }
	            break;
	      }
	    }
	  }

		if(!empty($formFieldsArray)){
		  echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='max-width: 750px;'>";
		    echo "<div class='page'>";
		      foreach($formFieldsArray as $element){
		        if($element["type"] == "text" || $element["type"] == "textarea" || $element["type"] == "select" || $element["type"] == "radio-group" || $element["type"] == "checkbox-group"){
		          if($element["type"] == "checkbox-group"){
		            $id = $element['name']."[]";
		          }else{
		            $id = $element['name'];
		          }

		          echo "<div class='row'>";
		            echo "<div class='col s12'>";
		              echo "<h5>".$element['label']."</h5>";
		              if(isset($resultsSummaryArray[$id]['totalAnswers'])){
		                echo "<p>".$resultsSummaryArray[$id]['totalAnswers']." Responses</p>";
		              }else{
		                echo "<p>0 Responses</p>";
		              }
		            echo "</div>";
		          echo "</div>";
		          echo "<div class='row'>";
		            echo "<div class='col s12'>";
		            if(!isset($resultsSummaryArray[$id]['totalAnswers'])){
		              echo "<p style='font-size:16px; margin-left: 24px;'>No responses yet for this question.</p>";
		            }else{
		              if($element["type"] == "select" || $element["type"] == "radio-group"){
		                echo "<canvas id='".$id."' style='max-width:400px; max-height:400px; display:block; margin-left:auto; margin-right:auto;'></canvas>";
		              }else if($element["type"] == "textarea"){
		                echo "<table id='".$id."' class='striped'>";
		                  echo "<tbody id='".$id."Body'>";
		                  echo "</tbody>";
		                echo "</table>";
		              }else{
		                echo "<canvas id='".$id."' style='max-width:600px; max-height: 500px; display:block; margin-left:auto; margin-right:auto;'></canvas>";
		              }
		            }
		            echo "</div>";
		          echo "</div>";
		        }
		        if(isset($id) && isset($resultsSummaryArray[$id]['totalAnswers'])){
							unset($resultsSummaryArray[$id]['totalAnswers']);
						}
		      }
		    echo "</div>";
		  echo "</div>";
		}else{
			echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Form Questions</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Details about form responses will be shown here.</p></div>";
		}

		$resultsSummaryJSON = json_encode($resultsSummaryArray);
	}else{
		echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>You Do Not Have Response Access</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Please request access from the form owner.</p></div>";
	}
?>

<script>

  $(function(){

    function getSum(total, num) {
      return total + num;
    }

    var resultsSummaryArray = <?php echo $resultsSummaryJSON ?>;
    Chart.defaults.global.plugins.datalabels.color = "#fff";

    for(var name in resultsSummaryArray){
      var labels = [];
      var data = [];
      var backgroundColor = [];
      var borderColor = [];
      var highestValue = 0;
      switch (resultsSummaryArray[name]["type"]){
        case "text":
            for(var key in resultsSummaryArray[name]){
              if(key == "type"){ continue; }
              labels.push(key);
              if(resultsSummaryArray[name][key] > highestValue){
                highestValue = resultsSummaryArray[name][key];
              }
              data.push(resultsSummaryArray[name][key]);
              backgroundColor.push("<?php echo getSiteColor() ?>");
              borderColor.push("<?php echo getSiteColor() ?>");
            }

            var ctx = document.getElementById(name).getContext('2d');
            var myBarChart = new Chart(ctx, {
              type: 'bar',

              data: {
                  labels: labels,
                  datasets: [{
                    label: 'Number of Responses',
                    data: data,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                  }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                },
                plugins: {
                  datalabels: {
                    formatter: function(value, context) {
                      return ((value/context.dataset.data.reduce(getSum))*100).toFixed(1) + '%';
                    }
                  }
                }
              }
            });
            break;
        case "textarea":
            for(var key in resultsSummaryArray[name]){
              if(key == "type"){ continue; }
              if(resultsSummaryArray[name][key] > 1){
                $("#"+name+"Body").append("<tr><td style='padding: 8px 16px;'>"+key+" ("+resultsSummaryArray[name][key]+")</td></tr>");
              }else{
                $("#"+name+"Body").append("<tr><td style='padding: 8px 16px;'>"+key+"</td></tr>");
              }
            }
            break;
        case "checkbox-group":
            for(var key in resultsSummaryArray[name]){
              if(key == "type"){ continue; }
              labels.push(key);
              if(resultsSummaryArray[name][key] > highestValue){
                highestValue = resultsSummaryArray[name][key];
              }
              data.push(resultsSummaryArray[name][key]);
              backgroundColor.push("<?php echo getSiteColor() ?>");
              borderColor.push("<?php echo getSiteColor() ?>");
            }

            var ctx = document.getElementById(name).getContext('2d');
            var myHorizontalBarChart = new Chart(ctx, {
              type: 'horizontalBar',

              data: {
                  labels: labels,
                  datasets: [{
                    label: 'Number of Responses',
                    data: data,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                  }]
              },
              options: {
                scales: {
                  xAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                },
                plugins: {
                  datalabels: {
                    formatter: function(value, context) {
                      return ((value/context.dataset.data.reduce(getSum))*100).toFixed(1) + '%';
                    }
                  }
                }
              }
            });
            break;
        case "radio-group":
            backgroundColor = ["#F44336", "#9C27B0", "#2196F3", "#4CAF50", "#FF9800", "#607D8B", "#B71C1C", "#4A148C", "#0D47A1", "#1B5E20", "#E65100", "#263238"];
            borderColor = ["#F44336", "#9C27B0", "#2196F3", "#4CAF50", "#FF9800", "#607D8B", "#B71C1C", "#4A148C", "#0D47A1", "#1B5E20", "#E65100", "#263238"];
            for(var key in resultsSummaryArray[name]){
              if(key == "type"){ continue; }
              labels.push(key);
              if(resultsSummaryArray[name][key] > highestValue){
                highestValue = resultsSummaryArray[name][key];
              }
              data.push(resultsSummaryArray[name][key]);
            }

            var ctx = document.getElementById(name).getContext('2d');
            var myPieChart = new Chart(ctx, {
              type: 'pie',

              data: {
                  labels: labels,
                  datasets: [{
                    label: 'Number of Responses',
                    data: data,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                  }]
              },
              options: {
                legend: {
                  position: 'right'
                },
                plugins: {
                  datalabels: {
                    formatter: function(value, context) {
                      return ((value/context.dataset.data.reduce(getSum))*100).toFixed(1) + '%';
                    }
                  }
                }
              }
            });
            break;
        case "select":
            backgroundColor = ["#F44336", "#9C27B0", "#2196F3", "#4CAF50", "#FF9800", "#607D8B", "#B71C1C", "#4A148C", "#0D47A1", "#1B5E20", "#E65100", "#263238"];
            borderColor = ["#F44336", "#9C27B0", "#2196F3", "#4CAF50", "#FF9800", "#607D8B", "#B71C1C", "#4A148C", "#0D47A1", "#1B5E20", "#E65100", "#263238"];
            for(var key in resultsSummaryArray[name]){
              if(key == "type"){ continue; }
              labels.push(key);
              if(resultsSummaryArray[name][key] > highestValue){
                highestValue = resultsSummaryArray[name][key];
              }
              data.push(resultsSummaryArray[name][key]);
            }

            var ctx = document.getElementById(name).getContext('2d');
            var myPieChart = new Chart(ctx, {
              type: 'pie',

              data: {
                  labels: labels,
                  datasets: [{
                    label: 'Number of Responses',
                    data: data,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                  }]
              },
              options: {
                legend: {
                  position: 'right'
                },
                plugins: {
                  datalabels: {
                    formatter: function(value, context) {
                      return ((value/context.dataset.data.reduce(getSum))*100).toFixed(1) + '%';
                    }
                  }
                }
              }
            });
            break;
      }
    }

  });
</script>
