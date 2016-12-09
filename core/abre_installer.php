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
	
if (!file_exists('configuration.php'))
{
	
	$site_title=$_POST["site_title"];
	$domain_name=$_POST["domain_name"];
	$db_host=$_POST["db_host"];
	$db_name=$_POST["db_name"];
	$db_user=$_POST["db_user"];
	$db_password=$_POST["db_password"];
	$google_client_id=$_POST["google_client_id"];
	$google_client_secret=$_POST["google_client_secret"];
	$google_api_key=$_POST["google_api_key"];
		
	if(isset($site_title))
	{
		
		//Check connection to database
		$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
		if (!$conn->connect_error)
		{ 

			//Create required database tables
			$sql = "CREATE TABLE `users` (`id` int(11) NOT NULL,`email` text NOT NULL,`superadmin` int(11) NOT NULL DEFAULT '0',`refresh_token` text NOT NULL,`cookie_token` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	  		$sql .= "ALTER TABLE `users` ADD PRIMARY KEY (`id`);";
	  		$sql .= "ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
	  		
			$sql .= "CREATE TABLE IF NOT EXISTS `directory` (`id` int(11) NOT NULL AUTO_INCREMENT,`updatedtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,`superadmin` int(11) NOT NULL,`admin` int(11) NOT NULL,`archived` int(11) NOT NULL,`picture` text NOT NULL,`firstname` text NOT NULL,`lastname` text NOT NULL,`middlename` text NOT NULL,`title` text NOT NULL,`contract` text NOT NULL,`address` text NOT NULL,`city` text NOT NULL,`state` text NOT NULL,`zip` text NOT NULL,`email` text NOT NULL,`phone` text NOT NULL,`cellphone` text NOT NULL,`ss` text NOT NULL,`dob` text NOT NULL,`gender` text NOT NULL,`ethnicity` text NOT NULL,`classification` text NOT NULL,`location` text NOT NULL,`grade` text NOT NULL,`subject` text NOT NULL,`doh` text NOT NULL,`senioritydate` text NOT NULL,`effectivedate` text NOT NULL,`step` text NOT NULL,`salary` text NOT NULL,`hours` text NOT NULL,`stateeducatorid` text NOT NULL,`licensetype1` text NOT NULL,`licenseissuedate1` text NOT NULL,`licenseexpirationdate1` text NOT NULL,`licenseterm1` text NOT NULL,`licensetype2` text NOT NULL,`licenseissuedate2` text NOT NULL,`licenseexpirationdate2` text NOT NULL,`licenseterm2` text NOT NULL,`licensetype3` text NOT NULL,`licenseissuedate3` text NOT NULL,`licenseexpirationdate3` text NOT NULL,`licenseterm3` text NOT NULL,`licensetype4` text NOT NULL,`licenseissuedate4` text NOT NULL,`licenseexpirationdate4` text NOT NULL,`licenseterm4` text NOT NULL,`licensetype5` text NOT NULL,`licenseissuedate5` text NOT NULL,`licenseexpirationdate5` text NOT NULL,`licenseterm5` text NOT NULL,`licensetype6` text NOT NULL,`licenseissuedate6` text NOT NULL,`licenseexpirationdate6` text NOT NULL,`licenseterm6` text NOT NULL,`probationreportdate` text NOT NULL,`statebackgroundcheck` text NOT NULL,`federalbackgroundcheck` text NOT NULL,`permissions` text NOT NULL,`contractdays` text NOT NULL,`RefID` text NOT NULL,`StateID` text NOT NULL,`TeacherID` text NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	   		$sql .= "CREATE TABLE `directory_discipline` (`id` int(11) NOT NULL,`archived` int(11) NOT NULL,`UserID` int(11) NOT NULL,`Filename` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	  		$sql .= "ALTER TABLE `directory_discipline` ADD PRIMARY KEY (`id`);";
	  		$sql .= "ALTER TABLE `directory_discipline` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";	
	  		
	  		
			//Create Configuration file
			$myfile = fopen("configuration.php", "w") or die("Unable to create configuration file.");
				
			//Setup PHP file
			$txt = "<?php\n\n";
			fwrite($myfile, $txt);
				
			//Get current URL and write path
			function url(){
				return sprintf(
					"%s://%s%s",
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
				    $_SERVER['SERVER_NAME'],
				    $_SERVER['REQUEST_URI']
				);
			}
			
			$currenturl=url();
			$currenturl = substr($currenturl, 0, strrpos($currenturl, "/"));
			$txt = '$portal_root = "'.$currenturl.'";';
			fwrite($myfile, $txt);
				
			//Write Google Apps Domain name
			if($domain_name!="")
			{
				$txt = "\n";
				fwrite($myfile, $txt);
				$txt = "if (!defined('SITE_GAFE_DOMAIN')){ define('SITE_GAFE_DOMAIN','$domain_name'); }";
				fwrite($myfile, $txt);
			}
				
			//Write MySQL host
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('DB_HOST')){ define('DB_HOST','$db_host'); }";
			fwrite($myfile, $txt);
			
			//Write MySQL name
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('DB_NAME')){ define('DB_NAME','$db_name'); }";
			fwrite($myfile, $txt);
				
			//Write MySQL username
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('DB_USER')){ define('DB_USER','$db_user'); }";
			fwrite($myfile, $txt);
				
			//Write MySQL password
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('DB_PASSWORD')){ define('DB_PASSWORD','$db_password'); }";
			fwrite($myfile, $txt);
				
			//Write MySQL key
			$txt = "\n";
			fwrite($myfile, $txt);
			function generateRandomString($length = 32) {
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
				return $randomString;
			}
			
			$randommysqlkey=generateRandomString();
			$txt = "if (!defined('DB_KEY')){ define('DB_KEY','$randommysqlkey'); }";
			fwrite($myfile, $txt);
				
			//Write Google Console client ID
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('GOOGLE_CLIENT_ID')){ define('GOOGLE_CLIENT_ID','$google_client_id'); }";
			fwrite($myfile, $txt);
				
			//Write Google Console client secret
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('GOOGLE_CLIENT_SECRET')){ define('GOOGLE_CLIENT_SECRET','$google_client_secret'); }";
			fwrite($myfile, $txt);
				
			//Write Google Console API key
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('GOOGLE_API_KEY')){ define('GOOGLE_API_KEY','$google_api_key'); }";
			fwrite($myfile, $txt);
				
			//Write Google Console Domain name
			if($domain_name!="")
			{
				$txt = "\n";
				fwrite($myfile, $txt);
				$domain_name_single = substr($domain_name, 1);
				$txt = "if (!defined('GOOGLE_HD')){ define('GOOGLE_HD','$domain_name_single'); }";
				fwrite($myfile, $txt);
			}
				
			//Write cookie encryption
			$txt = "\n";
			fwrite($myfile, $txt);
			$randomcookiekey = substr(md5(microtime()),rand(0,26),10);
			$txt = "if (!defined('PORTAL_COOKIE_KEY')){ define('PORTAL_COOKIE_KEY','$randomcookiekey'); }";
			fwrite($myfile, $txt);
				
			//Write cookie name
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('PORTAL_COOKIE_NAME')){ define('PORTAL_COOKIE_NAME','Abre'); }";
			fwrite($myfile, $txt);
				
			//Write turn off php errors
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "ini_set('display_errors','off');";
			fwrite($myfile, $txt);
				
			//Write server path
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = '$portal_path_root = $_SERVER[\'DOCUMENT_ROOT\'];';
			fwrite($myfile, $txt);
				
			//Write Google redirection location
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = 'if (!defined(\'GOOGLE_REDIRECT\')){ define(\'GOOGLE_REDIRECT\', $portal_root.\'/index.php\'); }';
			fwrite($myfile, $txt);
				
			//Write Google scopes
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('GOOGLE_SCOPES')){ define('GOOGLE_SCOPES',serialize (array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/gmail.modify', 'https://www.googleapis.com/auth/drive.readonly', 'https://www.googleapis.com/auth/calendar.readonly', 'https://www.googleapis.com/auth/classroom.courses.readonly', 'https://www.googleapis.com/auth/classroom.rosters.readonly'))); }";
			fwrite($myfile, $txt);
				
			//Write stream cache setting
			$txt = "\n";
			fwrite($myfile, $txt);
			$txt = "if (!defined('STREAM_CACHE')){ define('STREAM_CACHE','true'); }";
			fwrite($myfile, $txt);
				
			//End PHP file
			$txt = "\n\n?>";
			fwrite($myfile, $txt);
				
			//Close file
			fclose($myfile);
				
			//Create Private Folders
			if (!file_exists('../private')){ mkdir("../private", 0700); }
			if (!file_exists('../private/books')){ mkdir("../private/books", 0700); }
			if (!file_exists('../private/directory')){ mkdir("../private/directory", 0700); }
			if (!file_exists('../private/directory/discipline')){ mkdir("../private/directory/discipline", 0700); }
			if (!file_exists('../private/directory/images')){ mkdir("../private/directory/images", 0700); }
			if (!file_exists('../private/directory/images/employees')){ mkdir("../private/directory/images/employees", 0700); }
			if (!file_exists('../private/stream')){ mkdir("../private/stream", 0700); }
			if (!file_exists('../private/stream/cache')){ mkdir("../private/stream/cache", 0700); }
			if (!file_exists('../private/stream/cache/feed')){ mkdir("../private/stream/cache/feed", 0700); }
			if (!file_exists('../private/stream/cache/images')){ mkdir("../private/stream/cache/images", 0700); }
			
			//Redirect
			header("Location: $currenturl");
	  			  		
		}
 		$conn->multi_query($sql);
		$conn->close();	

			
	}
	else
	{
		$errormessage="Please check your database credentials. Abre was unable to establish a connection.";
	}
		
	//Header
	require_once('core/abre_header.php');
	require_once('core/abre_version.php');
		
	?>
		
	<!--Abre Setup Screen-->
	<div class='row' style='margin-top:50px;'><img src='core/images/abre_logo.png' alt='Abre' style='display: block; margin-left: auto; margin-right: auto; width:200px; height:63px;'></div>
	<div style='margin-top:50px;'>
	<div class='page_container page_container_limit mdl-shadow--4dp'>
	<div class='page'>
	<div class='row'>
		<div class='col s12'><h3>Welcome</h3></div>
		<div class='col s12'><p>Welcome to the 5 minute Abre installation process! You may want to browse the documentation available at <a href='https://abre.io/documentation' target='_blank' class='deep-orange-text text-darken-3'>abre.io/documentation</a>. Otherwise, just fill in the information below and you'll be on your way to using the Abre Platform. <?php echo "($abre_version)"; ?></p></div>			
			<form id='form-abresetup' method='post' action='/'>
				<?php if(!isset($errormessage)){ ?> <div class='col s12 deep-orange darken-3 white-text' style='padding:10px; margin-bottom:20px; border-radius: 3px;'>Please check your database credentials. Abre was unable to establish a connection.</div> <?php } ?>
				<div class='col s12'><h6>Basic Information</h6></div>
				<div class='input-field col l6 s12'>
					<input placeholder='Enter a Title' id='site_title' name='site_title' type='text' value='<?php echo $site_title; ?>' required>
					<label class='active' for='site_title'>Site Title</label>
				</div>
				<div class='input-field col l6 s12'>
					<input placeholder='@example.org' id='domain_name' name='domain_name' type='text' value='<?php echo $domain_name; ?>' required>
					<label class='active' for='domain_name'>Primary Google Apps Domain Name</label>
				</div>
				<div class='col s12'><h6>Database Credentials</h6></div>
				<div class='input-field col l3 s12'>
					<input placeholder='Enter Database Host' id='db_host' name='db_host' type='text' value='<?php echo $db_host; ?>' required>
					<label class='active' for='db_host'>Database Host</label>
				</div>
				<div class='input-field col l3 s12'>
					<input placeholder='Enter Database Name' id='db_name' name='db_name' type='text' value='<?php echo $db_name; ?>' required>
					<label class='active' for='db_name'>Database Name</label>
				</div>
				<div class='input-field col l3 s12'>
					<input placeholder='Enter Database User' id='db_user' name='db_user' type='text' value='<?php echo $db_user; ?>' required>
					<label class='active' for='db_user'>Database User</label>
				</div>
				<div class='input-field col l3 s12'>
					<input placeholder='Enter Database Password' id='db_password' name='db_password' type='text' value='<?php echo $db_password; ?>' required>
					<label class='active' for='db_password'>Database Password</label>
				</div>
				<div class='col s12'><h6>Google Console Settings</h6></div>
				<div class='input-field col l4 s12'>
					<input placeholder='Enter Google Client ID' id='google_client_id' name='google_client_id' type='text' value='<?php echo $google_client_id; ?>' required>
					<label class='active' for='google_client_id'>Client ID</label>
				</div>
				<div class='input-field col l4 s12'>
					<input placeholder='Enter Google Client Secret' id='google_client_secret' name='google_client_secret' type='text' value='<?php echo $google_client_secret; ?>' required>
					<label class='active' for='google_client_secret'>Client Secret</label>
				</div>
				<div class='input-field col l4 s12'>
					<input placeholder='Enter Google API Key' id='db_api_key' name='google_api_key' type='text' value='<?php echo $google_api_key; ?>' required>
					<label class='active' for='google_api_key'>API Key</label>
				</div>
				<div class='col s12'>
					<br><button class='btn waves-effect btn-flat deep-orange darken-3 white-text' type='submit'>Install Abre</button>
				</div>
			</form>
	</div>
	</div>
	</div>
	</div>
<?php
}
?>