-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Creato il: Apr 05, 2021 alle 23:29
-- Versione del server: 8.0.22
-- Versione PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql_injection`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `arguments`
--

CREATE TABLE `arguments` (
  `id` int NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `queryExample` text CHARACTER SET utf8 COLLATE utf8_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `arguments`
--

INSERT INTO `arguments` (`id`, `title`, `description`, `queryExample`) VALUES
(1, 'Viste', 'Possiamo pensare ad una vista come se fosse una sorta di tabella temporanea il cui scopo è di presentare determinati dati in un determinato modo. Esattamente come le tabelle, infatti, le viste sono composte da colonne e righe le quali, però, sono il frutto di una query che è stata memorizzata, all’interno del database, in qualità di oggetto.', 'CREATE VIEW nome_view AS SELECT nome, cognome FROM persone WHERE sesso = \"M\";'),
(2, 'Procedure', 'Una stored procedure è un insieme di istruzioni SQL che vengono memorizzate nel server con un nome che le identifica; tale nome consente in seguito di rieseguire l’insieme di istruzioni facendo semplicemente riferimento ad esso. Vediamo come creare una stored procedure:', 'DELIMITER $$<br>	CREATE PROCEDURE riempiVariabile()<br>BEGIN<br>    DECLARE NrStudenti INT DEFAULT 0;<br>    SELECT COUNT(*) INTO NrStudenti FROM Studenti;<br>    SELECT NrStudenti;<br>END $$<br>DELIMITER ;<br>call riempiVariabile();'),
(3, 'Funzioni', 'Le stored functions sono simili alle stored procedures, ma hanno uno scopo più semplice, cioè quello di definire vere e proprie funzioni, come quelle già fornite da MySQL. Esse restituiscono un valore, e non possono quindi restituire resultset, al contrario delle stored procedures.', 'DELIMITER $$;\r\n<br /> \r\nCREATE FUNCTION LivelloUtente(punti INT) RETURNS VARCHAR(10) <br />  DETERMINISTIC <br /> \r\nBEGIN <br /> \r\nDECLARE livello VARCHAR(10) DEFAULT \'BASE\'; <br /> \r\n \r\n  IF punti > 10000 THEN <br /> \r\n    SET livello = \'VIP\'; <br /> \r\nEND IF; <br /> \r\n \r\nRETURN (livello);  <br /> \r\nEND $$ <br /> \r\n\r\nDELIMITER ; <br /> \r\n\r\nSELECT nome, LivelloUtente(punti_fedelta) FROM clienti <br />\r\n');

-- --------------------------------------------------------

--
-- Struttura della tabella `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `surname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `students`
--

INSERT INTO `students` (`id`, `name`, `surname`, `email`, `gender`, `registered`) VALUES
(1, 'Raimondo', 'Barge', 'rbarge0@prlog.org', 'M', '2020-02-12 11:42:52'),
(2, 'Lucinda', 'Broseman', 'lbroseman1@deliciousdays.com', 'F', '2020-03-09 06:42:21'),
(3, 'Kimbra', 'McClure', 'kmcclure2@techcrunch.com', 'F', '2019-11-21 19:30:09'),
(4, 'Celina', 'McLeoid', 'cmcleoid3@fda.gov', 'F', '2020-05-12 01:45:22'),
(5, 'Ernie', 'Dossettor', 'edossettor4@hud.gov', 'M', '2019-12-15 00:29:01'),
(6, 'Jemimah', 'Pendlenton', 'jpendlenton5@google.com.au', 'F', '2020-06-28 20:33:15'),
(7, 'Coop', 'Pettko', 'cpettko6@uol.com.br', 'M', '2020-01-15 09:54:05'),
(8, 'Lamont', 'Eyam', 'leyam7@walmart.com', 'M', '2020-06-10 18:16:16'),
(9, 'Gottfried', 'Gors', 'ggors8@bbc.co.uk', 'M', '2020-05-23 04:47:21'),
(10, 'Frannie', 'Canas', 'fcanas9@ca.gov', 'F', '2020-05-17 22:53:46'),
(11, 'Raviv', 'Ambrois', 'rambroisa@theatlantic.com', 'M', '2019-09-17 20:10:11'),
(12, 'Arluene', 'Dummer', 'adummerb@squarespace.com', 'F', '2020-04-22 04:03:26'),
(13, 'Ivonne', 'Parrott', 'iparrottc@disqus.com', 'F', '2019-08-21 22:42:32'),
(14, 'Maggy', 'Meir', 'mmeird@businessweek.com', 'F', '2020-01-11 09:39:52'),
(15, 'Alric', 'Bellew', 'abellewe@thetimes.co.uk', 'M', '2019-12-09 05:08:37'),
(16, 'Laverna', 'McCaughen', 'lmccaughenf@msu.edu', 'F', '2020-10-11 08:59:07'),
(17, 'Oby', 'Readshaw', 'oreadshawg@deliciousdays.com', 'M', '2021-03-09 22:16:41'),
(18, 'Jemima', 'Smallacombe', 'jsmallacombeh@tripadvisor.com', 'F', '2020-03-07 02:55:14'),
(19, 'Salomone', 'Hutchence', 'shutchencei@upenn.edu', 'M', '2020-01-27 22:02:48'),
(20, 'Essa', 'Antonetti', 'eantonettij@craigslist.org', 'F', '2020-10-11 21:18:56'),
(21, 'Elsinore', 'Stuckey', 'estuckeyk@hugedomains.com', 'F', '2020-10-18 09:09:24'),
(22, 'Nanny', 'Perryman', 'nperrymanl@va.gov', 'F', '2021-01-22 08:23:11'),
(23, 'Trina', 'Felix', 'tfelixm@wsj.com', 'F', '2019-09-15 01:56:46'),
(24, 'Burgess', 'Planque', 'bplanquen@tmall.com', 'M', '2021-03-02 02:01:34'),
(25, 'Donni', 'Willoughby', 'dwilloughbyo@google.com.hk', 'F', '2020-01-10 20:42:21');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `arguments`
--
ALTER TABLE `arguments`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `arguments`
--
ALTER TABLE `arguments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
