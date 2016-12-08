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

$(function()
{

	//Comment Modal
	$('.modal-addstreamcomment').leanModal({
		in_duration: 0,
		out_duration: 0,
		ready: function() { $("#streamComment").focus(); }
	});

	//Fill comment modal
	$(document).on("click", ".modal-addstreamcomment", function (event)
	{
		event.preventDefault();
		$("#commentloader").show();
		$("#streamComments").empty();
		var Stream_Title = $(this).data('title');
		Stream_Title_Decoded = atob(Stream_Title);
		$(".modal-content #streamTitle").text(Stream_Title_Decoded);
		$(".modal-content #streamTitleValue").val(Stream_Title_Decoded);
		var Stream_Url = $(this).data('url');
		$(".modal-content #streamUrl").val(Stream_Url);
	
		$( "#streamComments" ).load( "modules/stream/comment_list.php?url="+Stream_Url, function() {
		$("#commentloader").hide();
				
		//Scroll to bottom
		var height=$("#addstreamcomment").height();
		height=height+10000;
		$('.modal-content').scrollTop(height);
				
		});
	});
			
	//Delete a comment
	$(".commentdeletebutton").unbind().click(function(event)
	{				
		event.preventDefault();
		$(this).closest(".commentwrapper").hide();
		var address = $(this).attr("href");
		$.ajax({
			type: 'POST',
			url: address,
			data: '',
		})
					
		.done(function() {
			$('#streamcards').load("modules/stream/stream_feeds.php", function () {	
				$('.grid').masonry( 'reloadItems' );
				$('.grid').masonry( 'layout' );
				mdlregister();
			});
			$('#streamlikes').load("modules/stream/stream_likes.php", function () {	
				mdlregister();
			});
		});			
	});
	
});