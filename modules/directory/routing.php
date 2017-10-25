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

  if($_SESSION['usertype'] == "staff"){

		echo "
			'directory': function(name) {
		    	$('#navigation_top').hide();
				$('#content_holder').hide();
				$('#loader').show();
				$('#titletext').text('Staff Directory');
				document.title = 'Staff Directory';
				$('#content_holder').load( 'modules/directory/directory.php', function() { init_page(); $('#searchquery').focus(); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				$( '#navigation_top' ).show();
				$( '#navigation_top' ).load( 'modules/directory/menu.php', function() {
					$( '#navigation_top' ).show();
					$('.tab_1').addClass('tabmenuover');
				});
	    	},
			'directory/archived': function(name) {
		    	$( '#navigation_top' ).hide();
				$( '#content_holder' ).hide();
				$( '#loader' ).show();
				$( '#titletext' ).text('Staff Directory');
				document.title = 'Staff Directory';
				$( '#content_holder' ).load( 'modules/directory/archieved.php', function() { init_page(); });

				$( '#navigation_top' ).show();
				$( '#navigation_top' ).load( 'modules/directory/menu.php', function() {
					$( '#navigation_top' ).show();
					$('.tab_2').addClass('tabmenuover');
				});
	    	},
			'directory/settings': function(name) {
		    	$( '#navigation_top' ).hide();
				$( '#content_holder' ).hide();
				$( '#loader' ).show();
				$( '#titletext' ).text('Staff Directory');
				document.title = 'Staff Directory';
				$( '#content_holder' ).load( 'modules/directory/settings.php', function() { init_page(); });


				$( '#navigation_top' ).show();
				$( '#navigation_top' ).load( 'modules/directory/menu.php', function() {
					$( '#navigation_top' ).show();
					$('.tab_3').addClass('tabmenuover');
				});
	    	},
			'directory/?:name': function(name) {
		    	$( '#navigation_top' ).hide();
				$( '#content_holder' ).hide();
				$( '#loader' ).show();
				$( '#titletext' ).text('Staff Directory');
				document.title = 'Staff Directory';
				$( '#content_holder' ).load( 'modules/directory/profile.php?id='+name, function() { init_page(); back_button('#directory'); $('#firstname').focus();
				});
	    	},";
	}
?>
