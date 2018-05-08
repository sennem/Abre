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
	require_once(dirname(__FILE__) . '/../../core/fpdf/fpdf.php');
	require_once('permissions.php');

	//Display Dropdowns
	if($pagerestrictions=="")
	{

		include "../../core/abre_dbconnect.php";
		$Course_ID=htmlspecialchars($_GET["cid"], ENT_QUOTES);
		$Lesson_ID=htmlspecialchars($_GET["lid"], ENT_QUOTES);

		$sqllogin = "SELECT Title, Grade FROM curriculum_course WHERE ID='$Course_ID'";
		$resultlogin = $db->query($sqllogin);
		while($rowlogin = $resultlogin->fetch_assoc())
		{
			$Course_Title=htmlspecialchars($rowlogin["Title"], ENT_QUOTES);
			$Course_Grade=htmlspecialchars($rowlogin["Grade"], ENT_QUOTES);
		}

		$sqllogin = "SELECT Title, Standards, Resources, Anticipatory, Objectives, DirectInstruction, GuidedPractice, IndependentPractice, FormativeAssessment, Closure FROM curriculum_lesson WHERE ID='$Lesson_ID'";
		$resultlogin = $db->query($sqllogin);
		while($rowlogin = $resultlogin->fetch_assoc())
		{
			$Lesson_Title=$rowlogin["Title"];
			$Lesson_Standards=$rowlogin["Standards"];
			$Lesson_Resources=$rowlogin["Resources"];
			$Lesson_Anticipatory=$rowlogin["Anticipatory"];
			$Lesson_Objectives=$rowlogin["Objectives"];
			$Lesson_DirectInstruction=$rowlogin["DirectInstruction"];
			$Lesson_GuidedPractice=$rowlogin["GuidedPractice"];
			$Lesson_IndependentPractice=$rowlogin["IndependentPractice"];
			$Lesson_FormativeAssessment=$rowlogin["FormativeAssessment"];
			$Lesson_Closure=$rowlogin["Closure"];
		}


		class PDF extends FPDF
		{
			function Footer()
			{
			    $this->SetY(-15);
			    $this->SetFont('Arial','B',8);

				include "../../core/abre_dbconnect.php";
				$Course_ID=htmlspecialchars($_GET["cid"], ENT_QUOTES);
				$Lesson_ID=htmlspecialchars($_GET["lid"], ENT_QUOTES);

				$sqllogin = "SELECT Title FROM curriculum_lesson WHERE ID='$Lesson_ID'";
				$resultlogin = $db->query($sqllogin);
				while($rowlogin = $resultlogin->fetch_assoc())
				{
					$Lesson_Title=$rowlogin["Title"];
				}

				$this->SetTextColor(0,0,0);
			    $this->Cell(0,10,$Lesson_Title,0,0,'L');
			    $this->Cell(0,10,$this->PageNo(),0,0,'R');
			}

			function Section($title, $text)
			{
				$this->Ln(5);
				$this->SetFont('Arial','B',14);
				$this->SetTextColor(20,91,171);
				$this->MultiCell(0, 10, $title, 0, 'L');
				$this->Ln(0);
				$this->Cell(8);
				$this->SetFont('Arial','',11);
				$this->SetTextColor(0,0,0);
				$this->MultiCell(0, 7, $text, 0, 'L');
			}
		}


		$pdf = new PDF();
		$pdf->AddPage();
		$pdf->Image('images/logo.png',98,10,15,15);
		$pdf->Ln(20);
		$pdf->SetTitle($Lesson_Title);
		$pdf->SetFont('Arial','B',30);
		$pdf->MultiCell(0, 12, $Lesson_Title, 0, 'C');
		$pdf->Ln(0);
		$pdf->SetFont('Arial','I',12);
		$pdf->MultiCell(0, 8, "$Course_Title, Grade Level: $Course_Grade", 0, 'C');

		//Standards
		$pdf->Section('Standards',$Lesson_Standards);

		//Resources & Materials
		$pdf->Section('Resources & Materials',$Lesson_Resources);

		//Anticipatory Set
		$pdf->Section('Anticipatory Set',$Lesson_Anticipatory);

		//Learning Objectives/Goals
		$pdf->Section('Learning Objectives/Goals',$Lesson_Objectives);

		//Direct Instruction
		$pdf->Section('Direct Instruction',$Lesson_DirectInstruction);

		//Guided Practices
		$pdf->Section('Guided Practice',$Lesson_GuidedPractice);

		//Independent Practice
		$pdf->Section('Independent Practice',$Lesson_IndependentPractice);

		//Formative Assessments
		$pdf->Section('Formative Assessment(s)',$Lesson_FormativeAssessment);

		//Closure
		$pdf->Section('Closure',$Lesson_Closure);

		$pdf->Output();

	}

?>