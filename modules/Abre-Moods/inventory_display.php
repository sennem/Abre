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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('../../core/abre_functions.php');
	require_once('permissions.php');

	//Display the inventory for authorized users
	if($booksadmin==1)
	{

		$sql = "SELECT ID, Title, Author, Code, Code_Limit, Students_Required, Staff_Required, Cover FROM books ORDER BY Title";
		$result = $db->query($sql);
		$numrows = $result->num_rows;
		$coursecount=0;
		while($row = $result->fetch_assoc())
		{
			$Book_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
			$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
			$Author=htmlspecialchars($row["Author"], ENT_QUOTES);
			$Code=htmlspecialchars($row["Code"], ENT_QUOTES);
			$Code_Limit=htmlspecialchars($row["Code_Limit"], ENT_QUOTES);
			$Students_Required=htmlspecialchars($row["Students_Required"], ENT_QUOTES);
			if($Students_Required==1){ $Students_Required="Yes"; }else{ $Students_Required="No"; }
			$Staff_Required=htmlspecialchars($row["Staff_Required"], ENT_QUOTES);
			if($Staff_Required==1){ $Staff_Required="Yes"; }else{ $Staff_Required="No"; }
			if($Code_Limit==""){ $Code_Limit="Unlimited"; }
			$Cover=htmlspecialchars($row["Cover"], ENT_QUOTES);
			$Cover=$portal_root."/modules/".basename(__DIR__)."/serveimage.php?file=$Cover&ext=png";

			$sql2 = "SELECT COUNT(*) FROM books_libraries WHERE Book_ID=$Book_ID";
			$result2 = $db->query($sql2);
			$returnrow = $result2->fetch_assoc();
			$Remaining_Licenses = $returnrow["COUNT(*)"];

			if($coursecount==0)
			{
			?>

				<div class='page_container mdl-shadow--4dp'>
				<div class='page'>
				<div id='searchresults'>
				<div class='row'><div class='col s12'>
				<table id='myTable' class='tablesorter'>
				<thead>
				<tr class='pointer'>
				<th class='hide-on-med-and-down'></th>
				<th>Title</th>
				<th class='hide-on-med-and-down'>Author</th>
				<th>Coupon Code</th>
				<th class='hide-on-small-only'>Used Licenses</th>
				<th class='hide-on-small-only'>Staff Required</th>
				<th class='hide-on-small-only'>Student Required</th>
				<th style='width:30px'></th>
				<th style='width:30px'></th>
				</tr>
				</thead>
				<tbody>

			<?php
			}

			echo "<tr>";
									echo "<td class='hide-on-med-and-down'>";
										echo "<img src='$Cover' class='profile-avatar-small'>";
									echo "</td>";
									echo "<td>$Title</td>";
									echo "<td class='hide-on-med-and-down'>$Author</td>";
									echo "<td>$Code</td>";
									if($Code_Limit==0)
									{
										echo "<td class='hide-on-small-only'>Unlimited</td>";
									}
									else
									{
										echo "<td class='hide-on-small-only'>$Remaining_Licenses/$Code_Limit</td>";
									}
									echo "<td class='hide-on-small-only'>$Staff_Required</td>";
									echo "<td class='hide-on-small-only'>$Students_Required</td>";
									echo "<td width=30px><a class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 modal-modifybook' href='#modifybook' data-id='$Book_ID' data-title='$Title' data-author='$Author' data-studentrequired='$Students_Required' data-staffrequired='$Staff_Required'><i class='material-icons'>mode_edit</i></a></td>";
									echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 deletebook'><a href='modules/".basename(__DIR__)."/deletebook.php?id=$Book_ID'></a><i class='material-icons'>delete</i></button></td>";
			echo "</tr>";

			if($coursecount==$numrows)
			{
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
			$coursecount++;
		}

		if($coursecount==0 && admin())
		{
			echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Books in Inventory</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' at the bottom to upload a book.</p></div>";
		}

		include "uploadbook.php";
	}
?>

<script>

	$(function()
	{

		//Set the table sort
		$("#myTable").tablesorter({ });

		$(".modal-uploadbook").unbind().click(function(){
			event.preventDefault();

			$("#booktitle").val('');
			$("#bookauthor").val('');
			$("#bookfile").val('');
			$("#bookcover").val('');
			$("#booklicencelimit").val('');
			$(".file-path").val('');
			$(".file-path").removeClass('valid invalid');
			$("#bookstudentrequired").prop('checked', false);
			$("#bookstaffrequired").prop('checked', false);

		});

		//Upload book modal
		$('.modal-uploadbook').leanModal({
			in_duration: 0,
			out_duration: 0,
	    ready: function() { $("#bookcode").focus(); $('.modal-content').scrollTop(0); }
	  });

		$(".modal-modifybook").unbind().click(function(){
			event.preventDefault();

			var id = $(this).data('id');
			$("#modifiedbookid").val(id);
			var title = $(this).data('title');
			$("#modifiedbooktitle").val(title);
			var author = $(this).data('author');
			$("#modifiedbookauthor").val(author);
			var studentrequired = $(this).data('studentrequired');
			if(studentrequired == "Yes"){
				$("#modifiedbookstudentrequired").prop('checked', true);
			}else{
				$("#modifiedbookstudentrequired").prop('checked', false);
			}
			var staffrequired = $(this).data('staffrequired');
			if(staffrequired == "Yes"){
				$("#modifiedbookstaffrequired").prop('checked', true);
			}else{
				$("#modifiedbookstaffrequired").prop('checked', false);
			}

		});

		//Modify book modal
		$('.modal-modifybook').leanModal({
			in_duration: 0,
			out_duration: 0,
			ready: function() { $('.modal-content').scrollTop(0); }
		});

		//Permanently Delete Book
		$(".deletebook").unbind().click(function()
		{
			var result = confirm("Want to permanently delete this book?");
			if (result)
			{
				var address = $(this).find("a").attr("href");
				$.ajax({
					type: 'POST',
					url: address,
					data: '',
				})

				//Show the notification
				.done(function(response) {

					$("#displaybooks").load( "modules/<?php echo basename(__DIR__); ?>/inventory_display.php", function(){

					});

					//Register MDL Components
					mdlregister();

					var notification = document.querySelector('.mdl-js-snackbar');
					var data = { message: response };
					notification.MaterialSnackbar.showSnackbar(data);

				})
			}
		});

	});

</script>