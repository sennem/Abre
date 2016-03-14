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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	//Setup tables if new module
	if(!$resultbooks = $db->query("SELECT *  FROM books"))
	{
		$sql = "CREATE TABLE `books` (`ID` int(11) NOT NULL,`Code` varchar(11) NOT NULL,`Code_Limit` int(11) DEFAULT NULL,`Title` text NOT NULL,`Author` text NOT NULL,`Slug` text NOT NULL,`Cover` text NOT NULL,`File` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$sql .= "CREATE TABLE `books_libraries` (`ID` int(11) NOT NULL,`User_ID` int(11) NOT NULL,`Book_ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$sql .= "ALTER TABLE `books` ADD PRIMARY KEY (`ID`);";
  		$sql .= "ALTER TABLE `books_libraries` ADD PRIMARY KEY (`ID`);";
   		$sql .= "ALTER TABLE `books` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
  		$sql .= "ALTER TABLE `books_libraries` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
  		if ($db->multi_query($sql) === TRUE) { }
	}
	$db->close();
	

	$pageview=1;
	$drawerhidden=0;
	$pageorder=2;
	$pagetitle="Books";
	$pageicon="book";
	$pagepath="books";
	
	require_once('permissions.php');
	
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
			
			<?php if($pagerestrictions==""){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/books/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>
	    },
	    'books/inventory': function(name) {
		    $( "#navigation_top" ).hide();
		    $( "#content_holder" ).hide();
		    $('.tooltipped').tooltip('remove');
		    $( "#loader" ).show();
		    $( "#titletext" ).text("Books");
		    document.title = 'HCSD Portal - Books Inventory';
			$( "#content_holder" ).load( 'modules/books/inventory.php', function() { init_page(); });	
			
			<?php if($pagerestrictions==""){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/books/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>
			
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