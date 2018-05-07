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
		    'books': function(name) {
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('.tooltipped').tooltip('remove');
			    $('#loader').show();
			    $('#titletext').text('Books');
			    document.title = 'Books';
					$('#content_holder').load('modules/".basename(__DIR__)."/books.php', function() { init_page(); });
					$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
					ga('set', 'page', '/#books/');
					ga('send', 'pageview');";

					if(CONSTANT('SITE_MODE') != 'DEMO'){
					echo "$('#navigation_top').show();
						$('#navigation_top').load('modules/".basename(__DIR__)."/menu.php', function() {
							$('#navigation_top').show();
							$('.tab_1').addClass('tabmenuover');
						});";
					}
		    echo "},
		    'books/inventory': function(name) {
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('.tooltipped').tooltip('remove');
			    $('#loader').show();
			    $('#titletext').text('Books');
			    document.title = 'Books Inventory';
					$('#content_holder').load('modules/".basename(__DIR__)."/inventory.php', function() { init_page(); });
					$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
					ga('set', 'page', '/#books/inventory/');
					ga('send', 'pageview');

					$('#navigation_top').show();
					$('#navigation_top').load('modules/".basename(__DIR__)."/menu.php', function() {
						$('#navigation_top').show();
						$('.tab_2').addClass('tabmenuover');
					});
		    },
		    'books/?:name': function(name) {
			    $('#navigation_top').hide();
			    $('#content_holder').hide();
			    $('.tooltipped').tooltip('remove');
			    $('#loader').show();
			    $('#titletext').text('Books');
			    document.title = 'Reader';
					$('#content_holder').load('modules/".basename(__DIR__)."/reader.php?id='+name, function() { init_page(); back_button('#books'); });
					ga('set', 'page', '/#books/reader/');
					ga('send', 'pageview');
		    },";
?>