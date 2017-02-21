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
	require_once('permissions.php');
	
	if($location!=""){ echo "<option value='$title' selected>$title</option>"; }else{ echo "<option value='$title' selected>Choose</option>"; }
	
?>
	<option value="American Sign Language Interpreter/Translator">American Sign Language Interpreter/Translator</option>
	<option value="Assistant Athletic Director">Assistant Athletic Director</option>
	<option value="Assistant Director of Assessment, ESL & Gifted">Assistant Director of Assessment, ESL & Gifted</option>
	<option value="Assistant Director of HR for Pupil Personnel">Assistant Director of HR for Pupil Personnel</option>
	<option value="Assistant Elementary Principal">Assistant Elementary Principal</option>
	<option value="Assistant Superintendent/HR">Assistant Superintendent/HR</option>
	<option value="Assistant Superintendent/Instruction">Assistant Superintendent/Instruction</option>
	<option value="Assistant Treasurer">Assistant Treasurer</option>
	<option value="Athletic Director">Athletic Director</option>
	<option value="Attendance Monitor">Attendance Monitor</option>
	<option value="Auxiliary Services Clerk">Auxiliary Services Clerk</option>
	<option value="Bookkeeper">Bookkeeper</option>
	<option value="Braillist">Braillist</option>
	<option value="Buildings and Grounds Director">Buildings and Grounds Director</option>
	<option value="Bus Aide">Bus Aide</option>
	<option value="Bus Driver">Bus Driver</option>
	<option value="Business Manager">Business Manager</option>
	<option value="Career Development Coordinator">Career Development Coordinator</option>
	<option value="Carpenter Class I">Carpenter Class I</option>
	<option value="Clerk I">Clerk I</option>
	<option value="Communications Coordinator">Communications Coordinator</option>
	<option value="Communications Director">Communications Director</option>
	<option value="Computer Technician">Computer Technician</option>
	<option value="Cook (Grade 7-12)">Cook (Grade 7-12)</option>
	<option value="Cook (Grade PreK-6)">Cook (Grade PreK-6)</option>
	<option value="Counselor">Counselor</option>
	<option value="Custodian">Custodian</option>
	<option value="Data Application Specialist">Data Application Specialist</option>
	<option value="Digital Reproduction and Storage Specialist">Digital Reproduction and Storage Specialist</option>
	<option value="Director of Elementary Programs">Director of Elementary Programs</option>
	<option value="Director of EMIS & Student Services">Director of EMIS & Student Services</option>
	<option value="Director of Pupil Personnel">Director of Pupil Personnel</option>
	<option value="Director of Secondary Programs">Director of Secondary Programs</option>
	<option value="Director of Technology">Director of Technology</option>
	<option value="Educational Assistant">Educational Assistant</option>
	<option value="Electrician Journeyman">Electrician Journeyman</option>
	<option value="Elementary School Principal">Elementary School Principal</option>
	<option value="EMIS Coordinator">EMIS Coordinator</option>
	<option value="ESL Interpreter/Translator">ESL Interpreter/Translator</option>
	<option value="Executive Secretary">Executive Secretary</option>
	<option value="Fiscal Specialist">Fiscal Specialist</option>
	<option value="Food Service Equipment Technician">Food Service Equipment Technician</option>
	<option value="Freshman School Principal">Freshman School Principal</option>
	<option value="General Worker">General Worker</option>
	<option value="Head Custodian (Grade 10-12)">Head Custodian (Grade 10-12)</option>
	<option value="Head Custodian (Grade PreK-9)">Head Custodian (Grade PreK-9)</option>
	<option value="High School Principal">High School Principal</option>
	<option value="Hourly Tutor">Hourly Tutor</option>
	<option value="HVAC Journeyman">HVAC Journeyman</option>
	<option value="Instructional Coach">Instructional Coach</option>
	<option value="Interpreter for the Deaf">Interpreter for the Deaf</option>
	<option value="Library Clerk">Library Clerk</option>
	<option value="Mail Truck Driver">Mail Truck Driver</option>
	<option value="Maintenance Class I">Maintenance Class I</option>
	<option value="Manager (Grade 7-12)">Manager (Grade 7-12)</option>
	<option value="Manager (Grade PreK-6)">Manager (Grade PreK-6)</option>
	<option value="Mentor">Mentor</option>
	<option value="Middle School Principal">Middle School Principal</option>
	<option value="Nurse">Nurse</option>
	<option value="Occupational Therapist">Occupational Therapist</option>
	<option value="Payroll Supervisor">Payroll Supervisor</option>
	<option value="Physical Therapist">Physical Therapist</option>
	<option value="Plumbing Journeyman">Plumbing Journeyman</option>
	<option value="Program Manager-TV Studio">Program Manager-TV Studio</option>
	<option value="Psychologist">Psychologist</option>
	<option value="Safe and Secure Schools Monitor">Safe and Secure Schools Monitor</option>
	<option value="Secondary Assistant Principal">Secondary Assistant Principal</option>
	<option value="Secretary I">Secretary I</option>
	<option value="Secretary II">Secretary II</option>
	<option value="Special Education Assistant">Special Education Assistant</option>
	<option value="Speech/Language Pathologist">Speech/Language Pathologist</option>
	<option value="Student & Family Support">Student & Family Support</option>
	<option value="Superintendent">Superintendent</option>
	<option value="Supervisor of Special Education">Supervisor of Special Education</option>
	<option value="Teacher">Teacher</option>
	<option value="Technology Integration Coordinator">Technology Integration Coordinator</option>
	<option value="Transition Coordinator">Transition Coordinator</option>
	<option value="Transportation Director">Transportation Director</option>
	<option value="Treasurer">Treasurer</option>
	<option value="Utility Worker">Utility Worker</option>