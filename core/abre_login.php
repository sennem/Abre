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
	require_once(dirname(__FILE__) . '/../configuration.php'); 
	require_once('abre_functions.php'); 
	
?>

	<!-- Book Code Modal -->
	<div id="qrlogin" class="modal modal-mobile-full">
		<form class="col s12" id="form-addbook" method="post" action="modules/books/addbook_process.php">
		<div class="modal-content">
			<br><br>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div id="qrmessage" style="font-size:22px;text-align:center;padding-bottom:20px;"></div>
			<div id="qrreader" style="width:450px;height:300px;margin:0 auto;"></div>
			<br><br>
    	</div>
		</form>
	</div>

<!-- Display the Login -->
<div class="mdl-layout mdl-js-layout login-card">
	<div class="login_wrapper">	  	
		
		<div class="login-card-square mdl-card animated fadeIn">
			<div class="mdl-card__title mdl-card--expand" style='width:200px; height:200px; background: url(<?php echo sitesettings('sitelogo'); ?>) center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; margin-left:20px; margin-bottom:5px;'></div>
			<?php
				echo "<div class='mdl-card-text mdl-color-text--grey-600'>".sitesettings('sitelogintext')."</div>";

		  		echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='$authUrl' style='margin: 0 auto; width:100%; text-transform:none; background-color:".sitesettings("sitecolor")."'>Login with Google</a>";
		  	?>
		</div>
		
	</div>      	
</div>

<script>
      
	$(function() 
	{
		//Books Modal
		$('.modal-qrlogin').leanModal(
		{
			in_duration: 0,
			out_duration: 0,
			ready: function()
			{
				$('#qrreader').html5_qrcode(function(data){
				    	$.post( "/core/abre_login_qr.php", { identifier: data } )
				    	.done(function(data) {
							if(data==="Authenticated")
							{
								$('#qrreader').hide();
								$('#qrreader').html5_qrcode_stop();
								$('#qrmessage').html("Logging in...");
								location.reload();
							}
							else
							{
								$('#qrmessage').html("Sorry, we can't recognize your badge");
							}
						});
				    },
				    function(error){
				        $('#qrmessage').html("Hold your badge up to the camera");
				    }, function(videoError){
				        ('#qrmessage').html("There is a problem with your camera");
				    }
				);				
			},
			complete: function()
			{ 
				$('#qrreader').html5_qrcode_stop();
			}
		});
		
	});
	
	//Responsive login view
	function loginWidthCheck()
	{
		if ($(window).width() < 600) {
			$( ".login-card-square" ).removeClass( "mdl-shadow--2dp" );
			$( ".login-card" ).addClass( "mdl-color--white" );
		}
		else
		{
			$( ".login-card-square" ).addClass( "mdl-shadow--2dp" );
			$( ".login-card" ).removeClass( "mdl-color--white" );
		}
	}
	
	loginWidthCheck();
	$(window).resize(loginWidthCheck);

</script>