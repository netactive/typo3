<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2010 Steffen Kamper <steffen@typo3.org>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class to handle debug
 *
 * $Id: $
 *
 *
 * @author	 Steffen Kamper <steffen@typo3.org>
 * @package TYPO3
 * @subpackage t3lib
 */
class t3lib_utility_Debug {

	/**
	 * Template for debug output
	 *
	 * @var string
	 */
	const DEBUG_TABLE_TEMPLATE = '
	<table class="typo3-debug" border="0" cellpadding="0" cellspacing="0" bgcolor="white" style="border:0px; margin-top:3px; margin-bottom:3px;">
		<tr>
			<td style="background-color:#bbbbbb; font-family: verdana,arial; font-weight: bold; font-size: 10px;">%s</td>
		</tr>
		<tr>
			<td>
			%s
			</td>
		</tr>
	</table>
	';


	public function debug($var = '', $header = '', $group = 'Debug') {
		// buffer the output of debug if no buffering started before
		if (ob_get_level() == 0) {
			ob_start();
		}
		$debug = '';

		if (is_array($var)) {
			$debug .= self::viewArray($var);
		} elseif (is_object($var)) {
			$debug .= '<strong>|Object:<pre>';
			$debug .= print_r($var, TRUE);
			$debug .= '</pre>|</strong>';
		} elseif ((string) $var !== '') {
			$debug .= '<strong>|' . htmlspecialchars((string) $var) . '|</strong>';
		} else {
			$debug .= '<strong>| debug |</strong>';
		}

		if ($header) {
			$debug = sprintf(self::DEBUG_TABLE_TEMPLATE, htmlspecialchars((string) $header), $debug);
		}

		if (TYPO3_MODE === 'BE') {
			$group = htmlspecialchars($group);

			if ($header !== '') {
				$tabHeader = htmlspecialchars($header);
			} else {
				$tabHeader = 'Debug';
			}

			if (is_object($var)) {
				$debug = str_replace(array (
					'"', '/', '<', "\n", "\r"
				), array (
					'\"', '\/', '\<', '<br />', ''
				), $debug);
			} else {
				$debug = str_replace(array (
					'"', '/', '<', "\n", "\r"
				), array (
					'\"', '\/', '\<', '', ''
				), $debug);
			}

			$script = '
				(function debug() {
					var debugMessage = "' . $debug . '";
					var header = "' . $tabHeader . '";
					var group = "' . $group . '";

					if (typeof Ext !== "object" && (top && typeof top.Ext !== "object")) {
						document.write(debugMessage);
						return;
					}

					if (top && typeof Ext !== "object") {
						Ext = top.Ext;
					}

					Ext.onReady(function() {
						var TYPO3ViewportInstance = null;

						if (top && top.TYPO3 && typeof top.TYPO3.Backend === "object") {
							TYPO3ViewportInstance = top.TYPO3.Backend;
						} else if (typeof TYPO3 === "object" && typeof TYPO3.Backend === "object") {
							TYPO3ViewportInstance = TYPO3.Backend;
						}

						if (TYPO3ViewportInstance !== null) {
							TYPO3ViewportInstance.DebugConsole.addTab(debugMessage, header, group);
						} else {
							document.write(debugMessage);
						}
					});
				})();
			';
			echo t3lib_div::wrapJS($script);
		} else {
			echo $debug;
		}
	}

	/**
	 * Displays the "path" of the function call stack in a string, using debug_backtrace
	 *
	 * @return	string
	 */
	public function debugTrail() {
		$trail = debug_backtrace();
		$trail = array_reverse($trail);
		array_pop($trail);

		$path = array ();
		foreach ($trail as $dat) {
			$path[] = $dat['class'] . $dat['type'] . $dat['function'] . '#' . $dat['line'];
		}

		return implode(' // ', $path);
	}

