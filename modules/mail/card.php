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
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php'); 

	//Set Access Token
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']){ $client->setAccessToken($_SESSION['access_token']); }
	
	//Get Gmail content
	if ($client->getAccessToken())
	{
		
		$_SESSION['access_token'] = $client->getAccessToken();
		
		$label = $Service_Gmail->users_labels->get('me', 'INBOX');
		$Gmail_Unread = $label->messagesUnread;	
		
		echo "<div class='mdl-card__title'>";
			echo "<div class='valign-wrapper'>";
				echo "<a href='https://mail.google.com' target='_blank'><img src='core/images/icon_mail.png' class='icon_small'></a>";
				if($Gmail_Unread!='1')
				{ echo "<div><div class='mdl-card__title-text'>Mail</div><div class='card-text-small'>You Have $Gmail_Unread Unread Emails</div></div>"; }
				else
				{ echo "<div><div class='mdl-card__title-text'>Mail</div><div class='card-text-small'>You Have $Gmail_Unread Unread Email</div></div>"; }
			echo "</div>";
		echo "</div>";
		
		echo "<div class='hide-on-small-only'>";
		echo "<div class='row' style='margin-bottom:0;'>";
		
		
		//Show Unread Mail
		if($Gmail_Unread!=0)
		{
			
			
			$list = $Service_Gmail->users_messages->listUsersMessages('me',['maxResults' => 3, 'q' => 'is:unread label:inbox']);
			$messageList = $list->getMessages();
			$inboxMessage = [];

			foreach($messageList as $mlist){

				$optParamsGet2['format'] = 'full';
				$single_message = $Service_Gmail->users_messages->get('me',$mlist->id, $optParamsGet2);

				$message_id = $mlist->id;
				$headers = $single_message->getPayload()->getHeaders();
				$snippet = $single_message->getSnippet();

				foreach($headers as $single) {

					if ($single->getName() == 'Subject') {

						$subjecttext = $single->getValue();

            		}

					else if ($single->getName() == 'From') {

						$sendertext = $single->getValue();
						$sendertext = str_replace('"', '', $sendertext);
					}
        		}
        
					echo "<hr>";
					echo "<div class='valign-wrapper emailwrapper'>";
						echo "<div class='col s10'>";
							echo "<div class='mdl-card__supporting-text subtext truncate'><b>$subjecttext</b>";
							if($sendertext!="Google"){ echo "<br>$sendertext"; }
							if($sendertext!=""){ echo "<br>$snippet</div>"; }
						echo "</div>";
						echo "<div class='col s2'>";
							echo "<a href='https://mail.google.com/mail/u/0/#inbox/$message_id' target='_blank' class='emailclick'><i class='material-icons mdl-color-text--grey-600'>play_circle_filled</i></a>";
						echo "</div>";
					echo "</div>";	



    		}
			
		echo "</div>";
		echo "</div>";	
		
		}
	
	}

	
?>