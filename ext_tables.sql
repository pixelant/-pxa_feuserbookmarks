#
# Table structure for table 'tx_pxafeuserbookmarks_domain_model_bookmark'
#
CREATE TABLE tx_pxafeuserbookmarks_domain_model_bookmark (

	feuserid int(11) DEFAULT '0' NOT NULL,
	pageid int(11) DEFAULT '0' NOT NULL,
	special_identificator int(11) DEFAULT '0' NOT NULL,
	params text NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
);
