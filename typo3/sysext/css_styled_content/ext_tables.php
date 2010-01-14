<?php
# TYPO3 CVS ID: $Id: ext_tables.php 937 2005-12-26 23:59:37Z sebastian $
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

	// add flexform
t3lib_extMgm::addPiFlexFormValue('default', 'FILE:EXT:css_styled_content/flexform_ds.xml');
t3lib_extMgm::addToAllTCAtypes('tt_content','pi_flexform;;;;1-1-1','table');

t3lib_extMgm::addStaticFile($_EXTKEY,'static/','CSS Styled Content');
?>