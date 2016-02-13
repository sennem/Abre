-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 13, 2016 at 08:39 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `abre`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `id` int(11) NOT NULL,
  `icon` text NOT NULL,
  `student` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `title` text NOT NULL,
  `image` text NOT NULL,
  `link` text NOT NULL,
  `required` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `minor_disabled` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `ID` int(11) NOT NULL,
  `Code` varchar(11) NOT NULL,
  `Code_Limit` int(11) DEFAULT NULL,
  `Title` text NOT NULL,
  `Author` text NOT NULL,
  `Slug` text NOT NULL,
  `Cover` text NOT NULL,
  `File` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `books_libraries`
--

CREATE TABLE `books_libraries` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Book_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_assessments`
--

CREATE TABLE `curriculum_assessments` (
  `ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_course`
--

CREATE TABLE `curriculum_course` (
  `ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Level` text NOT NULL,
  `Subject` text NOT NULL,
  `Grade` text NOT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_lesson`
--

CREATE TABLE `curriculum_lesson` (
  `ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_libraries`
--

CREATE TABLE `curriculum_libraries` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Course_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_resources`
--

CREATE TABLE `curriculum_resources` (
  `ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_standards`
--

CREATE TABLE `curriculum_standards` (
  `ID` int(11) NOT NULL,
  `Subject` text NOT NULL,
  `Standard_ID` text NOT NULL,
  `Category` text NOT NULL,
  `Sub_Category` text NOT NULL,
  `State_Standard` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_unit`
--

CREATE TABLE `curriculum_unit` (
  `ID` int(11) NOT NULL,
  `Course_ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Start_Time` text NOT NULL,
  `Length` text NOT NULL,
  `Description` text NOT NULL,
  `Standards` text NOT NULL,
  `Resources` text NOT NULL,
  `Assessments` text NOT NULL,
  `Lessons` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `directory`
--

CREATE TABLE `directory` (
  `id` int(11) NOT NULL,
  `updatedtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `superadmin` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `archived` int(11) NOT NULL,
  `picture` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `middlename` text NOT NULL,
  `title` text NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `zip` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `ss` text NOT NULL,
  `dob` text NOT NULL,
  `classification` text NOT NULL,
  `location` text NOT NULL,
  `doh` text NOT NULL,
  `senioritydate` text NOT NULL,
  `effectivedate` text NOT NULL,
  `step` text NOT NULL,
  `salary` text NOT NULL,
  `hours` text NOT NULL,
  `stateeducatorid` text NOT NULL,
  `licensetype1` text NOT NULL,
  `licenseissuedate1` text NOT NULL,
  `licenseexpirationdate1` text NOT NULL,
  `licenseterm1` text NOT NULL,
  `licensetype2` text NOT NULL,
  `licenseissuedate2` text NOT NULL,
  `licenseexpirationdate2` text NOT NULL,
  `licenseterm2` text NOT NULL,
  `licensetype3` text NOT NULL,
  `licenseissuedate3` text NOT NULL,
  `licenseexpirationdate3` text NOT NULL,
  `licenseterm3` text NOT NULL,
  `licensetype4` text NOT NULL,
  `licenseissuedate4` text NOT NULL,
  `licenseexpirationdate4` text NOT NULL,
  `licenseterm4` text NOT NULL,
  `licensetype5` text NOT NULL,
  `licenseissuedate5` text NOT NULL,
  `licenseexpirationdate5` text NOT NULL,
  `licenseterm5` text NOT NULL,
  `licensetype6` text NOT NULL,
  `licenseissuedate6` text NOT NULL,
  `licenseexpirationdate6` text NOT NULL,
  `licenseterm6` text NOT NULL,
  `probationreportdate` text NOT NULL,
  `statebackgroundcheck` text NOT NULL,
  `federalbackgroundcheck` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `directory_discipline`
--

CREATE TABLE `directory_discipline` (
  `id` int(11) NOT NULL,
  `archived` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discipline`
--

CREATE TABLE `discipline` (
  `id` int(11) NOT NULL,
  `Status` text NOT NULL,
  `Submit_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Update_Date` timestamp NULL DEFAULT NULL,
  `Creator` int(11) NOT NULL,
  `Type` text NOT NULL,
  `Student_ID` text NOT NULL,
  `Date` text NOT NULL,
  `Hour` text NOT NULL,
  `Minute` text NOT NULL,
  `Meridiem` text NOT NULL,
  `Time` text NOT NULL,
  `Description_of_Event` text NOT NULL,
  `Intervention` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discipline_students`
--

CREATE TABLE `discipline_students` (
  `id` int(11) NOT NULL,
  `Student_ID` text NOT NULL,
  `Student_Name` text NOT NULL,
  `School` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `startup` int(11) NOT NULL DEFAULT '1',
  `streams` text NOT NULL,
  `card_mail` int(11) NOT NULL DEFAULT '1',
  `card_drive` int(11) NOT NULL DEFAULT '1',
  `card_calendar` int(11) DEFAULT '1',
  `card_classroom` int(11) NOT NULL DEFAULT '1',
  `apps_order` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `streams`
--

CREATE TABLE `streams` (
  `id` int(11) NOT NULL,
  `group` text NOT NULL,
  `title` text NOT NULL,
  `slug` text NOT NULL,
  `type` text NOT NULL,
  `url` text NOT NULL,
  `required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `superadmin` int(11) NOT NULL DEFAULT '0',
  `refresh_token` text NOT NULL,
  `cookie_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `books_libraries`
--
ALTER TABLE `books_libraries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `curriculum_assessments`
--
ALTER TABLE `curriculum_assessments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `curriculum_course`
--
ALTER TABLE `curriculum_course`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `curriculum_lesson`
--
ALTER TABLE `curriculum_lesson`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `curriculum_libraries`
--
ALTER TABLE `curriculum_libraries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `curriculum_resources`
--
ALTER TABLE `curriculum_resources`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `curriculum_standards`
--
ALTER TABLE `curriculum_standards`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `curriculum_unit`
--
ALTER TABLE `curriculum_unit`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `directory`
--
ALTER TABLE `directory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `directory_discipline`
--
ALTER TABLE `directory_discipline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discipline_students`
--
ALTER TABLE `discipline_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `streams`
--
ALTER TABLE `streams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `books_libraries`
--
ALTER TABLE `books_libraries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum_assessments`
--
ALTER TABLE `curriculum_assessments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum_course`
--
ALTER TABLE `curriculum_course`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum_lesson`
--
ALTER TABLE `curriculum_lesson`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum_libraries`
--
ALTER TABLE `curriculum_libraries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum_resources`
--
ALTER TABLE `curriculum_resources`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum_standards`
--
ALTER TABLE `curriculum_standards`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum_unit`
--
ALTER TABLE `curriculum_unit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `directory`
--
ALTER TABLE `directory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `directory_discipline`
--
ALTER TABLE `directory_discipline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `discipline`
--
ALTER TABLE `discipline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `discipline_students`
--
ALTER TABLE `discipline_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `streams`
--
ALTER TABLE `streams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
