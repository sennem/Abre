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
	require_once("functions.php");

	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{

?>

		<!-- Send Form -->
		<div id="sendform" class="modal">

			<div class="modal-content" style="padding: 0px !important;">

				<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
					<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Send Form</span></div>
					<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
				</div>

				<div style='padding: 0px 24px 0px 24px;'>
					<div class="row">
						<div class='input-field col s12'>
							<input type="text" autocomplete="off" placeholder="Shareable Link" name="SendLink" id="SendLink">
							<label class="active" for="SendLink">Link</label>
						</div>

	    				<div class='col s12'>
	    					<a class="waves-effect btn-flat white-text copylink" data-clipboard-target="#SendLink" style='background-color: <?php echo getSiteColor(); ?>'>Copy</a>
	    				</div>
    				</div>
        		</div>

	    	</div>

		  	<div class="modal-footer">
		  		<a class="modal-close waves-effect btn-flat white-text" style='margin-right:5px; background-color: <?php echo getSiteColor(); ?>'>Close</a>
			</div>

		</div>

		<!-- Form Entry -->
		<div id="formentry" class="modal modal-fixed-footer modal-mobile-full">

			<div class="modal-content" style="padding: 0px !important;">

				<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
					<div class='col s11'><span class="truncate" id='entrymodaltitle' style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;"></span></div>
					<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
				</div>

				<div style='padding: 0px 24px 0px 24px;'>
					<div class='row' id='formentryloader' style='display:none;'>
						<div class='col s12'>
							<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="width:100%;"></div>
						</div>
					</div>
					<div class='row'>
						<div class='col s12' id='entrymodalbody'></div>
					</div>
        </div>

	    </div>

	  	<div class="modal-footer">
	  		<a class="modal-close waves-effect btn-flat white-text" style='margin-right:5px; background-color: <?php echo getSiteColor(); ?>'>Close</a>
			</div>

		</div>

<?php

	}

?>

<script src="/modules/Abre-Forms/js/clipboard.min.js"></script>

<script>

	$(function()
	{

		new ClipboardJS('.copylink');

	});

</script>