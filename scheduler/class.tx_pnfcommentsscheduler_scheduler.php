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

class tx_pnfcommentsscheduler_scheduler extends tx_scheduler_Task {

	/**
	 * Function executed from scheduler.
	 * Send the newsletter
	 * 
	 * @return	void
	 */
	function execute() {
		global $LANG;
		$helper = new tx_pnfcommentsscheduler_helper();
		
		return $helper->sendAlert();
		
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pnf_extend_comments/scheduler/class.tx_pnfcommentsscheduler_scheduler.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pnf_extend_comments/scheduler/class.tx_pnfcommentsscheduler_scheduler.php']);
}

?>