<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
$TCA['sys_category'] = array(
	'ctrl' => $TCA['sys_category']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,description'
	),
	'types' => array(
		'1' => array('showitem' => 'title;;1, parent,description,--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.items,items,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime')
	),
	'palettes' => array(
		'1' => array('showitem' => 'sys_language_uid, l10n_parent, hidden')
	),
	'columns' => array(
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'max' => '30'
			)
		),
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0)
				),
				'foreign_table' => 'sys_category',
				'foreign_table_where' => 'AND sys_category.uid=###REC_FIELD_l10n_parent### AND sys_category.sys_language_uid IN (-1,0)'
			)
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type' => 'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check'
			)
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => '10',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0',
				'range' => array(
					'upper' => mktime(0, 0, 0, 12, 31, date('Y') + 10),
					'lower' => mktime(0, 0, 0, date('m') - 1, date('d'), date('Y'))
				)
			)
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_category.title',
			'config' => array(
				'type' => 'input',
				'width' => '200',
				'eval' => 'trim,required'
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_category.description',
			'config' => array(
				'type' => 'text'
			)
		),
		'parent' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_category.parent',
			'config' => array(
				'minitems' => 0,
				'maxitems' => 1,
				'type' => 'select',
				'renderMode' => 'tree',
				'foreign_table' => 'sys_category',
				'foreign_table_where' => ' ORDER BY sys_category.title ASC',
				'treeConfig' => array(
					'parentField' => 'parent'
				)
			)
		),
		'items' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_category.items',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => '*',
				'MM' => 'sys_category_record_mm',
				'show_thumbs' => FALSE
			)
		)
	)
);
?>