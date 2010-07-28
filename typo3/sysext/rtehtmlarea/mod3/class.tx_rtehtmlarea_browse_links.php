<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2004 Kasper Skaarhoj (kasperYYYY@typo3.com)
*  (c) 2005-2009 Stanislas Rolland <typo3(arobas)sjbr.ca>
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
 * Displays the page/file tree for browsing database records or files.
 * Used from TCEFORMS an other elements
 * In other words: This is the ELEMENT BROWSER!
 *
 * Adapted for htmlArea RTE by Stanislas Rolland
 *
 * $Id: class.tx_rtehtmlarea_browse_links.php 8399 2010-07-28 09:12:12Z ohader $
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @author	Stanislas Rolland <stanislas.rolland(arobas)fructifor.ca>
 */

require_once (PATH_typo3.'class.browse_links.php');
require_once (PATH_t3lib.'class.t3lib_basicfilefunc.php');


/**
 * Class which generates the page tree
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @package TYPO3
 * @subpackage core
 */
class tx_rtehtmlarea_pageTree extends rtePageTree {
	
	/**
	 * Create the page navigation tree in HTML
	 *
	 * @param	array		Tree array
	 * @return	string		HTML output.
	 */
	function printTree($treeArr='')	{
		global $BACK_PATH;
		$titleLen=intval($GLOBALS['BE_USER']->uc['titleLen']);
		if (!is_array($treeArr))	$treeArr=$this->tree;

		$out='';
		$c=0;

		foreach($treeArr as $k => $v)	{
			$c++;
			$bgColorClass = ($c+1)%2 ? 'bgColor' : 'bgColor-10';
			if ($GLOBALS['SOBE']->browser->curUrlInfo['act']=='page' && $GLOBALS['SOBE']->browser->curUrlInfo['pageid']==$v['row']['uid'] && $GLOBALS['SOBE']->browser->curUrlInfo['pageid'])	{
				$arrCol='<td><img'.t3lib_iconWorks::skinImg($BACK_PATH,'gfx/blinkarrow_right.gif','width="5" height="9"').' class="c-blinkArrowR" alt="" /></td>';
				$bgColorClass='bgColor4';
			} else {
				$arrCol='<td></td>';
			}

			$aOnClick = 'return jumpToUrl(\''.$this->thisScript.'?act='.$GLOBALS['SOBE']->browser->act.'&editorNo='.$GLOBALS['SOBE']->browser->editorNo.'&contentTypo3Language='.$GLOBALS['SOBE']->browser->contentTypo3Language.'&contentTypo3Charset='.$GLOBALS['SOBE']->browser->contentTypo3Charset.'&mode='.$GLOBALS['SOBE']->browser->mode.'&expandPage='.$v['row']['uid'].'\');';
			$cEbullet = $this->ext_isLinkable($v['row']['doktype'],$v['row']['uid']) ?
						'<a href="#" onclick="'.htmlspecialchars($aOnClick).'"><img'.t3lib_iconWorks::skinImg($BACK_PATH,'gfx/ol/arrowbullet.gif','width="18" height="16"').' alt="" /></a>' :
						'';
			$out.='
				<tr class="'.$bgColorClass.'">
					<td nowrap="nowrap"'.($v['row']['_CSSCLASS'] ? ' class="'.$v['row']['_CSSCLASS'].'"' : '').'>'.
					$v['HTML'].
					$this->wrapTitle($this->getTitleStr($v['row'],$titleLen),$v['row'],$this->ext_pArrPages).
					'</td>'.
					$arrCol.
					'<td>'.$cEbullet.'</td>
				</tr>';
		}
		$out='


			<!--
				Navigation Page Tree:
			-->
			<table border="0" cellpadding="0" cellspacing="0" id="typo3-tree">
				'.$out.'
			</table>';
		return $out;
	}
}

/**
 * Base extension class which generates the folder tree.
 * Used directly by the RTE.
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @package TYPO3
 * @subpackage core
 */
class tx_rtehtmlarea_folderTree extends rteFolderTree {
	
	/**
	 * Wrapping the title in a link, if applicable.
	 *
	 * @param	string		Title, ready for output.
	 * @param	array		The "record"
	 * @return	string		Wrapping title string.
	 */
	function wrapTitle($title,$v)	{
		$title = htmlspecialchars($title);
		
		if ($this->ext_isLinkable($v))	{
			$aOnClick = 'return jumpToUrl(\''.$this->thisScript.'?act='.$GLOBALS['SOBE']->browser->act.'&editorNo='.$GLOBALS['SOBE']->browser->editorNo.'&contentTypo3Language='.$GLOBALS['SOBE']->browser->contentTypo3Language.'&contentTypo3Charset='.$GLOBALS['SOBE']->browser->contentTypo3Charset.'&mode='.$GLOBALS['SOBE']->browser->mode.'&expandFolder='.rawurlencode($v['path']).'\');';
			return '<a href="#" onclick="'.htmlspecialchars($aOnClick).'">'.$title.'</a>';
		} else {
			return '<span class="typo3-dimmed">'.$title.'</span>';
		}
	}
	
