<?php

namespace OCA\Openfiresync;


\OC_Util::checkAdminUser();
\OCP\Util::addScript('openfiresync', 'admin');
if($_POST) {
	// CSRF check
	\OCP\JSON::callCheck();

	if(isset($_POST['openfire_server_url'])) {
		\OC_CONFIG::setValue('openfire_server_url', strip_tags($_POST['openfire_server_url']));
		\OC_CONFIG::setValue('openfire_secret_key', strip_tags($_POST['openfire_secret_key']));
	}
}

// fill template
$tmpl = new \OCP\Template('openfiresync', 'admin');
$tmpl->assign('openfire_server_url', \OC_Config::getValue( "openfire_server_url" ));
$tmpl->assign('openfire_secret_key', \OC_Config::getValue( "openfire_secret_key" ));
return $tmpl->fetchPage();

