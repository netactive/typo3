<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Stefan Galinski <stefan.galinski@gmail.com>
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
 * Ext Direct Debug
 *
 * @author	Stefan Galinski <stefan.galinski@gmail.com>
 * @package	TYPO3
 */
final class t3lib_extjs_ExtDirectDebug {
	/**
	 * Internal debug message array
	 *
	 * @var array
	 */
	protected static $debugMessages = array();

	/**
	 * Adds a new message of any data type to the internal debug message array.
	 *
	 * @param mixed $message
	 * @return void
	 */
	public static function debug($message) {
		self::$debugMessages[] = $message;
	}

	/**
	 * Returns the internal debug messages as a string.
	 *
	 * @return string
	 */
	public static function toString() {
		$messagesAsString = '';
		if (count(self::$debugMessages)) {
			$messagesAsString = t3lib_utility_Debug::viewArray(self::$debugMessages);
		}

		return $messagesAsString;
	}
}

?>