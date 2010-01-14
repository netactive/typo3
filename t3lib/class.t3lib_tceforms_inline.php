<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Oliver Hader <oh@inpublica.de>
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
 * The Inline-Relational-Record-Editing (IRRE) functions as part of the TCEforms.
 *
 * $Id: class.t3lib_tceforms_inline.php 3605 2008-04-22 15:26:07Z ohader $
 *
 * @author	Oliver Hader <oh@inpublica.de>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   88: class t3lib_TCEforms_inline
 *  109:     function init(&$tceForms)
 *  127:     function getSingleField_typeInline($table,$field,$row,&$PA)
 *
 *              SECTION: Regular rendering of forms, fields, etc.
 *  263:     function renderForeignRecord($parentUid, $rec, $config = array())
 *  319:     function renderForeignRecordHeader($parentUid, $foreign_table,$rec,$config = array())
 *  375:     function renderForeignRecordHeaderControl($table,$row,$config = array())
 *  506:     function renderCombinationTable(&$rec, $appendFormFieldNames, $config = array())
 *  560:     function renderPossibleRecordsSelector($selItems, $conf, $uniqueIds=array())
 *  627:     function addJavaScript()
 *  643:     function addJavaScriptSortable($objectId)
 *
 *              SECTION: Handling of AJAX calls
 *  665:     function createNewRecord($domObjectId, $foreignUid = 0)
 *  755:     function getJSON($jsonArray)
 *  770:     function getNewRecordLink($objectPrefix, $conf = array())
 *
 *              SECTION: Get data from database and handle relations
 *  807:     function getRelatedRecords($table,$field,$row,&$PA,$config)
 *  839:     function getPossibleRecords($table,$field,$row,$conf,$checkForConfField='foreign_selector')
 *  885:     function getUniqueIds($records, $conf=array())
 *  905:     function getRecord($pid, $table, $uid, $cmd='')
 *  929:     function getNewRecord($pid, $table)
 *
 *              SECTION: Structure stack for handling inline objects/levels
 *  951:     function pushStructure($table, $uid, $field = '', $config = array())
 *  967:     function popStructure()
 *  984:     function updateStructureNames()
 * 1000:     function getStructureItemName($levelData)
 * 1015:     function getStructureLevel($level)
 * 1032:     function getStructurePath($structureDepth = -1)
 * 1057:     function parseStructureString($string, $loadConfig = false)
 *
 *              SECTION: Helper functions
 * 1098:     function checkConfiguration(&$config)
 * 1123:     function checkAccess($cmd, $table, $theUid)
 * 1185:     function compareStructureConfiguration($compare)
 * 1199:     function normalizeUid($string)
 * 1213:     function wrapFormsSection($section, $styleAttrs = array(), $tableAttrs = array())
 * 1242:     function isInlineChildAndLabelField($table, $field)
 * 1258:     function getStructureDepth()
 * 1295:     function arrayCompareComplex($subjectArray, $searchArray, $type = '')
 * 1349:     function isAssociativeArray($object)
 * 1364:     function getPossibleRecordsFlat($possibleRecords)
 * 1383:     function skipField($table, $field, $row, $config)
 *
 * TOTAL FUNCTIONS: 35
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

require_once(PATH_t3lib.'class.t3lib_parsehtml.php');

class t3lib_TCEforms_inline {
	var $fObj;								// Reference to the calling TCEforms instance
	var $backPath;							// Reference to $fObj->backPath

	var $isAjaxCall = false;				// Indicates if a field is rendered upon an AJAX call
	var $inlineStructure = array();			// the structure/hierarchy where working in, e.g. cascading inline tables
	var $inlineFirstPid;					// the first call of an inline type appeared on this page (pid of record)
	var $inlineNames = array();				// keys: form, object -> hold the name/id for each of them
	var $inlineData = array();				// inline data array used for JSON output
	var $inlineView = array();				// expanded/collapsed states for the current BE user
	var $inlineCount = 0;					// count the number of inline types used
	var $inlineStyles = array();

	var $prependNaming = 'data';			// how the $this->fObj->prependFormFieldNames should be set ('data' is default)
	var $prependFormFieldNames;				// reference to $this->fObj->prependFormFieldNames
	var $prependCmdFieldNames;				// reference to $this->fObj->prependCmdFieldNames


	/**
	 * Intialize an instance of t3lib_TCEforms_inline
	 *
	 * @param	object		$tceForms: Reference to an TCEforms instance
	 * @return	void
	 */
	function init(&$tceForms) {
		$this->fObj =& $tceForms;
		$this->backPath =& $tceForms->backPath;
		$this->prependFormFieldNames =& $this->fObj->prependFormFieldNames;
		$this->prependCmdFieldNames =& $this->fObj->prependCmdFieldNames;
		$this->inlineStyles['margin-right'] = '5';
	}


	/**
	 * Generation of TCEform elements of the type "inline"
	 * This will render inline-relational-record sets. Relations.
	 *
	 * @param	string		$table: The table name of the record
	 * @param	string		$field: The field name which this element is supposed to edit
	 * @param	array		$row: The record data array where the value(s) for the field can be found
	 * @param	array		$PA: An array with additional configuration options.
	 * @return	string		The HTML code for the TCEform field
	 */
	function getSingleField_typeInline($table,$field,$row,&$PA) {
			// check the TCA configuration - if false is returned, something was wrong
		if ($this->checkConfiguration($PA['fieldConf']['config']) === false) return false;

			// count the number of processed inline elements
		$this->inlineCount++;

			// Init:
		$config = $PA['fieldConf']['config'];
		$foreign_table = $config['foreign_table'];
		t3lib_div::loadTCA($foreign_table);

		$minitems = t3lib_div::intInRange($config['minitems'],0);
		$maxitems = t3lib_div::intInRange($config['maxitems'],0);
		if (!$maxitems)	$maxitems=100000;

			// Register the required number of elements:
		$this->fObj->requiredElements[$PA['itemFormElName']] = array($minitems,$maxitems,'imgName'=>$table.'_'.$row['uid'].'_'.$field);

			// remember the page id (pid of record) where inline editing started first
			// we need that pid for ajax calls, so that they would know where the action takes place on the page structure
		if (!isset($this->inlineFirstPid)) {
				// if this record is not new, try to fetch the inlineView states
				// @TODO: Add checking/cleaning for unused tables, records, etc. to save space in uc-field
			if (t3lib_div::testInt($row['uid'])) {
				$inlineView = unserialize($GLOBALS['BE_USER']->uc['inlineView']);
				$this->inlineView = $inlineView[$table][$row['uid']];
			}
				// If the parent is a page, use the uid(!) of the (new?) page as pid for the child records:
			if ($table == 'pages') {
				$this->inlineFirstPid = $row['uid'];
				// If pid is negative, fetch the previous record and take its pid:
			} elseif ($row['pid'] < 0) {
				$prevRec = t3lib_BEfunc::getRecord($table, abs($row['pid']));
				$this->inlineFirstPid = $prevRec['pid'];
				// Take the pid as it is:
			} else {
				$this->inlineFirstPid = $row['pid'];
			}
		}
			// add the current inline job to the structure stack
		$this->pushStructure($table, $row['uid'], $field, $config);
			// e.g. inline[<table>][<uid>][<field>]
		$nameForm = $this->inlineNames['form'];
			// e.g. inline[<pid>][<table1>][<uid1>][<field1>][<table2>][<uid2>][<field2>]
		$nameObject = $this->inlineNames['object'];
			// get the records related to this inline record
		$recordList = $this->getRelatedRecords($table,$field,$row,$PA,$config);
			// set the first and last record to the config array
		$config['inline']['first'] = $recordList[0]['uid'];
		$config['inline']['last'] = $recordList[count($recordList)-1]['uid'];

			// Tell the browser what we have (using JSON later):
		$top = $this->getStructureLevel(0);
		$this->inlineData['config'][$nameObject] = array(
			'table' => $foreign_table,
			'md5' => md5($nameObject),
		);
		$this->inlineData['config'][$nameObject.'['.$foreign_table.']'] = array(
			'min' => $minitems,
			'max' => $maxitems,
			'sortable' => $config['appearance']['useSortable'],
			'top' => array(
				'table' => $top['table'],
				'uid'	=> $top['uid'],
			),
		);
			// Set a hint for nested IRRE and tab elements:
		$this->inlineData['nested'][$nameObject] = $this->fObj->getDynNestedStack(false, $this->isAjaxCall);

			// if relations are required to be unique, get the uids that have already been used on the foreign side of the relation
		if ($config['foreign_unique']) {
				// If uniqueness *and* selector are set, they should point to the same field - so, get the configuration of one:
			$selConfig = $this->getPossibleRecordsSelectorConfig($config, $config['foreign_unique']);
				// Get the used unique ids:
			$uniqueIds = $this->getUniqueIds($recordList, $config, $selConfig['type']=='groupdb');
			$possibleRecords = $this->getPossibleRecords($table,$field,$row,$config,'foreign_unique');
			$uniqueMax = $config['appearance']['useCombination'] || $possibleRecords === false ? -1	: count($possibleRecords);
			$this->inlineData['unique'][$nameObject.'['.$foreign_table.']'] = array(
				'max' => $uniqueMax,
				'used' => $uniqueIds,
				'type' => $selConfig['type'],
				'table' => $config['foreign_table'],
				'elTable' => $selConfig['table'], // element/record table (one step down in hierarchy)
				'field' => $config['foreign_unique'],
				'selector' => $selConfig['selector'],
				'possible' => $this->getPossibleRecordsFlat($possibleRecords),
			);
		}

			// if it's required to select from possible child records (reusable children), add a selector box
		if ($config['foreign_selector']) {
				// if not already set by the foreign_unique, set the possibleRecords here and the uniqueIds to an empty array
			if (!$config['foreign_unique']) {
				$possibleRecords = $this->getPossibleRecords($table,$field,$row,$config);
				$uniqueIds = array();
			}
			$selectorBox = $this->renderPossibleRecordsSelector($possibleRecords,$config,$uniqueIds);
			$item .= $selectorBox;
		}

			// wrap all inline fields of a record with a <div> (like a container)
		$item .= '<div id="'.$nameObject.'">';

			// define how to show the "Create new record" link - if there are more than maxitems, hide it
		if (count($recordList) >= $maxitems || ($uniqueMax > 0 && count($recordList) >= $uniqueMax)) {
			$config['inline']['inlineNewButtonStyle'] = 'display: none;';
		}
			// add the "Create new record" link before all child records
		if (in_array($config['appearance']['newRecordLinkPosition'], array('both', 'top'))) {
			$item .= $this->getNewRecordLink($nameObject.'['.$foreign_table.']', $config);
		}

		$item .= '<div id="'.$nameObject.'_records">';
		$relationList = array();
		if (count($recordList)) {
			foreach ($recordList as $rec) {
				$item .= $this->renderForeignRecord($row['uid'],$rec,$config);
				$relationList[] = $rec['uid'];
			}
		}
		$item .= '</div>';

			// add the "Create new record" link after all child records
		if (in_array($config['appearance']['newRecordLinkPosition'], array('both', 'bottom'))) {
			$item .= $this->getNewRecordLink($nameObject.'['.$foreign_table.']', $config);
		}

			// add Drag&Drop functions for sorting to TCEforms::$additionalJS_post
		if (count($relationList) > 1 && $config['appearance']['useSortable'])
			$this->addJavaScriptSortable($nameObject.'_records');
			// publish the uids of the child records in the given order to the browser
		$item .= '<input type="hidden" name="'.$nameForm.'" value="'.implode(',', $relationList).'" class="inlineRecord" />';
			// close the wrap for all inline fields (container)
		$item .= '</div>';

			// on finishing this section, remove the last item from the structure stack
		$this->popStructure();

			// if this was the first call to the inline type, restore the values
		if (!$this->getStructureDepth()) {
			unset($this->inlineFirstPid);
		}

		return $item;
	}


