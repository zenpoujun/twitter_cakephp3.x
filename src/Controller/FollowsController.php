<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class FollowsController extends AppController {

  public $paginate = [
    'page' => 1,
    'limit' => 10,
    'order' => ['created' => 'DESC']
  ];




  public function initialize(){
    parent::initialize();
    // ページネーションのロード
    $this->loadComponent('Paginator');
    // モデルの組み込み
    $this->Users = TableRegistry::get('Users');
    $this->posts = TableRegistry::get('Posts');
    $this->Follows = TableRegistry::get('Follows');
  }

  // アクセスの権限処理
  public function isAuthorized($user = null){
    $this->set('user',$user);
    return true;
  }

  // フォロー機能
  public function follow(){
    if(!empty($this->request->data)){
      $follow = $this->Follows->newEntity($this->request->data);
      $this->Follows->save($follow);
    }
    // リダイレクトで友達検索ページに戻る
    $this->redirect(['controller'=>'Posts','action'=>'search']);
  }

  // フォロー外し機能
  public function unfollow(){
    if(!empty($this->request->data)){
      try {
      $this->Follows->deleteAll([
        'user_id'=>$this->request->data['user_id'],
        'follow_id'=>$this->request->data['follow_id']
      ]);
      } catch (Exception $e) {
        Log::write('debug',$e->getMessage());
      }
      // リダイレクトで友達検索ページに戻る
      $this->redirect(['controller'=>'Posts','action'=>'search']);
    }
  }


  // ホームでのフォロー外し機能
  public function homeunfollow(){
    if(!empty($this->request->data)){
      try {
      $this->Follows->deleteAll([
        'user_id'=>$this->request->data['user_id'],
        'follow_id'=>$this->request->data['follow_id']
      ]);
      } catch (Exception $e) {
        Log::write('debug',$e->getMessage());
      }
      // リダイレクトで友達検索ページに戻る
      $this->redirect(['controller'=>'Posts','action'=>'index']);
    }
  }


  // フォローページでのフォロー外し機能
  public function userunfollow(){
    if(!empty($this->request->data)){
      try {
      $this->Follows->deleteAll([
        'user_id'=>$this->request->data['user_id'],
        'follow_id'=>$this->request->data['follow_id']
      ]);
      } catch (Exception $e) {
        Log::write('debug',$e->getMessage());
      }
      // リダイレクトで友達検索ページに戻る
      $this->redirect(['controller'=>'Posts','action'=>'followpage']);
    }
  }

}
