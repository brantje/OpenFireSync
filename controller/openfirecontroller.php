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

namespace OCA\OpenfireSync\Controller;

class OpenfireController {

	private $userId;
	private $config;
	private $logger;
	private $appName;

	public function __construct($appName, $request, $userId,  $logger) {
		$this -> userId = $userId;
		$this -> logger = $logger;
		$this -> appName = $appName;
	}

	public function getAppValue($key) {
		return $this -> config -> getAppValue($this -> appName, $key);
	}

	public function setAppValue($key, $value) {
		$this -> config -> setAppValue($this -> appName, $key, $value);
	}

	public function createOpenFireUser($user, $pw) {
		$params = array('type' => 'add', "username" => $user, 'password' => $pw, 'name' => $user, 'email' => $user . '@ownCloud');
		$this -> openFireRequest($params);
	}

	public function deleteOpenFireUser($user) {
		$params = array('type' => 'delete', 'username' => $user -> getUID());
		$this -> openFireRequest($params);
	}

	public function updateOpenFireUser($user, $pw) {
		$params = array('type' => 'update', "username" => $user -> getUID(), 'name' => $user -> getDisplayName(), 'password' => $pw, 'email' => $user . '@ownCloud');
		$this -> openFireRequest($params);
	}

	/**
	 * Handle groups serperate
	 */

	public function updateOpenFireGroups($group, $user) {
		$userGroups = OC_Group::getUserGroups($user);
		$g = array();
		foreach ($userGroups as $key => $group) {
			$this -> logger -> info(print_r($group,true), array('app' => $this -> appName));
		}
	}

	public function openFireRequest($params) {
		$secretKey = \OC_Config::getValue( "openfire_secret_key" );
		$host = \OC_Config::getValue( "openfire_server_url" );
		$paramsHTTP = http_build_query($params);
		$url = 'http://' . $host .  '/plugins/userService/userservice?secret=' . $secretKey . '&' . $paramsHTTP;

		$response = file_get_contents(str_replace('&amp;', '&', $url));
		$o = implode(', ', array_map(function($v, $k) {
			return $k . '=' . $v;
		}, $params, array_keys($params)));
		$this -> logger -> info('Parameters: ' . $o . ' URL: ' . $url . ' Response: ' . $response, array('app' => $this -> appName));
	}

}
