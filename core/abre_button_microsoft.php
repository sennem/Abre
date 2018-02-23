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
	echo "<a class='waves-effect waves-light btn-large mdl-color-text--white loginbutton' style='background-color:#fff !important; color:#757575 !important;' href='https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=".getSiteMicrosoftClientId()."&response_type=code&redirect_uri=".$portal_root."/core/abre_microsoft_login_helper.php&response_mode=form_post&scope=openid%20profile&state=12345&prompt=consent'><span class='loginicon' style='background: url(\"core/images/integrations/button_icon_microsoft.png\") no-repeat;'></span> Sign in with Microsoft</a>";

?>