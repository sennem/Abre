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

	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  //require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
?>

<html>
	<header>
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	</header>
</html>

<?php
		echo "<hr class='widget_hr'>";
		echo "<div class='widget_holder'>";
			echo "<div class='widget_container widget_body' style='color:#666;'>Select Mood<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_content.php' data-reload='true'>refresh</i></div>";
		echo "</div>";

		echo '
		<div>
			<ul>
				<li>
					<i id="emojizero" class="em em-laughing EmojiSpacingLeft" ></i>
					<i id="emojione" class="em em-smiley EmojiSpacing" ></i>
					<i id="emojitwo" class="em em-slightly_smiling_face EmojiSpacing" ></i>
				</li>
				<li>
					<i id="emojithree" class="em em-weary EmojiSpacingLeft" ></i>
					<i id="emojifour" class="em em-cry EmojiSpacing" ></i>
					<i id="emojifive" class="em em-slightly_frowning_face EmojiSpacing" ></i>
				</li>
				<li>
					<i id="emojisix" class="em em-persevere EmojiSpacingLeft" ></i>
					<i id="emojiseven" class="em em-grimacing EmojiSpacing" ></i>
					<i id="emojieight" class="em em-expressionless EmojiSpacing" ></i>
				</li>
			</ul>
		</div>';


?>
