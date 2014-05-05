<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Post\Form\PostForm;
use Post\Model\PostTable;
use Post\Model\Post;

class PostController extends AbstractActionController {
    
    public function indexAction() {
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        return array('posts' => $postTable->fetchAll());
    }
    
    public function addAction() {
        $postForm = new PostForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Post();
            $postForm->setData($request->getPost());
            //print_r($postForm);
        
            if ($postForm->isValid()) {
                $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
                $post->exchangeArray($postForm->getData());
                //print_r($post->text);
                $postTable->savePost($post);
                return $this->redirect()->toRoute('post');
            }
        }
        return array('form' => $postForm);
    }
    
    public function deleteAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        if ($request->isPost()) {
            $postData = $request->getPost();
            $id = (int) $postData->id;
            if ($id) {
                $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
                $postTable->deletePost($id);
                $status = 'ok';
            } else {
                $status = 'bad';
            }
        }
        $answer = array('status' => $status);
        $response->setContent(\Zend\Json\Json::encode($answer));
        $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        //print_r($response);
        return $response;
    } 
    
    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        //print_r($id);
        
        if (!$id) {
            return $this->redirect()->toRoute('post', array('action' => 'add'));
        }
        
        $postTable = new PostTable($this->getServiceLocator()->get('dbAdapter'));
        $post = $postTable->fetchById($id);
        $postForm = new PostForm();
        $postForm->get('submit')->setAttribute('value', 'Edit');
        $postForm->bind($post);
        //print_r($post);
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $post = new Post();
            $postForm->setData($request->getPost());
            
            if ($postForm->isValid()) {
                $post=$postForm->getData();
                $postTable->savePost($post);
                return $this->redirect()->toRoute('post');
            }
        }
        
        
        
        return array('form' => $postForm, 'id' => $id);
    }
}