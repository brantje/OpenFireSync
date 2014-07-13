<?php
/**
 * ownCloud - openfiresync
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Sander Brand <brantje@gmail.com>
 * @copyright Sander Brand 2014
 */

namespace OCA\OpenfireSync\AppInfo;


\OCP\App::registerAdmin('openfiresync', 'admin');


$app = new Application();
$app->getContainer()->query('UserHooks')->register();