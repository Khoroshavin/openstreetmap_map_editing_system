-- phpMyAdmin SQL Dump
-- Версия сервера: 10.2.37-MariaDB
-- PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `latlng` varchar(4000) NOT NULL,
  `html` mediumtext NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- dump `markers`
--

INSERT INTO `markers` (`id`, `latlng`, `html`, `type`) VALUES
(82, '[[{\"lat\":49.2707133082325,\"lng\":15.476754635123578},{\"lat\":49.27070280761099,\"lng\":15.477049589324523},{\"lat\":49.270807813725476,\"lng\":15.477038863717201},{\"lat\":49.27081481412513,\"lng\":15.476856528393002},{\"lat\":49.27119633440559,\"lng\":15.476781449141825},{\"lat\":49.27121383526511,\"lng\":15.47697987287703},{\"lat\":49.27131183996369,\"lng\":15.476969147269704},{\"lat\":49.27129083897323,\"lng\":15.476701007087048},{\"lat\":49.27102482565375,\"lng\":15.47671173269433},{\"lat\":49.27082181452382,\"lng\":15.47676536073086}]]', '<h1>Budova №3</h1>\n<p>Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text</p>\n<p><img title=\"Budova №3\" src=\"../vendor/tiny/images/blobid1624622944772.jpg\" alt=\"Budova №3\" width=\"565\" height=\"414\" /></p>', 'Polygon'),
(83, '[[{\"lat\":49.271189334060054,\"lng\":15.476459835902704},{\"lat\":49.271178833539864,\"lng\":15.47614343048716},{\"lat\":49.27078681252044,\"lng\":15.476170244505443},{\"lat\":49.270790312721914,\"lng\":15.476293588989469},{\"lat\":49.27108782893801,\"lng\":15.476282863382146},{\"lat\":49.271094829297944,\"lng\":15.476475924313668}]]', '<h1>Budova №1</h1>\n<p>Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.</p>\n<p><img title=\"Budova №1\" src=\"../vendor/tiny/images/blobid1624623123887.jpg\" alt=\"Budova №1\" width=\"642\" height=\"441\" /></p>', 'Polygon'),
(86, '[[{\"lat\":49.270986323607104,\"lng\":15.479162914956854},{\"lat\":49.27095832209977,\"lng\":15.479436417943152},{\"lat\":49.2708778176776,\"lng\":15.47942032953223},{\"lat\":49.270898818843854,\"lng\":15.479216542993386},{\"lat\":49.27079731312406,\"lng\":15.479200454582422},{\"lat\":49.27076231110331,\"lng\":15.479382789906621},{\"lat\":49.270660805102615,\"lng\":15.479366701495657},{\"lat\":49.27068180636128,\"lng\":15.479189728975102},{\"lat\":49.2705592988931,\"lng\":15.479157552153174},{\"lat\":49.27055579867526,\"lng\":15.479205817386063},{\"lat\":49.27045779247473,\"lng\":15.479189728975102},{\"lat\":49.270454292249674,\"lng\":15.479237994207992},{\"lat\":49.27039828861512,\"lng\":15.479221905797026},{\"lat\":49.270408789301435,\"lng\":15.479055658883752},{\"lat\":49.2707133082325,\"lng\":15.47909319850932}]]', '<h1>Budova №5</h1>\n<p>Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.</p>\n<p><img title=\"Budova №5\" src=\"../vendor/tiny/images/blobid1624623738459.jpg\" alt=\"Budova №5\" width=\"723\" height=\"542\" /></p>', 'Polygon'),
(87, '{\"lat\":49.27005876521959,\"lng\":15.477560318113744}', '<h1>Označen&iacute; №1</h1>\n<p>Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.</p>\n<p><img title=\"Označen&iacute; №1\" src=\"../vendor/tiny/images/blobid1624623948936.jpg\" alt=\"Označen&iacute; №1\" width=\"700\" height=\"394\" /></p>', 'Point'),
(88, '[[{\"lat\":49.27007976673453,\"lng\":15.479962282661443},{\"lat\":49.27007626648268,\"lng\":15.480208971629496},{\"lat\":49.27005876521959,\"lng\":15.48036985573913},{\"lat\":49.269978259329505,\"lng\":15.480364492935491},{\"lat\":49.269978259329505,\"lng\":15.480300139291636},{\"lat\":49.269894253043226,\"lng\":15.480305502095277},{\"lat\":49.269894253043226,\"lng\":15.480208971629496},{\"lat\":49.26996775855154,\"lng\":15.480208971629496},{\"lat\":49.269988760105235,\"lng\":15.480021273501617},{\"lat\":49.269876751715586,\"lng\":15.480031999108938},{\"lat\":49.26986625091601,\"lng\":15.47993546864316},{\"lat\":49.26999576062112,\"lng\":15.47993546864316}]]', '<h1>Označen&iacute; №2</h1>\n<p>Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.</p>\n<p><img title=\"Označen&iacute; №2\" src=\"../vendor/tiny/images/blobid1624624044604.jpg\" alt=\"Označen&iacute; №2\" width=\"700\" height=\"394\" /></p>', 'Polygon'),
(90, '[[{\"lat\":49.26975774252298,\"lng\":15.47758636207461},{\"lat\":49.26972974031828,\"lng\":15.477779423006133},{\"lat\":49.269656234455354,\"lng\":15.47776869739881},{\"lat\":49.26966673529963,\"lng\":15.477666804129388},{\"lat\":49.26951622298488,\"lng\":15.477639990111143},{\"lat\":49.26951622298488,\"lng\":15.477580999270929},{\"lat\":49.26945321769354,\"lng\":15.477580999270929},{\"lat\":49.26945671798961,\"lng\":15.477511282823436}]]', '<h1>Budova №2</h1>\n<p>Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.</p>\n<p><img title=\"Budova №2\" src=\"../vendor/tiny/images/blobid1624624162553.jpg\" alt=\"Budova №2\" width=\"676\" height=\"531\" /></p>', 'Polygon'),
(91, '[[{\"lat\":49.270044764204656,\"lng\":15.475966496711605},{\"lat\":49.270006261393135,\"lng\":15.476170283250449},{\"lat\":49.2699432567276,\"lng\":15.476138106428523},{\"lat\":49.26996775855154,\"lng\":15.47602548755182},{\"lat\":49.2697507419733,\"lng\":15.475945045497001},{\"lat\":49.26976124279745,\"lng\":15.475859240638544}]]', '<h1>Budova №4</h1>\n<p>Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text. Zde může b&yacute;t popisn&yacute; text.</p>\n<p><img title=\"Budova №4\" src=\"../vendor/tiny/images/blobid1624624321806.jpg\" alt=\"Budova №4\" width=\"670\" height=\"335\" /></p>', 'Polygon');

