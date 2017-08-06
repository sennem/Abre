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

	echo "<option value='' disabled selected>Choose a Role</option>";

	if (strpos($role, 'Directory Administrator') !== false) {
		echo "<option value='Directory Administrator' selected='selected'>Directory Administrator</option>";
	}
	else
	{
		echo "<option value='Directory Administrator'>Directory Administrator</option>";
	}

	if (strpos($role, 'Directory Supervisor') !== false) {
		echo "<option value='Directory Supervisor' selected='selected'>Directory Supervisor</option>";
	}
	else
	{
		echo "<option value='Directory Supervisor'>Directory Supervisor</option>";
	}

	if (strpos($role, 'Directory Advisor') !== false) {
		echo "<option value='Directory Advisor' selected='selected'>Directory Advisor</option>";
	}
	else
	{
		echo "<option value='Directory Advisor'>Directory Advisor</option>";
	}

	if (strpos($role, 'Conduct Verification Monitor') !== false) {
		echo "<option value='Conduct Verification Monitor' selected='selected'>Conduct Verification Monitor</option>";
	}
	else
	{
		echo "<option value='Conduct Verification Monitor'>Conduct Verification Monitor</option>";
	}

?>