	/**
	 * Create the folder navigation tree in HTML
	 *
	 * @param	mixed		Input tree array. If not array, then $this->tree is used.
	 * @return	string		HTML output of the tree.
	 */
	function printTree($treeArr='')	{
		global $BACK_PATH;
		$titleLen=intval($GLOBALS['BE_USER']->uc['titleLen']);

		if (!is_array($treeArr))	$treeArr=$this->tree;

		$out='';
		$c=0;

			// Preparing the current-path string (if found in the listing we will see a red blinking arrow).
		if (!$GLOBALS['SOBE']->browser->curUrlInfo['value'])	{
			$cmpPath='';
		} else if (substr(trim($GLOBALS['SOBE']->browser->curUrlInfo['info']),-1)!='/')	{
			$cmpPath=PATH_site.dirname($GLOBALS['SOBE']->browser->curUrlInfo['info']).'/';
		} else {
			$cmpPath=PATH_site.$GLOBALS['SOBE']->browser->curUrlInfo['info'];
		}

			// Traverse rows for the tree and print them into table rows:
		foreach($treeArr as $k => $v)	{
			$c++;
			$bgColorClass=($c+1)%2 ? 'bgColor' : 'bgColor-10';

				// Creating blinking arrow, if applicable:
			if ($GLOBALS['SOBE']->browser->curUrlInfo['act']=='file' && $cmpPath==$v['row']['path'])	{
				$arrCol='<td><img'.t3lib_iconWorks::skinImg($BACK_PATH,'gfx/blinkarrow_right.gif','width="5" height="9"').' class="c-blinkArrowR" alt="" /></td>';
				$bgColorClass='bgColor4';
			} else {
				$arrCol='<td></td>';
			}
				// Create arrow-bullet for file listing (if folder path is linkable):
			$aOnClick = 'return jumpToUrl(\''.$this->thisScript.'?act='.$GLOBALS['SOBE']->browser->act.'&editorNo='.$GLOBALS['SOBE']->browser->editorNo.'&contentTypo3Language='.$GLOBALS['SOBE']->browser->contentTypo3Language.'&contentTypo3Charset='.$GLOBALS['SOBE']->browser->contentTypo3Charset.'&mode='.$GLOBALS['SOBE']->browser->mode.'&expandFolder='.rawurlencode($v['row']['path']).'\');';
			$cEbullet = $this->ext_isLinkable($v['row']) ? '<a href="#" onclick="'.htmlspecialchars($aOnClick).'"><img'.t3lib_iconWorks::skinImg($BACK_PATH,'gfx/ol/arrowbullet.gif','width="18" height="16"').' alt="" /></a>' : '';

				// Put table row with folder together:
			$out.='
				<tr class="'.$bgColorClass.'">
					<td nowrap="nowrap">'.$v['HTML'].$this->wrapTitle(t3lib_div::fixed_lgd_cs($v['row']['title'],$titleLen),$v['row']).'</td>
					'.$arrCol.'
					<td>'.$cEbullet.'</td>
				</tr>';
		}

		$out='

			<!--
				Folder tree:
			-->
			<table border="0" cellpadding="0" cellspacing="0" id="typo3-tree">
				'.$out.'
			</table>';
		return $out;
	}

}

/**
 * Script class for the Element Browser window.
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @package TYPO3
 * @subpackage core
 */
class tx_rtehtmlarea_browse_links extends browse_links {

		// Internal, static:
	var $setTarget;			// Target (RTE specific)
	var $setClass;			// Class (RTE specific)
	var $setTitle;			// Title (RTE specific)
	
	var $contentTypo3Language;
	var $contentTypo3Charset;
	
	var $editorNo;
	var $buttonConfig = array();
	
