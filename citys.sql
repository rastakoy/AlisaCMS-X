CREATE TABLE IF NOT EXISTS `towns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `folder` int(11) NOT NULL DEFAULT '0',
  `prior` int(3) NOT NULL DEFAULT '0',
  `filter` int(11) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '1',
  `tmp` int(1) NOT NULL DEFAULT '1',
  `price` double NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `letters` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
