-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 06, 2015 at 08:44 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `api`
--
CREATE DATABASE IF NOT EXISTS `api` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `api`;

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
`produtoid` int(11) NOT NULL,
  `produtonome` varchar(100) NOT NULL,
  `produtovalor` double NOT NULL,
  `produtoestoque` int(11) NOT NULL,
  `usuariologin` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
`tokenid` int(11) NOT NULL,
  `usuariologin` varchar(10) NOT NULL,
  `tokenstring` varchar(32) NOT NULL,
  `tokendatalimite` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
`usuarioid` int(11) NOT NULL,
  `usuariologin` varchar(10) NOT NULL,
  `usuariosenha` varchar(32) NOT NULL,
  `usuariodatacadastro` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`usuarioid`, `usuariologin`, `usuariosenha`, `usuariodatacadastro`) VALUES
(1, 'aluno', '202cb962ac59075b964b07152d234b70', '2015-04-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
 ADD PRIMARY KEY (`produtoid`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
 ADD PRIMARY KEY (`tokenid`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`usuarioid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
MODIFY `produtoid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
MODIFY `tokenid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
MODIFY `usuarioid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
