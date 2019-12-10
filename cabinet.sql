-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: localhost
-- Timp de generare: dec. 11, 2019 la 02:06 AM
-- Versiune server: 10.4.8-MariaDB
-- Versiune PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `cabinet`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `cereri_programari`
--

CREATE TABLE `cereri_programari` (
  `cpID` int(11) NOT NULL,
  `cpTipProgramare` enum('consultatie','interventie') NOT NULL,
  `cpPacient` int(11) NOT NULL,
  `cpDate` date NOT NULL,
  `cptimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cpOra` varchar(255) NOT NULL,
  `cpSectia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `consultatii`
--

CREATE TABLE `consultatii` (
  `cID` int(11) NOT NULL,
  `cName` varchar(255) NOT NULL,
  `cSectie` int(11) NOT NULL,
  `cPret` varchar(255) NOT NULL,
  `cTip` enum('consultatie','interventie') NOT NULL,
  `cDurata` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `consultatii`
--

INSERT INTO `consultatii` (`cID`, `cName`, `cSectie`, `cPret`, `cTip`, `cDurata`) VALUES
(1, 'Consultatie ochi', 7, '100 lei', 'consultatie', '35 minute'),
(2, 'Operatie retina', 7, '350 lei', 'interventie', '40 minute');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `financiar_log`
--

CREATE TABLE `financiar_log` (
  `fID` int(11) NOT NULL,
  `fProgramareID` int(11) NOT NULL,
  `fPret` varchar(255) NOT NULL,
  `ftimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `financiar_log`
--

INSERT INTO `financiar_log` (`fID`, `fProgramareID`, `fPret`, `ftimestamp`) VALUES
(1, 2, '100 lei', '2019-12-10 23:40:06'),
(2, 1, '350 lei', '2019-12-11 00:16:03');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `obiecte`
--

CREATE TABLE `obiecte` (
  `oID` int(11) NOT NULL,
  `oName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `obiecte`
--

INSERT INTO `obiecte` (`oID`, `oName`) VALUES
(1, 'Bisturiu'),
(2, 'Fierastrau'),
(3, 'Foarfeca'),
(4, 'Tifon'),
(5, 'Spatula'),
(6, 'Siringa'),
(7, 'Penseta');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `obiecte_interventie`
--

CREATE TABLE `obiecte_interventie` (
  `oiID` int(11) NOT NULL,
  `oiInterventieID` int(11) NOT NULL,
  `oiObiectID` int(11) NOT NULL,
  `oiCantitate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `obiecte_interventie`
--

INSERT INTO `obiecte_interventie` (`oiID`, `oiInterventieID`, `oiObiectID`, `oiCantitate`) VALUES
(3, 1, 1, 6),
(4, 1, 2, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `programari`
--

CREATE TABLE `programari` (
  `pID` int(11) NOT NULL,
  `pPacient` int(11) NOT NULL,
  `pMedic` int(11) NOT NULL,
  `pConsultatie` int(11) NOT NULL,
  `pDataProgramare` date NOT NULL,
  `pOraProgramare` varchar(255) NOT NULL,
  `ptimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `pDurata` varchar(255) NOT NULL,
  `pAsistenta` varchar(255) NOT NULL,
  `pStatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `programari`
--

INSERT INTO `programari` (`pID`, `pPacient`, `pMedic`, `pConsultatie`, `pDataProgramare`, `pOraProgramare`, `ptimestamp`, `pDurata`, `pAsistenta`, `pStatus`) VALUES
(1, 5, 4, 2, '2019-12-25', '10:00', '2019-12-10 21:52:04', '40 minute', '', 2),
(2, 7, 4, 1, '2019-12-25', '10:00', '2019-12-10 23:01:25', '35 minute', '', 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `rezultate`
--

CREATE TABLE `rezultate` (
  `rID` int(11) NOT NULL,
  `rProgramare` int(11) NOT NULL,
  `rResult` varchar(255) NOT NULL,
  `rMedicatie` varchar(255) NOT NULL,
  `rPret` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `rezultate`
--

INSERT INTO `rezultate` (`rID`, `rProgramare`, `rResult`, `rMedicatie`, `rPret`) VALUES
(1, 2, 'ochelari distanta', '', '100 lei'),
(2, 1, 'a avut succes', '', '350 lei');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `sectii`
--

CREATE TABLE `sectii` (
  `sID` int(11) NOT NULL,
  `sNume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `sectii`
--

INSERT INTO `sectii` (`sID`, `sNume`) VALUES
(0, 'unsigned'),
(1, 'Chirurgie'),
(2, 'Interne'),
(3, 'Pediatrie'),
(4, 'Boli infectioase'),
(5, 'Maternitate'),
(6, 'Morga'),
(7, 'Oftalmologie'),
(8, 'Ginecologie');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userFirstName` varchar(255) NOT NULL,
  `userLastName` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPhoneNumber` varchar(255) NOT NULL,
  `userType` int(11) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userSection` int(11) NOT NULL,
  `userAccountStatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`userID`, `userFirstName`, `userLastName`, `userEmail`, `userPhoneNumber`, `userType`, `userPassword`, `userSection`, `userAccountStatus`) VALUES
(2, 'Liviu', 'Dragnea', 'liviumarian56@gmail.com', '0761261929', 4, 'aecc52e57300c943e00e36a6b9d8842f1dc9ad0b5b13fa869ea0628c38fa6aa0', 0, 1),
(3, 'Cristina', 'Calugaru', 'calugarucristina98@gmail.com', '0760608355', 3, '488a141d8b9990f0d55f5dd1fcd849ffe7711784ae559306aa2275c78fb3d9e0', 0, 0),
(4, 'Alexandru', 'Craciun', 'alexandru.craciun@gmail.com', '0738482913', 2, 'aecc52e57300c943e00e36a6b9d8842f1dc9ad0b5b13fa869ea0628c38fa6aa0', 7, 1),
(5, 'pacient1', 'pacient1', 'pacient1@gmail.com', '0746375463', 1, 'aecc52e57300c943e00e36a6b9d8842f1dc9ad0b5b13fa869ea0628c38fa6aa0', 0, 1),
(6, 'Cristiana', 'Ciungan', 'cristiana.ciungan@gmail.com', '0783742813', 3, 'aecc52e57300c943e00e36a6b9d8842f1dc9ad0b5b13fa869ea0628c38fa6aa0', 0, 1),
(7, 'test_p', 'test', 'test@gmail.com', '0734627318', 1, 'aecc52e57300c943e00e36a6b9d8842f1dc9ad0b5b13fa869ea0628c38fa6aa0', 0, 1),
(8, 'ambulatoriu', 'operatie', 'operatie@medengen.com', '0256384273', 5, 'aecc52e57300c943e00e36a6b9d8842f1dc9ad0b5b13fa869ea0628c38fa6aa0', 0, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users_types`
--

CREATE TABLE `users_types` (
  `typeID` int(11) NOT NULL,
  `typeName` varchar(255) NOT NULL,
  `typeLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `users_types`
--

INSERT INTO `users_types` (`typeID`, `typeName`, `typeLevel`) VALUES
(1, 'Pacient', 1),
(2, 'Medic Specialist', 2),
(3, 'Secretara', 3),
(4, 'Administrator', 4),
(5, 'Operatie', 5);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `cereri_programari`
--
ALTER TABLE `cereri_programari`
  ADD PRIMARY KEY (`cpID`),
  ADD KEY `pacient_fk_key` (`cpPacient`),
  ADD KEY `cpsectia_fk_key` (`cpSectia`);

--
-- Indexuri pentru tabele `consultatii`
--
ALTER TABLE `consultatii`
  ADD PRIMARY KEY (`cID`),
  ADD KEY `SECTIE_FK_KEY` (`cSectie`);

--
-- Indexuri pentru tabele `financiar_log`
--
ALTER TABLE `financiar_log`
  ADD PRIMARY KEY (`fID`),
  ADD KEY `fprogramare_forein_key` (`fProgramareID`);

--
-- Indexuri pentru tabele `obiecte`
--
ALTER TABLE `obiecte`
  ADD PRIMARY KEY (`oID`);

--
-- Indexuri pentru tabele `obiecte_interventie`
--
ALTER TABLE `obiecte_interventie`
  ADD PRIMARY KEY (`oiID`),
  ADD KEY `oiobiect_foreign_key` (`oiObiectID`),
  ADD KEY `oiinterventie_foreign_key` (`oiInterventieID`);

--
-- Indexuri pentru tabele `programari`
--
ALTER TABLE `programari`
  ADD PRIMARY KEY (`pID`),
  ADD KEY `pmedic_fk_key` (`pMedic`),
  ADD KEY `ppacient_fk_key` (`pPacient`),
  ADD KEY `pconsultatie_fk_key` (`pConsultatie`);

--
-- Indexuri pentru tabele `rezultate`
--
ALTER TABLE `rezultate`
  ADD PRIMARY KEY (`rID`),
  ADD KEY `rprogramare_fk_key` (`rProgramare`);

--
-- Indexuri pentru tabele `sectii`
--
ALTER TABLE `sectii`
  ADD PRIMARY KEY (`sID`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `FOREIGN_KEY` (`userType`),
  ADD KEY `FOREIGN_KEY2` (`userSection`);

--
-- Indexuri pentru tabele `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`typeID`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `cereri_programari`
--
ALTER TABLE `cereri_programari`
  MODIFY `cpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `consultatii`
--
ALTER TABLE `consultatii`
  MODIFY `cID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `financiar_log`
--
ALTER TABLE `financiar_log`
  MODIFY `fID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `obiecte`
--
ALTER TABLE `obiecte`
  MODIFY `oID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pentru tabele `obiecte_interventie`
--
ALTER TABLE `obiecte_interventie`
  MODIFY `oiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `programari`
--
ALTER TABLE `programari`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `rezultate`
--
ALTER TABLE `rezultate`
  MODIFY `rID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `sectii`
--
ALTER TABLE `sectii`
  MODIFY `sID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pentru tabele `users_types`
--
ALTER TABLE `users_types`
  MODIFY `typeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `cereri_programari`
--
ALTER TABLE `cereri_programari`
  ADD CONSTRAINT `cpsectia_fk_key` FOREIGN KEY (`cpSectia`) REFERENCES `sectii` (`sID`),
  ADD CONSTRAINT `pacient_fk_key` FOREIGN KEY (`cpPacient`) REFERENCES `users` (`userID`);

--
-- Constrângeri pentru tabele `consultatii`
--
ALTER TABLE `consultatii`
  ADD CONSTRAINT `SECTIE_FK_KEY` FOREIGN KEY (`cSectie`) REFERENCES `sectii` (`sID`);

--
-- Constrângeri pentru tabele `financiar_log`
--
ALTER TABLE `financiar_log`
  ADD CONSTRAINT `fprogramare_forein_key` FOREIGN KEY (`fProgramareID`) REFERENCES `programari` (`pID`);

--
-- Constrângeri pentru tabele `obiecte_interventie`
--
ALTER TABLE `obiecte_interventie`
  ADD CONSTRAINT `oiinterventie_foreign_key` FOREIGN KEY (`oiInterventieID`) REFERENCES `programari` (`pID`),
  ADD CONSTRAINT `oiobiect_foreign_key` FOREIGN KEY (`oiObiectID`) REFERENCES `obiecte` (`oID`);

--
-- Constrângeri pentru tabele `programari`
--
ALTER TABLE `programari`
  ADD CONSTRAINT `pconsultatie_fk_key` FOREIGN KEY (`pConsultatie`) REFERENCES `consultatii` (`cID`),
  ADD CONSTRAINT `pmedic_fk_key` FOREIGN KEY (`pMedic`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `ppacient_fk_key` FOREIGN KEY (`pPacient`) REFERENCES `users` (`userID`);

--
-- Constrângeri pentru tabele `rezultate`
--
ALTER TABLE `rezultate`
  ADD CONSTRAINT `rprogramare_fk_key` FOREIGN KEY (`rProgramare`) REFERENCES `programari` (`pID`);

--
-- Constrângeri pentru tabele `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FOREIGN_KEY` FOREIGN KEY (`userType`) REFERENCES `users_types` (`typeID`),
  ADD CONSTRAINT `FOREIGN_KEY2` FOREIGN KEY (`userSection`) REFERENCES `sectii` (`sID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
