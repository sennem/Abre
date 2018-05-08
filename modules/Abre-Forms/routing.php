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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once("functions.php");

	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{
		echo "
			'forms': function() {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_forms.php', function() { init_page(); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );";

				if(CONSTANT('SITE_MODE') != "DEMO" || superadmin()){
					echo "$('#navigation_top').show();
					$('#navigation_top').load('modules/".basename(__DIR__)."/menu_forms.php?', function() {
						$('#navigation_top').show();
						$('.tab_1').addClass('tabmenuover');
					});";
				}

				echo "ga('set', 'page', '/#forms/');
				ga('send', 'pageview');

			},";
	}
	else
	{
		echo "
			'forms': function() {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_recommended.php', function() { init_page(); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				ga('set', 'page', '/#forms/');
				ga('send', 'pageview');

			},";
	}

		echo "
			'forms/recommended': function() {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_recommended.php', function() { init_page(); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				";

				if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
				{

					echo "

					$('#navigation_top').show();
					$('#navigation_top').load('modules/".basename(__DIR__)."/menu_forms.php?', function() {
						$('#navigation_top').show();
						$('.tab_3').addClass('tabmenuover');
					});

					";

				}

				echo "

				ga('set', 'page', '/#forms/recommended/');
				ga('send', 'pageview');

			},";

		echo "
			'forms/templates': function() {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_templates.php', function() { init_page(); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				$('#navigation_top').show();
				$('#navigation_top').load('modules/".basename(__DIR__)."/menu_forms.php?', function() {
					$('#navigation_top').show();
					$('.tab_4').addClass('tabmenuover');
				});

				ga('set', 'page', '/#forms/templates/');
				ga('send', 'pageview');

			},
			'forms/builder/?:id': function(id) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_builder.php?id='+id, function() { init_page(); back_button('#forms'); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				$('#navigation_top').show();
				$('#navigation_top').load('modules/".basename(__DIR__)."/menu_form.php?id='+id, function() {
					$('#navigation_top').show();
					$('.tab_1').addClass('tabmenuover');
				});

				ga('set', 'page', '/#forms/builder/');
				ga('send', 'pageview');

			},
			'forms/preview/?:id': function(id) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_preview.php?id='+id, function() { init_page(); back_button('#forms'); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				$('#navigation_top').show();
				$('#navigation_top').load('modules/".basename(__DIR__)."/menu_form.php?id='+id, function() {
					$('#navigation_top').show();
					$('.tab_2').addClass('tabmenuover');
				});

				ga('set', 'page', '/#forms/preview/');
				ga('send', 'pageview');

			},
			'forms/view/?:id': function(id) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_form.php?id='+id, function() { init_page(); back_button('#forms/recommended'); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				ga('set', 'page', '/#forms/view/');
				ga('send', 'pageview');

			},
			'forms/settings/?:id': function(id) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_settings.php?id='+id, function() { init_page(); back_button('#forms'); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				$('#navigation_top').show();
				$('#navigation_top').load('modules/".basename(__DIR__)."/menu_form.php?id='+id, function() {
					$('#navigation_top').show();
					$('.tab_5').addClass('tabmenuover');
				});

				ga('set', 'page', '/#forms/settings/');
				ga('send', 'pageview');

			},
			'forms/responses/entry/?:id/?:entryid': function(id,entryid) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_entry.php?id='+id+'&entryid='+entryid, function() { init_page(); back_button('#forms/responses/'+id); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				$('#navigation_top').show();
				$('#navigation_top').load('modules/".basename(__DIR__)."/menu_form.php?id='+id, function() {
					$('#navigation_top').show();
					$('.tab_4').addClass('tabmenuover');
				});

				ga('set', 'page', '/#forms/responses/entry/');
				ga('send', 'pageview');

			},
			'forms/responses/?:id': function(id) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Forms');
				document.title = 'Forms';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_responses.php?id='+id, function() { init_page(); back_button('#forms'); });
				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				$('#navigation_top').show();
				$('#navigation_top').load('modules/".basename(__DIR__)."/menu_form.php?id='+id, function() {
					$('#navigation_top').show();
					$('.tab_4').addClass('tabmenuover');
				});

				ga('set', 'page', '/#forms/responses/');
				ga('send', 'pageview');

			},
			'forms/session/?:id/?:sessionid': function(id, sessionid)
		    {
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('.mdl-layout__header').hide();
			    $('#loader').show();
			    $('#titletext').text('Forms');
			    document.title = 'Forms';
					$('#content_holder').load('modules/".basename(__DIR__)."/view_form.php?id='+id+'&sessionid='+sessionid, function() {
						init_page();
						$('.mdl-layout__header').hide();
					});
					ga('set', 'page', '/#forms/session/');
					ga('send', 'pageview');
			},
			'forms/summary/?:id': function(id) {
				 $('#navigation_top').hide();
				 $('#content_holder').hide();
				 $('.tooltipped').tooltip('remove');
				 $('#loader').show();
				 $('#titletext').text('Forms');
				 document.title = 'Forms';
				 $('#content_holder').load( 'modules/".basename(__DIR__)."/view_response_summary.php?id='+id, function() { init_page(); back_button('#forms'); });
				 $( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

				 $('#navigation_top').show();
				 $('#navigation_top').load('modules/".basename(__DIR__)."/menu_form.php?id='+id, function() {
					 $('#navigation_top').show();
					 $('.tab_3').addClass('tabmenuover');
				 });

				 ga('set', 'page', '/#forms/summary/');
				 ga('send', 'pageview');

			 },
			 'forms/sharedforms': function() {
				 $('#navigation_top').hide();
	 				$('#content_holder').hide();
	 				$('.tooltipped').tooltip('remove');
	 				$('#loader').show();
	 				$('#titletext').text('Forms');
	 				document.title = 'Forms';
	 				$('#content_holder').load( 'modules/".basename(__DIR__)."/view_shared_forms.php', function() { init_page(); });
	 				$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

	 				$('#navigation_top').show();
	 				$('#navigation_top').load('modules/".basename(__DIR__)."/menu_forms.php', function() {
	 					$('#navigation_top').show();
	 					$('.tab_2').addClass('tabmenuover');
	 				});

	 				ga('set', 'page', '/#forms/sharedforms/');
	 				ga('send', 'pageview');

 			},";

?>