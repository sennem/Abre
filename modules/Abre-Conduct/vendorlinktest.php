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

	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

	$json = vendorLinkGet("https://vendorlink.swoca.net/SisService/studentPersonal?studentPersonalRefId=6ac609ebeb1b4f779810009501475d58");
	$json = json_encode($json);

	print_r($json);

?>