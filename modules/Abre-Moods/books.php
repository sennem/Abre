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


	//Display book
	if(CONSTANT('SITE_MODE') == "DEMO"){
		echo "<div style='padding:30px; text-align:center; width:100%;'>";
			echo "<div class='row'>";
				echo "<span style='font-size: 22px; font-weight:700'>Learn more about the Books App!</span>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<p style='font-size:16px; margin:20px 0 0 0;'>For more information about the Abre Platform visit <a href='https://www.abre.io/' style='color:".getSiteColor().";' target='_blank'>our website</p>";
			echo "</div>";
		echo "</div>";
	}else{
		echo "<div id='displaylibrary'>"; include "books_display.php"; echo "</div>";
	}


?>