	/**
	 * Constructor:
	 * Initializes a lot of variables, setting JavaScript functions in header etc.
	 *
	 * @return	void
	 */
	function init()	{
		global $BE_USER,$BACK_PATH,$LANG;

			// Main GPvars:
		$this->pointer = t3lib_div::_GP('pointer');
		$this->bparams = t3lib_div::_GP('bparams');
		$this->P = t3lib_div::_GP('P');
		$this->RTEtsConfigParams = t3lib_div::_GP('RTEtsConfigParams');
		$this->expandPage = t3lib_div::_GP('expandPage');
		$this->expandFolder = t3lib_div::_GP('expandFolder');
		$this->PM = t3lib_div::_GP('PM');
		$this->contentTypo3Language = t3lib_div::_GP('typo3ContentLanguage');
		$this->contentTypo3Charset = t3lib_div::_GP('typo3ContentCharset');
		$this->editorNo = t3lib_div::_GP('editorNo');
		
			// Find "mode"
		$this->mode=t3lib_div::_GP('mode');
		if (!$this->mode)	{
			$this->mode='rte';
		}
		
			// Site URL
		$this->siteURL = t3lib_div::getIndpEnv('TYPO3_SITE_URL');	// Current site url
		
			// the script to link to
		$this->thisScript = t3lib_div::getIndpEnv('SCRIPT_NAME');
		
			// CurrentUrl - the current link url must be passed around if it exists
		if ($this->mode=='wizard')	{
			$currentLinkParts = t3lib_div::trimExplode(' ',$this->P['currentValue']);
			$this->curUrlArray = array(
				'target' => $currentLinkParts[1]
			);
			$this->curUrlInfo=$this->parseCurUrl($this->siteURL.'?id='.$currentLinkParts[0],$this->siteURL);
		} else {
			$this->curUrlArray = t3lib_div::_GP('curUrl');
			if ($this->curUrlArray['all'])	{
				$this->curUrlArray=t3lib_div::get_tag_attributes($this->curUrlArray['all']);
			}
			$this->curUrlInfo=$this->parseCurUrl($this->curUrlArray['href'],$this->siteURL);
		}

			// Determine nature of current url:
		$this->act=t3lib_div::_GP('act');
		if (!$this->act)	{
			$this->act=$this->curUrlInfo['act'];
		}

			// Initializing the titlevalue
		$this->setTitle = $LANG->csConvObj->conv($this->curUrlArray['title'], 'utf-8', $LANG->charSet);

			// Rich Text Editor specific configuration:
		$addPassOnParams='';
		if ((string)$this->mode=='rte')	{
			$RTEtsConfigParts = explode(':',$this->RTEtsConfigParams);
			$addPassOnParams .= '&RTEtsConfigParams='.rawurlencode($this->RTEtsConfigParams);
			$addPassOnParams .= ($this->contentTypo3Language ? '&typo3ContentLanguage=' . rawurlencode($this->contentTypo3Language) : '');
			$addPassOnParams .= ($this->contentTypo3Charset ? '&typo3ContentCharset=' . rawurlencode($this->contentTypo3Charset) : '');
			$RTEsetup = $BE_USER->getTSConfig('RTE',t3lib_BEfunc::getPagesTSconfig($RTEtsConfigParts[5]));
			$this->thisConfig = t3lib_BEfunc::RTEsetup($RTEsetup['properties'],$RTEtsConfigParts[0],$RTEtsConfigParts[2],$RTEtsConfigParts[4]);
			if (is_array($this->thisConfig['buttons.']) && is_array($this->thisConfig['buttons.']['link.'])) {
				$this->buttonConfig = $this->thisConfig['buttons.']['link.'];
			}
			if($this->thisConfig['classesAnchor']) {
				$this->setClass = $this->curUrlArray['class'];
				$classesAnchorArray = t3lib_div::trimExplode(',',$this->thisConfig['classesAnchor'],1);
				$anchorTypes = array( 'page', 'url', 'file', 'mail', 'spec');
				$classesAnchor = array();
				$classesAnchorDefault = array();
				$this->classesAnchorDefaultTitle = array();
				$classesAnchor['all'] = array();
				if (is_array($RTEsetup['properties']['classesAnchor.'])) {
					reset($RTEsetup['properties']['classesAnchor.']);
					while(list($label,$conf)=each($RTEsetup['properties']['classesAnchor.'])) {
						$classesAnchor['all'][] = $conf['class'];
						if (in_array($conf['type'], $anchorTypes)) {
							$classesAnchor[$conf['type']][] = $conf['class'];
							if (is_array($this->thisConfig['classesAnchor.']) && is_array($this->thisConfig['classesAnchor.']['default.']) && $this->thisConfig['classesAnchor.']['default.'][$conf['type']] == $conf['class']) {
								$classesAnchorDefault[$conf['type']] = $conf['class'];
								if ($conf['titleText']) {
									$string = trim($conf['titleText']);
									if (substr($string,0,4)=='LLL:') {       // language file
										$arr = explode(':',$string);
										if($arr[0] == 'LLL' && $arr[1] == 'EXT') {
											$BE_lang = $LANG->lang;
											$BE_origCharset = $LANG->origCharSet;
											$LANG->lang = $this->contentTypo3Language;
											$LANG->origCharSet = $LANG->csConvObj->charSetArray[$this->contentTypo3Language];
											$LANG->origCharSet = $LANG->origCharSet ? $LANG->origCharSet : 'iso-8859-1';
											$string = $LANG->getLLL($arr[3], $LANG->readLLfile($arr[1].':'.$arr[2]), true);
											$LANG->lang = $BE_lang;
											$LANG->origCharSet = $BE_origCharset;
										}
									}
									$this->classesAnchorDefaultTitle[$conf['type']] = $string;
								}
							}
						}
					}
				}
				$this->classesAnchorJSOptions = array();
				reset($anchorTypes);
				while (list(, $anchorType) = each($anchorTypes) ) {
					reset($classesAnchorArray);
					while(list(,$class)=each($classesAnchorArray)) {
						if (!in_array($class, $classesAnchor['all']) || (in_array($class, $classesAnchor['all']) && is_array($classesAnchor[$anchorType]) && in_array($class, $classesAnchor[$anchorType]))) {
							$selected = '';
							if ($this->setClass == $class) $selected = 'selected="selected"';
							if (!$this->setClass && $classesAnchorDefault[$anchorType] == $class) {
								$selected = 'selected="selected"';
							}
							$this->classesAnchorJSOptions[$anchorType] .= '<option ' . $selected . ' value="' .$class . '">' . $class . '</option>';
						}
					}
					if ($this->classesAnchorJSOptions[$anchorType]) {
						$selected = '';
						if (!$this->setClass && !$classesAnchorDefault[$anchorType])  $selected = 'selected="selected"';
						$this->classesAnchorJSOptions[$anchorType] =  '<option ' . $selected . ' value=""></option>' . $this->classesAnchorJSOptions[$anchorType];
					}
				}
			}
		}

			// Initializing the target value (RTE)
		$this->setTarget = $this->curUrlArray['target'];
		if ($this->thisConfig['defaultLinkTarget'] && !isset($this->curUrlArray['target']))	{
			$this->setTarget=$this->thisConfig['defaultLinkTarget'];
		}

			// Creating backend template object:
		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->docType= 'xhtml_trans';
		$this->doc->backPath = $BACK_PATH;

			// BEGIN accumulation of header JavaScript:
		$JScode = '';
		$JScode.= '
			if (window.opener && !window.opener.closed) {
				var editor = window.opener.RTEarea[' . $this->editorNo . ']["editor"];
				var HTMLArea = window.opener.HTMLArea;
			}
				// This JavaScript is primarily for RTE/Link. jumpToUrl is used in the other cases as well...
			var add_href="'.($this->curUrlArray['href']?'&curUrl[href]='.rawurlencode($this->curUrlArray['href']):'').'";
			var add_target="'.($this->setTarget?'&curUrl[target]='.rawurlencode($this->setTarget):'').'";
			var add_class="'.($this->setClass?'&curUrl[class]='.rawurlencode($this->setClass):'').'";
			var add_title="'.($this->setTitle?'&curUrl[title]='.rawurlencode($this->setTitle):'').'";
			var add_params="'.($this->bparams?'&bparams='.rawurlencode($this->bparams):'').'";

			var cur_href="'.($this->curUrlArray['href']?$this->curUrlArray['href']:'').'";
			var cur_target="'.($this->setTarget?$this->setTarget:'').'";
			var cur_class="'.($this->setClass?$this->setClass:'').'";
			var cur_title="'.($this->setTitle?$this->setTitle:'').'";

			function setTarget(value)	{
				cur_target=value;
				add_target="&curUrl[target]="+encodeURIComponent(value);
			}
			function setClass(value)	{
				cur_class=value;
				add_class="&curUrl[class]="+encodeURIComponent(value);
			}
			function setTitle(value)	{
				cur_title=value;
				add_title="&curUrl[title]="+encodeURIComponent(value);
			}
			function setValue(value)	{
				cur_href=value;
				add_href="&curUrl[href]="+value;
			}
';

		if ($this->mode=='wizard')	{	// Functions used, if the link selector is in wizard mode (= TCEforms fields)
			if (!$this->areFieldChangeFunctionsValid()) {
				$this->P['fieldChangeFunc'] = array();
			}
			unset($this->P['fieldChangeFunc']['alert']);
			reset($this->P['fieldChangeFunc']);
			$update='';
			while(list($k,$v)=each($this->P['fieldChangeFunc']))	{

				$update.= '
				window.opener.'.$v;
			}

			$P2=array();
			$P2['itemName']=$this->P['itemName'];
			$P2['formName']=$this->P['formName'];
			$P2['fieldChangeFunc']=$this->P['fieldChangeFunc'];
			$addPassOnParams.=t3lib_div::implodeArrayForUrl('P',$P2);

			$JScode.='
				function link_typo3Page(id,anchor)	{	//
					updateValueInMainForm(id+(anchor?anchor:"")+" "+cur_target);
					close();
					return false;
				}
				function link_folder(folder)	{	//
					updateValueInMainForm(folder+" "+cur_target);
					close();
					return false;
				}
				function link_current()	{	//
					if (cur_href!="http://" && cur_href!="mailto:")	{
						var setValue = cur_href+" "+cur_target+" "+cur_class+" "+cur_title;
						if (setValue.substr(0,7)=="http://")	setValue = setValue.substr(7);
						if (setValue.substr(0,7)=="mailto:")	setValue = setValue.substr(7);
						updateValueInMainForm(setValue);
						close();
					}
					return false;
				}
				function checkReference()	{	//
					if (window.opener && window.opener.document && window.opener.document.'.$this->P['formName'].' && window.opener.document.'.$this->P['formName'].'["'.$this->P['itemName'].'"] )	{
						return window.opener.document.'.$this->P['formName'].'["'.$this->P['itemName'].'"];
					} else {
						close();
					}
				}
				function updateValueInMainForm(input)	{	//
					var field = checkReference();
					if (field)	{
						field.value = input;
						'.$update.'
					}
				}
			';
		} else {	// Functions used, if the link selector is in RTE mode:
			$JScode.='
				function link_typo3Page(id,anchor)	{
					var theLink = \''.$this->siteURL.'?id=\'+id+(anchor?anchor:"");
					if (document.ltargetform.anchor_title) setTitle(document.ltargetform.anchor_title.value);
					if (document.ltargetform.anchor_class) setClass(document.ltargetform.anchor_class.value);
					editor.renderPopup_addLink(theLink,cur_target,cur_class,cur_title);
					return false;
				}
				function link_folder(folder)	{	//
					var theLink = \''.$this->siteURL.'\'+folder;
					if (document.ltargetform.anchor_title) setTitle(document.ltargetform.anchor_title.value);
					if (document.ltargetform.anchor_class) setClass(document.ltargetform.anchor_class.value);
					editor.renderPopup_addLink(theLink,cur_target,cur_class,cur_title);
					return false;
				}
				function link_spec(theLink)	{	//
					if (document.ltargetform.anchor_title) setTitle(document.ltargetform.anchor_title.value);
					if (document.ltargetform.anchor_class) setClass(document.ltargetform.anchor_class.value);
					editor.renderPopup_addLink(theLink,cur_target,cur_class,cur_title);
					return false;
				}
				function link_current()	{	//
					if (document.ltargetform.anchor_title) setTitle(document.ltargetform.anchor_title.value);
					if (document.ltargetform.anchor_class) setClass(document.ltargetform.anchor_class.value);
					if (cur_href!="http://" && cur_href!="mailto:")	{
						editor.renderPopup_addLink(cur_href,cur_target,cur_class,cur_title);
					}
					return false;
				}
			';
		}

			// General "jumpToUrl" function:
		$JScode.='
			function jumpToUrl(URL,anchor)	{	//
				var add_editorNo = URL.indexOf("editorNo=")==-1 ? "&editorNo='.$this->editorNo.'" : "";
				var add_contentTypo3Language = URL.indexOf("contentTypo3Language=")==-1 ? "&contentTypo3Language='.$this->contentTypo3Language.'" : "";
				var add_contentTypo3Charset = URL.indexOf("contentTypo3Charset=")==-1 ? "&contentTypo3Charset='.$this->contentTypo3Charset.'" : "";
				var add_act = URL.indexOf("act=")==-1 ? "&act='.$this->act.'" : "";
				var add_mode = URL.indexOf("mode=")==-1 ? "&mode='.$this->mode.'" : "";
				var theLocation = URL+add_act+add_editorNo+add_contentTypo3Language+add_contentTypo3Charset+add_mode+add_href+add_target+add_class+add_title+add_params'.($addPassOnParams?'+"'.$addPassOnParams.'"':'').'+(anchor?anchor:"");
				window.location.href = theLocation;
				return false;
			}
		';

			// This is JavaScript especially for the TBE Element Browser!
		$pArr = explode('|',$this->bparams);
		$formFieldName = 'data['.$pArr[0].']['.$pArr[1].']['.$pArr[2].']';
		$JScode.='
			var elRef="";
			var targetDoc="";

			function launchView(url)	{	//
				var thePreviewWindow="";
				thePreviewWindow = window.open("' . $BACK_PATH . 'show_item.php?table="+url,"ShowItem","height=300,width=410,status=0,menubar=0,resizable=0,location=0,directories=0,scrollbars=1,toolbar=0");
				if (thePreviewWindow && thePreviewWindow.focus)	{
					thePreviewWindow.focus();
				}
			}
			function setReferences()	{	//
				if (parent.window.opener
				&& parent.window.opener.content
				&& parent.window.opener.content.document.editform
				&& parent.window.opener.content.document.editform["'.$formFieldName.'"]
						) {
					targetDoc = parent.window.opener.content.document;
					elRef = targetDoc.editform["'.$formFieldName.'"];
					return true;
				} else {
					return false;
				}
			}
			function insertElement(table, uid, type, filename,fp,filetype,imagefile,action, close)	{	//
				if (1=='.($pArr[0]&&!$pArr[1]&&!$pArr[2] ? 1 : 0).')	{
					addElement(filename,table+"_"+uid,fp,close);
				} else {
					if (setReferences())	{
						parent.window.opener.group_change("add","'.$pArr[0].'","'.$pArr[1].'","'.$pArr[2].'",elRef,targetDoc);
					} else {
						alert("Error - reference to main window is not set properly!");
					}
					if (close)	{
						parent.window.opener.focus();
						parent.close();
					}
				}
				return false;
			}
			function addElement(elName,elValue,altElValue,close)	{	//
				if (parent.window.opener && parent.window.opener.setFormValueFromBrowseWin)	{
					parent.window.opener.setFormValueFromBrowseWin("'.$pArr[0].'",altElValue?altElValue:elValue,elName);
					if (close)	{
						parent.window.opener.focus();
						parent.close();
					}
				} else {
					alert("Error - reference to main window is not set properly!");
					parent.close();
				}
			}
		';

			// Finally, add the accumulated JavaScript to the template object:
		$this->doc->JScode = $this->doc->wrapScriptTags($JScode);

			// Debugging:
		if (FALSE) debug(array(
			'pointer' => $this->pointer,
			'act' => $this->act,
			'mode' => $this->mode,
			'curUrlInfo' => $this->curUrlInfo,
			'curUrlArray' => $this->curUrlArray,
			'P' => $this->P,
			'bparams' => $this->bparams,
			'RTEtsConfigParams' => $this->RTEtsConfigParams,
			'expandPage' => $this->expandPage,
			'expandFolder' => $this->expandFolder,
			'PM' => $this->PM,
		),'Internal variables of Script Class:');
	}