	/**
	 * Displays an array as rows in a table. Useful to debug output like an array of database records.
	 *
	 * @param	mixed		Array of arrays with similar keys
	 * @param	string		Table header
	 * @param	boolean		If TRUE, will return content instead of echo'ing out.
	 * @return	void		Outputs to browser.
	 */
	public function debugRows($rows, $header = '', $returnHTML = FALSE) {
		if (is_array($rows)) {
			reset($rows);
			$firstEl = current($rows);
			if (is_array($firstEl)) {
				$headerColumns = array_keys($firstEl);
				$tRows = array ();

				// Header:
				$tRows[] = '<tr><td colspan="' . count($headerColumns) .
					'" style="background-color:#bbbbbb; font-family: verdana,arial; font-weight: bold; font-size: 10px;"><strong>' .
					htmlspecialchars($header) . '</strong></td></tr>';
				$tCells = array ();
				foreach ($headerColumns as $key) {
					$tCells[] = '
							<td><font face="Verdana,Arial" size="1"><strong>' . htmlspecialchars($key) . '</strong></font></td>';
				}
				$tRows[] = '
						<tr>' . implode('', $tCells) . '
						</tr>';

				// Rows:
				foreach ($rows as $singleRow) {
					$tCells = array ();
					foreach ($headerColumns as $key) {
						$tCells[] = '
							<td><font face="Verdana,Arial" size="1">' .
							(is_array($singleRow[$key]) ? self::debugRows($singleRow[$key], '', TRUE) : htmlspecialchars($singleRow[$key])) .
							'</font></td>';
					}
					$tRows[] = '
						<tr>' . implode('', $tCells) . '
						</tr>';
				}

				$table = '
					<table border="1" cellpadding="1" cellspacing="0" bgcolor="white">' . implode('', $tRows) . '
					</table>';
				if ($returnHTML)
					return $table;
				else
					echo $table;
			} else
				debug('Empty array of rows', $header);
		} else {
			debug('No array of rows', $header);
		}
	}

	/**
	 * Returns a string with a list of ascii-values for the first $characters characters in $string
	 *
	 * @param	string		String to show ASCII value for
	 * @param	integer		Number of characters to show
	 * @return	string		The string with ASCII values in separated by a space char.
	 * @deprecated since TYPO3 4.5 - Use t3lib_utility_Debug::debug_ordvalue instead
	 */
	public function ordinalValue($string, $characters = 100) {
		if (strlen($string) < $characters)
			$characters = strlen($string);
		for ($i = 0; $i < $characters; $i++) {
			$valuestring .= ' ' . ord(substr($string, $i, 1));
		}
		return trim($valuestring);
	}

	/**
	 * Returns HTML-code, which is a visual representation of a multidimensional array
	 * use t3lib_div::print_array() in order to print an array
	 * Returns false if $array_in is not an array
	 *
	 * @param	mixed		Array to view
	 * @return	string		HTML output
	 */
	public function viewArray($array_in) {
		if (is_array($array_in)) {
			$result = '
			<table border="1" cellpadding="1" cellspacing="0" bgcolor="white">';
			if (count($array_in) == 0) {
				$result .= '<tr><td><font face="Verdana,Arial" size="1"><strong>EMPTY!</strong></font></td></tr>';
			} else {
				foreach ($array_in as $key => $val) {
					$result .= '<tr>
						<td valign="top"><font face="Verdana,Arial" size="1">' . htmlspecialchars((string) $key) . '</font></td>
						<td>';
					if (is_array($val)) {
						$result .= self::viewArray($val);
					} elseif (is_object($val)) {
						$string = '';
						if (method_exists($val, '__toString')) {
							$string .= get_class($val) . ': ' . (string) $val;
						} else {
							$string .= print_r($val, TRUE);
						}
						$result .= '<font face="Verdana,Arial" size="1" color="red">' .
							nl2br(htmlspecialchars($string)) .
							'<br /></font>';
					} else {
						if (gettype($val) == 'object') {
							$string = 'Unknown object';
						} else {
							$string = (string) $val;
						}
						$result .= '<font face="Verdana,Arial" size="1" color="red">' .
							nl2br(htmlspecialchars($string)) .
							'<br /></font>';
					}
					$result .= '</td>
					</tr>';
				}
			}
			$result .= '</table>';
		} else {
			$result = '<table border="1" cellpadding="1" cellspacing="0" bgcolor="white">
				<tr>
					<td><font face="Verdana,Arial" size="1" color="red">' .
					nl2br(htmlspecialchars((string) $array_in)) .
					'<br /></font></td>
				</tr>
			</table>'; // Output it as a string.
		}
		return $result;
	}

	/**
	 * Prints an array
	 *
	 * @param	mixed		Array to print visually (in a table).
	 * @return	void
	 * @see view_array()
	 */
	public function printArray($array_in) {
		echo self::viewArray($array_in);
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['t3lib/utility/class.t3lib_utility_debug.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['t3lib/utility/class.t3lib_utility_debug.php']);
}
?>