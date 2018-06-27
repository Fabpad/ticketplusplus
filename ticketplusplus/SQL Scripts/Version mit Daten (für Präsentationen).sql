-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Jun 2018 um 09:33
-- Server-Version: 10.1.31-MariaDB
-- PHP-Version: 7.2.4

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


CREATE DATABASE ticketplusplus;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `beschreibung` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`category_id`, `beschreibung`) VALUES
(1, 'Hardware'),
(2, 'Software'),
(3, 'Organisation');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `department`
--

CREATE TABLE `department` (
  `dept_id` int(10) UNSIGNED NOT NULL,
  `beschreibung` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `department`
--

INSERT INTO `department` (`dept_id`, `beschreibung`) VALUES
(1, 'Marketing'),
(2, 'Einkauf'),
(3, 'IT'),
(4, 'Produktion'),
(5, 'Buchhaltung');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_attempts`
--

CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `priority`
--

CREATE TABLE `priority` (
  `priority_id` int(10) UNSIGNED NOT NULL,
  `beschreibung` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `priority`
--

INSERT INTO `priority` (`priority_id`, `beschreibung`) VALUES
(1, 'High'),
(2, 'Normal'),
(3, 'Low');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE `roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'User'),
(2, 'Agent'),
(3, 'Admin');

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `status`
--

CREATE TABLE `status` (
  `status_id` int(10) UNSIGNED NOT NULL,
  `beschreibung` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `status`
--

INSERT INTO `status` (`status_id`, `beschreibung`) VALUES
(1, 'Abgeschlossen'),
(2, 'In Bearbeitung'),
(3, 'Warten'),
(4, 'Offen');

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
(11, 'Ich kann nicht mehr telefonieren', 'Hilfe!', 10, 1, 2, 1, 2, 8, '', '', '2018-06-27 12:20:32'),
(12, 'Drucker druckt streifig', 'Hilfe!', 11, 1, 3, 2, 3, 12, NULL, NULL, '2018-06-27 12:23:18'),
(13, 'FEUER!', 'Mein PC ist in Flammen aufgegangen.\r\nJetzt kann ich kein SAP mehr benutzen. Bitte installieren.', 12, 1, 4, 1, 2, 8, NULL, NULL, '2018-06-27 12:24:30');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `vorname` varchar(40) NOT NULL,
  `nachname` varchar(40) NOT NULL,
  `telefonnummer` varchar(40) NOT NULL,
  `dept_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`, `vorname`, `nachname`, `telefonnummer`, `dept_id`, `role_id`) VALUES
