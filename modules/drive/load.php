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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');

	if($_SESSION['usertype'] != 'parent'){
?>

		<div class='grid-item'>
			<div class='demo-card-event mdl-card mdl-shadow--2dp card_stream'>
				<div id='drive'>
					<div class='mdl-card__title'>
						<div class="valign-wrapper">
							<img src='core/images/icon_drive.png' class='icon_small'>
							<div class='mdl-card__title-text'>Drive</div>
						</div>
					</div>
					<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
				</div>
			</div>
		</div>
<?php } ?>
