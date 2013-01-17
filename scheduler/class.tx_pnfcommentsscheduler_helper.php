<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 In Cite Solution (technique@in-cite.net)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

class tx_pnfcommentsscheduler_helper {
	function sendAlert() {
		$tsconfig = t3lib_BEfunc::getModTSconfig(1, 'tx_commentsscheduler_cli'); // get whole tsconfig from backend
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		$comments = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'pid,`tstamp`',
			'`tx_comments_comments`',
			'1 AND deleted=0 AND hidden=0 ',
			'',
			'tstamp desc'
		);
		
		$nbComment = 0;
		$pidList ='';
		foreach($comments as $comment) {
			if($comment['tstamp'] >= mktime(0,0,0,date('m'), date('d'), date('Y')) && $comment['tstamp'] <= mktime(23, 59, 59, date('m'), date('d'), date('Y'))) {
				$nbComment++;
				$pidList .= ($pidList!='')? ','.$comment['pid'] : $comment['pid'];
			}
		}
		
		$pidList = t3lib_div::uniqueList($pidList);
		
		if($nbComment) {
			$language = t3lib_div::GPVar('L');
			
			switch($language) {
				default:
				case 0:
					$lang = 'fr';
				break;
			}
			
			$LOCAL_LANG = t3lib_div::readLLfile('EXT:pnf_extend_comments/scheduler/locallang.xml', $lang);
			$toEmail = $tsconfig['properties']['email'];
			$subject = $LOCAL_LANG[$lang]['subject'];
			$url = $tsconfig['properties']['typo3Url'];
			
			$markers = array(
				'###NB_COMMENTS###',
				'###PAGE_LIST###',
				'###URL###'
			);
			
			$pages = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'uid,title,tx_pnfextendcomments_email,pid',
			'`pages`',
			'uid IN ('.$pidList.') AND deleted=0 AND hidden=0 '
			);
			
			$aContact = array();
			$aContactEmail = array();
			if(is_array($pages) && count($pages)) {
				foreach($pages as $page) {
					if(!empty($page['tx_pnfextendcomments_email'])) {
						$aContact[] = $page['tx_pnfextendcomments_email'];
					}
					else {
						$rootline = t3lib_BEfunc::BEgetRootLine($page['uid']);
						if(is_array($rootline) && count($rootline)) {
							foreach($rootline as $rootlinePage) {
								$contactEmail = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
									'tx_pnfextendcomments_email',
									'pages',
									'uid = ' . $rootlinePage['uid'] . ' AND hidden = 0 AND deleted = 0'
								);
								if(!empty($contactEmail[0]['tx_pnfextendcomments_email'])) {
									$aContactEmail[] = $contactEmail[0]['tx_pnfextendcomments_email'];
								}
							}
						}
					}
				}
			}

			$aContact = array_merge($aContact, $aContactEmail);
			$aContact = array_filter($aContact);
			$aContact = array_unique($aContact);
			
			if(!empty($toEmail)) {
				if(is_array($aContact) && count($aContact)) { 
					$toEmail .= ',' . implode(',', $aContact);
				}
			}
			elseif(is_array($aContact) && count($aContact)) { 
				$toEmail .= implode(',', $aContact);
			}
				
			$pageList='';
			foreach($pages as $page) {
				$pageList .= ($pageList != '')? ', '.$page['title'] : $page['title'];
			}
			$values = array(
				$nbComment,
				$pageList,
				$url
			);
			
			$body = str_replace($markers, $values, $LOCAL_LANG[$lang]['body']);
			t3lib_div::plainMailEncoded($toEmail, $subject, $body, 'From: ' . $tsconfig['properties']['fromEmail']);
		}
		return true;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pnf_extend_comments/scheduler/class.tx_pnfcommentsscheduler_helper.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pnf_extend_comments/scheduler/class.tx_pnfcommentsscheduler_helper.php']);
}

?>