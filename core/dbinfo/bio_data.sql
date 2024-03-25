
CREATE TABLE IF NOT EXISTS `bio_data` (
  `client_id` int(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `nin` varchar(50) NOT NULL,
  `passport` text NOT NULL,
  `tel` int(15) NOT NULL,
  `marital` varchar(20) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `occupation` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `contact` int(15) DEFAULT NULL,
  `kin_name` varchar(250) NOT NULL,
  `kin_address` varchar(250) NOT NULL,
  `kin_cntct` int(15) NOT NULL,
  `kin1_rel` varchar(100) NOT NULL,
  `reg_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130200 ;
