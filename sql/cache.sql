
CREATE TABLE IF NOT EXISTS `cache` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `filter` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tags` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `thumbnail` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `caption` text COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `profile` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `flagged` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
