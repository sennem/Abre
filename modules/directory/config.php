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
	require(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
	//Check for tables
	if(!$resultbooks = $db->query("SELECT *  FROM directory"))
	{
		$sql = "CREATE TABLE `directory` (
  `id` int(11) NOT NULL,
  `updatedtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `superadmin` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `archived` int(11) NOT NULL,
  `picture` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `middlename` text NOT NULL,
  `title` text NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `zip` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `cellphone` text NOT NULL,
  `gender` text NOT NULL,
  `ethnicity` text NOT NULL,
  `contract` text NOT NULL,
  `grade` text NOT NULL,
  `subject` text NOT NULL,
  `ss` text NOT NULL,
  `dob` text NOT NULL,
  `classification` text NOT NULL,
  `location` text NOT NULL,
  `doh` text NOT NULL,
  `senioritydate` text NOT NULL,
  `effectivedate` text NOT NULL,
  `step` text NOT NULL,
  `salary` text NOT NULL,
  `hours` text NOT NULL,
  `stateeducatorid` text NOT NULL,
  `licensetype1` text NOT NULL,
  `licenseissuedate1` text NOT NULL,
  `licenseexpirationdate1` text NOT NULL,
  `licenseterm1` text NOT NULL,
  `licensetype2` text NOT NULL,
  `licenseissuedate2` text NOT NULL,
  `licenseexpirationdate2` text NOT NULL,
  `licenseterm2` text NOT NULL,
  `licensetype3` text NOT NULL,
  `licenseissuedate3` text NOT NULL,
  `licenseexpirationdate3` text NOT NULL,
  `licenseterm3` text NOT NULL,
  `licensetype4` text NOT NULL,
  `licenseissuedate4` text NOT NULL,
  `licenseexpirationdate4` text NOT NULL,
  `licenseterm4` text NOT NULL,
  `licensetype5` text NOT NULL,
  `licenseissuedate5` text NOT NULL,
  `licenseexpirationdate5` text NOT NULL,
  `licenseterm5` text NOT NULL,
  `licensetype6` text NOT NULL,
  `licenseissuedate6` text NOT NULL,
  `licenseexpirationdate6` text NOT NULL,
  `licenseterm6` text NOT NULL,
  `probationreportdate` text NOT NULL,
  `statebackgroundcheck` text NOT NULL,
  `federalbackgroundcheck` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$sql .= "CREATE TABLE `directory_discipline` (
  `id` int(11) NOT NULL,
  `archived` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$sql .= "ALTER TABLE `directory`
  ADD PRIMARY KEY (`id`);";
  		$sql .= "ALTER TABLE `directory_discipline`
  ADD PRIMARY KEY (`id`);";
   		$sql .= "ALTER TABLE `directory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
  		$sql .= "ALTER TABLE `directory_discipline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

  		if ($db->multi_query($sql) === TRUE) { }
	}
	$db->close();

	$pageview=1;
	$drawerhidden=0;
	$pageorder=5;
	$pagetitle="Directory";
	$pageicon="people";
	$pagepath="directory";
	$pagerestrictions="student";
	
	require_once('permissions.php');

?>

<script>

//Page Locations
routie({
    'directory': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/directory.php', function() { init_page(); $("#searchquery").focus(); });
		
			<?php if($pageaccess==1){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/directory/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>

		
    },
    'directory/archived': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/archieved.php', function() { init_page(); });
		
			<?php if($pageaccess==1){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/directory/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>
		
    },
    'directory/export': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/export.php', function() { init_page(); });
		
			<?php if($pageaccess==1){ ?>
				//Load Navigation
				$( "#navigation_top" ).show();
				$( "#navigation_top" ).load( "modules/directory/menu.php", function() {	
					$( "#navigation_top" ).show();
				});
			<?php } ?>
		
    },
    'directory/?:name': function(name) {
	    $( "#navigation_top" ).hide();
	    $( "#content_holder" ).hide();
	    $( "#loader" ).show();
	    $('.tooltipped').tooltip('remove');
	    $( "#titletext" ).text("Directory");
	    document.title = 'HCSD Portal - Directory';
		$( "#content_holder" ).load( 'modules/directory/profile.php?id='+name, function() { init_page(); $("#firstname").focus(); });
    }
});

</script>