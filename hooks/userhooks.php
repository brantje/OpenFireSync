<?php
namespace OCA\OpenfireSync\Hooks;

class UserHooks {

	private $userManager;
	private $logger;
	private $appName;
	private $openfireController;

	public function __construct($userManager, $logger, $appName, $userId, $openfireController) {
		$this -> userManager = $userManager;
		$this -> groupManager = $groupManager;
		$this -> logger = $logger;
		$this -> appName = $appName;
		$this -> openfireController = $openfireController;
	}

	public function register() {

		/**
		 * Before the user is deleted
		 */
		$preDelete = function($user, $a) {
			$this -> openfireController -> deleteOpenFireUser($user);
		};
		$this -> userManager -> listen('\OC\User', 'postDelete', $preDelete);

		/**
		 * Before the user is created
		 */
		$preCreateUser = function($user, $pw) {
			$this -> openfireController -> createOpenFireUser($user, $pw);
		};
		$this -> userManager -> listen('\OC\User', 'preCreateUser', $preCreateUser);

		/**
		 * After password change
		 */
		$postsetPassword = function($user, $pw) {
			$this -> openfireController -> updateOpenFireUser($user, $pw);
		};

		$this -> userManager -> listen('\OC\User', 'postSetPassword', $postsetPassword);

		/* Mange groups */
		$handleGroupChange = function($groups, $user) {
			$this -> logger -> info('lalalalala', array('app' => $this -> appName));
			//$this -> openfireController -> updateOpenFireGroups($groups, $user);
		};
		$this -> userManager -> listen('\OC\Group', 'postAddUser', $handleGroupChange);
		$this -> userManager -> listen('\OC\Group', 'postRemoveUser', $handleGroupChange);
	}

}
?>