<?php
App::uses('CakeEmail', 'Network/Email');
class PostsController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('show', 'showAll', 'showFeatured', 'details', 'getRecentVists', 'getMostViewedProducts', 'add', 'edit');
	}

	/**
	 * Function to show category posts
	 */
	function show($categoryID, $postID) {
		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'error'));
			$this->redirect($this->request->referer());
		}
		else {
			$this->Post->unbindModel(array('belongsTo'=>array('Category')));
			$this->Post->bindModel(array('hasMany'=>array('Image'=>array('conditions'=>array('Image.shared_photo NOT'=>'1')))));

			$postInfo = $this->Post->findById($postID);

			// Set post views
			$data['Post']['id'] = $postInfo['Post']['id'];
			$data['Post']['views'] = $postInfo['Post']['views']+1;
			$this->Post->save($data);

			if(!$postInfo) {
				$this->Session->setFlash('Page Not Found', 'default', array('class'=>'error'));
				$this->redirect($this->request->referer());
			}
		}
		$title_for_layout = $postInfo['Post']['title'];

		$this->set(compact('categoryInfo', 'postInfo', 'title_for_layout'));
	}


	/**
	 * Function to show all category posts
	 */
	function showAll($categoryID) {
		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'error'));
			$this->redirect($this->request->referer());
		}
		$title_for_layout = $categoryInfo['Category']['name'];

		$this->Post->unbindModel(array('belongsTo'=>array('Category')));
		$this->Post->bindModel(array('hasMany'=>array('Image'=>array('limit'=>'1', 'order'=>'Image.created DESC', 'conditions'=>array('Image.shared_photo NOT'=>'1')))));

		$conditions = array('Post.category_id'=>$categoryID, 'Post.active'=>'1');
		if($this->Session->read('User.moderator') or $this->Session->read('User.admin')) {
			$conditions = array('Post.category_id'=>$categoryID);
		}
		$posts = $this->Post->find('all', array('conditions'=>$conditions, 'order'=>array('Post.created DESC')));

		$this->set(compact('posts', 'categoryInfo', 'title_for_layout'));
	}

	/**
	 * Funtion to get all the posts which has photo sharing
	 */
	function getSharedPhotosPostList() {
		App::uses('Category', 'Model');
		$this->Category = new Category;

		$this->Category->bindModel(array('hasMany'=>array('Post'=>array('conditions'=>array('Post.allow_photo_sharing'=>'1', 'Post.active'=>'1'), 'fields'=>array('Post.id', 'Post.title')))));
		$categoryPosts = $this->Category->find('all', array('conditions'=>array('Category.active'=>'1'), 'order'=>'Category.created'));

		return $categoryPosts;
	}

	function admin_index() {
		$productInfoLinkActive = true;
		$conditions = array('Post.site_id'=>$this->Session->read('Site.id'));

		$this->Post->bindModel(array('hasMany'=>array('CategoryProduct')));
		$this->Post->CategoryProduct->unbindModel(array('belongsTo'=>array('Post')));
		//$this->Post->Image->unbindModel(array('belongsTo'=>array('Post', 'Category')));

		$posts = $this->Post->find('all', array('conditions'=>$conditions, 'order'=>'Post.title', 'recursive'=>'2'));
		$this->set(compact('posts', 'productInfoLinkActive'));
	}

	function admin_showPosts($categoryID) {
		$errorMsg = null;
		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'default'));
			$this->redirect('/admin/categories/');
		}

		$posts = $this->Post->findAllByCategoryId($categoryID, [], 'Post.id desc', 200);

		$this->set(compact('posts', 'categoryInfo'));
	}

	function admin_add($categoryID) {
		$productInfoLinkActive = true;
		$errorMsg = array();

		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'default'));
			$this->redirect('/admin/categories/');
		}

		if($this->request->isPost()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Post']['title'])) {
				$errorMsg[] = 'Enter Post Name';
			}

			// Sanitize data
			$data['Post']['title'] = Sanitize::paranoid($data['Post']['title'], array(' ','-', '!'));
			$data['Post']['category_id'] = $categoryID;

			if(!$errorMsg) {
				$conditions = array('Post.title'=>$data['Post']['title']);
				if($this->Post->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Post "'.$data['Post']['title'].'" already exists';
				}
				else {
					$data['Post']['site_id'] = $this->Session->read('Site.id');
					if($this->Post->save($data)) {
						$productInfo = $this->Post->read();
						$postID = $productInfo['Post']['id'];
						$this->Session->setFlash('Post successfully added', 'default', array('class'=>'success'));
						$this->redirect('/admin/posts/showPosts/'.$categoryInfo['Category']['id']);
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'categoryInfo'));
	}

	function admin_edit($postID, $categoryID) {
		$errorMsg = array();
		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
			$this->redirect('/admin/categories/');
		}
		else {
			$postInfo = $this->Post->findById($postID);
			if(!$postInfo) {
				$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
				$this->redirect('/admin/posts/showPosts/'.$categoryInfo['Category']['id']);
			}
		}

		if($this->request->isPost() or $this->request->isPut()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Post']['title'])) {
				$errorMsg[] = 'Enter Post Name';
			}
			// Sanitize data
			$data['Post']['title'] = Sanitize::paranoid($data['Post']['title'], array(' ','-', '!'));

			if(!$errorMsg) {
				$conditions = array('Post.title'=>$data['Post']['title'], 'Post.id NOT'=>$postID);
				if($this->Post->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Post "'.$data['Post']['title'].'" already exists';
				}
				else {
					$data['Post']['id'] = $postID;

					if($this->Post->save($data)) {
						$this->Session->setFlash('Post information successfully updated', 'default', array('class'=>'success'));
						$this->redirect('/admin/posts/showPosts/'.$categoryInfo['Category']['id']);
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}
		else {
			$this->data = $postInfo;
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'postInfo', 'categoryID', 'categoryInfo'));
	}

	function admin_deletePost($postID, $categoryID) {
		$postInfo = $this->Post->findById($postID);
		if(!$postInfo) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
		}
		elseif(!empty($categoryID) and !$this->isCategory($categoryID)) {
			$this->Session->setFlash('Post Category Not Found', 'default', array('class'=>'error'));
		}
		else {
			$this->deletePost($postID, $categoryID);
			$this->Session->setFlash('Post Deleted Successfully', 'default', array('class'=>'success'));
		}

		// redirect
		$this->redirect('/admin/posts/showPosts/'.$categoryID);

	}

	/**
	 * Function to deactivate a product
	 */
	function admin_setInactive($postID) {
		if(!$postInfo = $this->Post->findById($postID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
		}
		else {
			$tmp['Post']['id'] = $postID;
			$tmp['Post']['active'] = '0';
			if($this->Post->save($tmp)) {
				$this->Session->setFlash('Post successfully deactivated.', 'default', array('class'=>'success'));
			}
			else {
				$this->Session->setFlash('An error occurred while communicating with the server.', 'default', array('class'=>'error'));
			}
		}
		$this->redirect($this->request->referer());
	}

	/**
	 * Function to deactivate a product
	 */
	function admin_setActive($postID) {
		if(!$postInfo = $this->Post->findById($postID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
		}
		else {
			$tmp['Post']['id'] = $postID;
			$tmp['Post']['active'] = '1';
			if($this->Post->save($tmp)) {
				$this->Session->setFlash('Post successfully activated.', 'default', array('class'=>'success'));
			}
			else {
				$this->Session->setFlash('An error occurred while communicating with the server.', 'default', array('class'=>'error'));
			}
		}
		$this->redirect($this->request->referer());
	}

	/**
	 * Function to unset a featured product
	 */
	function admin_unsetFeatured($postID) {
		if(!$productInfo = $this->isSiteProduct($postID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
		}
		else {
			$tmp['Post']['id'] = $postID;
			$tmp['Post']['featured'] = '0';
			if($this->Post->save($tmp)) {
				$this->Session->setFlash('Post successfully removed from featured list.', 'default', array('class'=>'success'));
			}
			else {
				$this->Session->setFlash('An error occurred while communicating with the server.', 'default', array('class'=>'error'));
			}
		}
		$this->redirect($this->request->referer());
	}

	/**
	 * Function to deactivate a product
	 */
	function admin_setFeatured($postID) {
		if(!$productInfo = $this->isSiteProduct($postID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
		}
		else {
			$tmp['Post']['id'] = $postID;
			$tmp['Post']['featured'] = '1';
			if($this->Post->save($tmp)) {
				$this->Session->setFlash('Post successfully added to featured list.', 'default', array('class'=>'success'));
			}
			else {
				$this->Session->setFlash('An error occurred while communicating with the server.', 'default', array('class'=>'error'));
			}
		}
		$this->redirect($this->request->referer());
	}

	/**
	 * Function to create a post by user
	 */
	function add($categoryID) {
		$this->checkModerator();

		$productInfoLinkActive = true;
		$errorMsg = array();

		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'default'));
			$this->redirect('/admin/categories/');
		}

		if($this->request->isPost()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Post']['title'])) {
				$errorMsg[] = 'Enter Post Name';
			}

			// Sanitize data
			$data['Post']['title'] = Sanitize::paranoid($data['Post']['title'], array(' ','-', '!'));
			$data['Post']['category_id'] = $categoryID;

			if(!$errorMsg) {
				$conditions = array('Post.title'=>$data['Post']['title']);
				if($this->Post->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Post "'.$data['Post']['title'].'" already exists';
				}
				else {
					$data['Post']['site_id'] = $this->Session->read('Site.id');
					if($this->Post->save($data)) {
						$postInfo = $this->Post->read();
						$postID = $postInfo['Post']['id'];

						$tmp['Activity']['type'] = 'post_add';
						$tmp['Activity']['title'] = $postInfo['Post']['title'];
						$tmp['Activity']['post_id'] = $postInfo['Post']['id'];
						$tmp['Activity']['category_id'] = $categoryID;
						$tmp['Activity']['url'] = '/posts/show/'.$categoryID.'/'.$postID.'/'.Inflector::slug($categoryInfo['Category']['name'], '-').'/'.Inflector::slug($postInfo['Post']['title'], '-');
						$this->saveActivity($tmp);

						// Notify all users
						$messageType = 'notification';
						$subject = 'New post has been added titled "'.$postInfo['Post']['title'].'"';
						$message = '
'.$this->Session->read('User.name').' has added a new post titled "'.$postInfo['Post']['title'].'" in "'.$categoryInfo['Category']['name'].'" section.

For more details visit:
http://www.bhelhss.com'.$tmp['Activity']['url'].'

Unsubscribe from the mailing list:
http://www.bhelhss.com/users/subscribe


-
bhelhss.com
support@bhelhss.com

This message is for notification purpose only and is auto generated. Please do not reply.

';
						try {
							$this->sendBulkEmail($messageType, $subject, $message);
						}
						catch(Exception $e) {

						}


						$this->Session->setFlash('Post successfully added', 'default', array('class'=>'success'));

						$categoryName = ucwords($categoryInfo['Category']['name']);
						$categoryNameSlug = Inflector::slug($categoryName, '-');
						$this->redirect('/posts/showAll/'.$categoryInfo['Category']['id'].'/'.$categoryNameSlug);
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'categoryInfo'));
	}

	/**
	 * Function to edit a post by user
	 */
	function edit($postID, $categoryID) {
		$this->checkModerator();

		$errorMsg = array();
		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
			$this->redirect('/admin/categories/');
		}
		else {
			$postInfo = $this->Post->findById($postID);
			if(!$postInfo) {
				$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
				$this->redirect('/admin/posts/showPosts/'.$categoryInfo['Category']['id']);
			}
		}

		if($this->request->isPost() or $this->request->isPut()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Post']['title'])) {
				$errorMsg[] = 'Enter Post Name';
			}
			// Sanitize data
			$data['Post']['title'] = Sanitize::paranoid($data['Post']['title'], array(' ','-', '!'));

			if(!$errorMsg) {
				$conditions = array('Post.title'=>$data['Post']['title'], 'Post.id NOT'=>$postID);
				if($this->Post->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Post "'.$data['Post']['title'].'" already exists';
				}
				else {
					$data['Post']['id'] = $postID;

					if($this->Post->save($data)) {
						$this->Session->setFlash('Post information successfully updated', 'default', array('class'=>'success'));
						$categoryName = ucwords($categoryInfo['Category']['name']);
						$categoryNameSlug = Inflector::slug($categoryName, '-');

						$postNameSlug = Inflector::slug(ucwords($postInfo['Post']['title']), '-');
						$this->redirect('/posts/show/'.$categoryInfo['Category']['id'].'/'.$postID.'/'.$categoryNameSlug.'/'.$postNameSlug);
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}
		else {
			$this->data = $postInfo;
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'postInfo', 'categoryID', 'categoryInfo'));
	}

	/**
	 * Function to delete a post by user
	 */
	function deleteUserPost($postID, $categoryID) {
		if($this->isModerator()) {
			$conditions = array('Post.id'=>$postID);
		}
		else {
			$conditions = array('Post.id'=>$postID, 'Post.user_id'=>$this->Session->read('User.id'));
		}

		$postInfo = $this->Post->find('first', array('conditions'=>$conditions));
		if(!$postInfo) {
			$this->Session->setFlash('Post Not Found', 'default', array('class'=>'error'));
		}
		elseif(!empty($categoryID) and (!($categoryInfo = $this->isCategory($categoryID)))) {
			$this->Session->setFlash('Post Category Not Found', 'default', array('class'=>'error'));
		}
		else {
			$this->deletePost($postID, $categoryID);
			$this->Session->setFlash('Post Deleted Successfully', 'default', array('class'=>'success'));
		}
		// redirect
		$this->redirect('/posts/showAll/'.$categoryID.'/'.Inflector::slug(ucwords($categoryInfo['Category']['name']), '-'));
	}

}
?>