	/******************************************************************
	 *
	 * Main functions
	 *
	 ******************************************************************/
	/**
	 * Rich Text Editor (RTE) link selector (MAIN function)
	 * Generates the link selector for the Rich Text Editor.
	 * Can also be used to select links for the TCEforms (see $wiz)
	 *
	 * @param	boolean		If set, the "remove link" is not shown in the menu: Used for the "Select link" wizard which is used by the TCEforms
	 * @return	string		Modified content variable.
	 */
	function main_rte($wiz=0)	{
		global $LANG, $BE_USER, $BACK_PATH;

			// Starting content:
		$content=$this->doc->startPage($LANG->getLL('Insert/Modify Link',1));

			// Initializing the action value, possibly removing blinded values etc:
		$allowedItems = explode(',','page,file,url,mail,spec');
		if (is_array($this->buttonConfig['options.']) && $this->buttonConfig['options.']['removeItems']) {
			$allowedItems = array_diff($allowedItems,t3lib_div::trimExplode(',',$this->buttonConfig['options.']['removeItems'],1));
		} else {
			$allowedItems = array_diff($allowedItems,t3lib_div::trimExplode(',',$this->thisConfig['blindLinkOptions'],1));
		}
		reset($allowedItems);
		if (!in_array($this->act,$allowedItems)) {
			$this->act = current($allowedItems);
		}
		
			// Making menu in top:
		$menuDef = array();
		if (!$wiz)	{
			$menuDef['removeLink']['isActive'] = $this->act=='removeLink';
			$menuDef['removeLink']['label'] = $LANG->getLL('removeLink',1);
			$menuDef['removeLink']['url'] = '#';
			$menuDef['removeLink']['addParams'] = 'onclick="editor.renderPopup_unLink();return false;"';
		}
		if (in_array('page',$allowedItems)) {
			$menuDef['page']['isActive'] = $this->act=='page';
			$menuDef['page']['label'] = $LANG->getLL('page',1);
			$menuDef['page']['url'] = '#';
			$menuDef['page']['addParams'] = 'onclick="jumpToUrl(\'?act=page&editorNo='.$this->editorNo.'&contentTypo3Language='.$this->contentTypo3Language.'&contentTypo3Charset='.$this->contentTypo3Charset.'\');return false;"';
		}
		if (in_array('file',$allowedItems)){
			$menuDef['file']['isActive'] = $this->act=='file';
			$menuDef['file']['label'] = $LANG->getLL('file',1);
			$menuDef['file']['url'] = '#';
			$menuDef['file']['addParams'] = 'onclick="jumpToUrl(\'?act=file&editorNo='.$this->editorNo.'&contentTypo3Language='.$this->contentTypo3Language.'&contentTypo3Charset='.$this->contentTypo3Charset.'\');return false;"';
		}
		if (in_array('url',$allowedItems)) {
			$menuDef['url']['isActive'] = $this->act=='url';
			$menuDef['url']['label'] = $LANG->getLL('extUrl',1);
			$menuDef['url']['url'] = '#';
			$menuDef['url']['addParams'] = 'onclick="jumpToUrl(\'?act=url&editorNo='.$this->editorNo.'&contentTypo3Language='.$this->contentTypo3Language.'&contentTypo3Charset='.$this->contentTypo3Charset.'\');return false;"';
		}
		if (in_array('mail',$allowedItems)) {
			$menuDef['mail']['isActive'] = $this->act=='mail';
			$menuDef['mail']['label'] = $LANG->getLL('email',1);
			$menuDef['mail']['url'] = '#';
			$menuDef['mail']['addParams'] = 'onclick="jumpToUrl(\'?act=mail&editorNo='.$this->editorNo.'&contentTypo3Language='.$this->contentTypo3Language.'&contentTypo3Charset='.$this->contentTypo3Charset.'\');return false;"';
		}
		if (is_array($this->thisConfig['userLinks.']) && in_array('spec',$allowedItems)) {
			$menuDef['spec']['isActive'] = $this->act=='spec';
			$menuDef['spec']['label'] = $LANG->getLL('special',1);
			$menuDef['spec']['url'] = '#';
			$menuDef['spec']['addParams'] = 'onclick="jumpToUrl(\'?act=spec&editorNo='.$this->editorNo.'&contentTypo3Language='.$this->contentTypo3Language.'&contentTypo3Charset='.$this->contentTypo3Charset.'\');return false;"';
		}
		$content .= $this->doc->getTabMenuRaw($menuDef);

			// Adding the menu and header to the top of page:
		$content.=$this->printCurrentUrl($this->curUrlInfo['info']).'<br />';
		
			// Depending on the current action we will create the actual module content for selecting a link:
		switch($this->act)	{
			case 'mail':
				$extUrl='
			<!--
				Enter mail address:
			-->
					<form action="" name="lurlform" id="lurlform">
						<table border="0" cellpadding="2" cellspacing="1" id="typo3-linkMail">
							<tr>
								<td>'.$LANG->getLL('emailAddress',1).':</td>
								<td><input type="text" name="lemail"'.$this->doc->formWidth(20).' value="'.htmlspecialchars($this->curUrlInfo['act']=='mail'?$this->curUrlInfo['info']:'').'" /> '.
									'<input type="submit" value="'.$LANG->getLL('setLink',1).'" onclick="setTarget(\'\');setValue(\'mailto:\'+document.lurlform.lemail.value); return link_current();" /></td>
							</tr>
						</table>
					</form>';
				$content.=$extUrl;
				$content.=$this->addAttributesForm();
			break;
			case 'url':
				$extUrl='
			<!--
				Enter External URL:
			-->
					<form action="" name="lurlform" id="lurlform">
						<table border="0" cellpadding="2" cellspacing="1" id="typo3-linkURL">
							<tr>
								<td>URL:</td>
								<td><input type="text" name="lurl"'.$this->doc->formWidth(20).' value="'.htmlspecialchars($this->curUrlInfo['act']=='url'?$this->curUrlInfo['info']:'http://').'" /> '.
									'<input type="submit" value="'.$LANG->getLL('setLink',1).'" onclick="if (/^[A-Za-z0-9_+]{1,8}:/i.test(document.lurlform.lurl.value)) { setValue(document.lurlform.lurl.value); } else { setValue(\'http://\'+document.lurlform.lurl.value); }; return link_current();" /></td>
							</tr>
						</table>
					</form>';
				$content.=$extUrl;
				$content.=$this->addAttributesForm();
			break;
			case 'file':
				$content.=$this->addAttributesForm();
				
				$foldertree = t3lib_div::makeInstance('tx_rtehtmlarea_folderTree');
				$tree=$foldertree->getBrowsableTree();

				if (!$this->curUrlInfo['value'] || $this->curUrlInfo['act']!='file')	{
					$cmpPath='';
				} elseif (substr(trim($this->curUrlInfo['info']),-1)!='/')	{
					$cmpPath=PATH_site.dirname($this->curUrlInfo['info']).'/';
					if (!isset($this->expandFolder)) $this->expandFolder = $cmpPath;
				} else {
					$cmpPath=PATH_site.$this->curUrlInfo['info'];
				}

				list(,,$specUid) = explode('_',$this->PM);
				$files = $this->expandFolder($foldertree->specUIDmap[$specUid]);

					// Create upload/create folder forms, if a path is given:
				if ($BE_USER->getTSConfigVal('options.uploadFieldsInTopOfEB')) {
					$fileProcessor = t3lib_div::makeInstance('t3lib_basicFileFunctions');
					$fileProcessor->init($GLOBALS['FILEMOUNTS'], $GLOBALS['TYPO3_CONF_VARS']['BE']['fileExtensions']);
					$path=$this->expandFolder;
					if (!$path || !@is_dir($path))	{
						$path = $fileProcessor->findTempFolder().'/';	// The closest TEMP-path is found
					}
					if ($path!='/' && @is_dir($path))	{
						$uploadForm=$this->uploadForm($path);
						$createFolder=$this->createFolder($path);
					} else {
						$createFolder='';
						$uploadForm='';
					}
					$content.=$uploadForm;
					if ($BE_USER->isAdmin() || $BE_USER->getTSConfigVal('options.createFoldersInEB')) {
						$content.=$createFolder;
					}
				}

				$content.= '
			<!--
			Wrapper table for folder tree / file list:
			-->
					<table border="0" cellpadding="0" cellspacing="0" id="typo3-linkFiles">
						<tr>
							<td class="c-wCell" valign="top">'.$this->barheader($LANG->getLL('folderTree').':').$tree.'</td>
							<td class="c-wCell" valign="top">'.$files.'</td>
						</tr>
					</table>
					';
			break;
			case 'spec':
				if (is_array($this->thisConfig['userLinks.']))	{
					$subcats=array();
					$v=$this->thisConfig['userLinks.'];
					reset($v);
					while(list($k2)=each($v))	{
						$k2i = intval($k2);
						if (substr($k2,-1)=='.' && is_array($v[$k2i.'.']))	{

								// Title:
							$title = trim($v[$k2i]);
							if (!$title)	{
								$title=$v[$k2i.'.']['url'];
							} else {
								$title=$LANG->sL($title);
							}
								// Description:
							$description=$v[$k2i.'.']['description'] ? $LANG->sL($v[$k2i.'.']['description'],1).'<br />' : '';

								// URL + onclick event:
							$onClickEvent='';
							if (isset($v[$k2i.'.']['target']))	$onClickEvent.="setTarget('".$v[$k2i.'.']['target']."');";
							$v[$k2i.'.']['url'] = str_replace('###_URL###',$this->siteURL,$v[$k2i.'.']['url']);
							if (substr($v[$k2i.'.']['url'],0,7)=="http://" || substr($v[$k2i.'.']['url'],0,7)=='mailto:')	{
								$onClickEvent.="cur_href=unescape('".rawurlencode($v[$k2i.'.']['url'])."');link_current();";
							} else {
								$onClickEvent.="link_spec(unescape('".$this->siteURL.rawurlencode($v[$k2i.'.']['url'])."'));";
							}

								// Link:
							$A=array('<a href="#" onclick="'.htmlspecialchars($onClickEvent).'return false;">','</a>');

								// Adding link to menu of user defined links:
							$subcats[$k2i]='
								<tr>
									<td class="bgColor4">'.$A[0].'<strong>'.htmlspecialchars($title).($this->curUrlInfo['info']==$v[$k2i.'.']['url']?'<img'.t3lib_iconWorks::skinImg($BACK_PATH,'gfx/blinkarrow_right.gif','width="5" height="9"').' class="c-blinkArrowR" alt="" />':'').'</strong><br />'.$description.$A[1].'</td>
								</tr>';
						}
					}

						// Sort by keys:
					ksort($subcats);

						// Add menu to content:
					$content.= '
			<!--
				Special userdefined menu:
			-->
						<table border="0" cellpadding="1" cellspacing="1" id="typo3-linkSpecial">
							<tr>
								<td class="bgColor5" class="c-wCell" valign="top"><strong>'.$LANG->getLL('special',1).'</strong></td>
							</tr>
							'.implode('',$subcats).'
						</table>
						';
				}
			break;
			case 'page':
			default:
				$content.=$this->addAttributesForm();
				
				$pagetree = t3lib_div::makeInstance('tx_rtehtmlarea_pageTree');
				$tree=$pagetree->getBrowsableTree();
				$cElements = $this->expandPage();
				$content.= '
			<!--
				Wrapper table for page tree / record list:
			-->
					<table border="0" cellpadding="0" cellspacing="0" id="typo3-linkPages">
						<tr>
							<td class="c-wCell" valign="top">'.$this->barheader($LANG->getLL('pageTree').':').$tree.'</td>
							<td class="c-wCell" valign="top">'.$cElements.'</td>
						</tr>
					</table>
					';
			break;
		}

			// End page, return content:
		$content.= $this->doc->endPage();
		return $content;
	}
	
