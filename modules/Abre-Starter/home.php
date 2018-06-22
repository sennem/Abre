<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
//	<!-- hello world -->
?>

<div class='page_container mdl-shadow--4dp'>
	<div class='page'>
		<div class='row'>
			<div style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>Weclome!</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Amazing Events Below</p></div>
		</div>
		<!-- below should be cards -->
		<div class='row'>
			<div class='row'>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event One</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url("http://masoncomets.org/sites/default/files/NEWwhite-comet-with-green-white-m-black-circle-and-green-and-black-stroke.png"); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Two</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("https://www.ffwd.org/wp-content/uploads/12391785_1077834235600931_1299484106104597636_n.png"); <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
			<!--	<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Three</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("http://media2.fdncms.com/thecoast/imager/classic-lan-party/u/zoom/3748195/url-7.jpeg"); <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php //echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div> -->
				<!-- start -->
				<div class="col l4 m12 s12">
					<div class="mdl-shadow--2dp" style="background-color:#fff; padding:30px 35px 15px 35px;">
						<div class="center-align"><img src="/modules/Abre-Students/image.php?student=593883152" class="circle" style="width:100px; height:100px;">
						</div>
						<h4 class="center-align">Hedy Delawder</h4>
						<p class="center-align">Hamilton High School<br>ID: <span id="studentid">593883152</span></p>
						<hr><h5>Student Information</h5><p><b>Birthday:</b> 8/21/02<br><b>Gender:</b> Female<br><b>Grade:</b> 10<br><b>IEP Status:</b> N<br><b>Gifted Status:</b> N<br><b>ELL Status:</b> S<br><b>Email:</b> <span>No Associated Email</span><br></p>
						<hr>
						<h5>Guardian Contacts</h5>
						<b>Primary Contact</b>
						<p>Renee Delawder<br>No Email Listed</p>
					</div>
				</div>
				<!-- end -->
			</div>
			<br/>
		</div>
		<!-- second row of clubs -->
		<div class='row'>
			<div class= 'row'>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Four</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url(https://www.acm.org/images/acm_rgb_grad_pos_diamond.png); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Five</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url(https://irp-cdn.multiscreensite.com/19d36af0/dms3rep/multi/mobile/drama%20club-300x260.jpg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Six</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url(https://www.nhs.us/assets/images/nhs/NHS_header_logo.png); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
			</div>
			<br/>
		</div>
		<!-- thired row of clubs -->
		<div class='row'>
			<div class='row'>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Seven</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url(https://global-uploads.webflow.com/586cc078fcd66fc24dc054b4/5975ab1d6e571824118fb904_Blue%20Code.svg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Eight</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url(https://i.ytimg.com/vi/uYs4c9AawmE/maxresdefault.jpg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Event Nine</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url(https://pbs.twimg.com/profile_images/814420266583400449/GBz31NqB.jpg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
			</div>
			<br/>
		</div>
		<!-- more rows go here -->
	</div>
</div>

<!-- club creator button -->
<div class='fixed-action-btn buttonpin'>
	<a class='modal-newclub btn-floating btn-large waves-effect waves-light' style='background-color: <?php echo getSiteColor(); ?>' href='#clubmodal'><i class='large material-icons'>add</i></a>
	<div class="mdl-tooltip mdl-tooltip--left" for="createcourse">New Club</div>
</div>

<script src="/modules/Abre-Clubs/button_club.js"></script>
© 2018 GitHub, Inc.
Terms
Privacy
Security
Status
Help
Contact GitHub
API
Training
Shop
Blog
About
