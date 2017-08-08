<?php

namespace App\Controller;

use Cake\Event\Event;

class UsersController extends AppController {


  // Auth認証なしでアクセスできる処理
  public function beforeFilter(Event $event){
    parent::beforeFilter($event);
    $this->Auth->allow(['home','register','login','complete','userlogout']);
  }


  // アクセスの権限処理
  public function isAuthorized($user = null){
    $this->set('user',$user);
    return true;
  }


  // ログイン後にリダイレクトされるページ処理
  public function index(){
    $this->set('user',$this->Auth->user());
  }


// ユーザー登録の処理
  public function register(){
    $this->set('entity',$this->Users->newEntity());
    if($this->request->is('post')){
      $users = $this->Users->newEntity($this->request->data);
      if($this->Users->save($users)){
        $this->redirect(['action'=>'complete']);
      }
      $this->set('entity',$users);
    }
  }


  // ログイン処理
  public function login(){
    $this->set('entity',$this->Users->newEntity());
    if($this->request->isPost()){
      $user = $this->Auth->identify();
      if(!empty($user)){
        $this->Auth->setUser($user);
        return $this->redirect($this->Auth->redirectUrl());
      }
      $this->Flash->error('ユーザー名かパスワードが違います。');
    }
  }


  // ログアウト処理
  public function logout(){
    $this->Session->destroy();
    return $this->redirect($this->Auth->logout());
  }


  // ログアウト後にリダイレクトされるページ処理
  public function userlogout(){}


  // ユーザー登録完了後のページ
  public function complete(){
    $this->set('entity',$this->Users->newEntity());
  }

// ホームとなるページ
  public function home(){}

}
