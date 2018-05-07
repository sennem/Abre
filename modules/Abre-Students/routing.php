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
	require_once('functions.php');
	require_once('permissions.php');

	if($_SESSION['usertype']=='staff' || $isParent)
    {
		echo "
			'students': function(name) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('Students');
				document.title = 'Students';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/home.php', function() { init_page(); });
				$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
				ga('set', 'page', '/#students/');
				ga('send', 'pageview');
			},
			'students/group/?:group': function(group) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('#loader').show();
				$('#titletext').text('Students');
				document.title = 'Students';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/course.php?groupid='+group, function() { init_page(); back_button('#students'); });
				$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
				ga('set', 'page', '/#students/group/');
				ga('send', 'pageview');
			},
			'students/counseling/?:counselingid': function(staffid) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('#loader').show();
				$('#titletext').text('Students');
				document.title = 'Students';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/course.php?counselingid='+staffid, function() { init_page(); back_button('#students'); });
				$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
				ga('set', 'page', '/#students/counseling/');
				ga('send', 'pageview');
			},
			'students/?:course/?:section': function(course,section) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('#loader').show();
				$('#titletext').text('Students');
				document.title = 'Students';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/course.php?courseid='+course+'&section='+section, function() { init_page(); back_button('#students'); });
				$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
				ga('set', 'page', '/#students/course/');
				ga('send', 'pageview');
			},
			'mystudents': function(name) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('.tooltipped').tooltip('remove');
				$('#loader').show();
				$('#titletext').text('My Students');
				document.title = 'My Students';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/dashboard.php', function() { init_page(); });
				$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
				ga('set', 'page', '/#mystudents/');
				ga('send', 'pageview');
			},
			'mystudents/?:studentid': function(studentid) {
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('#loader').show();
				$('#titletext').text('My Students');
				document.title = 'My Students';
				$('#content_holder').load( 'modules/".basename(__DIR__)."/student.php?Student_ID='+studentid, function() { init_page(); back_button('#mystudents'); });
				$('#modal_holder').load('modules/".basename(__DIR__)."/modals.php');
				ga('set', 'page', '/#mystudents/student/');
				ga('send', 'pageview');
			},";
	}

?>