(1, 'superadmin', 'superadmin@tpp.de', '2017e1fa551e6caa41434eab4a5662c5ac42c2341a32ada9cf1afb16b859e920bdd39e0cc0b32228eb50ab3796e2d3d8ace6086015bb47cdbe74c74ac029fede', '1072c7f2670ec72c6c8d0ebff4490e52c0b38bf8a1ab0da73d65b7942ab728ca234ba67025e42280c812801042c357fa93aefa6475bde515bf0dcd0beef222b1', 'Super', 'Admin', '0123456789', 3, 3),
(2, 'Admin1', 'Admin1@tpp.de', 'e7d58a4942ebd8c838a5b8b42f9dc00a975b1876d2c9fd571ff4c5e9e19aebe56caf191fd46879f6ce2a7b5bbc74bae1d895a2141928fc2afa94684d2641e8e9', 'ba0f5cc344d7b3ffb1fb324023429bbb73118ab94b7d965264d02f0d2f6a799eaca54195f7d290b8ae3171ded5c266d0052ec9c1a22260da5245f6afd76316f5', 'Admin', 'Eins', '0123456789', 3, 3),
(3, 'Admin2', 'Admin2@tpp.de', 'fc84c31d30f5ae87f7c68e2775d12b26073ab2ef1d66bdbb290c15c70817b52a6de5cae76f58d22053c8a0c6f22744e92c21ab4c16a2beefc060a35acad72dcb', '94355aa3eec238334fbd24f6f8ae5159b048e44d8f9c1928456982cad02a81ead65d2bd4eaf3b6a9bb2470ebe0367d71a6d0ca099ec3de5ec13799ec4db722ef', 'Admin', 'Zwei', '0123456789', 3, 3),
(4, 'Techniker1', 'Techniker1@tpp.de', '855cb68ff3912d02d8583aeb1fea4d02086cd618b090f13c64219c0c0f0dd8f2eb27e8d4f55fabc9b254571cd9f65a3c5cd0c7cf5726d36e56cda945d55390a9', '9adfbc24c5d9f0789e7a4288b26e7076693ab4e9815a52ec9a1abb4d421f3d17cf2a1270da54e8208f5448a5229d579e307a065928bb1e7630516778aef300de', 'Techniker', 'Eins', '0123456789', 3, 2),
(5, 'Techniker2', 'Techniker2@tpp.de', '4e3442bdba42dce575fc90238b52b310983cff8ced410b11ab1bee2efde55281e2765b197dbfe9d2f3830993bdb33729d92caae926b122c7b0f586f324d77568', '25b6c59731aa7512f74a00c231ef6236f9faee4e9e2ac8df844c03c729adbdf5fa39f58cce55cff4b9cbb3bdbf2a393a36461e4e5162244a96b84816ba1c7eab', 'Techniker', 'Zwei', '0123456789', 1, 2),
(6, 'Techniker3', 'Techniker3@tpp.de', '51109956ea5eef5bb739822e4fe44e11fb7b4e765b782707cd6a2a9a7751d849a08ac14024f87fc487879e7e14ea8e93b7d0583794df8fcf9be538f68795ac08', 'ad1df4db87ca149f6e5813c7787915e20bd537d5e67c4410cb20ad5234c0670387e4e4f98d4689f489d1ed6f427e65bb1ac3a9153295793db1a99ee1cc0062ad', 'Techniker', 'Drei', '0123456789', 2, 2),
(7, 'Techniker4', 'Techniker4@tpp.de', '7dec32ab008ca5ce1a106a344a7eef5f835e9e58962dccca6acadb192027c62be0aa9fcae99d0fa4938316329c740cbd87aff8c149aa39ecda5898299bd5825c', '679b715d02fea6b21774161a86b3f720a91e11792f8985813080c837073b77ac343450bc3c4cd9abb1534cdc1d8304fcc0737f55729a79c488222c5019d003eb', 'Techniker', 'Vier', '0123456789', 4, 2),
(8, 'Techniker5', 'Techniker5@tpp.de', 'bd0b173a6af121330c409d4492d69cd95fdfa9c5feeb52739c88c55b48d799083f8a3fce157acd950692e1d9d0ac342e65a48be8368168d5addac6abc79b34c2', '2cef3654dc67ec765cf05b472b6f0a317d99e230664141fee65840a68b4fa0f6209c51e679a8e4aa01e7b75285d75a90a43d5fe8b6167cfbafee882631654d15', 'Techniker', 'FÃ¼nf', '0123456789', 5, 2),
(9, 'User1', 'User1@tpp.de', 'c9fd454c60bed2df0efce6b9d7ceb8de6d421f6a0ef435f3caa5a3536f788f791ad97e49f7a807197748725fe62db06bb735273825a2d37acd1cfc1147a2bf10', 'c651bbe906b0fc41b5f1b821889b3270db6b2a38aa47060c761f09c77cfee7fca62db19134d6e6464f5c1e8a5fc0d1d5bb03dd5cb1e26fcbc158ebe1e1eab540', 'User', 'Eins', '0123456789', 3, 1),
(10, 'User2', 'User2@tpp.de', '7484f61caa4ca56bfcd09e2bc43aff05d6c60a933bd1f701a0830320f82f634faad1aefd656a33761a6d0bbe2967fbdafd38946c0b41e86787e955e449aa988d', '4705bf47efe4e79874ac52b3b18990fd77e26fa458bb8f76b5876fb4cc5cb5d429d5adec72c3f4410d5366356e77769241d8d2c0fd29ab9149ad1535a21a01d6', 'User', 'Zwei', '0123456789', 2, 1),
(11, 'User3', 'User3@tpp.de', '30000c3eba9e8ba507205c5df820ff270ee9181e6b15529d2d7991848848d718e65d6eea6a86348f6f80af34913046b34e4c51ab6ad0ed37c4b809928cd46b16', '7e359a9daf7ec4ca12bf007b2bc225625fb60df14d85a2b723d88bce9a8aec497583576c637b37ff643b6ffb0cce7701d76aa7f6e85a35eba06d0f6ef7aea55f', 'User', 'Drei', '0123456789', 4, 1),
(12, 'User4', 'User4@tpp.de', '7e6c06dbf2d3304fa2ebc8ec181116e0d56547412e6028e13a74b63ff14a2621880a1a1f51f289262a0bcf08636f9e85984df00f81d7453c09db603fcd98fcc9', '63d386a1524ba9f6264a496fd67900335e4c33af73ed0c9dba448f91586a651e082931e5c3a024ed6190b1ca3bfd577c7c123cf4fc08d91a255a171ef95c8db6', 'User', 'Vier', '0123456789', 5, 1),
(13, 'User5', 'User5@tpp.de', '2543912034e1c61b4bc0953724a1fbc34b0679b18f64a1d87b50d826e536088f17021436c4692aed1428d3d31bc9daeffa29866bc9b905c48547b8eeea7d0ed9', 'a9d2ab2e3d5a7a655e8ef5953b84f462a6134a425f2adebd30d32fa28276b17fd1e3a7571fe65b45b491e80fecb35f29e6f226349de82324244437d1d3ee0457', 'User', 'FÃ¼nf', '0123456789', 4, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indizes für die Tabelle `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indizes für die Tabelle `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`priority_id`);

--
-- Indizes für die Tabelle `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indizes für die Tabelle `specification`
--
ALTER TABLE `specification`
  ADD PRIMARY KEY (`specification_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indizes für die Tabelle `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

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
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `priority`
--
ALTER TABLE `priority`
  MODIFY `priority_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `specification`
--
ALTER TABLE `specification`
  MODIFY `specification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `specification`
--
ALTER TABLE `specification`
  ADD CONSTRAINT `specification_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

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

--
-- Constraints der Tabelle `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
