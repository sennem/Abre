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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

?>

	<!-- Book Code Modal -->
	<div id="addbook" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-addbook" method="post" action="modules/<?php echo basename(__DIR__); ?>/addbook_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Enter a Code</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="input-field col s6">
						<input id="bookcode" name="bookcode" type="text" maxlength="20" placeholder="Enter a Coupon" autocomplete="off" required>
						<label class="active" for="bookcode">Enter a Coupon Code</label>
					</div>
				</div>
			</div>
    </div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='background-color: <?php echo getSiteColor(); ?>'>Redeem</button>
		</div>
		</form>
	</div>

	<!-- Upload Book Modal -->
	<div id="uploadbook" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-uploadbook" method="post" action="modules/<?php echo basename(__DIR__); ?>/uploadbook_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Upload Book</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="input-field col s12">
						<input id="booktitle" name="booktitle" type="text" placeholder="Book Title" autocomplete="off" required>
						<label for="booktitle" class="active">Book Title</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="bookauthor" name="bookauthor" type="text" placeholder="Book Author" autocomplete="off" required>
						<label for="bookauthor" class="active">Book Author</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="booklicencelimit" name="booklicencelimit" type="number" placeholder="Limited Licence Number (Leave Blank if Unlimited)" autocomplete="off">
						<label for="booklicencelimit" class="active">Book License Limit</label>
					</div>
				</div>
				<div class="row">
					<div class="file-field input-field col s12">
						<div class="btn" style='background-color: <?php echo getSiteColor(); ?>'>
							<span>ePub File</span>
							<input id="bookfile" name="bookfile" type="file" required>
						</div>
						<div class="file-path-wrapper">
					        <input class="file-path validate" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="file-field input-field col s12">
						<div class="btn" style='background-color: <?php echo getSiteColor(); ?>'>
							<span>PNG Cover</span>
							<input id="bookcover" name="bookcover" type="file" required>
						</div>
						<div class="file-path-wrapper">
					        <input class="file-path validate" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<input type="checkbox" class="filled-in" id="bookstudentrequired" name="bookstudentrequired" value="1" />
						<label for="bookstudentrequired">Require this book for students</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<input type="checkbox" class="filled-in" id="bookstaffrequired" name="bookstaffrequired" value="1" />
						<label for="bookstaffrequired">Require this book for staff</label>
					</div>
				</div>
			</div>
    </div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text uploadbutton" style='background-color: <?php echo getSiteColor(); ?>'>Upload</button>
		</div>
		</form>
	</div>

  <!-- Modify Book Settings Modal -->
  <div id="modifybook" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-modifybook" method="post" action="modules/<?php echo basename(__DIR__); ?>/modifybook_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Modify Book Settings</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="input-field col s12">
						<input id="modifiedbooktitle" name="modifiedbooktitle" type="text" placeholder="Book Title" autocomplete="off" required>
						<label for="modifiedbooktitle" class="active">Book Title</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input id="modifiedbookauthor" name="modifiedbookauthor" type="text" placeholder="Book Author" autocomplete="off" required>
						<label for="modifiedbookauthor" class="active">Book Author</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<input type="checkbox" class="filled-in" id="modifiedbookstudentrequired" name="modifiedbookstudentrequired" value="1" />
						<label for="modifiedbookstudentrequired">Require this book for students</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<input type="checkbox" class="filled-in" id="modifiedbookstaffrequired" name="modifiedbookstaffrequired" value="1" />
						<label for="modifiedbookstaffrequired">Require this book for staff</label>
					</div>
				</div>
	      <input type="hidden" id="modifiedbookid" name="modifiedbookid">
			</div>
    </div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text modifybutton" style='background-color: <?php echo getSiteColor(); ?>'>Save</button>
		</div>
		</form>
	</div>

<script>

	$(function()
	{

		//Add a coupon code
		var formaddbook = $('#form-addbook');

		$(formaddbook).submit(function(event) {
			event.preventDefault();
			$('#addbook').closeModal({
				in_duration: 0,
				out_duration: 0,
			});
			var formData = $(formaddbook).serialize();
			$.ajax({
				type: 'POST',
				url: $(formaddbook).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(response) {

        $( "#displaylibrary" ).load( "modules/<?php echo basename(__DIR__); ?>/books_display.php", function() {
          //Register MDL Components
				  mdlregister();

  				$("#form-addbook input").val('');
  				var notification = document.querySelector('.mdl-js-snackbar');
  				var data = { message: response };
  				notification.MaterialSnackbar.showSnackbar(data);
        });
      })
		});

		//Upload a book
		var formuploadbook = $('#form-uploadbook');

		$(formuploadbook).submit(function(event) {
			event.preventDefault();

			$('.uploadbutton').html("Uploading...");

			var formDataupload = new FormData($(this)[0]);
			$.ajax({
				type: 'POST',
				url: $(formuploadbook).attr('action'),
				data: formDataupload,
				contentType: false,
				processData: false
			})

			//Show the notification
			.done(function(response) {

        $('#uploadbook').closeModal({ in_duration: 0, out_duration: 0 });

        $('.uploadbutton').html("Upload");

				$( "#content_holder" ).load( "modules/<?php echo basename(__DIR__); ?>/inventory.php", function() {
          //Register MDL Components
				  mdlregister();

  				var notification = document.querySelector('.mdl-js-snackbar');
  				var data = { message: response };
  				notification.MaterialSnackbar.showSnackbar(data);
        });
      })
    });

    var formModifyBook = $('#form-modifybook');

    $(formModifyBook).submit(function(event) {
      event.preventDefault();

      var formDataModify = $(formModifyBook).serialize();
      $.ajax({
        type: 'POST',
        url: $(formModifyBook).attr('action'),
        data: formDataModify
      })

      //Show the notification
      .done(function(response) {

        $('#modifybook').closeModal({ in_duration: 0, out_duration: 0 });

        $( "#content_holder" ).load( "modules/<?php echo basename(__DIR__); ?>/inventory.php", function() {
          //Register MDL Components
          mdlregister();

          var notification = document.querySelector('.mdl-js-snackbar');
          var data = { message: response };
          notification.MaterialSnackbar.showSnackbar(data);
        });
      })
    });

	});

</script>