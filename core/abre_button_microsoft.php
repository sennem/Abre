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

	//Google Auth Button
	echo "<a class='waves-effect waves-light btn-large mdl-color-text--white' href='https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=".getSiteMicrosoftClientId()."&response_type=code&redirect_uri=$url 'style='text-align:left; width:100%; text-transform:none; background-color:#0078d7; font-size:14px'><i class='fa fa-windows material-icons left' style='width:20px'></i>Sign in with Microsoft</a>";