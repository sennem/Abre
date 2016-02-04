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
	
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php');
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/portal_functions.php'); 

	$bookslug=htmlspecialchars($_GET["id"], ENT_QUOTES);
	
	//Get book id given slug
	include "../../core/portal_dbconnect.php";
	$sql = "SELECT * FROM books where Slug='$bookslug'";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{
		$bookid=htmlspecialchars($row["ID"], ENT_QUOTES);
		$File=htmlspecialchars($row["File"], ENT_QUOTES);
	}
	
	//Check to see if you user has access to book
	include "../../core/portal_dbconnect.php";
	$userid=finduseridcore($_SESSION['useremail']);
	$sql = "SELECT * FROM books_libraries where Book_ID='$bookid' and User_ID='$userid'";
	$result = $db->query($sql);
	$access=0;
	while($row = $result->fetch_assoc())
	{
			$access=1;
			echo "<script src='modules/books/js/epub.min.js'></script>";
			if(strpos($File, '.epub') !== false)
			{
				echo "<script src='modules/books/js/zip.min.js'></script>";
				echo "<script src='modules/books/js/reader.min.js'></script>";
			}
			
		?>
		
			<div id="main">
				<div id="divider"></div>
				<div id="titlebar">
					<div id="metainfo">					
						<div class="row valign-wrapper">
							<div class="col l6 hide-on-small-only ellipsis">
								<span id="book-title"></span> - <span id="book-creator"></span>
							</div>
							<div class="col l6 s12 right-align">
								<select id='toc'></select>
							</div>
						</div>
					</div> 
				</div>
		
				<!-- Controls and Viewer -->
				<div id="prev" onclick="Book.prevPage();" class="arrow">‹</div>
			    <div id="viewer"></div>
			    <div id="next" onclick="Book.nextPage();" class="arrow">›</div>
			</div>
		
		
		
			<script>
			        
				<?php 

					if(strpos($File, '.epub') !== false)
					{
						echo "var Book = ePub('modules/books/serveepub.php?book=$bookslug.epub', {contained: true});";
					}
					else
					{
						echo "var Book = ePub('modules/books/books/$bookslug/');";
					}
					
				?>
				Book.renderTo("viewer");		
		
				//Book Table of Contents
				Book.getToc().then(function(toc)
				{
					var $select = document.getElementById("toc"),
					docfrag = document.createDocumentFragment();
			
					toc.forEach(function(chapter) {
						var option = document.createElement("option");
						option.textContent = chapter.label;
						option.ref = chapter.href;
						docfrag.appendChild(option);
					});
		
					$select.appendChild(docfrag);
			
					//Option Change
					$select.onchange = function(){
						var index = $select.selectedIndex,
						url = $select.options[index].ref;
			
						Book.goto(url);
						return false;
					}
				});
					
		
				//Book Title
				Book.getMetadata().then(function(meta){
					booktitle = meta.bookTitle;
					bookcreator = meta.creator;
					$( "#book-title" ).html( booktitle );
					$( "#book-creator" ).html( bookcreator );
				});
		         
		        //Format Book
				Book.setStyle("line-height", "1.5em");
				
				//Keyboard Shortcuts
				$(document).keyup(function (event) {
					if ((event.keyCode || event.which) == 37) {
				    	Book.prevPage();
				    }
					if ((event.keyCode || event.which) == 39) {
				    	Book.nextPage();
				    }
				});
				
				//Fullscreen View
				$("#titlebar").mouseenter(function(e) {
					if ($(e.target).is('select'))
					{
						
					}
					else
					{
						$("header").removeClass( "animated slideOutUp" );
					}
				});
				
				//Hide header bar on enter main
				$("#main").mouseenter(function() {
					$("header").addClass( "animated slideOutUp" );
				});

				//Show header if leave main or header
				$("#main, header").mouseleave(function() {
				   $("header").removeClass( "animated slideOutUp" );
				});

		
			</script>
			
	<?php
		}
		if($access==0)
		{
			echo "You do not have access to this book.";
		}
	?>