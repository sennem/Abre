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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
		echo "<div class='mdl-card mdl-shadow--2dp card_stream'>";
	
			if($image!=""){
				echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand' style='height:200px; background-image: url($image);'></div>"; 
			}; 
		
			echo "<div class='mdl-card__title'><div class='mdl-card__title-text'>$title</div></div>";
			echo "<div class='mdl-card__supporting-text-subtitle'><a href='$feedlink' class='mdl-color-text--blue-800' target='_blank'>$feedtitle</a></div>";
			if($excerpt!=""){ echo "<div class='mdl-card__supporting-text'>$excerpt</div>"; }
			echo "<div class='mdl-card__actions'>";
				echo "<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-800' href='$link' target='_blank'>$linklabel</a>";
			
			if($_SESSION['usertype']=='staff')
			{
				echo "<div class='mdl-layout-spacer'></div>";
				if($num_rows_comment==0)
				{
					echo "<a class='material-icons mdl-color-text--grey-400 modal-addstreamcomment' data-title='$title' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$link' title='Add this item' href='#addstreamcomment'>insert_comment</a>";
				}
				else
				{
					echo "<a class='material-icons mdl-badge mdl-badge--no-background mdl-badge--overlap mdl-color-text--grey-400 modal-addstreamcomment' data-badge='$num_rows_comment' data-title='$title' data-category='$feedtitle' data-excerpt='$excerpt' data-url='$link' title='Add this item' href='#addstreamcomment'>insert_comment</a>";
				}
			}
			
			echo "</div>";
			
		echo "</div>";
		
?>