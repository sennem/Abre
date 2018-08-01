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

		echo "
		    'moods': function(name) {
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('.tooltipped').tooltip('remove');
			    $('#loader').show();
			    $('#titletext').text('Moods');
			    document.title = 'Moods';
					$('#content_holder').load('modules/".basename(__DIR__)."/page_menu_or_roster.php', function() { init_page(); });
					$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
					ga('set', 'page', '/#moods/');
					ga('send', 'pageview');";

					if(CONSTANT('SITE_MODE') != 'DEMO'){
					echo "$('#navigation_top').show();
						$('#navigation_top').load('modules/".basename(__DIR__)."/menu.php', function() {
							$('#navigation_top').show();
							$('.tab_1').addClass('tabmenuover');
						});";
					}
		    echo "},
		    'moods/details': function(name) {
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('.tooltipped').tooltip('remove');
			    $('#loader').show();
			    $('#titletext').text('Moods');
			    document.title = 'Moods Memory';
					$('#content_holder').load('modules/".basename(__DIR__)."/page_history_or_overview.php', function() { init_page(); });
					ga('set', 'page', '/#moods/details/');
					ga('send', 'pageview');

					$('#navigation_top').show();
					$('#navigation_top').load('modules/".basename(__DIR__)."/menu.php', function() {
						$('#navigation_top').show();
						$('.tab_2').addClass('tabmenuover');
					});
		    },";
?>
