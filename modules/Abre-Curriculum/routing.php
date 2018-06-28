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

  if($_SESSION['usertype'] == "staff")
  {
		echo "
		    'curriculum': function(name) {
			    $( '#navigation_top' ).hide();
			    $( '#content_holder' ).hide();
			    $( '#loader' ).show();
			    $( '#titletext' ).text('Curriculum');
			    document.title = 'Curriculum';
					$( '#content_holder' ).load( 'modules/".basename(__DIR__)."/curriculum.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );
					ga('set', 'page', '/#curriculum/');
					ga('send', 'pageview');";

					if(CONSTANT('SITE_MODE') != "DEMO"){
						echo "$( '#navigation_top' ).show();
						$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
							$( '#navigation_top' ).show();
							$('.tab_1').addClass('tabmenuover');
						});";
					}
		    echo "},
		    'curriculum/courses': function(name) {
			    $( '#navigation_top' ).hide();
			    $( '#content_holder' ).hide();
			    $( '#loader' ).show();
			    $( '#titletext' ).text('Curriculum');
			    document.title = 'Curriculum';
					$( '#content_holder' ).load( 'modules/".basename(__DIR__)."/courses_display.php', function() { init_page(); });
					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );
					ga('set', 'page', '/#curriculum/courses/');
					ga('send', 'pageview');

					$( '#navigation_top' ).show();
					$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/menu.php', function() {
						$( '#navigation_top' ).show();
						$('.tab_2').addClass('tabmenuover');
					});
		    },
		    'curriculum/?:unitid/?:name': function(unitid, name) {
			    $( '#navigation_top' ).hide();
			    $( '#content_holder' ).hide();
			    $( '#loader' ).show();
			    $( '#titletext' ).text('Pacing Guide');
			    document.title = 'Pacing Guide';
					$( '#content_holder' ).load( 'modules/".basename(__DIR__)."/pacingguide.php?unitid='+unitid+'&id='+name, function() {
						init_page();
						back_button('#curriculum');
					});

					ga('set', 'page', '/#curriculum/course/');
					ga('send', 'pageview');

					$( '#modal_holder' ).load( 'modules/".basename(__DIR__)."/modals.php' );
		    },
		    'curriculum/lesson/?:unitid/?:course/?:name': function(unitid, course, name) {
			    $( '#navigation_top' ).hide();
			    $( '#content_holder' ).hide();
			    $( '#loader' ).show();
			    $( '#titletext' ).text('Model Lesson');
			    document.title = 'Model Lesson';
			    ga('set', 'page', '/#curriculum/lesson/');
					ga('send', 'pageview');

					$( '#navigation_top' ).show();
					$( '#navigation_top' ).load( 'modules/".basename(__DIR__)."/lesson_title.php?lesson='+name+'&course='+course, function() {
						$( '#navigation_top' ).show();

						$( '#content_holder' ).load( 'modules/".basename(__DIR__)."/lesson.php?lid='+name+'&cid='+course, function() {
							init_page();
							back_button('#curriculum/'+unitid+'/'+course);
						});

					});
		    },";
	}

?>