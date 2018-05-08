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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');
	require('permissions.php');

	?>
	<div class='page_container'>
	<div class='row'>
	<?php

	if($_SESSION['usertype']!="parent")
	{
		$userid=finduseridcore($_SESSION['useremail']);
		$sql = "SELECT Book_ID, ID FROM books_libraries WHERE User_ID='$userid' ORDER BY ID DESC";
	}
	else
	{
		$userid=finduseridparent($_SESSION['useremail']);
		$sql = "SELECT Book_ID, ID FROM books_libraries WHERE Parent_ID='$userid' ORDER BY ID DESC";
	}
	$result = $db->query($sql);
	$numrows = $result->num_rows;
	$bookcount=0;
	while($row = $result->fetch_assoc())
	{
			$Book_ID=htmlspecialchars($row["Book_ID"], ENT_QUOTES);
			$Library_ID=htmlspecialchars($row["ID"], ENT_QUOTES);

			$sqllookup = "SELECT Title, Author, Cover, File, Slug FROM books WHERE ID='$Book_ID'";
			$result2 = $db->query($sqllookup);
			$setting_preferences=mysqli_num_rows($result2);
			while($row = $result2->fetch_assoc())
			{
				$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
				$Author=htmlspecialchars($row["Author"], ENT_QUOTES);
				$Cover=htmlspecialchars($row["Cover"], ENT_QUOTES);
				$File=htmlspecialchars($row["File"], ENT_QUOTES);
				$Slug=htmlspecialchars($row["Slug"], ENT_QUOTES);
				$Cover = $portal_root."/modules/Abre-Books/serveimage.php?file=$Cover&ext=png";

				echo "<div class='mdl-card mdl-shadow--2dp card_books'>";
					echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand' style='height:250px; background-image: url($Cover);'></div>";
					echo "<div class='mdl-card__title'><div class='mdl-card__title-text truncate'><span class='truncate'>$Title</span></div></div>";
					echo "<div class='mdl-card__supporting-text mdl-card__supporting-text-standalone truncate'><span class='truncate'>$Author</span></div>";
					echo "<div class='mdl-card__actions'>";
						echo "<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' style='color:".getSiteColor()."' href='#books/$Slug'>Read</a>";
						echo "<div class='mdl-layout-spacer'></div>";
						echo "<a class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600' href='modules/".basename(__DIR__)."/serveepub.php?book=$File' target='_blank'><i class='material-icons'>cloud_download</i></a>";
						echo "<div class='removebook'><a class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600' href='modules/".basename(__DIR__)."/removebook.php?librarybookid=".$Library_ID."'><i class='material-icons'>delete</i></a></div>";

					echo "</div>";
				echo "</div>";
				$bookcount++;
			}
		}

		if($_SESSION['usertype']=="student")
		{
			$sql2 = "SELECT Title, Author, Cover, File, Slug FROM books WHERE Students_Required=1";
		}
		if($_SESSION['usertype']=="staff")
		{
			$sql2 = "SELECT Title, Author, Cover, File, Slug FROM books WHERE Staff_Required=1";
		}
		if($_SESSION['usertype']=="parent")
		{
			$sql2 = "SELECT Title, Author, Cover, File, Slug FROM books WHERE Staff_Required=99";
		}
		$result = $db->query($sql2);
		$numrows2 = $result->num_rows;
		while($row = $result->fetch_assoc())
		{
				$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
				$Author=htmlspecialchars($row["Author"], ENT_QUOTES);
				$CoverImage=htmlspecialchars($row["Cover"], ENT_QUOTES);
				$File=htmlspecialchars($row["File"], ENT_QUOTES);
				$Slug=htmlspecialchars($row["Slug"], ENT_QUOTES);
				$Cover = $portal_root."/modules/Abre-Books/serveimage.php?file=$CoverImage&ext=png";

				echo "<div class='mdl-card mdl-shadow--2dp card_books'>";
					echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand' style='height:250px; background-image: url($Cover);'></div>";
					echo "<div class='mdl-card__title'><div class='mdl-card__title-text truncate'><span class='truncate'>$Title</span></div></div>";
					echo "<div class='mdl-card__supporting-text mdl-card__supporting-text-standalone truncate'><span class='truncate'>$Author</span></div>";
					echo "<div class='mdl-card__actions'>";
						echo "<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' style='color:".getSiteColor()."' href='#books/$Slug'>Read</a>";
						echo "<div class='mdl-layout-spacer'></div>";
						echo "<a class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600' href='modules/".basename(__DIR__)."/serveepub.php?book=$File' target='_blank'><i class='material-icons'>cloud_download</i></a>";
					echo "</div>";
				echo "</div>";
				$bookcount++;
		}

		if($numrows==0 && $numrows2==0)
		{
			echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Books in Library</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' in the bottom right to add a book to your library.</p></div>";
		}
		?>

		</div>
		</div>

		<?php
		include "addbook.php";



?>

<script>

	$(function()
	{

		//Remove book from library
		$(".removebook").unbind().click(function()
		{
			event.preventDefault();
			var result = confirm("Want to remove the book?");
			if (result) {
				var address = $(this).find("a").attr("href");
				$.ajax({
					type: 'POST',
					url: address,
					data: '',
				})

				//Show the notification
				.done(function(response) {
					$( "#displaylibrary" ).load( "modules/<?php echo basename(__DIR__); ?>/books_display.php", function() {

						//Register MDL Components
						mdlregister();

						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response };
						notification.MaterialSnackbar.showSnackbar(data);
					});
				})
			}
		});

	});

</script>