	/*******************************************************
	 *
	 * Regular rendering of forms, fields, etc.
	 *
	 *******************************************************/


	/**
	 * Render the form-fields of a related (foreign) record.
	 *
	 * @param	string		$parentUid: The uid of the parent (embedding) record (uid or NEW...)
	 * @param	array		$rec: The table record of the child/embedded table (normaly post-processed by t3lib_transferData)
	 * @param	array		$config: content of $PA['fieldConf']['config']
	 * @return	string		The HTML code for this "foreign record"
	 */
	function renderForeignRecord($parentUid, $rec, $config = array()) {
		$foreign_table = $config['foreign_table'];
		$foreign_field = $config['foreign_field'];
		$foreign_selector = $config['foreign_selector'];

			// Send a mapping information to the browser via JSON:
			// e.g. data[<curTable>][<curId>][<curField>] => data[<pid>][<parentTable>][<parentId>][<parentField>][<curTable>][<curId>][<curField>]
		$this->inlineData['map'][$this->inlineNames['form']] = $this->inlineNames['object'];

			// Set this variable if we handle a brand new unsaved record:
		$isNewRecord = t3lib_div::testInt($rec['uid']) ? false : true;
			// If there is a selector field, normalize it:
		if ($foreign_selector) {
			$rec[$foreign_selector] = $this->normalizeUid($rec[$foreign_selector]);
		}

		$hasAccess = $this->checkAccess($isNewRecord?'new':'edit', $foreign_table, $rec['uid']);

		if(!$hasAccess) return false;

			// Get the current naming scheme for DOM name/id attributes:
		$nameObject = $this->inlineNames['object'];
		$appendFormFieldNames = '['.$foreign_table.']['.$rec['uid'].']';
		$formFieldNames = $nameObject.$appendFormFieldNames;
			// Put the current level also to the dynNestedStack of TCEforms:
		$this->fObj->pushToDynNestedStack('inline', $this->inlineNames['object'].$appendFormFieldNames);

		$header = $this->renderForeignRecordHeader($parentUid, $foreign_table, $rec, $config);
		$combination = $this->renderCombinationTable($rec, $appendFormFieldNames, $config);
		$fields = $this->renderMainFields($foreign_table, $rec);
		$fields = $this->wrapFormsSection($fields);
			// Get configuration:
		$collapseAll = (isset($config['appearance']['collapseAll']) && $config['appearance']['collapseAll']);

		if ($isNewRecord) {
				// show this record expanded or collapsed
			$isExpanded = (!$collapseAll ? 1 : 0);
				// get the top parent table
			$top = $this->getStructureLevel(0);
			$ucFieldName = 'uc[inlineView]['.$top['table'].']['.$top['uid'].']'.$appendFormFieldNames;
				// set additional fields for processing for saving
			$fields .= '<input type="hidden" name="'.$this->prependFormFieldNames.$appendFormFieldNames.'[pid]" value="'.$rec['pid'].'"/>';
			$fields .= '<input type="hidden" name="'.$ucFieldName.'" value="'.$isExpanded.'" />';
		} else {
				// show this record expanded or collapsed
			$isExpanded = (!$collapseAll && $this->getExpandedCollapsedState($foreign_table, $rec['uid']));
				// set additional field for processing for saving
			$fields .= '<input type="hidden" name="'.$this->prependCmdFieldNames.$appendFormFieldNames.'[delete]" value="1" disabled="disabled" />';
		}

			// if this record should be shown collapsed
		if (!$isExpanded) {
			$appearanceStyleFields = ' style="display: none;"';
		}

			// set the record container with data for output
		$out = '<div id="'.$formFieldNames.'_header">'.$header.'</div>';
		$out .= '<div id="'.$formFieldNames.'_fields"'.$appearanceStyleFields.'>'.$fields.$combination.'</div>';
			// wrap the header, fields and combination part of a child record with a div container
		$class = 'inlineDiv'.($this->fObj->clientInfo['BROWSER']=='msie' ? 'MSIE' : '').($isNewRecord ? ' inlineIsNewRecord' : '');
		$out = '<div id="'.$formFieldNames.'_div" class="'.$class.'">' . $out . '</div>';

			// Remove the current level also from the dynNestedStack of TCEforms:
		$this->fObj->popFromDynNestedStack();

		return $out;
	}


	/**
	 * Wrapper for TCEforms::getMainFields().
	 *
	 * @param	string		$table: The table name
	 * @param	array		$row: The record to be rendered
	 * @return	string		The rendered form
	 */
	function renderMainFields($table, $row) {
			// The current render depth of t3lib_TCEforms:
		$depth = $this->fObj->renderDepth;
			// If there is some information about already rendered palettes of our parent, store this info:
		if (isset($this->fObj->palettesRendered[$depth][$table])) {
			$palettesRendered = $this->fObj->palettesRendered[$depth][$table];
		}
			// Render the form:
		$content = $this->fObj->getMainFields($table, $row, $depth);
			// If there was some info about rendered palettes stored, write it back for our parent:
		if (isset($palettesRendered)) {
			$this->fObj->palettesRendered[$depth][$table] = $palettesRendered;
		}
		return $content;
	}


	/**
	 * Renders the HTML header for a foreign record, such as the title, toggle-function, drag'n'drop, etc.
	 * Later on the command-icons are inserted here.
	 *
	 * @param	string		$parentUid: The uid of the parent (embedding) record (uid or NEW...)
	 * @param	string		$foreign_table: The foreign_table we create a header for
	 * @param	array		$rec: The current record of that foreign_table
	 * @param	array		$config: content of $PA['fieldConf']['config']
	 * @return	string		The HTML code of the header
	 */
	function renderForeignRecordHeader($parentUid, $foreign_table, $rec, $config = array()) {
			// Init:
		$formFieldNames = $this->inlineNames['object'].'['.$foreign_table.']['.$rec['uid'].']';
		$expandSingle = $config['appearance']['expandSingle'] ? 1 : 0;
		$onClick = "return inline.expandCollapseRecord('".htmlspecialchars($formFieldNames)."', $expandSingle)";

			// Pre-Processing:
		$isOnSymmetricSide = t3lib_loadDBGroup::isOnSymmetricSide($parentUid, $config, $rec);
		$hasForeignLabel = !$isOnSymmetricSide && $config['foreign_label'] ? true : false;
		$hasSymmetricLabel = $isOnSymmetricSide && $config['symmetric_label'] ? true : false;
			// Get the record title/label for a record:
			// render using a self-defined user function
		if ($GLOBALS['TCA'][$foreign_table]['ctrl']['label_userFunc']) {
			$params = array(
				'table' => $foreign_table,
				'row'	=> $rec,
				'title'	=> '',
				'isOnSymmetricSide' => $isOnSymmetricSide
			);
			$null = null;	// callUserFunction requires a third parameter, but we don't want to give $this as reference!
			t3lib_div::callUserFunction($GLOBALS['TCA'][$foreign_table]['ctrl']['label_userFunc'], $params, $null);
			$recTitle = $params['title'];
			// render the special alternative title
		} elseif ($hasForeignLabel || $hasSymmetricLabel) {
			$titleCol = $hasForeignLabel ? $config['foreign_label'] : $config['symmetric_label'];
			$foreignConfig = $this->getPossibleRecordsSelectorConfig($config, $titleCol);
				// Render title for everything else than group/db:
			if ($foreignConfig['type'] != 'groupdb') {
				$recTitle = t3lib_BEfunc::getProcessedValueExtra($foreign_table, $titleCol, $rec[$titleCol], 0, 0, false);
				// Render title for group/db:
			} else {
					// $recTitle could be something like: "tx_table_123|...",
				$valueParts = t3lib_div::trimExplode('|', $rec[$titleCol]);
				$itemParts = t3lib_div::revExplode('_', $valueParts[0], 2);
				$recTemp = t3lib_befunc::getRecordWSOL($itemParts[0], $itemParts[1]);
				$recTitle = t3lib_BEfunc::getRecordTitle($itemParts[0], $recTemp, true);
			}
			$recTitle = t3lib_BEfunc::getRecordTitlePrep($recTitle);
			if (!strcmp(trim($recTitle),'')) {
				$recTitle = t3lib_BEfunc::getNoRecordTitle(true);
			}
			// render the standard
		} else {
			$recTitle = t3lib_BEfunc::getRecordTitle($foreign_table, $rec, true);
		}

		$altText = t3lib_BEfunc::getRecordIconAltText($rec, $foreign_table);
		$iconImg =
			'<a href="#" onclick="'.htmlspecialchars($onClick).'">'.t3lib_iconWorks::getIconImage(
				$foreign_table, $rec, $this->backPath,
				'title="'.htmlspecialchars($altText).'" class="absmiddle"'
			).'</a>';

		$label =
			'<a href="#" onclick="'.htmlspecialchars($onClick).'" style="display: block;">'.
				'<span id="'.$formFieldNames.'_label">'.$recTitle.'</span>'.
			'</a>';

		$ctrl = $this->renderForeignRecordHeaderControl($parentUid, $foreign_table, $rec, $config);

			// @TODO: Check the table wrapping and the CSS definitions
		$header =
			'<table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-right: '.$this->inlineStyles['margin-right'].'px;"'.
			($this->fObj->borderStyle[2] ? ' background="'.htmlspecialchars($this->backPath.$this->fObj->borderStyle[2]).'"':'').
			($this->fObj->borderStyle[3] ? ' class="'.htmlspecialchars($this->fObj->borderStyle[3]).'"':'').'>' .
			'<tr class="class-main12"><td width="18">'.$iconImg.'</td><td align="left"><b>'.$label.'</b></td><td align="right">'.$ctrl.'</td></tr></table>';

		return $header;
	}


