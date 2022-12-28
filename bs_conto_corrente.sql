-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 28, 2022 alle 17:36
-- Versione del server: 10.4.24-MariaDB
-- Versione PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bs_conto_corrente`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `tcategoriamovimenti`
--

CREATE TABLE `tcategoriamovimenti` (
  `CategoriaMovimentoID` int(11) NOT NULL,
  `NomeCategoria` text NOT NULL,
  `Tipologia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tcategoriamovimenti`
--

INSERT INTO `tcategoriamovimenti` (`CategoriaMovimentoID`, `NomeCategoria`, `Tipologia`) VALUES
(1, 'Apertura Conto', 'Entrata'),
(2, 'Bonifico Entrata', 'Entrata'),
(3, 'Bonifico Uscita', 'Uscita'),
(4, 'Prelievo Contanti', 'Uscita'),
(5, 'Pagamento Utenze', 'Uscite'),
(6, 'Ricarica', 'Entrata'),
(7, 'Versamento Bancomat', 'Entrata'),
(8, 'Uscita Bancomat', 'Uscita'),
(9, 'Stipendio', 'Entrata'),
(10, 'Giroconto Entrata', 'Entrata'),
(11, 'Giroconto Uscita', 'Uscita');

-- --------------------------------------------------------

--
-- Struttura della tabella `tconticorrenti`
--

CREATE TABLE `tconticorrenti` (
  `ContoCorrenteID` int(11) NOT NULL,
  `CodiceTitolare` int(11) NOT NULL,
  `Password` text NOT NULL,
  `IBAN` text NOT NULL,
  `Email` text NOT NULL,
  `NomeTitolare` text NOT NULL,
  `Professione` text NOT NULL,
  `Paese` text NOT NULL,
  `Indirizzo` text NOT NULL,
  `CAP` text NOT NULL,
  `Telefono` text NOT NULL,
  `ImmagineProfilo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tconticorrenti`
--

INSERT INTO `tconticorrenti` (`ContoCorrenteID`, `CodiceTitolare`, `Password`, `IBAN`, `Email`, `NomeTitolare`, `Professione`, `Paese`, `Indirizzo`, `CAP`, `Telefono`, `ImmagineProfilo`) VALUES
(1, 6474888, 'hfyf!kdjs8sy!', 'IT60X0542811101000000123456', 'email', 'Mario Rossi', 'Professore', 'Italia', '', '', '', 'profilo-63837c1b258480.73820148.jpg'),
(2, 1234567, 'aaa', 'IT60X0479863010000005678910', 'email', 'Francesca Ferrari', 'Architetto', 'Italia', 'viale Roma, 83', '', '+39 0123456789', 'profilo-638255ad112621.67190417.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `tlogin`
--

CREATE TABLE `tlogin` (
  `LoginID` int(11) NOT NULL,
  `ContoCorrenteID` int(11) NOT NULL,
  `CodiceSicurezza` int(11) NOT NULL,
  `Data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `tmovimenticonto`
--

