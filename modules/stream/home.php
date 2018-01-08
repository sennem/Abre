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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	//Display Stream and Widgets
	echo "<div class='row'>";
	
		//Stream
		echo "<div id='streamstream'>";
		
			//Display Stream Buttons
			require('stream_navigation.php');

			//Display Stream
			echo "<div id='streamcards'>";

				require('stream_all.php');
				
			echo "</div>";
			
			//Loader
			echo "<div style='clear:both; height:60px;'><div id='showmorestream' style='display:none; position:relative; top:50%; left:50%; margin-left:-20px;'>";
				echo "<div class='mdl-spinner mdl-js-spinner is-active'></div>";
			echo "</div></div>";
			
		echo "</div>";
		
		//Widget
		echo "<div id='streamwidgets'>";

			//Display Widgets
			require('widgets.php');
			
		echo "</div>";
		
	echo "</div>";
	
?>

<script>

	$(function(){
		
		//Variables
		var Page = "all";
		var StreamStart = 0;
		var StreamEnd = 20;
		var LoaderCheck = false;
			
		//Paging function	
		function streamPaging(start,end){
			
			$.get('modules/stream/stream_'+Page+'.php?StreamStartResult='+start+'&StreamEndResult='+end, function(results){
				$('#showmorestream').hide();
			    $('#streamcards').append(results);
			});
			
		}
		
		//Detect when at bottom of page
		$('.mdl-layout__content').on('scroll', function(){
			
			if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
				
				LoaderCheck = $('#showmorestream').is(":visible");
				
				if(LoaderCheck === false){
				    
				    $('#showmorestream').show();
				    StreamStart = StreamStart + 20;
					StreamEnd = StreamEnd + 20;
					streamPaging(StreamStart,StreamEnd);
					
				}
			         
			}
			
    	})
		
		function pageChange(Page){
			
			StreamStart = 0;
			StreamEnd = 20;
			
			$('#all, #likes, #comments').prop("disabled", false);
			$('#streamnavigationloader').show();
			$.get('modules/stream/stream_'+Page+'.php?StreamStartResult=0&StreamEndResult=20', function(results){
				$('#streamnavigationloader').hide();
			    $('#streamcards').html(results);
			});
			
		}
		
		//View All Streams
		$( "#all" ).unbind().click(function(){
			
			pageChange("all");
			Page = "all";
			$("#all").attr( "disabled", "disabled" );
			
		});
		
		//View Likes
		$("#likes").unbind().click(function(){
			
			pageChange("likes");
			Page = "likes";
			$("#likes").attr( "disabled", "disabled" );
			
		});
		
		//View Likes
		$("#comments").unbind().click(function(){
			
			pageChange("comments");
			Page = "comments";
			$("#comments").attr( "disabled", "disabled" );
			
		});

	});


</script>