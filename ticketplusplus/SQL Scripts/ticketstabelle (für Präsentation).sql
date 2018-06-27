-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 27. Jun 2018 um 14:26
-- Server-Version: 10.1.33-MariaDB
-- PHP-Version: 7.2.6

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
-- Tabellenstruktur für Tabelle `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `betreff` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `beschreibung` text COLLATE latin1_german1_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `agent_id` int(10) UNSIGNED DEFAULT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `priority_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `specification_id` int(10) UNSIGNED NOT NULL,
  `loesung` text COLLATE latin1_german1_ci,
  `notizen` text COLLATE latin1_german1_ci,
  `erstell_datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `betreff`, `beschreibung`, `user_id`, `agent_id`, `status_id`, `priority_id`, `category_id`, `specification_id`, `loesung`, `notizen`, `erstell_datum`) VALUES
(1, 'Programm defekt', 'Dieses Programm ist defekt. Bitte reparieren.', 9, 8, 2, 2, 2, 8, 'Programm wurde repariert.', '---', '2018-05-09 09:25:14'),
(2, 'Drucker funktioniert nicht', 'Hi,\r\n\r\nich kann seit heute morgen nicht mehr drucken.\r\n\r\nKÃ¶nnen Sie sich das Problem mal ansehen?', 10, 7, 4, 2, 1, 2, NULL, NULL, '2018-06-14 08:58:01'),
(3, 'AuflÃ¶sung niedrig', 'Die AuflÃ¶sung meines Bildschirms ist sehr niedrig.', 11, 6, 1, 2, 2, 6, 'AuflÃ¶sung wurde wieder auf 1080p zurÃ¼ckgestellt.', '', '2018-06-14 10:30:04'),
(4, 'Bluescreen beim Starten des PCs', 'User Eins hat berichtet, dass sein PC seite heute (25.1.) nicht mehr startet und einen Bluescreen anzeigt.', 12, 5, 2, 1, 2, 6, '', 'Grafikkarte, Ram und Festplatten wurden Ã¼berprÃ¼ft und funktionieren fehlerfrei', '2018-06-14 09:01:09'),
(5, 'Maus funktioniert nicht', 'siehe Titel', 13, 4, 1, 2, 1, 3, 'USB-Kabel war nicht richtig eingesteckt.', '', '2018-06-14 10:32:24'),
(6, 'Upgrade auf neues Betriebssytem', 'Bei mir ist bald ein Upgrade auf ein neues Betriebssystem fÃ¤llig.\r\n\r\nWann kÃ¶nnen Sie dieses durchfÃ¼hren?', 9, 8, 1, 3, 2, 6, 'Upgrade wurde erfolgreich durchgefÃ¼hrt.', '11.2.: Termin wurde vereinbart\r\n\r\n13.2.: Upgrade wurde durchgefÃ¼hrt.', '2018-06-14 10:33:58'),
(7, 'Passwort vergessen', 'Habe mein Passwort vergessen bitte zurÃ¼cksetzen.', 10, 7, 3, 2, 3, 12, '', 'Passwort wurde zurÃ¼ckgesetzt. Warte auf Antwort', '2018-06-14 11:20:39'),
(8, 'Festplatte voll', 'Hallo,\r\n\r\naufgrund meiner TÃ¤tigkeiten als Marketing Grafikdesigner reicht mein Festplattenspeicher nicht mehr aus.\r\n\r\nKÃ¶nnen Sie diesen erweitern? Ausgabe ist genehmigt.\r\n\r\nDanke!', 11, 6, 4, 2, 1, 1, NULL, NULL, '2018-06-14 08:59:38'),
(9, 'Kennwort vergessen', 'User Drei hat sein Kennwort vergessen und wÃ¼nscht ein neues Kennwort', 12, 5, 1, 1, 3, 12, 'Kennwort wurde zurÃ¼ckgesetzt.', '---', '2018-06-14 09:02:23'),
(10, 'Programm XY startet nicht', 'Hallo,\r\n\r\nmein Programm XY startet nicht, kÃ¶nnen Sie den Fehler beheben?\r\n\r\nDanke!', 13, 4, 1, 2, 2, 8, 'Programm wurde neu installiert.', 'Diverse Versuche in den Windows Einstellungen haben nicht geholfen.', '2018-06-14 10:35:01'),
(11, 'Test', 'Test2', 9, NULL, 1, 1, 2, 8, NULL, NULL, '2018-06-27 12:14:10'),
(12, 'PC reagiert nicht mehr', 'Hilfe!', 1, 4, 2, 1, 2, 8, NULL, NULL, '2018-06-27 12:19:54'),
(13, 'Ich kann nicht mehr telefonieren', 'Hilfe!', 10, 1, 2, 1, 2, 8, '', '', '2018-06-27 12:20:32'),
(14, 'Drucker druckt streifig', 'Hilfe!', 11, 1, 3, 2, 3, 12, NULL, NULL, '2018-06-27 12:23:18'),
(15, 'FEUER!', 'Mein PC ist in Flammen aufgegangen.\r\nJetzt kann ich kein SAP mehr benutzen. Bitte installieren.', 12, 1, 4, 1, 2, 8, NULL, NULL, '2018-06-27 12:24:30');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `agent_id` (`agent_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `specification_id` (`specification_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`priority_id`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`specification_id`) REFERENCES `specification` (`specification_id`),
  ADD CONSTRAINT `tickets_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_ibfk_6` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
