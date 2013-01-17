<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2012 Plan Net France <technique@in-cite.net>
 * All rights reserved
 *
 * This file is part of the Web-Empowered Church (WEC)
 * (http://WebEmpoweredChurch.org) ministry of Christian Technology Ministries 
 * International (http://CTMIinc.org). The WEC is developing TYPO3-based
 * (http://typo3.org) free software for churches around the world. Our desire
 * is to use the Internet to help offer new life through Jesus Christ. Please
 * see http://WebEmpoweredChurch.org/Jesus.
 *
 * You can redistribute this file and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation;
 * either version 2 of the License, or (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This file is distributed in the hope that it will be useful for ministry,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the file!
 ***************************************************************/

 /**
 * Utils function
 *	
 * @author	Virginie Cribier <virginie@in-cite.net>
 * @package	TYPO3
 * @subpackage	tx_comments_pi1
 */

class ux_tx_comments_pi1 extends tx_comments_pi1 {
	/**
	 * Sends notification e-mail about new comment
	 *
	 * @param	int		$uid	UID of new comment
	 * @param	int		$points	Number of earned spam points
	 * @return	void
	 */
	function sendNotificationEmail($uid, $points) {
		$toEmail = $this->conf['spamProtect.']['notificationEmail'];
		$fromEmail = $this->conf['spamProtect.']['fromEmail'];
		if (t3lib_div::validEmail($toEmail) && t3lib_div::validEmail($fromEmail)) {
			$template = $this->cObj->fileResource($this->conf['spamProtect.']['emailTemplate']);
			$check = md5($uid . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
			$markers = array(
				'###URL###' => t3lib_div::getIndpEnv('TYPO3_REQUEST_URL'),
				'###POINTS###' => $points,
				'###FIRSTNAME###' => $this->piVars['firstname'],
				'###LASTNAME###' => $this->piVars['lastname'],
				'###EMAIL###' => $this->piVars['email'],
				'###LOCATION###' => $this->piVars['location'],
				'###HOMEPAGE###' => $this->piVars['homepage'],
				'###CONTENT###' => $this->piVars['content'],
				'###REMOTE_ADDR###' => t3lib_div::getIndpEnv('REMOTE_ADDR'),
				'###APPROVE_LINK###' => t3lib_div::locationHeaderUrl('index.php?eID=comments&uid=' . $uid . '&chk=' . $check . '&cmd=approve'),
				'###DELETE_LINK###' => t3lib_div::locationHeaderUrl('index.php?eID=comments&uid=' . $uid . '&chk=' . $check . '&cmd=delete'),
				'###KILL_LINK###' => t3lib_div::locationHeaderUrl('index.php?eID=comments&uid=' . $uid . '&chk=' . $check . '&cmd=kill'),
				'###SITE_REL_PATH###' => t3lib_extMgm::siteRelPath('comments'),
			);
			// Call hook for custom markers
			if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['sendNotificationMail'])) {
				foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['sendNotificationMail'] as $userFunc) {
					$params = array(
						'pObj' => &$this,
						'template' => $template,
						'check' => $check,
						'markers' => $markers,
						'uid' => $uid
					);
					if (is_array($tempMarkers = t3lib_div::callUserFunction($userFunc, $params, $this))) {
						$markers = $tempMarkers;
					}
				}
			}
			$content = $this->cObj->substituteMarkerArray($template, $markers);
			t3lib_div::plainMailEncoded($toEmail, $this->pi_getLL('email_subject'), $content, 'From: ' . $this->conf['spamProtect.']['fromEmail']);
		}
	}
}
?>