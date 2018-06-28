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
	//$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );
		if($_SESSION['usertype'] == "staff"){
			echo "
				'tester': function()
				{
				    $('#navigation_top').hide();
				    $('#content_holder').hide();
				    $('#loader').show();
				    $('#titletext').text('Tester');
				    document.title = 'Tester';
					$('#content_holder').load('modules/".basename(__DIR__)."/home.php', function() { init_page(); });
			  },
				'tester/elements': function()
				{
						$('#navigation_top').hide();
						$('#content_holder').hide();
						$('#loader').show();
						$('#titletext').text('Tester');
						document.title = 'Tester';
					$('#content_holder').load('modules/".basename(__DIR__)."/elements.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );
				},";
		}
?>
