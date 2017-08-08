<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class PostsController extends AppController {

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


  // ホーム画面処理
  public function index(){
    $this->set('user',$this->Auth->user());
    $this->set('entity',$this->Posts->newEntity());

    // 自分のフォローしている人たちのidを取得
    $follow = $this->Follows->find('all')
                          ->where(['user_id'=>$this->Auth->user('id')])
                          ->contain(['Users']);

    // 自分のidを取得
    $id = [$this->Auth->user('id')];

    $follow = $follow->toArray();

    for ($i=0; $i < count($follow); $i++) {
      $num = $follow[$i]['follow_id'];
      // 自分のidとフォローしている人のidを配列にまとめる
      array_push($id,$num);
    }

      $conditions = $this->Posts->find()
                                ->where(['user_id IN'=>$id])
                                ->contain(['Users']);

    $data = $this->paginate($conditions);
    $this->set('data',$data);
  }


  // ツイート機能
  public function addRecord(){
    if($this->request->is('post')){
      $tweet = $this->Posts->newEntity($this->request->data);
      $this->Posts->save($tweet);
    }
    return $this->redirect(['action'=>'index']);
  }


  // ツイートの削除
  public function tweetdelete(){
    $id = $this->request->query['id'];
    if(!empty($id)){
      try {
        $this->Posts->deleteAll(['id'=>$id]);
        } catch (Exception $e) {
        Log::write('debug',$e->getMessage());
      }
    }
    $this->redirect(['controller'=>'Posts','action'=>'index']);
  }


  // マイページ処理
  public function mypage(){
    $this->set('user',$this->Auth->user());

    // フォロー数カウント
    $follow = $this->Follows->find()->where(['user_id'=>$this->Auth->user('id')]);
    $this->set('follow',$follow->count());

    // フォロワー数カウント
    $follower = $this->Follows->find()->where(['follow_id'=>$this->Auth->user('id')]);
    $this->set('follower',$follower->count());

    // フォロワー数カウント
    $tweet = $this->Posts->find()->where(['user_id'=>$this->Auth->user('id')]);
    $this->set('tweet',$tweet->count());

    // ツイートデータの詳細
    $conditions = $this->Posts->find()
                              ->where(['user_id'=>$this->Auth->user('id')])
                              ->contain(['Users']);

    $data = $this->paginate($conditions);
    $this->set('data',$data);
  }

  // マイページからのツイート削除機能
  public function mytweetdelete(){
    $id = $this->request->query['id'];
    if(!empty($id)){
      try {
        $this->Posts->deleteAll(['id'=>$id]);
        } catch (Exception $e) {
        Log::write('debug',$e->getMessage());
      }
    }
    $this->redirect(['controller'=>'Posts','action'=>'mypage']);
  }

  // フォローしている人の詳細ページ
  public function followpage(){
    $this->set('user',$this->Auth->user());
    $data = $this->Follows->find()
                              ->where(['user_id'=>$this->Auth->user('id')])
                              ->contain(['Users']);

    // id取得のために空の配列を用意
    $followid = [];

    //  ツイート情報を取得のために空の配列を用意
    $followtweet = [];

    $data = $data->toArray();
    for ($i=0; $i < count($data); $i++) {
      $follow = $data[$i]['follow_id'];
      // followidにフォローしている人のidを入れる
      array_push($followid,$follow);

      // 最新情報取得のための処理
      $usertweet= $this->Posts->find()
                                ->where(['user_id'=>$followid[$i]])
                                ->where(['created <' => date('Y-m-d H:i:s')])
                                ->order(['created'=>'DESC'])
                                ->contain(['Users']);

      $usertweet = $usertweet->first();
      array_push($followtweet,$usertweet['id']);
    }

    $usertweet= $this->Posts->find()
                              ->where(['Posts.id IN'=>$followtweet])
                              ->contain(['Users']);

    $data = $this->paginate($usertweet);
    $this->set('data',$data);
  }


  // フォロワーの詳細ページ
  public function followerpage(){
    $this->set('user',$this->Auth->user());
    $data = $this->Follows->find()
                              ->where(['follow_id'=>$this->Auth->user('id')])
                              ->contain(['Users']);

    // id取得のために空の配列を用意
    $followid = [];

    //  ツイート情報を取得のために空の配列を用意
    $followtweet = [];

    $data = $data->toArray();
    for ($i=0; $i < count($data); $i++) {
      $follow = $data[$i]['user_id'];
      // followidにフォローしている人のidを入れる
      array_push($followid,$follow);

      // 最新情報取得のための処理
      $usertweet= $this->Posts->find()
                                ->where(['user_id'=>$followid[$i]])
                                ->where(['created <' => date('Y-m-d H:i:s')])
                                ->order(['created'=>'DESC'])
                                ->contain(['Users']);

      $usertweet = $usertweet->first();
      array_push($followtweet,$usertweet['id']);
    }

    $usertweet= $this->Posts->find()
                              ->where(['Posts.id IN'=>$followtweet])
                              ->contain(['Users']);

    $data = $this->paginate($usertweet);
    $this->set('data',$data);
  }


  // ツイートの詳細ページ
  public function tweet(){
    $this->set('user',$this->Auth->user());
    $tweet= $this->Posts->find()
                        ->where(['user_id'=>$this->Auth->user('id')])
                        ->contain(['Users']);
    $data = $this->paginate($tweet);
    $this->set('data',$data);
  }

  // マイツイートページでのツイート削除
  public function tweetpagedelete(){
    $id = $this->request->query['id'];
    if(!empty($id)){
      try {
        $this->Posts->deleteAll(['id'=>$id]);
        } catch (Exception $e) {
        Log::write('debug',$e->getMessage());
      }
    }
    $this->redirect(['controller'=>'Posts','action'=>'tweet']);
  }


    // ユーザーページ
    public function userpage(){
      $this->set('user',$this->Auth->user());

      // ユーザーのパラメータを受け取る
      $id = $this->request->query['id'];
      $name = $this->request->query['name'];

      $this->set('id',$id);
      $this->set('name',$name);


      // フォロー数カウント
      $follow = $this->Follows->find()->where(['user_id'=>$id]);
      $this->set('follow',$follow->count());

      // フォロワー数カウント
      $follower = $this->Follows->find()->where(['follow_id'=>$id]);
      $this->set('follower',$follower->count());

      // ツイート数カウント
      $tweet = $this->Posts->find()->where(['user_id'=>$id]);
      $this->set('tweet',$tweet->count());

      // ツイートデータの詳細
      $conditions = $this->Posts->find()
                                ->where(['user_id'=>$id])
                                ->contain(['Users']);

      $data = $this->paginate($conditions);
      $this->set('data',$data);
    }


    // ユーザーのフォローページ
    public function userfollowpage(){
      $this->set('user',$this->Auth->user());

      $id = $this->request->query['id'];
      $name = $this->request->query['name'];
      $this->set('name',$name);

      $data = $this->Follows->find()
                                ->where(['user_id'=>$id])
                                ->contain(['Users']);

      // id取得のために空の配列を用意
      $followid = [];

      //  ツイート情報を取得のために空の配列を用意
      $followtweet = [];

      $data = $data->toArray();
      for ($i=0; $i < count($data); $i++) {
        $follow = $data[$i]['follow_id'];
        // followidにフォローしている人のidを入れる
        array_push($followid,$follow);

        // 最新情報取得のための処理
        $usertweet= $this->Posts->find()
                                  ->where(['user_id'=>$followid[$i]])
                                  ->where(['created <' => date('Y-m-d H:i:s')])
                                  ->order(['created'=>'DESC'])
                                  ->contain(['Users']);

        $usertweet = $usertweet->first();
        array_push($followtweet,$usertweet['id']);
      }

      $usertweet= $this->Posts->find()
                                ->where(['Posts.id IN'=>$followtweet])
                                ->contain(['Users']);

      $data = $this->paginate($usertweet);
      $this->set('data',$data);
    }


    // ユーザーのフォロワーページ
    public function userfollowerpage(){
      $this->set('user',$this->Auth->user());

      $id = $this->request->query['id'];
      $name = $this->request->query['name'];
      $this->set('name',$name);

      $data = $this->Follows->find()
                                ->where(['follow_id'=>$id])
                                ->contain(['Users']);

      // id取得のために空の配列を用意
      $followid = [];

      //  ツイート情報を取得のために空の配列を用意
      $followtweet = [];

      $data = $data->toArray();
      for ($i=0; $i < count($data); $i++) {
        $follow = $data[$i]['user_id'];
        // followidにフォローしている人のidを入れる
        array_push($followid,$follow);

        // 最新情報取得のための処理
        $usertweet= $this->Posts->find()
                                  ->where(['user_id'=>$followid[$i]])
                                  ->where(['created <' => date('Y-m-d H:i:s')])
                                  ->order(['created'=>'DESC'])
                                  ->contain(['Users']);

        $usertweet = $usertweet->first();
        array_push($followtweet,$usertweet['id']);
      }

      $usertweet= $this->Posts->find()
                                ->where(['Posts.id IN'=>$followtweet])
                                ->contain(['Users']);

      $data = $this->paginate($usertweet);
      $this->set('data',$data);
    }


    // ユーザーツイートページ
    public function usertweet(){
      $this->set('user',$this->Auth->user());

      $id = $this->request->query['id'];
      $name = $this->request->query['name'];
      $this->set('name',$name);

      $tweet= $this->Posts->find()
                          ->where(['user_id'=>$id])
                          ->contain(['Users']);
      $data = $this->paginate($tweet);
      $this->set('data',$data);
    }


  // 友達検索
  public function search($page = null,$sort = null, $direction = null){
    $this->set('user',$this->Auth->user());
    $this->set('entity',$this->Posts->newEntity());

    // 検索ボタンを押した時
    if(!empty($this->request->data)){
      // フォームの値を取得
      $content = $this->request->data['Post']['username'];


      // 検索条件のsql
      $query1 = ['username like'=>'%'.$this->request->data['Post']['username'].'%'];
      $query2 = ['name like'=>'%'.$this->request->data['Post']['username'].'%'];


      // 古い検索条件のsqlセッションを削除
      if($this->Session->check('query1'))
      $this->Session->delete('query1');

      if($this->Session->check('query2'))
      $this->Session->delete('query2');

      if($this->Session->check('content'))
      $this->Session->delete('content');


      // 新しい検索条件のsqlセッションを作成
      $this->Session->write('query1',$query1);
      $this->Session->write('query2',$query2);
      $this->Session->write('content',$content);

      // 検索条件
      $conditions = $this->Posts->find()
                                ->where($query1)
                                ->orWhere($query2)
                                ->contain(['Users']);

        // viewに渡す
        $data = $this->paginate($conditions);
        $this->set('conditions',$conditions);
        $this->set('data',$data);
    }else {
        if($this->Session->check('query1') && $this->Session->check('query2')){
        // パラメータが無ければ新しくページに来た
        if(empty($this->request->query['page']) && empty($this->request->query['sort']) && empty($this->request->query['direction'])){

          $this->Session->delete('query1');
          $this->Session->delete('query2');
          $this->Session->delete('content');
        }else {

          // ページ移動の処理
          $query1 = $this->Session->read('query1');
          $query2 = $this->Session->read('query1');
          $content = $this->Session->read('content');

          $conditions = $this->Posts->find()
                                    ->where($query1)
                                    ->orWhere($query2)
                                    ->contain(['Users']);

          // viewに渡す
          $data = $this->paginate($conditions);
          $this->set('data',$data);
          $this->set('content',$content);
        }
      }
    }
    $follow_id = $this->Follows->find()->where(['user_id'=>$this->Auth->user('id')]);
    $this->set('follow_id',$follow_id);
  }
}
