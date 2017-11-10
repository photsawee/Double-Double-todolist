-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2017 at 01:37 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `teg`
--

CREATE TABLE `teg` (
  `idtag` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `id_todolist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `todolist`
--

CREATE TABLE `todolist` (
  `idToDoList` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `decription` longtext,
  `Status` enum('pending','done') DEFAULT NULL,
  `category` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `priority` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `User_idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `todolist`
--

INSERT INTO `todolist` (`idToDoList`, `name`, `date`, `decription`, `Status`, `category`, `priority`, `User_idUser`) VALUES
(37, 'dsf', '2017-10-19', 'dsf', 'done', 'Workplace', '3', 1),
(40, 'adsadsagdjj', '2017-11-11', 'sadsad', 'pending', 'Workplace', '3', 1),
(41, 'à¸´à¸·à¸«à¸´à¸Ÿà¸—à¸·à¸´à¸à¸·à¸—à¸«', '2017-11-12', 'dgjhsagjhdgsjhhjsagjhdgshjagdhjgsajhgdkjhsagkgdsabdhgqwgdgxdgsagdhgskajhdgjsahgdkjhgsakjhdgshagdjhsgakjdhgsajhdghasgdkjhgsakjhdgsjahgdjhsagjhsjha', 'pending', 'Clubs to attend', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `UserName` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `EMail` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `UserName`, `Password`, `EMail`) VALUES
(1, 'root', '1234', 'banksine1735@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teg`
--
ALTER TABLE `teg`
  ADD PRIMARY KEY (`idtag`),
  ADD KEY `id_todolist` (`id_todolist`);

--
-- Indexes for table `todolist`
--
ALTER TABLE `todolist`
  ADD PRIMARY KEY (`idToDoList`,`User_idUser`),
  ADD KEY `fk_ToDoList_User_idx` (`User_idUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `EMail` (`EMail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teg`
--
ALTER TABLE `teg`
  MODIFY `idtag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `todolist`
--
ALTER TABLE `todolist`
  MODIFY `idToDoList` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `teg`
--
ALTER TABLE `teg`
  ADD CONSTRAINT `teg_ibfk_1` FOREIGN KEY (`id_todolist`) REFERENCES `todolist` (`idToDoList`);

--
-- Constraints for table `todolist`
--
ALTER TABLE `todolist`
  ADD CONSTRAINT `fk_ToDoList_User` FOREIGN KEY (`User_idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
