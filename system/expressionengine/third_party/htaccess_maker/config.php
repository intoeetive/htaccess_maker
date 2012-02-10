<?php

if ( ! defined('HTACCESS_MAKER_ADDON_NAME'))
{
	define('HTACCESS_MAKER_ADDON_NAME',         '.htaccess maker');
	define('HTACCESS_MAKER_ADDON_VERSION',      '1.1.1');
}

$config['name']=HTACCESS_MAKER_ADDON_NAME;
$config['version']=HTACCESS_MAKER_ADDON_VERSION;

$config['nsm_addon_updater']['versions_xml']='http://www.intoeetive.com/index.php/update.rss/37';