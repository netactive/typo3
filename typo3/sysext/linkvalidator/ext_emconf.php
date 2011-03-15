<?php

########################################################################
# Extension Manager/Repository config file for ext "linkvalidator".
#
# Auto generated 26-01-2011 20:08
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Linkvalidator',
	'description' => 'Linkvalidator checks the links in your website for validity. It can validate all kinds of links: internal, external and file links. Scheduler is supported to run Linkvalidator via Cron including the option to send status mails, if broken links were detected.',
	'category' => 'module',
	'author' => 'Jochen Rieger / Dimitri König / Michael Miousse',
	'author_email' => 'j.rieger@connecta.ag, mmiousse@infoglobe.ca',
	'shy' => '',
	'dependencies' => 'info',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => 'Connecta AG / cab services ag / Infoglobe',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.1.0-0.0.0',
			'php' => '5.0.0-0.0.0',
			'info' => '1.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:26:{s:9:"ChangeLog";s:4:"8fc2";s:16:"ext_autoload.php";s:4:"4efa";s:12:"ext_icon.gif";s:4:"838b";s:17:"ext_localconf.php";s:4:"5e6f";s:14:"ext_tables.php";s:4:"1679";s:14:"ext_tables.sql";s:4:"2489";s:13:"locallang.xml";s:4:"15c4";s:44:"classes/class.tx_linkvalidator_processor.php";s:4:"2d9e";s:61:"classes/linktype/class.tx_linkvalidator_linktype_abstract.php";s:4:"4c43";s:61:"classes/linktype/class.tx_linkvalidator_linktype_external.php";s:4:"83ce";s:57:"classes/linktype/class.tx_linkvalidator_linktype_file.php";s:4:"0a91";s:62:"classes/linktype/class.tx_linkvalidator_linktype_interface.php";s:4:"b40b";s:61:"classes/linktype/class.tx_linkvalidator_linktype_internal.php";s:4:"e9b4";s:64:"classes/linktype/class.tx_linkvalidator_linktype_linkhandler.php";s:4:"49b6";s:56:"classes/tasks/class.tx_linkvalidator_tasks_validator.php";s:4:"2442";s:79:"classes/tasks/class.tx_linkvalidator_tasks_validatoradditionalfieldprovider.php";s:4:"7681";s:14:"doc/manual.sxw";s:4:"a197";s:14:"doc/manual.txt";s:4:"6862";s:54:"modfuncreport/class.tx_linkvalidator_modfuncreport.php";s:4:"6d84";s:27:"modfuncreport/locallang.xml";s:4:"de5c";s:31:"modfuncreport/locallang_csh.xml";s:4:"39e9";s:31:"modfuncreport/locallang_mod.xml";s:4:"e370";s:31:"modfuncreport/mod_template.html";s:4:"4c0f";s:21:"res/linkvalidator.css";s:4:"77b4";s:21:"res/mailtemplate.html";s:4:"c425";s:20:"res/pagetsconfig.txt";s:4:"93e0";}',
	'suggests' => array(
	),
);

?>