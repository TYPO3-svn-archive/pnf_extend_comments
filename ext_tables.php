<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	'tx_pnfextendcomments_comments' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:pnf_extend_comments/locallang_db.xml:pages.tx_pnfextendcomments_comments',		
		'config' => array (
			'type' => 'check',
			'default' => '0'
		)
	),
	'tx_pnfextendcomments_commentsclosed' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:pnf_extend_comments/locallang_db.xml:pages.tx_pnfextendcomments_commentsclosed',		
		'config' => array (
			'type' => 'check',
			'default' => '0'
		)
	),
	'tx_pnfextendcomments_email' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:pnf_extend_comments/locallang_db.xml:pages.tx_pnfextendcomments_email',		
		'config' => array (
			'type' => 'input'
		)
	),
);


t3lib_div::loadTCA("pages");
t3lib_extMgm::addTCAcolumns("pages",$tempColumns,1);
$TCA['pages']['palettes']['comments'] = array(
	'canNotCollapse' => 1,
	'showitem' => 'tx_pnfextendcomments_comments;LLL:EXT:pnf_extend_comments/locallang_db.xml:pages.tx_pnfextendcomments_comments, tx_pnfextendcomments_commentsclosed;LLL:EXT:pnf_extend_comments/locallang_db.xml:pages.tx_pnfextendcomments_commentsclosed,tx_pnfextendcomments_email;LLL:EXT:pnf_extend_comments/locallang_db.xml:pages.tx_pnfextendcomments_email'
);
t3lib_extMgm::addToAllTCAtypes('pages','--palette--;LLL:EXT:pnf_extend_comments/locallang_db.xml:pages.tx_pnfextendcomments_comments;comments');

?>