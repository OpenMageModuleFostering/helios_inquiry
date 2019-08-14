<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('produkteinquiry')};
CREATE TABLE IF NOT EXISTS `produkteinquiry` (
  `inquiryid` int(11) NOT NULL AUTO_INCREMENT,
  `produckteinfo` text NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `company` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `road` varchar(25) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `location` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `iscustcreated` enum('0','1') NOT NULL,
  `status` enum('0','1') NOT NULL,
  `createddt` datetime NOT NULL,
  `updateddt` datetime NOT NULL,
  PRIMARY KEY (`inquiryid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


");

$installer->endSetup(); 