-- --------------------------------------------------------

--
-- `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `log` varchar(20) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- dump `users`
--

INSERT INTO `users` (`id`, `log`, `pass`, `role`) VALUES
(1, 'admin', '$2y$10$nwMT2Vjtt2VRdgXS4Dqv4e3MjxolASjQ0a7bK9viEJ/5PZ5NBuWBO', 'admin'),
(2, 'redaktor', '$2y$10$IUy/KqeiaxcRCMNv6l1/yu4oqQRUmoE08mQmf/E2xub.SCHaVIDCC', 'redaktor'),
(3, 'admin2', '$2y$10$rnoA2SKyiIamaeQjxGMkMObdqI5p0VoC/qgRzit8xKqPyw83kSbZy', 'admin'),
(4, 'redaktor2', '$2y$10$qUJyLAeO3XLxZaQKqNWt.OZ6G4x3SNfHDB9MWy8z0EqUcwj5RE9jK', 'redaktor'),
(5, 'admin3', '$2y$10$Pin//WaFKVAOONn.r5pda.ZNSq/WGoBZKgJbrEpfJxDj65.SGWVkC', 'admin'),
(6, 'redaktor3', '$2y$10$Zpg//PDM7FRP20/QKbKfE./myC0FN498iXjKNGh9MkshD7wSlNHza', 'redaktor');

-- --------------------------------------------------------

--
-- Table indexes
--

----
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

----

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

----
--
-- AUTO_INCREMENT
-- AUTO_INCREMENT `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--

-- AUTO_INCREMENT  `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


--
COMMIT;
