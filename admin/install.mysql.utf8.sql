CREATE TABLE IF NOT EXISTS `#__sk_sms_returnplus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skebby_dispatch_id` int(11) NOT NULL DEFAULT '0',
  `skebby_message_id` int(11) NOT NULL DEFAULT '0',
  `recipient` text,
  `status` varchar(50) NOT NULL DEFAULT '',
  `error_code` int(11) NOT NULL DEFAULT '0',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `user_reference` varchar(40) NOT NULL DEFAULT '',
  `skebby_date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator_date_time` varchar(20) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `#__sk_sms_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(50) NOT NULL DEFAULT '',
  `recipients` text,
  `text` text,
  `sender_number` varchar(20) NOT NULL DEFAULT '',
  `sender_string` varchar(20) NOT NULL DEFAULT '',
  `charset` varchar(10) NOT NULL DEFAULT '',
  `user_reference` varchar(40) NOT NULL DEFAULT '',
  `skebby_dispatch_id` int(11) NOT NULL DEFAULT '0',
  `status` varchar(30) NOT NULL DEFAULT '',
  `error_code` int(11) NOT NULL DEFAULT '0',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 ;