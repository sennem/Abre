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
    
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	echo "<div class='page_container'>";
	
	//Get Users Books
	echo "<div class='row'><div class='col s12'><h5>My Library</h5></div></div>";
	echo "<div class='row'>";
	
	$userid=finduseridcore($_SESSION['useremail']);
	$sql = "SELECT * FROM books_libraries where User_ID='$userid'";
	$result = $db->query($sql);
	$numrows = $result->num_rows;
	$bookcount=0;
	while($row = $result->fetch_assoc())
	{
		$Book_ID=htmlspecialchars($row["Book_ID"], ENT_QUOTES);
		$Library_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
		
		//Get Book Information
		$sqllookup = "SELECT * FROM books where ID='$Book_ID'";
		$result2 = $db->query($sqllookup);
		$setting_preferences=mysqli_num_rows($result2);
		while($row = $result2->fetch_assoc())
		{
			$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
			$Author=htmlspecialchars($row["Author"], ENT_QUOTES);
			$Cover=htmlspecialchars($row["Cover"], ENT_QUOTES);
			$File=htmlspecialchars($row["File"], ENT_QUOTES);
			$Slug=htmlspecialchars($row["Slug"], ENT_QUOTES);
			
			echo "<div class='mdl-card mdl-shadow--2dp card_books'>";
				echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand' style='height:250px; background-image: url(modules/books/books/$Cover);'></div>";
				echo "<div class='mdl-card__title'><div class='mdl-card__title-text truncate'>$Title</div></div>";
				echo "<div class='mdl-card__supporting-text mdl-card__supporting-text-standalone truncate'>$Author</div>";
				echo "<div class='mdl-card__actions'>";
					echo "<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-800' href='#books/$Slug'>Read Online</a>";
					echo "<div class='mdl-layout-spacer'></div>";
					echo "<button id='demo-menu-top-right-$bookcount' class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-js-ripple-effect mdl-color-text--blue-800'><i class='material-icons'>more_vert</i></button>";
					echo "<ul class='mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect' for='demo-menu-top-right-$bookcount'><li class='mdl-menu__item'><a href='modules/books/serveepub.php?book=$File' target='_blank' class='mdl-color-text--black'>Download Book</a></li><li class='mdl-menu__item removebook'><a href='modules/books/removebook.php?librarybookid=".$Library_ID."' class='mdl-color-text--black'>Remove Book</a></li></ul>";
					echo "</div>";
			echo "</div>";	
			$bookcount++;
		}
	}
	
	if($numrows==0)
	{
		echo "<div class='col s12'>There are no books in your library.</div>";
	}
	
	echo "</div>";
	echo "</div>";
	include "addbook.php";

?>