	/**
	 * Render the control-icons for a record header (create new, sorting, delete, disable/enable).
	 * Most of the parts are copy&paste from class.db_list_extra.inc and modified for the JavaScript calls here
	 *
	 * @param	string		$parentUid: The uid of the parent (embedding) record (uid or NEW...)
	 * @param	string		$foreign_table: The table (foreign_table) we create control-icons for
	 * @param	array		$rec: The current record of that foreign_table
	 * @param	array		$config: (modified) TCA configuration of the field
	 * @return	string		The HTML code with the control-icons
	 */
	function renderForeignRecordHeaderControl($parentUid, $foreign_table, $rec, $config = array()) {
			// Initialize:
		$cells=array();
		$isNewItem = substr($rec['uid'], 0, 3) == 'NEW';

		$tcaTableCtrl =& $GLOBALS['TCA'][$foreign_table]['ctrl'];
		$tcaTableCols =& $GLOBALS['TCA'][$foreign_table]['columns'];

		$isPagesTable = $foreign_table == 'pages' ? true : false;
		$isOnSymmetricSide = t3lib_loadDBGroup::isOnSymmetricSide($parentUid, $config, $rec);
		$enableManualSorting = $tcaTableCtrl['sortby'] || $config['MM'] || (!$isOnSymmetricSide && $config['foreign_sortby']) || ($isOnSymmetricSide && $config['symmetric_sortby']) ? true : false;

		$nameObject = $this->inlineNames['object'];
		$nameObjectFt = $nameObject.'['.$foreign_table.']';
		$nameObjectFtId = $nameObjectFt.'['.$rec['uid'].']';

		$calcPerms = $GLOBALS['BE_USER']->calcPerms(
			t3lib_BEfunc::readPageAccess($rec['pid'], $GLOBALS['BE_USER']->getPagePermsClause(1))
		);

			// If the listed table is 'pages' we have to request the permission settings for each page:
		if ($isPagesTable)	{
			$localCalcPerms = $GLOBALS['BE_USER']->calcPerms(t3lib_BEfunc::getRecord('pages',$rec['uid']));
		}

			// This expresses the edit permissions for this particular element:
		$permsEdit = ($isPagesTable && ($localCalcPerms&2)) || (!$isPagesTable && ($calcPerms&16));

			// "Info": (All records)
		if (!$isNewItem)
			$cells[]='<a href="#" onclick="'.htmlspecialchars('top.launchView(\''.$foreign_table.'\', \''.$rec['uid'].'\'); return false;').'">'.
				'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/zoom2.gif','width="12" height="12"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xml:showInfo',1).'" alt="" />'.
				'</a>';

			// If the table is NOT a read-only table, then show these links:
		if (!$tcaTableCtrl['readOnly'])	{

				// "New record after" link (ONLY if the records in the table are sorted by a "sortby"-row or if default values can depend on previous record):
			if ($enableManualSorting || $tcaTableCtrl['useColumnsForDefaultValues'])	{
				if (
					(!$isPagesTable && ($calcPerms&16)) || 	// For NON-pages, must have permission to edit content on this parent page
					($isPagesTable && ($calcPerms&8))		// For pages, must have permission to create new pages here.
					)	{
					$onClick = "return inline.createNewRecord('".$nameObjectFt."','".$rec['uid']."')";
					$class = ' class="inlineNewButton '.$this->inlineData['config'][$nameObject]['md5'].'"';
					if ($config['inline']['inlineNewButtonStyle']) {
						$style = ' style="'.$config['inline']['inlineNewButtonStyle'].'"';
					}
					$cells[]='<a href="#" onclick="'.htmlspecialchars($onClick).'"'.$class.$style.'>'.
							'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/new_'.($isPagesTable?'page':'el').'.gif','width="'.($isPagesTable?13:11).'" height="12"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xml:new'.($isPagesTable?'Page':'Record'),1).'" alt="" />'.
							'</a>';
				}
			}

