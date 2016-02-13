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
	
	//Configuration
	require(dirname(__FILE__) . '/../../configuration.php'); 
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	require_once('permissions.php');
	
	if($ethnicity!=""){ echo "<option value='$ethnicity' selected>$ethnicity</option>"; }else{ echo "<option value='$ethnicity' selected>Choose</option>"; }
	
?>
	<option value="Caucasian">Caucasian</option>
	<option value="African American/Black">African American/Black</option>
	<option value="Hispanic/Latino">Hispanic/Latino</option>
	<option value="Asian">Asian</option>
	<option value="Middle Eastern">Middle Eastern</option>
	<option value="Pacific Islander">Pacific Islander</option>
	<option value="Native American/Alaskan">Native American/Alaskan</option>
	<option value="Other">Other</option>