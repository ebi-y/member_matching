<?php
App::uses('AppController', 'Controller');
/**
 * Skills Controller
 *
 * @property Skill $Skill
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class SkillsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Skill->recursive = 0;
		$this->set('skills', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Skill->exists($id)) {
			throw new NotFoundException(__('Invalid skill'));
		}
		$options = array('conditions' => array('Skill.' . $this->Skill->primaryKey => $id));
		$this->set('skill', $this->Skill->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Skill->create();
			if ($this->Skill->save($this->request->data)) {
				$this->Session->setFlash(__('The skill has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The skill could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$skillCategories = $this->Skill->SkillCategory->find('list');
		$projects = $this->Skill->Project->find('list');
		$users = $this->Skill->User->find('list');
        $this->log($users);
		$this->set(compact('skillCategories', 'projects', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Skill->exists($id)) {
			throw new NotFoundException(__('Invalid skill'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Skill->save($this->request->data)) {
				$this->Session->setFlash(__('The skill has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The skill could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Skill.' . $this->Skill->primaryKey => $id));
			$this->request->data = $this->Skill->find('first', $options);
		}
		$skillCategories = $this->Skill->SkillCategory->find('list');
		$projects = $this->Skill->Project->find('list');
		$users = $this->Skill->User->find('list');
		$this->set(compact('skillCategories', 'projects', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Skill->id = $id;
		if (!$this->Skill->exists()) {
			throw new NotFoundException(__('Invalid skill'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Skill->delete()) {
			$this->Session->setFlash(__('The skill has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The skill could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
