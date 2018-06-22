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
					<h4 class='center-align'>Football Game</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url(https://openclipart.org/download/216274/1427059148.svg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Volleyball Game</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("https://s3.us-east-2.amazonaws.com/abreio/2017/07/Abre_Primary_Logo.png"); <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Hack Camp</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("https://pbs.twimg.com/profile_images/894062448407433217/ig5-H5ef.jpg"); <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
			</div>
			<br/>
		</div>
		<!-- second row of clubs -->
		<div class='row'>
			<div class= 'row'>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>ACM</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url(https://www.acm.org/images/acm_rgb_grad_pos_diamond.png); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Drama Club</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url(https://irp-cdn.multiscreensite.com/19d36af0/dms3rep/multi/mobile/drama%20club-300x260.jpg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>NHS</h4>
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
					<h4 class='center-align'>Coding Club</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url(https://global-uploads.webflow.com/586cc078fcd66fc24dc054b4/5975ab1d6e571824118fb904_Blue%20Code.svg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Firday Freetime</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url(https://i.ytimg.com/vi/uYs4c9AawmE/maxresdefault.jpg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Over The Wire</h4>
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

	<div class='page'>
			<div class='row'>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Running Club</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url(https://openclipart.org/download/216274/1427059148.svg); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Abre Club</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("https://s3.us-east-2.amazonaws.com/abreio/2017/07/Abre_Primary_Logo.png"); <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left;'>
					<h4 class='center-align'>Hack Club</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("https://pbs.twimg.com/profile_images/894062448407433217/ig5-H5ef.jpg"); <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Link to Homepage</a>
					</div>
				</div>
			</div>
			<br/>
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
