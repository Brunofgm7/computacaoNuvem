-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 09-Jun-2021 às 22:23
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `computacaonuvem`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `backgroundimage`
--

CREATE TABLE `backgroundimage` (
  `id` int(11) NOT NULL,
  `backgroundimage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `backgroundimage`
--

INSERT INTO `backgroundimage` (`id`, `backgroundimage`) VALUES
(1, 'background/stock.png'),
(2, 'background/default.jpg'),
(3, 'background/default2.png'),
(4, 'background/default3.jpg'),
(5, 'background/default4.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos`
--

CREATE TABLE `jogos` (
  `id` int(11) NOT NULL,
  `idVisitado` varchar(11) NOT NULL,
  `idVisitante` int(11) NOT NULL,
  `vencedor` varchar(11) NOT NULL,
  `idJogo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`id`, `idVisitado`, `idVisitante`, `vencedor`, `idJogo`) VALUES
(1, '25', 1, '25', 1),
(3, '25', 1, '25', 1),
(4, '25', 1, '25', 1),
(5, '25', 1, '25', 1),
(6, '25', 1, '25', 1),
(8, '47', 1, '47', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `last_activity_user`
--

CREATE TABLE `last_activity_user` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `last_activity_user`
--

INSERT INTO `last_activity_user` (`login_details_id`, `user_id`, `last_activity`) VALUES
(43, 46, '2021-06-09 20:48:56'),
(44, 45, '2021-06-09 20:50:01'),
(46, 26, '2021-06-09 21:04:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `profileimage`
--

CREATE TABLE `profileimage` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `profileimage`
--

INSERT INTO `profileimage` (`id`, `image`) VALUES
(1, 'profileP/default.png'),
(2, 'profileP/default2.jpg'),
(3, 'profileP/default3.jpg'),
(4, 'profileP/default4.jpg'),
(5, 'profileP/stock.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipojogo`
--

CREATE TABLE `tipojogo` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `img` text NOT NULL,
  `url` text NOT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipojogo`
--

INSERT INTO `tipojogo` (`id`, `nome`, `img`, `url`, `available`) VALUES
(1, 'TicTacToe', 'gameImage/tictactoe.png', 'tictactoeOpponent.php', 0),
(9, 'Teste', 'gameImage/4emlinha.png.jpg', 'teste.php', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `imagemPerfil` text NOT NULL,
  `vitorias` int(11) NOT NULL,
  `empates` int(11) NOT NULL,
  `derrotas` int(11) NOT NULL,
  `jogosFeitos` int(11) NOT NULL,
  `backgroundImage` text NOT NULL,
  `contaVerificada` int(11) NOT NULL,
  `isAdmin` int(11) NOT NULL,
  `userKey` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `imagemPerfil`, `vitorias`, `empates`, `derrotas`, `jogosFeitos`, `backgroundImage`, `contaVerificada`, `isAdmin`, `userKey`) VALUES
(1, 'BOT', 'bot@bot.pt', '$2y$10$CshR/WFmVW2oXUBv0LiDhukEQVS5.EdSV1kgCUcIIy1KR6/vI96YK', 'profileP/stock.jpg', 0, 0, 0, 0, 'background/stock.png', 1, 0, '$2y$10$./mn/CrEP5dx4NiDCVt1IeTS12K6bMxGldLy9BeVsvsxxkdon2aU6'),
(25, 'brunofgm7', 'bruno7moreira@gmail.com', '$2y$10$PiULNoMKwKsDitVQeay3wuzXwixv8IbX1Gu7VlIgpi4YKt7bjmU7W', 'profileP/stock.jpg', 5, 0, 0, 5, 'background/stock.png', 1, 0, '$2y$10$zEuN85nk8XOuFlkrhWymuu18NcIwAecbTYx5HPRh.3w1vpPP8TeM.'),
(26, 'admin', 'admin@admin.pt', '$2y$10$.K0IgTs/3pUVDnG0q0.0kOu1PKcGyfk7ENt1I3dKOdvHy73oGT0j6', 'profileP/stock.jpg', 0, 0, 0, 0, 'background/stock.png', 1, 1, '$2y$10$3her1O95lSImesy0QKuGSOa/d2raXH0EkwR1riJQi4TR7ejAsoeh6'),
(45, 'NSG', 'a034817@ismai.pt', '$2y$10$wBGvWyQhnch1V1nP/Jnw/ulPjnCKZdnVAXaN7zS5KPIKgZ64Jcx5G', 'profileP/stock.jpg', 0, 0, 0, 0, 'background/default3.jpg', 0, 0, '$2y$10$k/ZHlIqPHT3GyYAsL9AnmeJMIyD5qS1x/nq4cMa6TlyfE5BraCBF.'),
(46, 'gil', 'gil@gil.pt', '$2y$10$YNrQcp.1rA2NiBzOygHA2O2jELNmEzFJY9gWYZtJJDhUCV/vkdCdC', 'profileP/default2.jpg', 0, 0, 0, 0, 'background/default.jpg', 0, 0, '$2y$10$NdsvVyhs6CoVcQza76XgTuNVUUTw43Sny87ERX59JLdL7l/.nPh8C');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `backgroundimage`
--
ALTER TABLE `backgroundimage`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idVisitado` (`idVisitado`),
  ADD KEY `idVisitante` (`idVisitante`),
  ADD KEY `idJogo` (`idJogo`),
  ADD KEY `vencedor` (`vencedor`);

--
-- Índices para tabela `last_activity_user`
--
ALTER TABLE `last_activity_user`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Índices para tabela `profileimage`
--
ALTER TABLE `profileimage`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tipojogo`
--
ALTER TABLE `tipojogo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH;

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `backgroundimage`
--
ALTER TABLE `backgroundimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `last_activity_user`
--
ALTER TABLE `last_activity_user`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `profileimage`
--
ALTER TABLE `profileimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `tipojogo`
--
ALTER TABLE `tipojogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
