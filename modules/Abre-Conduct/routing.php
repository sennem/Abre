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

		if($_SESSION['usertype'] == "staff"){
			echo "
				'conduct': function(name)
				{
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/home.php', function() { init_page(); });
					ga('set', 'page', '/#conduct/');
					ga('send', 'pageview');
			  },
			  'conduct/classroom': function(name)
				{
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/classroom.php', function() { init_page(); back_button('#conduct'); });
					ga('set', 'page', '/#conduct/classroom/');
					ga('send', 'pageview');
			    },
			  'conduct/classroom/?:coursegroup/?:section': function(coursegroup,section)
				{
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/class.php?coursegroup='+coursegroup+'&section='+section, function() { init_page(); back_button('#conduct/classroom'); });
			  },
			  'conduct/pbis': function(name)
				{
					$('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/home.php', function() { init_page(); back_button('#conduct'); });
					ga('set', 'page', '/#conduct/pbis/');
					ga('send', 'pageview');
			  },
			  'conduct/discipline/open': function(name)
				{
					$('.picker').remove();
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/open.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );";

					if(CONSTANT('SITE_MODE') != 'DEMO'){
						echo "$( '#navigation_top' ).show();
						$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
							$( '#navigation_top' ).show();
							$('.tab_1').addClass('tabmenuover');
						});";
					}
					echo "ga('set', 'page', '/#conduct/discipline/open/');
					ga('send', 'pageview');
			  },
			  'conduct/discipline/closed': function(name)
				{
					$('.picker').remove();
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/closed.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

					$( '#navigation_top' ).show();
					$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
						$( '#navigation_top' ).show();
						$('.tab_4').addClass('tabmenuover');
					});
					ga('set', 'page', '/#conduct/discipline/closed/');
					ga('send', 'pageview');
			    },";

			echo "
			  'conduct/discipline/queue': function(name)
				{
					$('.picker').remove();
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/queue.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

					$( '#navigation_top' ).show();
					$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
						$( '#navigation_top' ).show();
						$('.tab_2').addClass('tabmenuover');
					});
					ga('set', 'page', '/#conduct/discipline/queue/');
					ga('send', 'pageview');
			  },
			  'conduct/discipline/verification': function(name)
				{
					$('.picker').remove();
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/verification.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

					$( '#navigation_top' ).show();
					$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
						$( '#navigation_top' ).show();
						$('.tab_3').addClass('tabmenuover');
					});
					ga('set', 'page', '/#conduct/discipline/verification/');
					ga('send', 'pageview');
			  },
			  'conduct/discipline/reports': function(name)
				{
					$('.picker').remove();
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('#loader').show();
			    $('#titletext').text('Conduct');
			    document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/reports.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

					$( '#navigation_top' ).show();
					$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
						$( '#navigation_top' ).show();
						$('.tab_5').addClass('tabmenuover');
					});
					ga('set', 'page', '/#conduct/discipline/reports/');
					ga('send', 'pageview');
			  },
				'conduct/discipline/settings': function(name)
				{
					$('.picker').remove();
					$('#navigation_top').hide();
					$('#content_holder').hide();
					$('#loader').show();
					$('#titletext').text('Conduct');
					document.title = 'Conduct';
					$('#content_holder').load('modules/".basename(__DIR__)."/settings.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );

					$( '#navigation_top' ).show();
					$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
						$( '#navigation_top' ).show();
						$('.tab_6').addClass('tabmenuover');
					});
					ga('set', 'page', '/#conduct/discipline/settings/');
					ga('send', 'pageview');
				},";
			//}
		}
?>