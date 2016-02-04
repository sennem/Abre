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

	$pageview=1;
	$drawerhidden=0;
	$pageorder=2;
	$pagetitle="Books";
	$pageicon="book";
	$pagepath="books";
	$pagerestrictions="staff, students";
	
	
	include "core/portal_dbconnect.php";
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and (superadmin='1' or superadmin='2')";
	$result = $db->query($sql);
	$superadmin=0;
	while($row = $result->fetch_assoc())
	{
		$pagerestrictions="";
	}
	
?>

	<!-- Book Code Modal -->
	<div id="addbook" class="modal">
		<form class="col s12" id="form-addbook" method="post" action="modules/books/addbook_process.php">
		<div class="modal-content">
			<h4>Enter a Code</h4>
			<p>Enter a book coupon code:</p>
			<div class="input-field col s6">
				<input id="bookcode" name="bookcode" type="text" maxlength="20">
			</div>
    	</div>
	    <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat blue darken-3 white-text">Redeem</button>
		</div>
		</form>
	</div>

<script>

	//Page Locations
	routie({
	    'books': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $('.tooltipped').tooltip('remove');
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Books");
		    document.title = 'HCSD Portal - Books';
			$( "#content_holder" ).load( 'modules/books/books.php', function() { init_page(); });
	    },
	    'books/inventory': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $('.tooltipped').tooltip('remove');
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Books");
		    document.title = 'HCSD Portal - Books Inventory';
			$( "#content_holder" ).load( 'modules/books/inventory.php', function() { init_page(); });
	    },
	    'books/?:name': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $('.tooltipped').tooltip('remove');
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Books");
		    document.title = 'HCSD Portal - Reader';
			$( "#content_holder" ).load( 'modules/books/reader.php?id='+name, function() { init_page(); });
	    }
	});

</script>