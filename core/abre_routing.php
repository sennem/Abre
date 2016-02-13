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
	
?>

<script>

//Toggle Side Navigation Drawer
function toggle_drawer() {
	var drawer = document.getElementsByClassName('mdl-layout__drawer')[0];
	var drawer_obfuscator = document.getElementsByClassName('mdl-layout__obfuscator')[0];
	drawer.classList.toggle("is-visible");
	drawer_obfuscator.classList.toggle("is-visible");
}

//Start the Page
function init_page(loader) {
	//Hide Loader
	if (loader === undefined){ $( "#loader" ).hide(); }	
	//Scroll to Top
	var content = $(".mdl-layout__content");
	var target = top ? 0 : $(".content").height();
	content.stop().animate({ scrollTop: target }, 0);
	//Fade in Content
	$( "#content_holder" ).fadeTo(0,0);
	$( "#content_holder" ).css({marginTop: '100px'});
	$( "#content_holder" ).animate({ opacity: 1, marginTop: "0" }, 500, "swing");
	
	//Register MDL elements
	var html = document.createElement('content_holder');
	$(document.body).append(html);      
	componentHandler.upgradeAllRegistered();
	//Make sure top nav is present
	$("header").removeClass( "animated slideOutUp" );	
}

//404 Not Found Page
routie({
    '*': function() {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $( "#titletext" ).text("404");
	    document.title = 'HCSD Portal';
		$( "#content_holder" ).load( "core/abre_404.php", function() { init_page(); });
    }
});

</script>