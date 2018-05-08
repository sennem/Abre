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


	if($_SESSION['usertype'] == "staff")
	{
	echo "
		'guide': function() {
			$( '#navigation_top' ).hide();
			$( '#content_holder' ).hide();
			$( '#loader' ).show();
			$( '#titletext' ).text('Guided Learning');
			document.title = 'Guided Learning';
			$( '#content_holder' ).load( 'modules/".basename(__DIR__)."/builder.php', function() { init_page(); });
			$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals_builder.php' );
			ga('set', 'page', '/#guide/');
			ga('send', 'pageview');
		},
		'guide/users/?:code': function(code) {
			$( '#navigation_top' ).hide();
			$( '#content_holder' ).hide();
			$( '#loader' ).show();
			$( '#titletext' ).text('Guided Learning');
			document.title = 'Guided Learning';
			$( '#content_holder' ).load( 'modules/".basename(__DIR__)."/lessonactivity.php?code='+code, function() { init_page(); back_button('#guide'); });
			$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals_builder.php' );
			ga('set', 'page', '/#guide/users/');
			ga('send', 'pageview');
		},
		'guide/users/?:code/?:id': function(code, id) {
			$( '#navigation_top' ).hide();
			$( '#content_holder' ).hide();
			$( '#loader' ).show();
			$( '#titletext' ).text('Guided Learning');
			document.title = 'Guided Learning';
			$( '#content_holder' ).load( 'modules/".basename(__DIR__)."/studentactivity.php?code='+code+'&id='+id, function() { init_page(); back_button('#guide/users/'+code); });
			$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals_builder.php' );
			ga('set', 'page', '/#guide/users/activity/');
			ga('send', 'pageview');
		},";
	}

?>