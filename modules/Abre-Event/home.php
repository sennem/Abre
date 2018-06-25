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
			<div style='padding:56px; text-align:center; width:100%; style="background-color:powderblue;'><span style='font-size: 22px; font-weight:700'>Weclome!</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Amazing Events Below</p></div>
		</div>
		<!-- below should be cards -->

		<!-- first row of events-->
		<div class='row'>
			<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left; width: 250px'>
				<h4 class='center-align'>App-a-thon</h4>
				<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url('https://pbs.twimg.com/profile_images/892546012258029569/5mgrMgl2_400x400.jpg'); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
				<div class='mdl-card__actions'>
					<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Read More</a>
				</div>
			</div>
			<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left; width: 250px'>
				<h4 class='center-align'>Hack Camp</h4>
				<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("https://www.ffwd.org/wp-content/uploads/12391785_1077834235600931_1299484106104597636_n.png"); <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
				<div class='mdl-card__actions'>
					<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Read More</a>
				</div>
			</div>

			<?php require(dirname(__FILE__) . '/../../modules/Abre-Starter/sidebar.php');?>
			<!-- end -->
		</div>
		<br>
		<!-- second row of events -->
		<div class='row'>
			<div class= 'row'>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left; width: 250px'>
					<h4 class='center-align'>Lan Party</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url('http://media2.fdncms.com/thecoast/imager/classic-lan-party/u/zoom/3748195/url-7.jpeg'); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Read More</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left; width: 250px'>
					<h4 class='center-align'>Band Concert</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("https://c1.staticflickr.com/3/2633/3717131933_88a7bcbe83_b.jpg"); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Read More</a>
					</div>
				</div>
				<?php require(dirname(__FILE__) . '/../../modules/Abre-Starter/calendar.php');?>
			</div>
			<br/>
		</div>
		<!-- thired row of clubs -->
		<div class='row'>
			<div class='row'>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left; width: 250px'>
					<h4 class='center-align'>Volleyball Game</h4>
					<div class="mdl-card__media mdl-color--grey-100 mdl-card--expand valign-wrapper cardclick pointer" style="height:200px; background-image: url('http://www.clipartbest.com/cliparts/9ip/LAp/9ipLApj6T.jpg'); background-colr: <?php echo getSiteColor() ?> !important; overflow:hidden;"></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Read More</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left; width: 250px'>
					<h4 class='center-align'>Career Fair</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("http://dataforge.s3.amazonaws.com/hih/2016/10/02193427/College-Fair-3.jpg"); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Read More</a>
					</div>
				</div>
				<div class='mdl-card mdl-shadow--2dp card_stream hoverable' style='float:left; width: 250px'>
					<h4 class='center-align'>Football Game</h4>
					<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand cardclick pointer' style='height:200px; background-image: url("http://masoncomets.org/sites/default/files/NEWwhite-comet-with-green-white-m-black-circle-and-green-and-black-stroke.png"); background-color: <?php echo getSiteColor() ?> !important; overflow:hidden;'></div>
					<div class='mdl-card__actions'>
						<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' href='#' style='color:<?php echo getSiteColor() ?>;'>Read More</a>
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


	<?php //require(dirname(__FILE__) . '/../../modules/Abre-Starter/sidebar.php');?>

<!-- <script src="/modules/Abre-Clubs/button_club.js"></script> -->
