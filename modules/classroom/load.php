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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');

	if($_SESSION['usertype'] != parent){
?>

		<div class='grid-item'>
			<div class='demo-card-event mdl-card mdl-shadow--2dp card_stream'>
				<div id='classroom'>
					<div class='mdl-card__title'>
						<div class="valign-wrapper">
							<img src='core/images/icon_classroom.png' class='icon_small'>
							<div class='mdl-card__title-text'>Classroom</div>
						</div>
					</div>
					<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
				</div>
			</div>
		</div>
<?}?>
