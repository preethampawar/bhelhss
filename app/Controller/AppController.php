<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('AccessController', 'Controller');
App::uses('Validation', 'Utility');
App::uses('Sanitize', 'Utility');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Security', 'Utility');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeEmail', 'Network/Email');
App::uses('ConnectionManager', 'Model');
App::uses('Payment', 'Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array('Html', 'Form', 'Session', 'Number', 'Js' => 'Jquery', 'Img', 'Time', 'Text');

	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => '/admin/categories/',
			'logoutRedirect' => '/',
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username' => 'email')
				)
			)
		),
		'Flash'
	);

	public function beforeFilter() {
		Configure::write('Security.salt', '');
		Security::setHash('md5');

		ini_set('max_execution_time', '10000');
		ini_set('memory_limit', '256M');

		// // Enable GZIP compression
		// if (Configure::read('debug') == 0) {
		// @ob_start ('ob_gzhandler');
		// header('Content-type: text/html; charset: UTF-8');
		// header('Cache-Control: must-revalidate');

		// $offset = 200;
		// $ExpStr = "Expires: " .gmdate('D, d M Y H:i:s',time() + $offset) .' GMT';
		// header($ExpStr);
		// }
		// $this->response->compress();

		if($this->request->isAjax()) {
			$this->layout = 'ajax';
		} else {
			$this->layout = $this->Session->check('Auth.User.id') ? 'default' : 'hss';
		}

//		if(!$this->Session->check('SiteVisitSet')) {
//			$count = (int)file_get_contents('site_visits');
//			$count++;
//			file_put_contents('site_visits', $count);
//			$this->Session->write('SiteVisitSet', true);
//		}
//		$visitCount = (int)file_get_contents('site_visits');
//		$this->Session->write('SiteVisitCount', $visitCount);



		if($this->Session->check('User')) {
			// Check if the logged in user has completed his profile and know the user type(student or teacher or pricipal or non teaching staff)
			$hasCompletedProfile = $this->Session->read('User.has_completed_profile');
			if(!$hasCompletedProfile) {
				$excludeActions = array('createProfile', 'logout');
				if(!in_array($this->action, $excludeActions)) {
					$this->redirect('/users/createProfile');
				}
			}

			// check if the user is trying to access admin methods.
			if(isset($this->request->params['admin'])) {
				if(!$this->Session->read('User.admin')) {
					$this->Session->setFlash('You are not authorized to view this page.');
					$this->redirect($this->request->referer());
				}
			}

		}
	}

	protected function showRegistrationMessage()
	{
		$memberInfo['AlumniMember'] = $this->Session->read('AlumniMember');
		if ($memberInfo['AlumniMember'] && !$this->Session->read('Auth.User.admin')) {
			$alumniMemberId = $memberInfo['AlumniMember']['id'];
			$paymentModel = new Payment();
			$conditions = [
				'Payment.alumni_member_id' => $alumniMemberId,
				'Payment.type' => 'event_registration_fee'
			];
			$isRegisteredCount = $paymentModel->find('count', ['conditions' => $conditions]);

			if ($isRegisteredCount < 1) {
				$this->Flash->set('You have not registered yourself for the upcoming Alumni event.
				<br><a href="/hss/event_registration" class="text-decoration-underline">Click here</a> to register.', ['element' => 'info']);
			}
		}
	}

	public function isModerator() {
		if($this->Session->check('User.id')) {
			if($this->Session->read('User.admin') or $this->Session->read('User.moderator')) {
				return true;
			}
		}
		return false;
	}

	public function checkModerator() {
		if($this->Session->check('User.id')) {
			if($this->Session->read('User.admin') or $this->Session->read('User.moderator')) {
				return true;
			}
		}

		$this->Session->setFlash("You are not authorized to view this page.", 'default', array('class'=>'success'));
		$this->redirect('/');
	}

	public function isCategory($categoryID) {
		App::uses('Category', 'Model');
		$this->Category = new Category;

		$this->Category->recursive = -1;
		$categoryInfo = $this->Category->findById($categoryID);
		return $categoryInfo;
	}

	/**
	 * Function to give user access to specific controllers and actions
	 */
	public function checkUserAccess() {
		$AccessController = new AccessController;
		$AccessController->constructClasses();

		$controller = $this->name;
		$action = $this->action;
		$allowed = $AccessController->checkUserAccess($controller, $action);

		return $allowed;
	}

	/**
	 * Function to check valid image size
	 */
	function isValidImageSize($imgSize) {
		if($imgSize > 0) {
			$maxSize = Configure::read('MaxImageSize');
			if(ceil($imgSize/(1024*1024)) > $maxSize) {
				return false;
			}
			else {
				return true;
			}
		}
		return false;
	}

	/**
	 * Function to check a valid image
	 */
	function isValidImage($image) {
		if(isset($image['tmp_name'])) {
			$info = getimagesize($image['tmp_name']);
			$validImage = false;
			if ($info) {
				switch ($info[2]) {
					case IMAGETYPE_GIF:
					case IMAGETYPE_JPEG:
					case IMAGETYPE_PNG:
						$validImage = true; break;
				}
			}
			return ($validImage) ? true : false;
		}
		return false;
	}

	function deleteImage($imageID) {
		// remove from images cache folder
		$imageCachePath = 'img/imagecache/';
		$imgCacheDir = new Folder();

		$imgCacheDir->path = $imageCachePath;
		$files = $imgCacheDir->find($imageID.'_.*');
		if(!empty($files)) {
			foreach($files as $file) {
				$cacheFilePath = $imageCachePath.$file;
				$file = new File($cacheFilePath);
				$file->delete();
			}
		}

		// remove from images folder
		$imagePath = 'img/images/'.$imageID;
		$file = new File($imagePath);
		$file->delete();

		// remove image from images table
		App::uses('Image', 'Model');
		$this->Image = new Image;
		$this->Image->delete($imageID);

		// remove image comments
		App::uses('Comment', 'Model');
		$this->Comment = new Comment;
		$this->Comment->deleteAll(array('Comment.image_id'=>$imageID));

		//remove info from activity table
		$this->deleteActivity(array('Activity.image_id'=>$imageID));

		return true;
	}


	/**
	 * Function to delete product by id
	 */
	function deletePost($postID, $categoryID) {
		App::uses('Category', 'Model');
		$this->Category = new Category;
		$this->Category->recursive = -1;

		App::uses('Post', 'Model');
		$this->Post = new Post;
		$this->Post->recursive = -1;

		// delete post images
		App::uses('Image', 'Model');
		$this->Image = new Image;
		$postImages = $this->Image->findAllByPostId($postID);
		if(!empty($postImages)) {
			foreach($postImages as $row) {
				$this->deleteImage($row['Image']['id']);
			}
		}

		// remove post comments
		App::uses('Comment', 'Model');
		$this->Comment = new Comment;
		$this->Comment->deleteAll(array('Comment.post_id'=>$postID));

		// remove post activity
		App::uses('Activity', 'Model');
		$this->Activity = new Activity;
		$this->Activity->deleteAll(array('Activity.post_id'=>$postID));

		// delete post from database
		$this->Post->delete($postID);

		return true;
	}

	/**
	 * Function to delete a category by id
	 */
	function deleteCategory($categoryID) {
		App::uses('Category', 'Model');
		$this->Category = new Category;

		$this->Category->recursive = -1;
		$categoryInfo = $this->Category->findById($categoryID);

		App::uses('Post', 'Model');
		$this->Post = new Post;
		$this->Post->recursive = -1;
		$posts = $this->Post->findAllByCategoryId($categoryID);

		try {
			// delete all posts
			if(!empty($posts)) {
				foreach($posts as $row) {
					$postID = $row['Post']['id'];
					$this->deletePost($postID, $categoryID);
				}
			}

			// delete category from database
			$this->Category->delete($categoryID);
		}
		catch(Exception $e) {
		}

		return true;
	}

	function saveActivity($data) {
		App::uses('Activity', 'Model');
		$this->Activity = new Activity;

		$data['Activity']['id'] = null;
		$data['Activity']['user_id'] = $this->Session->read('User.id');
		$data['Activity']['user_name'] = $this->Session->read('User.name');

		$this->Activity->save($data);
	}

	function deleteActivity($conditions) {
		App::uses('Activity', 'Model');
		$this->Activity = new Activity;
		if(!empty($conditions)) {
			$this->Activity->deleteAll($conditions);
		}

	}

	function sendBulkEmail($type=null, $subject=null, $message=null, $excludeUsers=array()) {
		return true;

		/*
		App::uses('User', 'Model');
		$this->User = new User;

		$conditions = array();
		switch($type) {
			case 'notification':
				$conditions = array('User.subscribe_to_notifications'=>'1');
				break;
			case 'news_letters':
				$conditions = array('User.subscribe_to_news_letters'=>'1');
				break;
			default:
				$conditions = array('User.subscribe_to_news_letters'=>'1', 'User.subscribe_to_notifications'=>'1');
				break;
		}

		$this->User->recursive = -1;
		$users = $this->User->find('all', array('conditions'=>$conditions, 'fields'=>array('User.id', 'User.name', 'User.email')));

		if(!empty($users)) {
			foreach($users as $row){
				$usersInfo[$row['User']['email']] = $row['User']['name'];
			}

			try {
				$email = new CakeEmail();
				$name = $row['User']['name'];
				$emailAddress = $row['User']['email'];

				$email->from(array('noreply@bhelhss.com' => 'bhelhss.com'));
				$email->to($usersInfo);
				$email->subject($subject);
				// $email->emailFormat('text');
				$email->send($message);
			}
			catch(Exception $e) {

			}
		}
		return true;
		*/
	}

	protected function getConnectionManager()
	{
		$host = ConnectionManager::getDataSource('default')->config['host'];
		$port = ConnectionManager::getDataSource('default')->config['port'];
		$datasource = ConnectionManager::getDataSource('default')->config['datasource'];
		$prefix = ConnectionManager::getDataSource('default')->config['prefix'];
		$database = ConnectionManager::getDataSource('default')->config['database'];
		$login = ConnectionManager::getDataSource('default')->config['login'];
		$password = ConnectionManager::getDataSource('default')->config['password'];

		return json_encode([
			'host' => $host,
			'port' => $port,
			'datasource' => $datasource,
			'prefix' => $prefix,
			'database' => $database,
			'login' => $login,
			'password' => $password
		]);
	}
}
