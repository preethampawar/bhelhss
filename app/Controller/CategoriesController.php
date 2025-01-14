<?php
App::uses('CakeEmail', 'Network/Email');
class CategoriesController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('getCategories');
	}


	public function getCategories() {
		$conditions = array('Category.active'=>'1');
		$categories = $this->Category->find('all', array('conditions'=>$conditions, 'recursive'=>'-1', 'order'=>'Category.name ASC'));
		return $categories;
	}

	public function admin_getCategories() {
		$conditions = array();
		$categories = $this->Category->find('all', array('conditions'=>$conditions, 'recursive'=>'-1', 'order'=>'Category.name ASC'));
		return $categories;
	}

	public function admin_index() {
		$conditions = array('Category.active'=>'1');
		$categories = $this->Category->find('all', array('conditions'=>$conditions, 'recursive'=>'-1', 'order'=>'Category.name ASC'));
		$categoryInfoLinkActive = true;
		$title_for_layout = 'Manage Posts';
		$this->set('categoryInfoLinkActive', $categoryInfoLinkActive);
		$this->set('title_for_layout', $title_for_layout);
		$this->set('categories', $categories);
	}

	public function admin_add() {

		$errorMsg = array();
		if($this->request->isPost()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Category']['name'])) {
				$errorMsg[] = 'Enter Category Name';
			}
			// Sanitize data
			$data['Category']['name'] = Sanitize::paranoid($data['Category']['name'], array(' ','-'));
			if(!$errorMsg) {
				$conditions = array('Category.name'=>$data['Category']['name']);
				if($this->Category->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Category "'.$data['Category']['name'].'" already exists';
				}
				else {

					if($this->Category->save($data)) {
						$this->Session->setFlash('Category successfully added', 'default', array('class'=>'success'));
						$this->redirect('/admin/categories/add');
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg'));
	}

	public function admin_edit($categoryID) {
		$errorMsg = array();
		$categoryInfoLinkActive = true;
		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'default'));
			$this->redirect('/admin/categories/');
		}

		if($this->request->isPost() or $this->request->isPut()) {
			$data = $this->request->data;

			// Validate name
			if(Validation::blank($data['Category']['name'])) {
				$errorMsg[] = 'Enter Category Name';
			}
			// Sanitize data
			$data['Category']['name'] = Sanitize::paranoid($data['Category']['name'], array(' ','-'));
			if(!$errorMsg) {
				$conditions = array('Category.name'=>$data['Category']['name'], 'Category.id NOT'=>$categoryID);
				if($this->Category->find('first', array('conditions'=>$conditions))) {
					$errorMsg[] = 'Category "'.$data['Category']['name'].'" already exists';
				}
				else {
					$data['Category']['site_id'] = $this->Session->read('Site.id');
					$data['Category']['id'] = $categoryID;
					if($this->Category->save($data)) {
						$this->Session->setFlash('Category successfully added', 'default', array('class'=>'success'));
						$this->redirect('/admin/categories/add');
					}
					else {
						$errorMsg[] = 'An error occurred while communicating with the server';
					}
				}
			}
		}
		else {
			$this->data = $categoryInfo;
		}

		$errorMsg = implode('<br>', $errorMsg);
		$this->set(compact('errorMsg', 'categoryInfo', 'categoryInfoLinkActive'));
	}

	public function admin_delete($categoryID) {
		if($categoryInfo = $this->isCategory($categoryID)) {
			$this->deleteCategory($categoryID);
			$this->Session->setFlash('Category successfully deleted', 'default', array('class'=>'success'));
		}
		else {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'error'));
		}
		$this->redirect('/admin/categories/');
	}

	public function admin_showProducts($categoryID) {
		$errorMsg = null;
		if(!$categoryInfo = $this->isCategory($categoryID)) {
			$this->Session->setFlash('Category Not Found', 'default', array('class'=>'default'));
			$this->redirect('/admin/categories/');
		}

		App::uses('CategoryProduct', 'Model');
		$this->CategoryProduct = new CategoryProduct;
		$conditions = array('CategoryProduct.category_id'=>$categoryID);

		$this->CategoryProduct->unbindModel(array('belongsTo'=>array('Category')));
		$categoryProducts = $this->CategoryProduct->findAllByCategoryId($categoryID);

		$tmp = array();
		$productsList = array();
		if(!empty($categoryProducts)) {
			foreach($categoryProducts as $row) {
				$tmp[$row['Product']['id']] = $row;
				$productsList[$row['Product']['id']] = ucwords($row['Product']['name']);
			}
			asort($productsList);
			$categoryProducts = $tmp;
		}

		$this->set(compact('errorMsg', 'categoryInfo', 'categoryProducts', 'productsList'));
	}

}
?>
