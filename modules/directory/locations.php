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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once('permissions.php');

	if($location!=""){ echo "<option value='$location' selected>$location</option>"; }else{ echo "<option value='$location' selected>Choose</option>"; }
	$sql = "SELECT options FROM directory_settings where dropdownID='homeBuildings'";
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	$titles = explode(PHP_EOL, $row['options']);
	foreach($titles as $value){
		$val = str_replace(array("\n\r", "\n", "\r"), '', $value);
		echo "<option value ='$val'>$val</option>";
	 }
?>
	<!-- <option value="ABLE">ABLE</option>
	<option value="JDC">JDC/JRC</option>
	<option value="Badin">Badin</option>
	<option value="Grant ELC">Grant ELC</option>
	<option value="Hayes">Hayes</option>
	<option value="Board Office">Board Office</option>
	<option value="Bridgeport">Bridgeport</option>
	<option value="Brookwood">Brookwood</option>
	<option value="Crawford Woods">Crawford Woods</option>
	<option value="Fairwood">Fairwood</option>
	<option value="Highland">Highland</option>
	<option value="Linden">Linden</option>
	<option value="Ridgeway">Ridgeway</option>
	<option value="Riverview">Riverview</option>
	<option value="Garfield">Garfield</option>
	<option value="Wilson">Wilson</option>
	<option value="Hamilton Freshman">Hamilton Freshman</option>
	<option value="Hamilton High">Hamilton High</option>
	<option value="Maintenance">Maintenance</option>
	<option value="Transportation">Transportation</option>
	<option value="Food Service">Food Service</option>
	<option value="Immanuel Lutheran">Immanuel Lutheran</option>
	<option value="St. Ann">St. Ann</option>
	<option value="St. Peter">St. Peter</option>
	<option value="St. Joseph">St. Joseph</option> -->
