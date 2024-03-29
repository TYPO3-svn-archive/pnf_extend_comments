<?php
if (!defined ('TYPO3_MODE'))    die ('Access denied.');

t3lib_extMgm::addPageTSConfig('
	tx_pnfextendcomments_cli{
		email = email@example.com
		typo3Url = http://www.example.com/typo3/
		fromEmail = noreply@example.com
	}
');

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['comments'][] = 'EXT:' . $_EXTKEY . '/class.user_pnfextendcomments_hook.php:user_pnfextendcomments_hook->addMarkers';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['form'][] = 'EXT:' . $_EXTKEY . '/class.user_pnfextendcomments_hook.php:user_pnfextendcomments_hook->addMarkersForm';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['closeCommentsAfter'][] = 'EXT:' . $_EXTKEY . '/class.user_pnfextendcomments_hook.php:user_pnfextendcomments_hook->closeComments';

$GLOBALS['TYPO3_CONF_VARS']['FE']['XCLASS']['ext/comments/pi1/class.tx_comments_pi1.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'class.ux_tx_comments_pi1.php';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_pnfextendcomments_scheduler'] = array(
	'extension'			=> $_EXTKEY,
	'title'				=> 'Comments alert',
	'description'		=> 'Send an email alert ',	
	'additionalFields'	=> ''
);
?>