CREATE TABLE `tmovimenticonto` (
  `MovimentoID` int(11) NOT NULL,
  `ContoCorrenteID` int(11) NOT NULL,
  `Data` date NOT NULL DEFAULT current_timestamp(),
  `Importo` float NOT NULL,
  `Saldo` float NOT NULL,
  `CategoriaMovimentoID` int(11) NOT NULL,
  `Stato` text NOT NULL,
  `DescrizioneEstesa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tmovimenticonto`
--

INSERT INTO `tmovimenticonto` (`MovimentoID`, `ContoCorrenteID`, `Data`, `Importo`, `Saldo`, `CategoriaMovimentoID`, `Stato`, `DescrizioneEstesa`) VALUES
(1, 1, '2022-08-01', 2000, 2000, 1, 'Eseguito', 'Apertura Conto'),
(2, 1, '2022-09-05', 500, 2500, 2, 'Eseguito', 'Affitto studenti settembre 2022'),
(3, 1, '2022-10-07', 110, 2390, 5, 'Eseguito', 'Bollette luce settembre/ottobre 2022'),
(4, 1, '2022-10-23', 400, 1990, 3, 'Eseguito', 'Mutuo ottobre 2022'),
(5, 1, '2022-10-13', 1300, 3290, 2, 'Eseguito', 'Stipendio ottobre 2022'),
(6, 1, '2022-10-29', 50, 3240, 4, 'Eseguito', 'Prelievo sportello bancomat'),
(7, 1, '2022-11-07', 70, 3170, 8, 'Eseguito', 'Pagamento spesa Eurospin via Tal dei tali, ecc.'),
(8, 1, '2022-11-24', 20, 3150, 6, 'Eseguito', 'Ricarica telefonica Vodafone da 20 €'),
(9, 1, '2022-11-24', 20, 3130, 6, 'Eseguito', 'Ricarica telefonica Tim da 20 €'),
(10, 2, '2022-11-24', 500, 500, 1, 'Eseguito', 'Apertura Conto'),
(11, 1, '2022-11-29', 859.78, 2290.22, 11, 'Eseguito', 'Rimborso'),
(12, 2, '2022-11-29', 859.78, 1359.78, 10, 'Eseguito', 'Rimborso'),
(13, 1, '2022-11-29', 25, 2265.22, 6, 'Eseguito', 'Ricarica Vodafone di 25 € '),
(17, 2, '2022-12-01', 1, 1358.78, 11, 'Eseguito', 'caffe'),
(18, 1, '2022-12-01', 1, 2291.22, 10, 'Eseguito', 'caffe'),
(23, 2, '2022-12-02', 2.5, 1356.28, 3, 'In attesa', 'capuccino'),
(24, 2, '2022-12-28', 15, 1343.78, 6, 'Eseguito', 'Ricarica Vodafone di 15 € ');

-- --------------------------------------------------------

--
-- Struttura della tabella `toperatoretelefonico`
--

CREATE TABLE `toperatoretelefonico` (
  `operatoreID` int(11) NOT NULL,
  `Nome` text NOT NULL,
  `CategoriaMovimentoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `toperatoretelefonico`
--

INSERT INTO `toperatoretelefonico` (`operatoreID`, `Nome`, `CategoriaMovimentoID`) VALUES
(1, 'vodafone', 6),
(2, 'tim', 6),
(3, 'iliad', 6),
(4, 'wind3', 6),
(5, 'ho', 6),
(6, 'postemobile', 6);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `tcategoriamovimenti`
--
ALTER TABLE `tcategoriamovimenti`
  ADD PRIMARY KEY (`CategoriaMovimentoID`);

--
-- Indici per le tabelle `tconticorrenti`
--
ALTER TABLE `tconticorrenti`
  ADD PRIMARY KEY (`ContoCorrenteID`);

--
-- Indici per le tabelle `tlogin`
--
ALTER TABLE `tlogin`
  ADD PRIMARY KEY (`LoginID`);

--
-- Indici per le tabelle `tmovimenticonto`
--
ALTER TABLE `tmovimenticonto`
  ADD PRIMARY KEY (`MovimentoID`);

--
-- Indici per le tabelle `toperatoretelefonico`
--
ALTER TABLE `toperatoretelefonico`
  ADD PRIMARY KEY (`operatoreID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `tcategoriamovimenti`
--
ALTER TABLE `tcategoriamovimenti`
  MODIFY `CategoriaMovimentoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `tconticorrenti`
--
ALTER TABLE `tconticorrenti`
  MODIFY `ContoCorrenteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `tlogin`
--
ALTER TABLE `tlogin`
  MODIFY `LoginID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tmovimenticonto`
--
ALTER TABLE `tmovimenticonto`
  MODIFY `MovimentoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `toperatoretelefonico`
--
ALTER TABLE `toperatoretelefonico`
  MODIFY `operatoreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