	function addAttributesForm() {
		$ltargetForm = '';
			// Add target and class selector box and title field:
		$ltarget = $this->addTargetSelector();
		$lclass = $this->addClassSelector();
		$ltitle = $this->addTitleSelector();
		if ($ltarget || $lclass || $ltitle) {
			$ltargetForm = $this->wrapInForm($ltarget.$lclass.$ltitle);
		}
		return $ltargetForm;
	}
	
	function wrapInForm($string) {
		global $LANG;
		
		$form = '
			<!--
				Selecting target for link:
			-->
				<form action="" name="ltargetform" id="ltargetform">
					<table border="0" cellpadding="2" cellspacing="1" id="typo3-linkTarget">'. $string;
		if ((($this->act == 'page' && $this->curUrlInfo['act']=='page') || ($this->act == 'file' && $this->curUrlInfo['act']=='file') || ($this->act == 'url' && $this->curUrlInfo['act']!='page')) && $this->curUrlArray['href']) {
			$form .='
						<tr>
							<td>
							</td>
							<td colspan="3">
								<input type="submit" value="'.$LANG->getLL('update',1).'" onclick="return link_current();" />
							</td>
						</tr>';
		}
		$form .= '
					</table>
				</form>';
		return $form;
	}
	
	function addTargetSelector() {
		global $LANG;
		
		$targetSelectorConfig = array();
		$popupSelectorConfig = array();
		if (is_array($this->buttonConfig['targetSelector.'])) {
			$targetSelectorConfig = $this->buttonConfig['targetSelector.'];
		}
		if (is_array($this->buttonConfig['popupSelector.'])) {
			$popupSelectorConfig = $this->buttonConfig['popupSelector.'];
		}
		
		$ltarget = '';
		if ($this->act != 'mail')	{
			if (!($targetSelectorConfig['disabled'] && $popupSelectorConfig['disabled'])) {
				$ltarget .= '
						<tr>
							<td>'.$LANG->getLL('target',1).':</td>
							<td><input type="text" name="ltarget" onchange="setTarget(this.value);" value="'.htmlspecialchars($this->setTarget).'"'.$this->doc->formWidth(10).' /></td>';
				$ltarget .= '
							<td colspan="2">';
				if (!$targetSelectorConfig['disabled']) {
					$ltarget .= '
								<select name="ltarget_type" onchange="setTarget(this.options[this.selectedIndex].value);document.ltargetform.ltarget.value=this.options[this.selectedIndex].value;this.selectedIndex=0;">
									<option></option>
									<option value="_top">'.$LANG->getLL('top',1).'</option>
									<option value="_blank">'.$LANG->getLL('newWindow',1).'</option>
								</select>';
				}
				$ltarget .= '
							</td>';
			}
			
			$ltarget .= '
						</tr>';
			if (!$popupSelectorConfig['disabled']) {
				
				$selectJS = 'if (document.ltargetform.popup_width.options[document.ltargetform.popup_width.selectedIndex].value>0 && document.ltargetform.popup_height.options[document.ltargetform.popup_height.selectedIndex].value>0)	{
					document.ltargetform.ltarget.value = document.ltargetform.popup_width.options[document.ltargetform.popup_width.selectedIndex].value+\'x\'+document.ltargetform.popup_height.options[document.ltargetform.popup_height.selectedIndex].value;
					setTarget(document.ltargetform.ltarget.value);
					document.ltargetform.popup_width.selectedIndex=0;
					document.ltargetform.popup_height.selectedIndex=0;
				}';

				$ltarget.='
						<tr>
							<td>'.$LANG->getLL('target_popUpWindow',1).':</td>
							<td colspan="3">
								<select name="popup_width" onchange="'.$selectJS.'">
									<option value="0">'.$LANG->getLL('target_popUpWindow_width',1).'</option>
									<option value="300">300</option>
									<option value="400">400</option>
									<option value="500">500</option>
									<option value="600">600</option>
									<option value="700">700</option>
									<option value="800">800</option>
								</select>
								x
								<select name="popup_height" onchange="'.$selectJS.'">
									<option value="0">'.$LANG->getLL('target_popUpWindow_height',1).'</option>
									<option value="200">200</option>
									<option value="300">300</option>
									<option value="400">400</option>
									<option value="500">500</option>
									<option value="600">600</option>
								</select>
							</td>
						</tr>';
			}
		}
		return $ltarget;
	}
	
	function addClassSelector() {
		global $LANG;
		
		$selectClass = '';
		if ($this->classesAnchorJSOptions[$this->act]) {
			$selectClassJS = '
					document.ltargetform.anchor_class.value = document.ltargetform.anchor_class.options[document.ltargetform.anchor_class.selectedIndex].value;
					if(document.ltargetform.anchor_class.value && editor.classesAnchorSetup) {
						for (var i = editor.classesAnchorSetup.length; --i >= 0;) {
							var anchorClass = editor.classesAnchorSetup[i];
							if (anchorClass[\'name\'] == document.ltargetform.anchor_class.value) {
								if(anchorClass[\'titleText\'] && document.ltargetform.anchor_title) document.ltargetform.anchor_title.value = anchorClass[\'titleText\'];
								break;
							}
						}
					}
					setClass(document.ltargetform.anchor_class.value);
				';
			$selectClass ='
						<tr>
							<td>'.$LANG->getLL('anchor_class',1).':</td>
							<td colspan="3">
								<select name="anchor_class" onchange="'.$selectClassJS.'">
									' . $this->classesAnchorJSOptions[$this->act] . '
								</select>
							</td>
						</tr>';
		}
		return $selectClass;
	}
	
	function addTitleSelector() {
		global $LANG;
		
		return '
						<tr>
							<td>'.$LANG->getLL('anchor_title',1).':</td>
							<td colspan="3">
								<input type="text" name="anchor_title" value="' . ($this->setTitle?$this->setTitle:($this->thisConfig['classesAnchor']?$this->classesAnchorDefaultTitle[$this->act]:'')) . '" ' . $this->doc->formWidth(30) . ' />
							</td>
						</tr>';
	}
	
	/**
	 * For TBE: Makes an upload form for uploading files to the filemount the user is browsing.
	 * The files are uploaded to the tce_file.php script in the core which will handle the upload.
	 *
	 * @param	string		Absolute filepath on server to which to upload.
	 * @return	string		HTML for an upload form.
	 */
	function uploadForm($path)	{
		global $BACK_PATH;
		$count=3;

			// Create header, showing upload path:
		$header = t3lib_div::isFirstPartOfStr($path,PATH_site)?substr($path,strlen(PATH_site)):$path;
		$code=$this->barheader($GLOBALS['LANG']->getLL('uploadImage').':');
		$code.='

			<!--
				Form, for uploading files:
			-->
			<form action="'.$BACK_PATH.'tce_file.php" method="post" name="editform" enctype="'.$GLOBALS['TYPO3_CONF_VARS']['SYS']['form_enctype'].'">
				<table border="0" cellpadding="0" cellspacing="3" id="typo3-uplFiles">
					<tr>
						<td><strong>'.$GLOBALS['LANG']->getLL('path',1).':</strong> '.htmlspecialchars($header).'</td>
					</tr>
					<tr>
						<td>';

			// Traverse the number of upload fields (default is 3):
		for ($a=1;$a<=$count;$a++)	{
			$code.='<input type="file" name="upload_'.$a.'"'.$this->doc->formWidth(35).' size="50" />
				<input type="hidden" name="file[upload]['.$a.'][target]" value="'.htmlspecialchars($path).'" />
				<input type="hidden" name="file[upload]['.$a.'][data]" value="'.$a.'" /><br />';
		}

			// Make footer of upload form, including the submit button:
		$redirectValue = $this->thisScript.'?act='.$this->act.'&editorNo='.$this->editorNo.'&mode='.$this->mode.'&expandFolder='.rawurlencode($path).'&bparams='.rawurlencode($this->bparams);
		$code.='<input type="hidden" name="redirect" value="'.htmlspecialchars($redirectValue).'" />'.
				'<input type="submit" name="submit" value="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:file_upload.php.submit',1).'" />';

		$code.='
			<div id="c-override">
				<input type="checkbox" name="overwriteExistingFiles" value="1" /> '.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_misc.xml:overwriteExistingFiles',1).'
			</div>
		';


		$code.='</td>
					</tr>
				</table>
			</form>';

		return $code;
	}
	
	/**
	 * For TBE: Makes a form for creating new folders in the filemount the user is browsing.
	 * The folder creation request is sent to the tce_file.php script in the core which will handle the creation.
	 *
	 * @param	string		Absolute filepath on server in which to create the new folder.
	 * @return	string		HTML for the create folder form.
	 */
	function createFolder($path)	{
		global $BACK_PATH;
			// Create header, showing upload path:
		$header = t3lib_div::isFirstPartOfStr($path,PATH_site)?substr($path,strlen(PATH_site)):$path;
		$code=$this->barheader($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:file_newfolder.php.pagetitle').':');
		$code.='

			<!--
				Form, for creating new folders:
			-->
			<form action="'.$BACK_PATH.'tce_file.php" method="post" name="editform2">
				<table border="0" cellpadding="0" cellspacing="3" id="typo3-crFolder">
					<tr>
						<td><strong>'.$GLOBALS['LANG']->getLL('path',1).':</strong> '.htmlspecialchars($header).'</td>
					</tr>
					<tr>
						<td>';

			// Create the new-folder name field:
		$a=1;
		$code.='<input'.$this->doc->formWidth(20).' type="text" name="file[newfolder]['.$a.'][data]" />'.
				'<input type="hidden" name="file[newfolder]['.$a.'][target]" value="'.htmlspecialchars($path).'" />';

			// Make footer of upload form, including the submit button:
		$redirectValue = $this->thisScript.'?act='.$this->act.'&editorNo='.$this->editorNo.'&mode='.$this->mode.'&expandFolder='.rawurlencode($path).'&bparams='.rawurlencode($this->bparams);
		$code.='<input type="hidden" name="redirect" value="'.htmlspecialchars($redirectValue).'" />'.
				'<input type="submit" name="submit" value="'.$GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:file_newfolder.php.submit',1).'" />';

		$code.='</td>
					</tr>
				</table>
			</form>';

		return $code;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/rtehtmlarea/mod3/class.tx_rtehtmlarea_browse_links.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/rtehtmlarea/mod3/class.tx_rtehtmlarea_browse_links.php']);
}

?>