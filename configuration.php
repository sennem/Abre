<?php
	
	/*
	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//PHP Settings
	ini_set('display_errors','off');
	date_default_timezone_set("America/New_York");
	
	//Site Path
	$portal_root = "";
	$portal_path_root = $_SERVER['DOCUMENT_ROOT'];
	
	//Site Information
	if (!defined('SITE_TITLE')){ define('SITE_TITLE','Abre'); }
	if (!defined('SITE_DESCRIPTION')){ define('SITE_DESCRIPTION','Abre Open Platform'); }
	if (!defined('SITE_FAVICON')){ define('SITE_FAVICON',''); }
	if (!defined('SITE_CHROME_ICON')){ define('SITE_CHROME_ICON',''); }
	if (!defined('SITE_SAFARI_ICON')){ define('SITE_SAFARI_ICON',''); }
	if (!defined('SITE_WINDOWS_ICON')){ define('SITE_WINDOWS_ICON',''); }
	
	//MySQL Settings
	if (!defined('DB_HOST')){ define('DB_HOST',''); }
	if (!defined('DB_USER')){ define('DB_USER',''); }
	if (!defined('DB_PASSWORD')){ define('DB_PASSWORD',''); }
	if (!defined('DB_NAME')){ define('DB_NAME',''); }
	if (!defined('DB_KEY')){ define('DB_KEY',''); }
	
	//Google Console Authentication Settings
	if (!defined('GOOGLE_CLIENT_ID')){ define('GOOGLE_CLIENT_ID',''); }
	if (!defined('GOOGLE_CLIENT_SECRET')){ define('GOOGLE_CLIENT_SECRET',''); }
	if (!defined('GOOGLE_REDIRECT')){ define('GOOGLE_REDIRECT', $portal_root.'/index.php'); }
	if (!defined('GOOGLE_API_KEY')){ define('GOOGLE_API_KEY',''); }
	if (!defined('GOOGLE_HD')){ define('GOOGLE_HD','example.org'); }
	
	//Cookie Settings
	if (!defined('PORTAL_COOKIE_KEY')){ define('PORTAL_COOKIE_KEY',''); }
	
	//Stream Module Cache
	if (!defined('STREAM_CACHE')){ define('STREAM_CACHE','true'); }	
	
?>