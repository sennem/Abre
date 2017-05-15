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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if(superadmin() && !file_exists("$portal_path_root/modules/settings/setup.txt"))
	{
		//Check for users_parents table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM users_parent"))
		{
			$stmt = $db->stmt_init();
      $sql = "CREATE TABLE `users_parent` (`id` int(11) NOT NULL,`email` text NOT NULL,`students` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
      $sql .= "ALTER TABLE `users_parent` ADD PRIMARY KEY (`id`);";
      $sql .= "ALTER TABLE `users_parent` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
			$stmt->prepare($sql);
			$stmt->execute();
		}

		//Check for student_tokens table
		if(!$db->query("SELECT * FROM student_tokens"))
		{
			$stmt = $db->stmt_init();
			$sql = "CREATE TABLE `student_tokens` (`id` int(11) NOT NULL,`studentId` text NOT NULL,`token` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `student_tokens` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `student_tokens` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
			$stmt->prepare($sql);
			$stmt->execute();

			$sql = "SELECT studentId FROM Abre_Students";
			$result = $db->query($sql);
			$studentIds = [];
			while($row = $result->fetch_array($result, MYSQL_ASSOC)){
				$studentIds = $row['studentId'];
			}
			foreach($studentIds as $id){
				$stringToken = $id . string(time());
				$token = encrypt(substr(hash('sha256', $token), 0, 10), "");
				$stmt = $db->stmt_init();
				$sql = "INSERT INTO `student_tokens` (`studentId`, `token`) VALUES ('$id', '$token');";
				$stmt->prepare($sql);
				$stmt->execute();
			}
			$db->close();
		}
  }

  //Write the Setup File
  $myfile = fopen("$portal_path_root/modules/settings/setup.txt", "w");
  fwrite($myfile, '');
  fclose($myfile);
?>
