<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Plan Net <technique@in-cite.net>
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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

/**
 * Hook for powermail extension
 *
 * @author	Virginie Sugere <virginie@in-cite.net>
 * @package	TYPO3
 * @subpackage	pnf_extend_comments
 */ 
class user_pnfextendcomments_hook {
	function addMarkers($params, $object) {
		$params['markers']['###ADDITIONAL_CONTENT###'] = '';
		$infosPage = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'tx_pnfextendcomments_commentsclosed,tx_pnfextendcomments_comments',
			'pages',
			'uid = '.$GLOBALS['TSFE']->id
		);

		if($infosPage) {
			//echo t3lib_div::view_array($infosPage[0]['tx_pnfextendcomments_commentsclosed']);
			//if($infosPage[0]['tx_rrmpagesdata_commentsclosed'] == 1)
			if($infosPage[0]['tx_pnfextendcomments_commentsclosed'] == 1)
				$add = $object->cObj->cObjGetSingle($object->conf['addtional_closed'], $object->conf['additional_closed.']);
			else
				$add = $object->cObj->cObjGetSingle($object->conf['additonal'], $object->conf['additional.']);
			
			$params['markers']['###ADDITIONAL_CONTENT###'] = $add;
				
		}
		return $params['markers'];
	}
	
	function addMarkersForm($params, $object) {
		//if(t3lib_div::_GP('tx_comments_pi1'))
		$params['markers']['###ADDITIONAL_CONTENT###'] = '';
		$infosPage = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'tx_pnfextendcomments_commentsclosed,tx_pnfextendcomments_comments',
			'pages',
			'uid = '.$GLOBALS['TSFE']->id
		);

		if($infosPage) {
			//echo t3lib_div::view_array($infosPage[0]['tx_pnfextendcomments_commentsclosed']);
			//if($infosPage[0]['tx_rrmpagesdata_commentsclosed'] == 1)
			if($infosPage[0]['tx_pnfextendcomments_commentsclosed'] == 1)
				$add = $object->cObj->cObjGetSingle($object->conf['addtional_closed'], $object->conf['additional_closed.']);
			else
				$add = $object->cObj->cObjGetSingle($object->conf['additional'], $object->conf['additional.']);
			
			$params['markers']['###ADDITIONAL_CONTENT###'] = $add;
				
		}
		
		if($params['pObj']->formValidationErrors || $params['pObj']->formTopMessage)
			$params['markers']['###VIEW_FORM###'] = 'style="display:block;"';
		else
			$params['markers']['###VIEW_FORM###'] = 'style="display:none;"';
		return $params['markers'];
	}
	
	function additionalParams($params, $object) {
		if($params['pObj']->conf['extraQueryString'])
			$params['additionalParameters'] .= $params['pObj']->conf['extraQueryString'];
		return $params['additionalParameters'];
	}
	
	function closeComments($params,$object){
		$infosPage = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'tx_pnfextendcomments_commentsclosed',
			'pages',
			'uid = '.$GLOBALS['TSFE']->id
		);
		if(($infosPage) && ($infosPage[0]['tx_pnfextendcomments_commentsclosed'] == 1)){
			return 0;
		}
		else{
			return false;
		}
	}
}
?>