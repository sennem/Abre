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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	if($pagerestrictionsedit=="")
	{

?>

	<div class='fixed-action-btn buttonpin'>
		<?php
		echo "<a class='modal-addtopic btn-floating btn-large waves-effect waves-light' style='background-color:".getSiteColor()."' id='createtopic' data-courseid='$Course_ID' data-topicid='blank' data-topicstarttime='blank' data-topicestimatenumberofdays='blank' href='#curriculumtopic'><i class='large material-icons'>add</i></a>";
		echo "<div class='mdl-tooltip mdl-tooltip--left' for='createtopic'>Create Topic</div>";
		?>
	</div>

<?php
	
	}
	
?>
<script>
	
	$(function()
	{
		
    	$('.modal-addtopic').leanModal({
	    	in_duration: 0,
			out_duration: 0,
	    	ready: function() { $("#topic_title").focus(); }
	   	});
	   	
	   	
	   	
			$(document).off().on("click", ".modal-addtopic", function ()
			{
				$("#topicFiles").hide();
				$("#topicLoader").show();
			    var Course_ID = $(this).data('courseid');
			    $(".modal-content #courseID").val(Course_ID);
			    var Topic_ID = $(this).data('topicid');
			    $(".modal-content #topicID").val(Topic_ID);
			    var Topic_Title = $(this).data('topictitle');
			    $(".modal-content #topic_title").val(Topic_Title);
			    var Topic_Theme = $(this).data('topictheme');
			    $(".modal-content #topic_theme").val(Topic_Theme);
				var Topic_Start_Time = $(this).data('topicstarttime');
				var picker = $('.topic_starttime').pickadate('picker');
				picker.set('select', Topic_Start_Time);
				
				var Topic_Estimated_Number_Of_Days = $(this).data('topicestimatenumberofdays');
				$(".modal-content #topic_estimated_days").val(Topic_Estimated_Number_Of_Days);
				
				//Fill in files
				if(Topic_ID!="blank")
				{
					$("#topicFiles").load( "modules/<?php echo basename(__DIR__); ?>/topic_list_resources.php?topicid="+Topic_ID, function(){
						$("#topicLoader").hide();
						$( "#topicFiles" ).show();
					});
				}
				else
				{
					$("#topicLoader").hide();
					$( "#topicFiles" ).hide();
					
					$.ajax({
						type: 'POST',
						url: 'modules/<?php echo basename(__DIR__); ?>/topic_process.php',
						data: { courseID : Course_ID }
					})
					.done(function(response) {
						$("#content_holder").load( "modules/<?php echo basename(__DIR__); ?>/pacingguide.php?id="+response.courseid+"&topicid="+response.topicid, function(){
							mdlregister();
							$(".modal-content #topicID").val(response.topicid);
						});
					})
					
				}
			});
	   	
	   	
    	
  	});
  	
</script>