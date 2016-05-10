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
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 	
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	
	
	//Find what streams to display
	$query = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
	$dbreturn = databasequery($query);
	foreach ($dbreturn as $value) {
		$userstreams=htmlspecialchars($value ['streams'], ENT_QUOTES);
	}
		
	//Create the Feed Array & Count
	$feeds = array();
	$totalcount=0;
	
	//Get Feeds
	require_once('simplepie/autoloader.php');
	$feed_flipboard = new SimplePie();				
	if(!empty($userstreams)!=NULL)
	{
		$sql = "SELECT * FROM streams where (required=1 and `group`='".$_SESSION['usertype']."') or id in ($userstreams)";
	}
	else
	{
		$sql = "SELECT * FROM streams where `required`=1 and `group`='".$_SESSION['usertype']."'";
	}
	
	//Look for all streams that apply to user
	$flipboardarray = array();
	$dbreturn = databasequery($sql);
	foreach ($dbreturn as $value) {
		$fburl=htmlspecialchars($value['url'], ENT_QUOTES);
		if($fburl!="")
		{
			array_push($flipboardarray, $fburl);
		}
   	}
	
	$feed_flipboard->set_cache_duration(1800);
	$feed_flipboard->set_stupidly_fast(true);
	$feed_flipboard->set_feed_url($flipboardarray);
	$streamcachesetting=constant("STREAM_CACHE");
	$location=$_SERVER['DOCUMENT_ROOT'] . '/../private/stream/cache/feed/';
	$feed_flipboard->set_cache_location($location);
	$feed_flipboard->enable_cache($streamcachesetting);
	$feed_flipboard->set_item_limit(10);
	$feed_flipboard->init();
	$feed_flipboard->handle_content_type();	

	
	foreach ($feed_flipboard->get_items() as $item)
	{
		$title=$item->get_title();
		$link=$item->get_link();
		$date=$item->get_date();
		$feedtitle = $item->get_feed()->get_title();
		$feedlink = $item->get_feed()->get_link();
		$date=strtotime($date);
		$linklabel="Read";
		$excerpt=$item->get_description();
		if ($enclosure = $item->get_enclosure())
		{
			$image=$enclosure->get_link();
		}
		array_push($feeds, array("$date","$title","$excerpt","$link","$image","$linklabel","$feedtitle","$feedlink"));
		$totalcount++;
	}
		
	//Display the Feeds
	sort($feeds, SORT_DESC);
	$feeds = array_reverse($feeds);
	for($cardcountloop = 0; $cardcountloop < $totalcount; $cardcountloop++)
	{
		$date=$feeds[$cardcountloop][0];
		$title=$feeds[$cardcountloop][1];
		$title = str_replace("<p>", " ", $title);
		$title=strip_tags(html_entity_decode($title));
		$title = preg_replace('/(\.)([[:alpha:]]{2,})/', '$1 $2', $title);
		$title=str_replace("'",'"',$title);
		$excerpt=$feeds[$cardcountloop][2];
		$excerpt = str_replace("<p>", " ", $excerpt);
		$excerpt=strip_tags(html_entity_decode($excerpt));
		$excerpt = preg_replace('/(\.)([[:alpha:]]{2,})/', '$1 $2', $excerpt);
		$link=$feeds[$cardcountloop][3];
		$image=$feeds[$cardcountloop][4];
		$linklabel=$feeds[$cardcountloop][5];
		$feedtitle=$feeds[$cardcountloop][6];
		$feedlink=$feeds[$cardcountloop][7];
		
		//Add images to server to securely store and reference
		include "stream_save_image.php";
		
		//Comment count
		$query = "SELECT * FROM streams_comments where url='$link' and comment!=''";
		$dbreturn = databasequery($query);
		$num_rows_comment = count($dbreturn);
		
		//Like count
		$query = "SELECT * FROM streams_comments where url='$link' and comment='' and liked='1'";
		$dbreturn = databasequery($query);
		$num_rows_like = count($dbreturn);
	
		if($title!="" && $excerpt!="")
		{
			echo "<div class='grid-item'>"; include "stream_layout_card.php"; echo "</div>";	
		}	
	}	

?>

<script>

	$(document).ready(function(){
    	$('.modal-addstreamcomment').leanModal({
	    	in_duration: 0,
			out_duration: 0,
	    	ready: function() { $("#streamComment").focus(); }
	   	});
  	});

	$(document).on("click", ".modal-addstreamcomment", function (event) {
		event.preventDefault();
		$("#commentloader").show();
		$("#streamComments").empty();
	    var Stream_Title = $(this).data('title');
	    $(".modal-content #streamTitle").text(Stream_Title);
	    $(".modal-content #streamTitleValue").val(Stream_Title);
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

</script>