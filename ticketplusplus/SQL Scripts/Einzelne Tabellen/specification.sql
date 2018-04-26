-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Apr 2018 um 08:39
-- Server-Version: 10.1.28-MariaDB
-- PHP-Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ticketplusplus`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `specification`
--

CREATE TABLE `specification` (
  `specification_id` int(10) UNSIGNED NOT NULL,
  `beschreibung` varchar(30) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `specification`
--

INSERT INTO `specification` (`specification_id`, `beschreibung`, `category_id`) VALUES
(1, 'Anforderung neue Hardware', 1),
(2, 'Drucker defekt', 1),
(3, 'PC defekt', 1),
(4, 'WLAN / LAN defekt', 1),
(5, 'Sonstiges', 1),
(6, 'OS', 2),
(7, 'Programmanforderung', 2),
(8, 'Programm defekt', 2),
(9, 'Sonstiges', 2),
(10, 'Benutzer anlegen', 3),
(11, 'Benutzer entsperren', 3),
(12, 'Kennwort vergessen', 3),
(13, 'Speicherplatz erweitern', 3),
(14, 'Sonstiges', 3);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `specification`
--
ALTER TABLE `specification`
  ADD PRIMARY KEY (`specification_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `specification`
--
ALTER TABLE `specification`
  MODIFY `specification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `specification`
--
ALTER TABLE `specification`
  ADD CONSTRAINT `specification_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
