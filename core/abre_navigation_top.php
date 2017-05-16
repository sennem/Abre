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

	//Include required files
	require_once('abre_verification.php');
	require_once('abre_functions.php');

?>
<?php
if($_SESSION['usertype'] == 'parent'){
?>
	<!-- Student Token Modal -->
	<div id="verifystudent" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-verifystudent" method="post" action="<?php echo basename(__DIR__); ?>/verifystudent_process.php">
		<div class="modal-content">
			<h4>Verify Your Student</h4>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class="input-field col s6">
				<input id="studenttoken" name="studenttoken" type="text" maxlength="20" placeholder="Enter your student token" autocomplete="off" required>
			</div>
			<div id="errormessage" style="color:#F44336"></div>
			</div>
			<div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='background-color: <?php echo sitesettings("sitecolor");?>'>Verify</button>
		</div>
		</form>
	</div>
<?php } ?>

	<!--Display top navigation-->
	<header class='mdl-layout__header mdl-color-text--white' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>
		<div class='mdl-layout__header-row'>
			<span class='mdl-layout-title'><div id='titletext' class='truncate'></div></span>
			<div class='mdl-layout-spacer'></div>
				<?php
					if(!isset($_GET["dash"]))
					{
						if($_SESSION['usertype'] == 'parent'){
							echo "<a id='addstudent' class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon modal-verifystudent' href='#verifystudent'><i class='material-icons' style='margin-right:10px'>add</i></a>";
							isVerified();
						}
						echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon modal-viewapps' href='#viewapps'><i class='material-icons'>apps</i></a>";
					}
				?>
				<div class='navspace'></div>
				<?php
						echo "<a href='#viewprofile' class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon modal-viewprofile'><img src='".$_SESSION['picture']."?sz=120' class='img-center' style='width:32px; height:32px;'></a>";
				?>
			</div>
		<div id='navigation_top'></div>
	</header>

<script>

	$(function()
	{
		//Student Token Modal
		$('.modal-verifystudent').leanModal(
		{
			in_duration: 0,
			out_duration: 0,
			 ready: function() { $("#studenttoken").focus(); }
		});

		//Scroll to top
		$('.mdl-layout__header-row').click(function()
		{
			$('.mdl-layout__content').animate({ scrollTop: 0 }, 'fast');
		});

		var formverifystudent = $('#form-verifystudent');
		$(formverifystudent).submit(function(event) {
			event.preventDefault();
			var formData = $(formverifystudent).serialize();
			$.ajax({
				type: 'POST',
				url: $(formverifystudent).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(response) {
				var notification = document.querySelector('.mdl-js-snackbar');
				var status = response.status;
				if(status == "Success"){
					<?php isVerified(); ?>
					$("#studenttoken").val('');
					$('#verifystudent').closeModal({
						in_duration: 0,
						out_duration: 0,
					});
					var data = { message: response.message };
					notification.MaterialSnackbar.showSnackbar(data);
				}
				if(status == "Error"){
					$('#errormessage').text(response.message);
				}
			});
		});
	});

</script>
