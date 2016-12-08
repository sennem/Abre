<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
    
    //Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	    
	    $StreamEnd=20;
	    if(isset($_GET["StreamEnd"])){ $StreamEnd=$_GET["StreamEnd"]; }
	
		echo "		
			'': function()
			{
				$('#navigation_top').hide();
				$('#content_holder').hide();
				$('#loader').show();
				$('#titletext').text('Home');
				document.title = 'Stream';
				$('#modal_holder').load( 'modules/stream/modals.php', function()
				{				
					$('#content_holder').load( 'modules/stream/stream.php?StreamEnd=$StreamEnd');
				});
				
				$( '#navigation_top' ).show();
				$( '#navigation_top' ).load( 'modules/stream/menu.php', function() {	
					$( '#navigation_top' ).show();
					$('.tab_1').addClass('tabmenuover');
				});							
			},		
			'likes': function() 
			{
				$( '#navigation_top' ).hide();
				$( '#content_holder' ).hide();
				$( '#loader' ).show();
				$( '#titletext' ).text('Home');
				document.title = 'Stream';
				$('#modal_holder').load( 'modules/stream/modals.php', function()
				{
					$( '#content_holder' ).load( 'modules/stream/likes.php');
				});
					
				$( '#navigation_top' ).show();
				$( '#navigation_top' ).load( 'modules/stream/menu.php', function() {	
					$( '#navigation_top' ).show();
					$('.tab_2').addClass('tabmenuover');
				});				
			},";
	
?>