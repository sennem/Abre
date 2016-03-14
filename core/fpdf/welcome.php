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
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php'); 
	require_once(dirname(__FILE__) . '/../../modules/directory/permissions.php'); 
	require_once(dirname(__FILE__) . '/../../core/portal_functions.php'); 
	
	//Display welcome letter for allowed users
	if($pageaccess==1)
	{
		
		$id=$_GET['id'];
		include "../core/portal_dbconnect.php";
		$sql = "SELECT *  FROM directory where id=$id and archived=0";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$firstname=htmlspecialchars($row["firstname"], ENT_QUOTES);
			$firstname=stripslashes(decrypt($firstname, ""));
			$title=htmlspecialchars($row["title"], ENT_QUOTES);
			$title=stripslashes(decrypt($title, ""));
			$location=htmlspecialchars($row["location"], ENT_QUOTES);
			$location=stripslashes(decrypt($location, ""));
			$effectivedate=htmlspecialchars($row["effectivedate"], ENT_QUOTES);
			$effectivedate=stripslashes(decrypt($effectivedate, ""));
		}
		
			
		require('fpdf.php');
		$pdf=new FPDF();
		$pdf->AddPage();
			
		$todaysdate=date("F d, Y");
		$content="\n\n\n\n\n\n\n\n$todaysdate\n\n\n\nDear $firstname,\n\nCongratulations! You have been appointed to the position of $title at $location for the Hamilton City School District effective $effectivedate. I am confident that you will make a fine contribution to our school system.\n\nPlease contact the Treasurer's Office to complete the necessary forms for fridge benefits, such as medical insurance, life insurance, etc. within thirty (30) days of the effective date of your appointment. Life insurance is at no cost, as it is paid by the Board of Education.\n\nPlease feel free to contact me if you have any questions, now or in the future.\n\nSincerely,\n\n\n\nDr. Chad Konkle\nAssistant Superintendent for Human Resources\n\nCK: lf\n\ncc: Robert Hancock, Treasurer";
		$pdf->SetFont("Arial", "", "");
		$pdf->SetLeftMargin(20); 
		$pdf->SetRightMargin(20); 
		$pdf->MultiCell(0,6,"$content",0,1);
		//$pdf->Output();
		$filename="welcome.pdf";
		$pdf->Output($filename, 'I');
	}
	
?>