				// Drag&Drop Sorting: Sortable handler for script.aculo.us
			if ($permsEdit && $enableManualSorting && $config['appearance']['useSortable'])	{
				$cells[] = '<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/move.gif','width="16" height="16" hspace="2"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:labels.move',1).'" alt="" style="cursor: move;" class="sortableHandle" />';
			}

				// "Up/Down" links
			if ($permsEdit && $enableManualSorting)	{
				$onClick = "return inline.changeSorting('".$nameObjectFtId."', '1')";	// Up
				$style = $config['inline']['first'] == $rec['uid'] ? 'style="visibility: hidden;"' : '';
				$cells[]='<a href="#" onclick="'.htmlspecialchars($onClick).'" class="sortingUp" '.$style.'>'.
						'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/button_up.gif','width="11" height="10"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xml:moveUp',1).'" alt="" />'.
						'</a>';

				$onClick = "return inline.changeSorting('".$nameObjectFtId."', '-1')";	// Down
				$style = $config['inline']['last'] == $rec['uid'] ? 'style="visibility: hidden;"' : '';
				$cells[]='<a href="#" onclick="'.htmlspecialchars($onClick).'" class="sortingDown" '.$style.'>'.
						'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/button_down.gif','width="11" height="10"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xml:moveDown',1).'" alt="" />'.
						'</a>';
			}

				// "Hide/Unhide" links:
			$hiddenField = $tcaTableCtrl['enablecolumns']['disabled'];
			if ($permsEdit && $hiddenField && $tcaTableCols[$hiddenField] && (!$tcaTableCols[$hiddenField]['exclude'] || $GLOBALS['BE_USER']->check('non_exclude_fields',$foreign_table.':'.$hiddenField)))	{
				$onClick = "return inline.enableDisableRecord('".$nameObjectFtId."')";
				if ($rec[$hiddenField])	{
					$cells[]='<a href="#" onclick="'.htmlspecialchars($onClick).'">'.
							'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/button_unhide.gif','width="11" height="10"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xml:unHide'.($isPagesTable?'Page':''),1).'" alt="" id="'.$nameObjectFtId.'_disabled" />'.
							'</a>';
				} else {
					$cells[]='<a href="#" onclick="'.htmlspecialchars($onClick).'">'.
							'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/button_hide.gif','width="11" height="10"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xml:hide'.($isPagesTable?'Page':''),1).'" alt="" id="'.$nameObjectFtId.'_disabled" />'.
							'</a>';
				}
			}

				// "Delete" link:
			if (
				($isPagesTable && ($localCalcPerms&4)) || (!$isPagesTable && ($calcPerms&16))
				)	{
				$onClick = "inline.deleteRecord('".$nameObjectFtId."');";
				$cells[]='<a href="#" onclick="'.htmlspecialchars('if (confirm('.$GLOBALS['LANG']->JScharCode($GLOBALS['LANG']->getLL('deleteWarning')).')) {	'.$onClick.' } return false;').'">'.
						'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/garbage.gif','width="11" height="12"').' title="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xml:delete',1).'" alt="" />'.
						'</a>';
			}
		}

			// If the record is edit-locked	by another user, we will show a little warning sign:
		if ($lockInfo=t3lib_BEfunc::isRecordLocked($foreign_table,$rec['uid']))	{
			$cells[]='<a href="#" onclick="'.htmlspecialchars('alert('.$GLOBALS['LANG']->JScharCode($lockInfo['msg']).');return false;').'">'.
					'<img'.t3lib_iconWorks::skinImg('','gfx/recordlock_warning3.gif','width="17" height="12"').' title="'.htmlspecialchars($lockInfo['msg']).'" alt="" />'.
					'</a>';
		}

			// Compile items into a DIV-element:
		return '
											<!-- CONTROL PANEL: '.$foreign_table.':'.$rec['uid'].' -->
											<div class="typo3-DBctrl">'.implode('',$cells).'</div>';
	}


	/**
	 * Render a table with TCEforms, that occurs on a intermediate table but should be editable directly,
	 * so two tables are combined (the intermediate table with attributes and the sub-embedded table).
	 * -> This is a direct embedding over two levels!
	 *
	 * @param	array		$rec: The table record of the child/embedded table (normaly post-processed by t3lib_transferData)
	 * @param	string		$appendFormFieldNames: The [<table>][<uid>] of the parent record (the intermediate table)
	 * @param	array		$config: content of $PA['fieldConf']['config']
	 * @return	string		A HTML string with <table> tag around.
	 */
	function renderCombinationTable(&$rec, $appendFormFieldNames, $config = array()) {
		$foreign_table = $config['foreign_table'];
		$foreign_selector = $config['foreign_selector'];

		if ($foreign_selector && $config['appearance']['useCombination']) {
			$comboConfig = $GLOBALS['TCA'][$foreign_table]['columns'][$foreign_selector]['config'];
			$comboRecord = array();

				// If record does already exist, load it:
			if ($rec[$foreign_selector] && t3lib_div::testInt($rec[$foreign_selector])) {
				$comboRecord = $this->getRecord(
					$this->inlineFirstPid,
					$comboConfig['foreign_table'],
					$rec[$foreign_selector]
				);
				$isNewRecord = false;
				// It is a new record, create a new record virtually:
			} else {
				$comboRecord = $this->getNewRecord(
					$this->inlineFirstPid,
					$comboConfig['foreign_table']
				);
				$isNewRecord = true;
			}

				// get the TCEforms interpretation of the TCA of the child table
			$out = $this->renderMainFields($comboConfig['foreign_table'], $comboRecord);
			$out = $this->wrapFormsSection($out, array(), array('class' => 'wrapperAttention'));

				// if this is a new record, add a pid value to store this record and the pointer value for the intermediate table
			if ($isNewRecord) {
				$comboFormFieldName = $this->prependFormFieldNames.'['.$comboConfig['foreign_table'].']['.$comboRecord['uid'].'][pid]';
				$out .= '<input type="hidden" name="'.$comboFormFieldName.'" value="'.$this->inlineFirstPid.'"/>';
			}

				// if the foreign_selector field is also responsible for uniqueness, tell the browser the uid of the "other" side of the relation
			if ($isNewRecord || $config['foreign_unique'] == $foreign_selector) {
				$parentFormFieldName = $this->prependFormFieldNames.$appendFormFieldNames.'['.$foreign_selector.']';
				$out .= '<input type="hidden" name="'.$parentFormFieldName.'" value="'.$comboRecord['uid'].'" />';
			}
		}

		return $out;
	}


	/**
	 * Get a selector as used for the select type, to select from all available
	 * records and to create a relation to the embedding record (e.g. like MM).
	 *
	 * @param	array		$selItems: Array of all possible records
	 * @param	array		$conf: TCA configuration of the parent(!) field
	 * @param	array		$uniqueIds: The uids that have already been used and should be unique
	 * @return	string		A HTML <select> box with all possible records
	 */
	function renderPossibleRecordsSelector($selItems, $conf, $uniqueIds=array()) {
		$foreign_table = $conf['foreign_table'];
		$foreign_selector = $conf['foreign_selector'];

		$selConfig = $this->getPossibleRecordsSelectorConfig($conf, $foreign_selector);
		$config = $selConfig['PA']['fieldConf']['config'];

		if ($selConfig['type'] == 'select') {
			$item = $this->renderPossibleRecordsSelectorTypeSelect($selItems, $conf, $selConfig['PA'], $uniqueIds);
		} elseif ($selConfig['type'] == 'groupdb') {
			$item = $this->renderPossibleRecordsSelectorTypeGroupDB($conf, $selConfig['PA']);
		}

		return $item;
	}


	/**
	 * Get a selector as used for the select type, to select from all available
	 * records and to create a relation to the embedding record (e.g. like MM).
	 *
	 * @param	array		$selItems: Array of all possible records
	 * @param	array		$conf: TCA configuration of the parent(!) field
	 * @param	array		$PA: An array with additional configuration options
	 * @param	array		$uniqueIds: The uids that have already been used and should be unique
	 * @return	string		A HTML <select> box with all possible records
	 */
	function renderPossibleRecordsSelectorTypeSelect($selItems, $conf, &$PA, $uniqueIds=array()) {
		$foreign_table = $conf['foreign_table'];
		$foreign_selector = $conf['foreign_selector'];

		$PA = array();
		$PA['fieldConf'] = $GLOBALS['TCA'][$foreign_table]['columns'][$foreign_selector];
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['form_type'] ? $PA['fieldConf']['config']['form_type'] : $PA['fieldConf']['config']['type'];	// Using "form_type" locally in this script
		$PA['fieldTSConfig'] = $this->fObj->setTSconfig($foreign_table,array(),$foreign_selector);
		$config = $PA['fieldConf']['config'];

		if(!$disabled) {
				// Create option tags:
			$opt = array();
			$styleAttrValue = '';
			foreach($selItems as $p)	{
				if ($config['iconsInOptionTags'])	{
					$styleAttrValue = $this->fObj->optionTagStyle($p[2]);
				}
				if (!in_array($p[1], $uniqueIds)) {
					$opt[]= '<option value="'.htmlspecialchars($p[1]).'"'.
									' style="'.(in_array($p[1], $uniqueIds) ? '' : '').
									($styleAttrValue ? ' style="'.htmlspecialchars($styleAttrValue) : '').'">'.
									htmlspecialchars($p[0]).'</option>';
				}
			}

				// Put together the selector box:
			$selector_itemListStyle = isset($config['itemListStyle']) ? ' style="'.htmlspecialchars($config['itemListStyle']).'"' : ' style="'.$this->fObj->defaultMultipleSelectorStyle.'"';
			$size = intval($conf['size']);
			$size = $conf['autoSizeMax'] ? t3lib_div::intInRange(count($itemArray)+1,t3lib_div::intInRange($size,1),$conf['autoSizeMax']) : $size;
			$onChange = "return inline.importNewRecord('".$this->inlineNames['object']."[".$conf['foreign_table']."]')";
			$item = '
				<select id="'.$this->inlineNames['object'].'['.$conf['foreign_table'].']_selector"'.
							$this->fObj->insertDefStyle('select').
							($size ? ' size="'.$size.'"' : '').
							' onchange="'.htmlspecialchars($onChange).'"'.
							$PA['onFocus'].
							$selector_itemListStyle.
							($conf['foreign_unique'] ? ' isunique="isunique"' : '').'>
					'.implode('
					',$opt).'
				</select>';

				// add a "Create new relation" link for adding new relations
				// this is neccessary, if the size of the selector is "1" or if
				// there is only one record item in the select-box, that is selected by default
				// the selector-box creates a new relation on using a onChange event (see some line above)
			$createNewRelationText = $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:cm.createNewRelation',1);
			$item .=
				'<a href="#" onclick="'.htmlspecialchars($onChange).'" align="abstop">'.
					'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/edit2.gif','width="11" height="12"').' align="absmiddle" '.t3lib_BEfunc::titleAltAttrib($createNewRelationText).' /> '.$createNewRelationText.
				'</a>';
				// wrap the selector and add a spacer to the bottom
			$item = '<div style="margin-bottom: 20px;">'.$item.'</div>';
		}

		return $item;
	}


	/**
	 * Generate a link that opens an element browser in a new window.
	 * For group/db there is no way o use a "selector" like a <select>|</select>-box.
	 *
	 * @param	array		$conf: TCA configuration of the parent(!) field
	 * @param	array		$PA: An array with additional configuration options
	 * @return	string		A HTML link that opens an element browser in a new window
	 */
	function renderPossibleRecordsSelectorTypeGroupDB($conf, &$PA) {
		$foreign_table = $conf['foreign_table'];

		$config = $PA['fieldConf']['config'];
		$allowed = $config['allowed'];
		$objectPrefix = $this->inlineNames['object'].'['.$foreign_table.']';

		$createNewRelationText = $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:cm.createNewRelation',1);
		$onClick = "setFormValueOpenBrowser('db','".('|||'.$allowed.'|'.$objectPrefix.'|inline.checkUniqueElement||inline.importElement')."'); return false;";
		$item =
			'<a href="#" onclick="'.htmlspecialchars($onClick).'">'.
				'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/insert3.gif','width="14" height="14"').' align="absmiddle" '.t3lib_BEfunc::titleAltAttrib($createNewRelationText).' /> '.$createNewRelationText.
			'</a>';

		return $item;
	}


	/**
	 * Creates a link/button to create new records
	 *
	 * @param	string		$objectPrefix: The "path" to the child record to create (e.g. '[parten_table][parent_uid][parent_field][child_table]')
	 * @param	array		$conf: TCA configuration of the parent(!) field
	 * @return	string		The HTML code for the new record link
	 */
	function getNewRecordLink($objectPrefix, $conf = array()) {
		$nameObject = $this->inlineNames['object'];
		$class = ' class="inlineNewButton '.$this->inlineData['config'][$nameObject]['md5'].'"';

		if ($conf['inline']['inlineNewButtonStyle']) {
			$style = ' style="'.$conf['inline']['inlineNewButtonStyle'].'"';
		}

		$onClick = "return inline.createNewRecord('$objectPrefix')";
		$title = $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:cm.createnew',1);

		if ($conf['appearance']['newRecordLinkAddTitle']) {
			$tableTitle .= ' '.$GLOBALS['LANG']->sL($GLOBALS['TCA'][$conf['foreign_table']]['ctrl']['title'],1);
		}

		$out = '
				<div class="typo3-newRecordLink">
					<a href="#" onClick="'.$onClick.'"'.$class.$style.' title="'.$title.$tableTitle.'">'.
					'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/new_el.gif','width="11" height="12"').' alt="'.$title.$tableTitle.'" />'.
					$title.t3lib_div::fixed_lgd_cs($tableTitle, $this->fObj->titleLen).
					'</a>
				</div>';
		return $out;
	}


	/**
	 * Add Sortable functionality using script.acolo.us "Sortable".
	 *
	 * @param	string		$objectId: The container id of the object - elements inside will be sortable
	 * @return	void
	 */
	function addJavaScriptSortable($objectId) {
		$this->fObj->additionalJS_post[] = '
			inline.createDragAndDropSorting("'.$objectId.'");
		';
	}


	/*******************************************************
	 *
	 * Handling of AJAX calls
	 *
	 *******************************************************/


	/**
	 * Initialize environment for AJAX calls
	 *
	 * @param	string		$method: Name of the method to be called
	 * @param	array		$arguments: Arguments to be delivered to the method
	 * @return	void
	 */
	function initForAJAX($method, &$arguments) {
			// Set t3lib_TCEforms::$RTEcounter to the given value:
		if ($method == 'createNewRecord') {
			$this->fObj->RTEcounter = intval(array_shift($arguments));
		}
	}


	/**
	 * Handle AJAX calls to show a new inline-record of the given table.
	 * Normally this method is never called from inside TYPO3. Always from outside by AJAX.
	 *
	 * @param	string		$domObjectId: The calling object in hierarchy, that requested a new record.
	 * @param	string		$foreignUid: If set, the new record should be inserted after that one.
	 * @return	string		A JSON string
	 */
	function createNewRecord($domObjectId, $foreignUid = 0) {
		$this->isAjaxCall = true;
			// parse the DOM identifier (string), add the levels to the structure stack (array) and load the TCA config
		$this->parseStructureString($domObjectId, true);
			// the current table - for this table we should add/import records
		$current = $this->inlineStructure['unstable'];
			// the parent table - this table embeds the current table
		$parent = $this->getStructureLevel(-1);
			// get TCA 'config' of the parent table
		$config = $parent['config'];
		$collapseAll = (isset($config['appearance']['collapseAll']) && $config['appearance']['collapseAll']);
		$expandSingle = (isset($config['appearance']['expandSingle']) && $config['appearance']['expandSingle']); 

			// Put the current level also to the dynNestedStack of TCEforms:
		$this->fObj->pushToDynNestedStack('inline', $this->inlineNames['object']);

			// dynamically create a new record using t3lib_transferData
		if (!$foreignUid || !t3lib_div::testInt($foreignUid) || $config['foreign_selector']) {
			$record = $this->getNewRecord($this->inlineFirstPid, $current['table']);

			// dynamically import an existing record (this could be a call from a select box)
		} else {
			$record = $this->getRecord($this->inlineFirstPid, $current['table'], $foreignUid);
		}

			// now there is a foreign_selector, so there is a new record on the intermediate table, but
			// this intermediate table holds a field, which is responsible for the foreign_selector, so
			// we have to set this field to the uid we get - or if none, to a new uid
		if ($config['foreign_selector'] && $foreignUid) {
			$selConfig = $this->getPossibleRecordsSelectorConfig($config, $config['foreign_selector']);
				// For a selector of type group/db, prepend the tablename (<tablename>_<uid>):
			$record[$config['foreign_selector']] = $selConfig['type'] != 'groupdb' ? '' : $selConfig['table'].'_';
			$record[$config['foreign_selector']] .= $foreignUid;
		}

			// the HTML-object-id's prefix of the dynamically created record
		$objectPrefix = $this->inlineNames['object'].'['.$current['table'].']';
		$objectId = $objectPrefix.'['.$record['uid'].']';

			// render the foreign record that should passed back to browser
		$item = $this->renderForeignRecord($parent['uid'], $record, $config);
		if($item === false) {
			$jsonArray = array(
				'data'	=> 'Access denied',
				'scriptCall' => array(
					"alert('Access denied');",
				)
			);
			return $this->getJSON($jsonArray);
		}

			// Encode TCEforms AJAX response with utf-8:
		$item = $GLOBALS['LANG']->csConvObj->utf8_encode($item, $GLOBALS['LANG']->charSet);

		if (!$current['uid']) {
			$jsonArray = array(
				'data'	=> $item,
				'scriptCall' => array(
					"inline.domAddNewRecord('bottom','".$this->inlineNames['object']."_records','$objectPrefix',json.data);",
					"inline.memorizeAddRecord('$objectPrefix','".$record['uid']."',null,'$foreignUid');"
				)
			);

			// append the HTML data after an existing record in the container
		} else {
			$jsonArray = array(
				'data'	=> $item,
				'scriptCall' => array(
					"inline.domAddNewRecord('after','".$domObjectId.'_div'."','$objectPrefix',json.data);",
					"inline.memorizeAddRecord('$objectPrefix','".$record['uid']."','".$current['uid']."','$foreignUid');"
				)
			);
		}

			// Add data that would have been added at the top of a regular TCEforms call:
		if ($headTags = $this->getHeadTags()) {
			$jsonArray['headData'] = $headTags;
		}
			// Add the JavaScript data that would have been added at the bottom of a regular TCEforms call:
		$jsonArray['scriptCall'][] = $this->fObj->JSbottom($this->fObj->formName, true);
			// if script.aculo.us Sortable is used, update the Observer to know the the record
		if ($config['appearance']['useSortable']) {
			$jsonArray['scriptCall'][] = "inline.createDragAndDropSorting('".$this->inlineNames['object']."_records');";
		}
			// if TCEforms has some JavaScript code to be executed, just do it
		if ($this->fObj->extJSCODE) {
			$jsonArray['scriptCall'][] = $this->fObj->extJSCODE;
		}
 			// Collapse all other records if requested:
 		if (!$collapseAll && $expandSingle) {
 			$jsonArray['scriptCall'][] = "inline.collapseAllRecords('$objectId', '$objectPrefix', '".$record['uid']."');";
 		}
			// tell the browser to scroll to the newly created record
		$jsonArray['scriptCall'][] = "Element.scrollTo('".$objectId."_div');";
			// fade out and fade in the new record in the browser view to catch the user's eye
		$jsonArray['scriptCall'][] = "inline.fadeOutFadeIn('".$objectId."_div');";

			// Remove the current level also from the dynNestedStack of TCEforms:
		$this->fObj->popFromDynNestedStack();

			// return the JSON string
		return $this->getJSON($jsonArray);
	}


	/**
	 * Save the expanded/collapsed state of a child record in the BE_USER->uc.
	 *
	 * @param	string		$domObjectId: The calling object in hierarchy, that requested a new record.
	 * @param	string		$expand: Whether this record is expanded.
	 * @param	string		$collapse: Whether this record is collapsed.
	 * @return	void
	 */
	function setExpandedCollapsedState($domObjectId, $expand, $collapse) {
			// parse the DOM identifier (string), add the levels to the structure stack (array), but don't load TCA config
		$this->parseStructureString($domObjectId, false);
			// the current table - for this table we should add/import records
		$current = $this->inlineStructure['unstable'];
			// the top parent table - this table embeds the current table
		$top = $this->getStructureLevel(0);

			// only do some action if the top record and the current record were saved before
		if (t3lib_div::testInt($top['uid'])) {
			$inlineView = (array)unserialize($GLOBALS['BE_USER']->uc['inlineView']);
			$inlineViewCurrent =& $inlineView[$top['table']][$top['uid']];

			$expandUids = t3lib_div::trimExplode(',', $expand);
			$collapseUids = t3lib_div::trimExplode(',', $collapse);

				// set records to be expanded
			foreach ($expandUids as $uid) {
				$inlineViewCurrent[$current['table']][] = $uid;
			}
				// set records to be collapsed
			foreach ($collapseUids as $uid) {
				$inlineViewCurrent[$current['table']] = $this->removeFromArray($uid, $inlineViewCurrent[$current['table']]);
			}

				// save states back to database
			if (is_array($inlineViewCurrent[$current['table']])) {
				$inlineViewCurrent = array_unique($inlineViewCurrent);
				$GLOBALS['BE_USER']->uc['inlineView'] = serialize($inlineView);
				$GLOBALS['BE_USER']->writeUC();
			}
		}
	}


	/*******************************************************
	 *
	 * Get data from database and handle relations
	 *
	 *******************************************************/


	/**
	 * Get the related records of the embedding item, this could be 1:n, m:n.
	 *
	 * @param	string		$table: The table name of the record
	 * @param	string		$field: The field name which this element is supposed to edit
	 * @param	array		$row: The record data array where the value(s) for the field can be found
	 * @param	array		$PA: An array with additional configuration options.
	 * @param	array		$config: (Redundant) content of $PA['fieldConf']['config'] (for convenience)
	 * @return	array		The records related to the parent item
	 */
	function getRelatedRecords($table,$field,$row,&$PA,$config) {
		$records = array();

			// Creating the label for the "No Matching Value" entry.
		$nMV_label = isset($PA['fieldTSConfig']['noMatchingValue_label']) ? $this->fObj->sL($PA['fieldTSConfig']['noMatchingValue_label']) : '[ '.$this->fObj->getLL('l_noMatchingValue').' ]';

			// Register the required number of elements:
		# $this->fObj->requiredElements[$PA['itemFormElName']] = array($minitems,$maxitems,'imgName'=>$table.'_'.$row['uid'].'_'.$field);

			// Perform modification of the selected items array:
		$itemArray = t3lib_div::trimExplode(',',$PA['itemFormElValue'],1);
		foreach($itemArray as $tk => $tv) {
			$tvP = explode('|',$tv,2);
				// get the records for this uid using t3lib_transferdata
			$records[] = $this->getRecord($row['pid'], $config['foreign_table'], $tvP[0]);
		}

		return $records;
	}


	/**
	 * Get possible records.
	 * Copied from TCEform and modified.
	 *
	 * @param	string		The table name of the record
	 * @param	string		The field name which this element is supposed to edit
	 * @param	array		The record data array where the value(s) for the field can be found
	 * @param	array		An array with additional configuration options.
	 * @param	string		$checkForConfField: For which field in the foreign_table the possible records should be fetched
	 * @return	mixed		Array of possible record items; false if type is "group/db", then everything could be "possible"
	 */
	function getPossibleRecords($table,$field,$row,$conf,$checkForConfField='foreign_selector') {
			// ctrl configuration from TCA:
		$tcaTableCtrl = $GLOBALS['TCA'][$table]['ctrl'];
			// Field configuration from TCA:
		$foreign_table = $conf['foreign_table'];
		$foreign_check = $conf[$checkForConfField];

		$foreignConfig = $this->getPossibleRecordsSelectorConfig($conf, $foreign_check);
		$PA = $foreignConfig['PA'];
		$config = $PA['fieldConf']['config'];
		
		if ($foreignConfig['type'] == 'select') {
				// Getting the selector box items from the system
			$selItems = $this->fObj->addSelectOptionsToItemArray($this->fObj->initItemArray($PA['fieldConf']),$PA['fieldConf'],$this->fObj->setTSconfig($table,$row),$field);
			if ($config['itemsProcFunc']) $selItems = $this->fObj->procItems($selItems,$PA['fieldTSConfig']['itemsProcFunc.'],$config,$table,$row,$field);
	
				// Possibly remove some items:
			$removeItems = t3lib_div::trimExplode(',',$PA['fieldTSConfig']['removeItems'],1);
			foreach($selItems as $tk => $p)	{
	
					// Checking languages and authMode:
				$languageDeny = $tcaTableCtrl['languageField'] && !strcmp($tcaTableCtrl['languageField'], $field) && !$GLOBALS['BE_USER']->checkLanguageAccess($p[1]);
				$authModeDeny = $config['form_type']=='select' && $config['authMode'] && !$GLOBALS['BE_USER']->checkAuthMode($table,$field,$p[1],$config['authMode']);
				if (in_array($p[1],$removeItems) || $languageDeny || $authModeDeny)	{
					unset($selItems[$tk]);
				} elseif (isset($PA['fieldTSConfig']['altLabels.'][$p[1]])) {
					$selItems[$tk][0]=$this->fObj->sL($PA['fieldTSConfig']['altLabels.'][$p[1]]);
				}
	
					// Removing doktypes with no access:
				if ($table.'.'.$field == 'pages.doktype')	{
					if (!($GLOBALS['BE_USER']->isAdmin() || t3lib_div::inList($GLOBALS['BE_USER']->groupData['pagetypes_select'],$p[1])))	{
						unset($selItems[$tk]);
					}
				}
			}
		} else {
			$selItems = false;
		}

		return $selItems;
	}

	/**
	 * Gets the uids of a select/selector that should be unique an have already been used.
	 *
	 * @param	array		$records: All inline records on this level
	 * @param	array		$conf: The TCA field configuration of the inline field to be rendered
	 * @param	boolean		$splitValue: for usage with group/db, values come like "tx_table_123|Title%20abc", but we need "tx_table" and "123"
	 * @return	array		The uids, that have been used already and should be used unique
	 */
	function getUniqueIds($records, $conf=array(), $splitValue=false) {
		$uniqueIds = array();

		if ($conf['foreign_unique'] && count($records)) {
			foreach ($records as $rec) {
				$value = $rec[$conf['foreign_unique']];
					// Split the value and extract the table and uid:
				if ($splitValue) {
					$valueParts = t3lib_div::trimExplode('|', $value);
					$itemParts = explode('_', $valueParts[0]);
					$value = array(
						'uid' => array_pop($itemParts),
						'table' => implode('_', $itemParts)
					);
				}
				$uniqueIds[$rec['uid']] = $value;
			}
		}

		return $uniqueIds;
	}


	/**
	 * Get a single record row for a TCA table from the database.
	 * t3lib_transferData is used for "upgrading" the values, especially the relations.
	 *
	 * @param	integer		$pid: The pid of the page the record should be stored (only relevant for NEW records)
	 * @param	string		$table: The table to fetch data from (= foreign_table)
	 * @param	string		$uid: The uid of the record to fetch, or the pid if a new record should be created
	 * @param	string		$cmd: The command to perform, empty or 'new'
	 * @return	array		A record row from the database post-processed by t3lib_transferData
	 */
	function getRecord($pid, $table, $uid, $cmd='') {
		$trData = t3lib_div::makeInstance('t3lib_transferData');
		$trData->addRawData = TRUE;
		# $trData->defVals = $this->defVals;
		$trData->lockRecords=1;
		$trData->disableRTE = $GLOBALS['SOBE']->MOD_SETTINGS['disableRTE'];
			// if a new record should be created
		$trData->fetchRecord($table, $uid, ($cmd === 'new' ? 'new' : ''));
		reset($trData->regTableItems_data);
		$rec = current($trData->regTableItems_data);
		$rec['uid'] = $cmd == 'new' ? uniqid('NEW') : $uid;
		if ($cmd=='new') $rec['pid'] = $pid;

		return $rec;
	}


	/**
	 * Wrapper. Calls getRecord in case of a new record should be created.
	 *
	 * @param	integer		$pid: The pid of the page the record should be stored (only relevant for NEW records)
	 * @param	string		$table: The table to fetch data from (= foreign_table)
	 * @return	array		A record row from the database post-processed by t3lib_transferData
	 */
	function getNewRecord($pid, $table) {
		return $this->getRecord($pid, $table, $pid, 'new');
	}


	/*******************************************************
	 *
	 * Structure stack for handling inline objects/levels
	 *
	 *******************************************************/


	/**
	 * Add a new level on top of the structure stack. Other functions can access the
	 * stack and determine, if there's possibly a endless loop.
	 *
	 * @param	string		$table: The table name of the record
	 * @param	string		$uid: The uid of the record that embeds the inline data
	 * @param	string		$field: The field name which this element is supposed to edit
	 * @param	array		$config: The TCA-configuration of the inline field
	 * @return	void
	 */
	function pushStructure($table, $uid, $field = '', $config = array()) {
		$this->inlineStructure['stable'][] = array(
			'table'	=> $table,
			'uid' => $uid,
			'field' => $field,
			'config' => $config,
		);
		$this->updateStructureNames();
	}


	/**
	 * Remove the item on top of the structure stack and return it.
	 *
	 * @return	array		The top item of the structure stack - array(<table>,<uid>,<field>,<config>)
	 */
	function popStructure() {
		if (count($this->inlineStructure['stable'])) {
			$popItem = array_pop($this->inlineStructure['stable']);
			$this->updateStructureNames();
		}
		return $popItem;
	}


	/**
	 * For common use of DOM object-ids and form field names of a several inline-level,
	 * these names/identifiers are preprocessed and set to $this->inlineNames.
	 * This function is automatically called if a level is pushed to or removed from the
	 * inline structure stack.
	 *
	 * @return	void
	 */
	function updateStructureNames() {
		$current = $this->getStructureLevel(-1);
			// if there are still more inline levels available
		if ($current !== false) {
			$lastItemName = $this->getStructureItemName($current);
			$this->inlineNames = array(
				'form' => $this->prependFormFieldNames.$lastItemName,
				'object' => $this->prependNaming.'['.$this->inlineFirstPid.']'.$this->getStructurePath(),
			);
			// if there are no more inline levels available
		} else {
			$this->inlineNames = array();
		}
	}


	/**
	 * Create a name/id for usage in HTML output of a level of the structure stack.
	 *
	 * @param	array		$levelData: Array of a level of the structure stack (containing the keys table, uid and field)
	 * @return	string		The name/id of that level, to be used for HTML output
	 */
	function getStructureItemName($levelData) {
		if (is_array($levelData)) {
			$name =	'['.$levelData['table'].']' .
					'['.$levelData['uid'].']' .
					(isset($levelData['field']) ? '['.$levelData['field'].']' : '');
		}
		return $name;
	}


	/**
	 * Get a level from the stack and return the data.
	 * If the $level value is negative, this function works top-down,
	 * if the $level value is positive, this function works bottom-up.
	 *
	 * @param	integer		$level: Which level to return
	 * @return	array		The item of the stack at the requested level
	 */
	function getStructureLevel($level) {
		$inlineStructureCount = count($this->inlineStructure['stable']);
		if ($level < 0) $level = $inlineStructureCount+$level;
		if ($level >= 0 && $level < $inlineStructureCount)
			return $this->inlineStructure['stable'][$level];
		else
			return false;
	}


	/**
	 * Get the identifiers of a given depth of level, from the top of the stack to the bottom.
	 * An identifier consists looks like [<table>][<uid>][<field>].
	 *
	 * @param	integer		$structureDepth: How much levels to output, beginning from the top of the stack
	 * @return	string		The path of identifiers
	 */
	function getStructurePath($structureDepth = -1) {
		$structureCount = count($this->inlineStructure['stable']);
		if ($structureDepth < 0 || $structureDepth > $structureCount) $structureDepth = $structureCount;

		for ($i = 1; $i <= $structureDepth; $i++) {
			$current = $this->getStructureLevel(-$i);
			$string = $this->getStructureItemName($current).$string;
		}

		return $string;
	}


	/**
	 * Convert the DOM object-id of an inline container to an array.
	 * The object-id could look like 'data[inline][tx_mmftest_company][1][employees]'.
	 * The result is written to $this->inlineStructure.
	 * There are two keys:
	 *  - 'stable': Containing full qualified identifiers (table, uid and field)
	 *  - 'unstable': Containting partly filled data (e.g. only table and possibly field)
	 *
	 * @param	string		$domObjectId: The DOM object-id
	 * @param	boolean		$loadConfig: Load the TCA configuration for that level
	 * @return	void
	 */
	function parseStructureString($string, $loadConfig = false) {
		$unstable = array();
		$vector = array('table', 'uid', 'field');
		$pattern = '/^'.$this->prependNaming.'\[(.+?)\]\[(.+)\]$/';
		if (preg_match($pattern, $string, $match)) {
			$this->inlineFirstPid = $match[1];
			$parts = explode('][', $match[2]);
			$partsCnt = count($parts);
			for ($i = 0; $i < $partsCnt; $i++) {
				if ($i > 0 && $i % 3 == 0) {
						// load the TCA configuration of the table field and store it in the stack
					if ($loadConfig) {
						t3lib_div::loadTCA($unstable['table']);
						$unstable['config'] = $GLOBALS['TCA'][$unstable['table']]['columns'][$unstable['field']]['config'];
							// Fetch TSconfig:
						$TSconfig = $this->fObj->setTSconfig(
							$unstable['table'],
							array('uid' => $unstable['uid'], 'pid' => $this->inlineFirstPid),
							$unstable['field']
						);
							// Override TCA field config by TSconfig:
						if (!$TSconfig['disabled']) {
							$unstable['config'] = $this->fObj->overrideFieldConf($unstable['config'], $TSconfig);
						}
					}
					$this->inlineStructure['stable'][] = $unstable;
					$unstable = array();
				}
				$unstable[$vector[$i % 3]] = $parts[$i];
			}
			$this->updateStructureNames();
			if (count($unstable)) $this->inlineStructure['unstable'] = $unstable;
		}
	}


	/*******************************************************
	 *
	 * Helper functions
	 *
	 *******************************************************/


	/**
	 * Does some checks on the TCA configuration of the inline field to render.
	 *
	 * @param	array		$config: Reference to the TCA field configuration
	 * @return	boolean		If critical configuration errors were found, false is returned
	 */
	function checkConfiguration(&$config) {
		$foreign_table = $config['foreign_table'];

			// An inline field must have a foreign_table, if not, stop all further inline actions for this field:
		if (!$foreign_table || !is_array($GLOBALS['TCA'][$foreign_table])) {
			return false;
		}
			// Init appearance if not set:
		if (!is_array($config['appearance'])) {
			$config['appearance'] = array();
		}
			// Set the position/appearance of the "Create new record" link:
		if ($config['foreign_selector'] && !$config['appearance']['useCombination']) {
			$config['appearance']['newRecordLinkPosition'] = 'none';
		} elseif (!in_array($config['appearance']['newRecordLinkPosition'], array('top', 'bottom', 'both', 'none'))) {
			$config['appearance']['newRecordLinkPosition'] = 'top';
		}

		return true;
	}


	/**
	 * Checks the page access rights (Code for access check mostly taken from alt_doc.php)
	 * as well as the table access rights of the user.
	 *
	 * @param	string		$cmd: The command that sould be performed ('new' or 'edit')
	 * @param	string		$table: The table to check access for
	 * @param	string		$theUid: The record uid of the table
	 * @return	boolean		Returns true is the user has access, or false if not
	 */
	function checkAccess($cmd, $table, $theUid) {
			// Checking if the user has permissions? (Only working as a precaution, because the final permission check is always down in TCE. But it's good to notify the user on beforehand...)
			// First, resetting flags.
		$hasAccess = 0;
		$deniedAccessReason = '';

			// If the command is to create a NEW record...:
		if ($cmd=='new') {
				// If the pid is numerical, check if it's possible to write to this page:
			if (t3lib_div::testInt($this->inlineFirstPid)) {
				$calcPRec = t3lib_BEfunc::getRecord('pages', $this->inlineFirstPid);
				if(!is_array($calcPRec)) {
					return false;
				}
				$CALC_PERMS = $GLOBALS['BE_USER']->calcPerms($calcPRec);	// Permissions for the parent page
				if ($table=='pages')	{	// If pages:
					$hasAccess = $CALC_PERMS&8 ? 1 : 0; // Are we allowed to create new subpages?
				} else {
					$hasAccess = $CALC_PERMS&16 ? 1 : 0; // Are we allowed to edit content on this page?
				}
				// If the pid is a NEW... value, the access will be checked on creating the page:
				// (if the page with the same NEW... value could be created in TCEmain, this child record can neither)
			} else {
				$hasAccess = 1;
			}
		} else {	// Edit:
			$calcPRec = t3lib_BEfunc::getRecord($table,$theUid);
			t3lib_BEfunc::fixVersioningPid($table,$calcPRec);
			if (is_array($calcPRec))	{
				if ($table=='pages')	{	// If pages:
					$CALC_PERMS = $GLOBALS['BE_USER']->calcPerms($calcPRec);
					$hasAccess = $CALC_PERMS&2 ? 1 : 0;
				} else {
					$CALC_PERMS = $GLOBALS['BE_USER']->calcPerms(t3lib_BEfunc::getRecord('pages',$calcPRec['pid']));	// Fetching pid-record first.
					$hasAccess = $CALC_PERMS&16 ? 1 : 0;
				}

					// Check internals regarding access:
				if ($hasAccess)	{
					$hasAccess = $GLOBALS['BE_USER']->recordEditAccessInternals($table, $calcPRec);
				}
			}
		}

		if(!$GLOBALS['BE_USER']->check('tables_modify', $table)) {
			$hasAccess = 0;
		}

		if(!$hasAccess) {
			$deniedAccessReason = $GLOBALS['BE_USER']->errorMsg;
			if($deniedAccessReason) {
				debug($deniedAccessReason);
			}
		}

		return $hasAccess ? true : false;
	}


	/**
	 * Check the keys and values in the $compare array against the ['config'] part of the top level of the stack.
	 * A boolean value is return depending on how the comparison was successful.
	 *
	 * @param	array		$compare: keys and values to compare to the ['config'] part of the top level of the stack
	 * @return	boolean		Whether the comparison was successful
	 * @see 	arrayCompareComplex
	 */
	function compareStructureConfiguration($compare) {
		$level = $this->getStructureLevel(-1);
		$result = $this->arrayCompareComplex($level, $compare);

		return $result;
	}


	/**
	 * Normalize a relation "uid" published by transferData, like "1|Company%201"
	 *
	 * @param	string		$string: A transferData reference string, containing the uid
	 * @return	string		The normalized uid
	 */
	function normalizeUid($string) {
		$parts = explode('|', $string);
		return $parts[0];
	}


	/**
	 * Wrap the HTML code of a section with a table tag.
	 *
	 * @param	string		$section: The HTML code to be wrapped
	 * @param	array		$styleAttrs: Attributes for the style argument in the table tag
	 * @param	array		$tableAttrs: Attributes for the table tag (like width, border, etc.)
	 * @return	string		The wrapped HTML code
	 */
	function wrapFormsSection($section, $styleAttrs = array(), $tableAttrs = array()) {
		if (!$styleAttrs['margin-right']) $styleAttrs['margin-right'] = $this->inlineStyles['margin-right'].'px';

		foreach ($styleAttrs as $key => $value) $style .= ($style?' ':'').$key.': '.htmlspecialchars($value).'; ';
		if ($style) $style = ' style="'.$style.'"';

		if (!$tableAttrs['background'] && $this->fObj->borderStyle[2]) $tableAttrs['background'] = $this->backPath.$this->borderStyle[2];
		if (!$tableAttrs['cellspacing']) $tableAttrs['cellspacing'] = '0';
		if (!$tableAttrs['cellpadding']) $tableAttrs['cellpadding'] = '0';
		if (!$tableAttrs['border']) $tableAttrs['border'] = '0';
		if (!$tableAttrs['width']) $tableAttrs['width'] = '100%';
		if (!$tableAttrs['class'] && $this->borderStyle[3]) $tableAttrs['class'] = $this->borderStyle[3];

		foreach ($tableAttrs as $key => $value) $table .= ($table?' ':'').$key.'="'.htmlspecialchars($value).'"';

		$out = '<table '.$table.$style.'>'.$section.'</table>';
		return $out;
	}


	/**
	 * Checks if the $table is the child of a inline type AND the $field is the label field of this table.
	 * This function is used to dynamically update the label while editing. This has no effect on labels,
	 * that were processed by a TCEmain-hook on saving.
	 *
	 * @param	string		$table: The table to check
	 * @param	string		$field: The field on this table to check
	 * @return	boolean		is inline child and field is responsible for the label
	 */
	function isInlineChildAndLabelField($table, $field) {
		$level = $this->getStructureLevel(-1);
		if ($level['config']['foreign_label'])
			$label = $level['config']['foreign_label'];
		else
			$label = $GLOBALS['TCA'][$table]['ctrl']['label'];
		return $level['config']['foreign_table'] === $table && $label == $field ? true : false;
	}


	/**
	 * Get the depth of the stable structure stack.
	 * (count($this->inlineStructure['stable'])
	 *
	 * @return	integer		The depth of the structure stack
	 */
	function getStructureDepth() {
		return count($this->inlineStructure['stable']);
	}


	/**
	 * Handles complex comparison requests on an array.
	 * A request could look like the following:
	 *
	 * $searchArray = array(
	 * 		'%AND'	=> array(
	 * 			'key1'	=> 'value1',
	 * 			'key2'	=> 'value2',
	 * 			'%OR'	=> array(
	 * 				'subarray' => array(
	 * 					'subkey' => 'subvalue'
	 * 				),
	 * 				'key3'	=> 'value3',
	 * 				'key4'	=> 'value4'
	 * 			)
	 * 		)
	 * );
	 *
	 * It is possible to use the array keys '%AND.1', '%AND.2', etc. to prevent
	 * overwriting the sub-array. It could be neccessary, if you use complex comparisons.
	 *
	 * The example above means, key1 *AND* key2 (and their values) have to match with
	 * the $subjectArray and additional one *OR* key3 or key4 have to meet the same
	 * condition.
	 * It is also possible to compare parts of a sub-array (e.g. "subarray"), so this
	 * function recurses down one level in that sub-array.
	 *
	 * @param	array		$subjectArray: The array to search in
	 * @param	array		$searchArray: The array with keys and values to search for
	 * @param	string		$type: Use '%AND' or '%OR' for comparision
	 * @return	boolean		The result of the comparison
	 */
	function arrayCompareComplex($subjectArray, $searchArray, $type = '') {
		$localMatches = 0;
		$localEntries = 0;

		if (is_array($searchArray) && count($searchArray)) {
				// if no type was passed, try to determine
			if (!$type) {
				reset($searchArray);
				$type = key($searchArray);
				$searchArray = current($searchArray);
			}

				// we use '%AND' and '%OR' in uppercase
			$type = strtoupper($type);

				// split regular elements from sub elements
			foreach ($searchArray as $key => $value) {
				$localEntries++;

					// process a sub-group of OR-conditions
				if ($key == '%OR') {
					$localMatches += $this->arrayCompareComplex($subjectArray, $value, '%OR') ? 1 : 0;
					// process a sub-group of AND-conditions
				} elseif ($key == '%AND') {
					$localMatches += $this->arrayCompareComplex($subjectArray, $value, '%AND') ? 1 : 0;
					// a part of an associative array should be compared, so step down in the array hierarchy
				} elseif (is_array($value) && $this->isAssociativeArray($searchArray)) {
					$localMatches += $this->arrayCompareComplex($subjectArray[$key], $value, $type) ? 1 : 0;
					// it is a normal array that is only used for grouping and indexing
				} elseif (is_array($value)) {
					$localMatches += $this->arrayCompareComplex($subjectArray, $value, $type) ? 1 : 0;
					// directly compare a value
				} else {
					if (isset($subjectArray[$key]) && isset($value)) {
							// Boolean match:
						if (is_bool($value)) {
							$localMatches += (!($subjectArray[$key] xor $value) ? 1 : 0);
							// Value match for numbers:
						} elseif (is_numeric($subjectArray[$key]) && is_numeric($value)) {
							$localMatches += ($subjectArray[$key] == $value ? 1 : 0);
							// Value and type match:
						} else {
							$localMatches += ($subjectArray[$key] === $value ? 1 : 0);
						}
					}
				}

					// if one or more matches are required ('OR'), return true after the first successful match
				if ($type == '%OR' && $localMatches > 0) return true;
					// if all matches are required ('AND') and we have no result after the first run, return false
				if ($type == '%AND' && $localMatches == 0) return false;
			}
		}

			// return the result for '%AND' (if nothing was checked, true is returned)
		return $localEntries == $localMatches ? true : false;
	}


	/**
	 * Checks whether an object is an associative array.
	 *
	 * @param	mixed		$object: The object to be checked
	 * @return	boolean		Returns true, if the object is an associative array
	 */
	function isAssociativeArray($object) {
		return is_array($object) && count($object) && (array_keys($object) !== range(0, sizeof($object) - 1))
			? true
			: false;
	}


	/**
	 * Remove an element from an array.
	 *
	 * @param	mixed		$needle: The element to be removed.
	 * @param	array		$haystack: The array the element should be removed from.
	 * @param	mixed		$strict: Search elements strictly.
	 * @return	array		The array $haystack without the $needle
	 */
	function removeFromArray($needle, $haystack, $strict=null) {
		$pos = array_search($needle, $haystack, $strict);
		if ($pos !== false) unset($haystack[$pos]);
		return $haystack;
	}


	/**
	 * Makes a flat array from the $possibleRecords array.
	 * The key of the flat array is the value of the record,
	 * the value of the flat array is the label of the record.
	 *
	 * @param	array		$possibleRecords: The possibleRecords array (for select fields)
	 * @return	mixed		A flat array with key=uid, value=label; if $possibleRecords isn't an array, false is returned.
	 */
	function getPossibleRecordsFlat($possibleRecords) {
		$flat = false;
		if (is_array($possibleRecords)) {
			$flat = array();
			foreach ($possibleRecords as $record) $flat[$record[1]] = $record[0];
		}
		return $flat;
	}


	/**
	 * Determine the configuration and the type of a record selector.
	 *
	 * @param	array		$conf: TCA configuration of the parent(!) field
	 * @return	array		Associative array with the keys 'PA' and 'type', both are false if the selector was not valid.
	 */
	function getPossibleRecordsSelectorConfig($conf, $field = '') {
		$foreign_table = $conf['foreign_table'];
		$foreign_selector = $conf['foreign_selector'];

		$PA = false;
		$type = false;
		$table = false;
		$selector = false;
		
		if ($field) {
			$PA = array();
			$PA['fieldConf'] = $GLOBALS['TCA'][$foreign_table]['columns'][$field];
			$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['form_type'] ? $PA['fieldConf']['config']['form_type'] : $PA['fieldConf']['config']['type'];	// Using "form_type" locally in this script
			$PA['fieldTSConfig'] = $this->fObj->setTSconfig($foreign_table,array(),$field);
			$config = $PA['fieldConf']['config'];
				// Determine type of Selector:
			$type = $this->getPossibleRecordsSelectorType($config);
				// Return table on this level:
			$table = $type == 'select' ? $config['foreign_table'] : $config['allowed'];
				// Return type of the selector if foreign_selector is defined and points to the same field as in $field:
			if ($foreign_selector && $foreign_selector == $field && $type) {
				$selector = $type;
			}
		}
		
		return array(
			'PA' => $PA,
			'type' => $type,
			'table' => $table,
			'selector' => $selector,
		);
	}
	

	/**
	 * Determine the type of a record selector, e.g. select or group/db.
	 *
	 * @param	array		$config: TCE configuration of the selector
	 * @return	mixed		The type of the selector, 'select' or 'groupdb' - false not valid
	 */
	function getPossibleRecordsSelectorType($config) {
		$type = false;
		if ($config['type'] == 'select') {
			$type = 'select';
		} elseif ($config['type'] == 'group' && $config['internal_type'] == 'db') {
			$type = 'groupdb';
		}
		return $type;
	}
	
	
	/**
	 * Check, if a field should be skipped, that was defined to be handled as foreign_field or foreign_sortby of
	 * the parent record of the "inline"-type - if so, we have to skip this field - the rendering is done via "inline" as hidden field
	 *
	 * @param	string		$table: The table name
	 * @param	string		$field: The field name
	 * @param	array		$row: The record row from the database
	 * @param	array		$config: TCA configuration of the field
	 * @return	boolean		Determines whether the field should be skipped.
	 */
	function skipField($table, $field, $row, $config) {
		$skipThisField = false;

		if ($this->getStructureDepth()) {
			$searchArray = array(
				'%OR' => array(
					'config' => array(
						0 => array(
							'%AND' => array(
								'foreign_table' => $table,
								'%OR' => array(
									'%AND' => array(
										'appearance' => array('useCombination' => true),
										'foreign_selector' => $field,
									),
									'MM' => $config['MM']
								),
							),
						),
						1 => array(
							'%AND' => array(
								'foreign_table' => $config['foreign_table'],
								'foreign_selector' => $config['foreign_field'],
							),
						),
					),
				),
			);

				// get the parent record from structure stack
			$level = $this->getStructureLevel(-1);

				// If we have symmetric fields, check on which side we are and hide fields, that are set automatically:
			if (t3lib_loadDBGroup::isOnSymmetricSide($level['uid'], $level['config'], $row)) {
				$searchArray['%OR']['config'][0]['%AND']['%OR']['symmetric_field'] = $field;
				$searchArray['%OR']['config'][0]['%AND']['%OR']['symmetric_sortby'] = $field;
				// Hide fields, that are set automatically:
			} else {
				$searchArray['%OR']['config'][0]['%AND']['%OR']['foreign_field'] = $field;
				$searchArray['%OR']['config'][0]['%AND']['%OR']['foreign_sortby'] = $field;
			}

			$skipThisField = $this->compareStructureConfiguration($searchArray, true);
		}

		return $skipThisField;
	}


	/**
	 * Creates recursively a JSON literal from a mulidimensional associative array.
	 * Uses Services_JSON (http://mike.teczno.com/JSON/doc/)
	 *
	 * @param	array		$jsonArray: The array (or part of) to be transformed to JSON
	 * @return	string		If $level>0: part of JSON literal; if $level==0: whole JSON literal wrapped with <script> tags
	 */
	function getJSON($jsonArray) {
		if (!$GLOBALS['JSON']) {
			require_once(PATH_typo3.'contrib/json.php');
			$GLOBALS['JSON'] = t3lib_div::makeInstance('Services_JSON');
		}
		return $GLOBALS['JSON']->encode($jsonArray);
	}


	/**
	 * Checks if a uid of a child table is in the inline view settings.
	 *
	 * @param	string		$table: Name of the child table
	 * @param	integer		$uid: uid of the the child record
	 * @return	boolean		true=expand, false=collapse
	 */
	function getExpandedCollapsedState($table, $uid) {
		if (isset($this->inlineView[$table]) && is_array($this->inlineView[$table])) {
			if (in_array($uid, $this->inlineView[$table]) !== false) {
				return true;
			}
		}
		return false;
	}


	/**
	 * Update expanded/collapsed states on new inline records if any.
	 *
	 * @param	array		$uc: The uc array to be processed and saved (by reference)
	 * @param	object		$tce: Instance of TCEmain that saved data before (by reference)
	 * @return	void
	 */
	function updateInlineView(&$uc, &$tce) {
		if (isset($uc['inlineView']) && is_array($uc['inlineView'])) {
			$inlineView = (array)unserialize($GLOBALS['BE_USER']->uc['inlineView']);

			foreach ($uc['inlineView'] as $topTable => $topRecords) {
				foreach ($topRecords as $topUid => $childElements) {
					foreach ($childElements as $childTable => $childRecords) {
						$uids = array_keys($tce->substNEWwithIDs_table, $childTable);
						if (count($uids)) {
							$newExpandedChildren = array();
							foreach ($childRecords as $childUid => $state) {
								if ($state && in_array($childUid, $uids)) {
									$newChildUid = $tce->substNEWwithIDs[$childUid];
									$newExpandedChildren[] = $newChildUid;
								}
							}
								// Add new expanded child records to UC (if any):
							if (count($newExpandedChildren)) {
								$inlineViewCurrent =& $inlineView[$topTable][$topUid][$childTable];
								if (is_array($inlineViewCurrent)) {
									$inlineViewCurrent = array_unique(array_merge($inlineViewCurrent, $newExpandedChildren));
								} else {
									$inlineViewCurrent = $newExpandedChildren;
								}
							}
						}
					}
				}
			}

			$GLOBALS['BE_USER']->uc['inlineView'] = serialize($inlineView);
			$GLOBALS['BE_USER']->writeUC();
		}
	}


	/**
	 * Returns the the margin in pixels, that is used for each new inline level.
	 *
	 * @return	integer		A pixel value for the margin of each new inline level.
	 */
	function getLevelMargin() {
		$margin = ($this->inlineStyles['margin-right']+1)*2;
		return $margin;
	}

	/**
	 * Parses the HTML tags that would have been inserted to the <head> of a HTML document and returns the found tags as multidimensional array.
	 *
	 * @return	array		The parsed tags with their attributes and innerHTML parts
	 */
	function getHeadTags() {
		$headTags = array();
		$headDataRaw = $this->fObj->JStop();

		if ($headDataRaw) {
				// Create instance of the HTML parser:
			$parseObj = t3lib_div::makeInstance('t3lib_parsehtml');
				// Removes script wraps:
			$headDataRaw = str_replace(array('/*<![CDATA[*/', '/*]]>*/'), '', $headDataRaw);
				// Removes leading spaces of a multiline string:
			$headDataRaw = trim(preg_replace('/(^|\r|\n)( |\t)+/', '$1', $headDataRaw));
				// Get script and link tags:
			$tags = array_merge(
				$parseObj->getAllParts($parseObj->splitTags('link', $headDataRaw)),
				$parseObj->getAllParts($parseObj->splitIntoBlock('script', $headDataRaw))
			);

			foreach ($tags as $tagData) {
				$tagAttributes = $parseObj->get_tag_attributes($parseObj->getFirstTag($tagData), true);
				$headTags[] = array(
					'name' => $parseObj->getFirstTagName($tagData),
					'attributes' => $tagAttributes[0],
					'innerHTML'	=> $parseObj->removeFirstAndLastTag($tagData),
				);
			}
		}

		return $headTags;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['t3lib/class.t3lib_tceforms_inline.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['t3lib/class.t3lib_tceforms_inline.php']);
}
?>