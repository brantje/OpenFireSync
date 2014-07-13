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


use \OCP\AppFramework\App;

use \OCA\OpenfireSync\Controller\OpenfireController;
use \OCA\OpenfireSync\Hooks\UserHooks;


class Application extends App {


	public function __construct (array $urlParams=array()) {
		parent::__construct('openfiresync', $urlParams);

		$container = $this->getContainer();

		/**
		 * Controllers
		 */
		$container->registerService('OpenfireController', function($c) {
			return new OpenfireController(
				$c->query('AppName'), 
				$c->query('Request'),
				$c->query('UserId'),
				$c->query('Logger')
			);
		});
		  /**
         * Controllers
         */
        $container->registerService('UserHooks', function($c) {
            return new UserHooks(
                $c->query('ServerContainer')->getUserManager(),
				$c->query('Logger'),
				$c->query('AppName'),
				$c->query('UserId'),
				$c->query('OpenfireController')
            );
        });

		/**
		 * Core
		 */
		$container->registerService('UserId', function($c) {
			return \OCP\User::getUser();
		});	
		$container->registerService('Logger', function($c) {
            return $c->query('ServerContainer')->getLogger();
        });		
	}


}