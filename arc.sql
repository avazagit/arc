--
-- Database: `arc`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_email` varchar(75) NOT NULL,
  `auth_passw` varchar(40) NOT NULL,
  `auth_creds` varchar(255) DEFAULT NULL,
  `auth_perms` varchar(255) DEFAULT NULL,
  `auth_atmpt` int(3) unsigned NOT NULL DEFAULT '0',
  `auth_block` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_email` (`auth_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='System Authentication Table' AUTO_INCREMENT=1 ;
