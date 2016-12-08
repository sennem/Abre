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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('permissions.php');
	
	if($pageaccess==1)
	{
	
		echo "<div class='row'>";
			echo "<div class='col l12'><h4>License Information</h4></div>";
			echo "<div class='input-field col s12'>";
				echo "<input placeholder='Enter a Educator State ID' value='$stateeducatorid' id='stateeducatorid' name='stateeducatorid' type='text'>";
				echo "<label class='active' for='stateeducatorid'>Educator State ID</label>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
		$fillcount=0;
		for ($x = 1; $x <= 6; $x++) {
				$licensetype = ${'licensetype'.$x};
				if($licensetype==""){ echo "<div class='toAdd'>"; }else{ $fillcount++;  echo "<div>"; }
				$licensetypeid = "licensetypeid".$x;
				echo "<div class='input-field col l4 s12'>";
				    echo "<input placeholder='Enter Type' value='$licensetype' id='$licensetypeid' name='$licensetypeid' type='text'>";
				    echo "<label class='active' for='$licensetypeid'>Type</label>";
				echo "</div>";
				$licenseissuedate = ${'licenseissuedate'.$x};
				$licenseissuedateid = "licenseissuedateid".$x;;
				echo "<div class='input-field col l3 s12'>";
					echo "<input placeholder='Enter Date' type='date' value='$licenseissuedate' id='$licenseissuedateid' name='$licenseissuedateid' class='datepicker'>";
				      echo "<label class='active' for='$licenseissuedateid'>Issue Date</label>";
				echo "</div>";
				$licenseexpirationdate = ${'licenseexpirationdate'.$x};
				$licenseexpirationdateid = "licenseexpirationdateid".$x;
				echo "<div class='input-field col l3 s12'>";
					echo "<input placeholder='Enter Date' type='date' value='$licenseexpirationdate' id='$licenseexpirationdateid' name='$licenseexpirationdateid' class='datepicker'>";
				      echo "<label class='active' for='$licenseexpirationdateid'>Expiration Date</label>";
				echo "</div>";
				$licenseterm = ${'licenseterm'.$x};
				$licensetermid = "licensetermid".$x;
				echo "<div class='input-field col l2 s12'>";
				    echo "<input placeholder='Enter Term' value='$licenseterm' id='$licensetermid' name='$licensetermid' type='text'>";
				    echo "<label class='active' for='$licensetermid'>Term</label>";
				echo "</div>";
			echo "</div>";
		}

			echo "<div class='col s12'>";
				echo "<button class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored' style='background-color: ".sitesettings("sitecolor")."' id='addlicensebutton'>Add</button>";
			 echo "</div>";   
		echo "</div>";
		
		?>
			<script>
				
				$('.toAdd').hide();

				<?php echo "var fillcounter = $fillcount;"; ?>
				var count = 0;
				$('#addlicensebutton').on('click',function(event){
					event.preventDefault();
				    $('.toAdd:eq('+count+')').show();
				    fillcounter++;
				    count++;
					buttonCheck();
				});
				buttonCheck();
				
				function buttonCheck(){
					if(fillcounter===6){
						$( "#addlicensebutton" ).hide();
					}
				}
				
			</script>
		<?php
	}
				  
?>