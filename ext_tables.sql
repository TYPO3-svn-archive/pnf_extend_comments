#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_pnfextendcomments_comments tinyint(3) DEFAULT '0' NOT NULL,
	tx_pnfextendcomments_commentsclosed tinyint(3) DEFAULT '0' NOT NULL,
	tx_pnfextendcomments_email text,
);