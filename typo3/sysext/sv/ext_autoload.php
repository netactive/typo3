<?php
/*
 * Register necessary class names with autoloader
 *
 * $Id: ext_autoload.php 8157 2010-07-11 12:45:16Z psychomieze $
 */
$extensionPath = t3lib_extMgm::extPath('sv');
return array(
	'tx_sv_reports_serviceslist' => $extensionPath . 'reports/class.tx_sv_reports_serviceslist.php',
);
?>