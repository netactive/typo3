<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2005 Kasper Skaarhoj (kasperYYYY@typo3.com)
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Top logo frame
 * Displays the logo in the top frame (upper left corner)
 *
 * $Id: alt_toplogo.php 593 2005-04-01 14:37:15Z kasper $
 * Revised for TYPO3 3.6 2/2003 by Kasper Skaarhoj
 * XHTML compliant content
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   66: class SC_alt_toplogo
 *   74:     function main()
 *  105:     function printContent()
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */



require ('init.php');
require ('template.php');




/**
 * Script Class for rendering of the logo frame content in upper left corner of the TYPO3 backend frameset
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @package TYPO3
 * @subpackage core
 */
class SC_alt_toplogo {
	var $content;

	/**
	 * Create content with the logo
	 *
	 * @return	void
	 */
	function main()	{
		global $TBE_TEMPLATE,$TBE_STYLES;

			// Start page
		$TBE_TEMPLATE->docType = 'xhtml_trans';

		$this->content.=$TBE_TEMPLATE->startPage('Logo frame');

			// Set logo:
		if ($TBE_STYLES['logo'])	{
			if (substr($TBE_STYLES['logo'],0,3)=='../')	{
				$imgInfo = @getimagesize(PATH_site.substr($TBE_STYLES['logo'],3));
			}
			$this->content.='<a href="http://www.typo3.com/" target="_blank" onclick="'.$TBE_TEMPLATE->thisBlur().'">'.
				'<img src="'.$TBE_STYLES['logo'].'" '.$imgInfo[3].' title="TYPO3 Content Management Framework" alt="" />'.
				'</a>';
		} else {
			$this->content.='<a href="http://www.typo3.com/" target="_blank" onclick="'.$TBE_TEMPLATE->thisBlur().'">'.
				'<img'.t3lib_iconWorks::skinImg('','gfx/alt_backend_logo.gif','width="117" height="32"').' title="TYPO3 Content Management Framework" alt="" />'.
				'</a>';
		}

			// End page:
		$this->content.=$TBE_TEMPLATE->endPage();
	}

	/**
	 * Outputting the accumulated content to screen
	 *
	 * @return	void
	 */
	function printContent()	{
		echo $this->content;
	}
}

// Include extension?
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3/alt_toplogo.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3/alt_toplogo.php']);
}












// Make instance:
$SOBE = t3lib_div::makeInstance('SC_alt_toplogo');
$SOBE->main();
$SOBE->printContent();
?>
