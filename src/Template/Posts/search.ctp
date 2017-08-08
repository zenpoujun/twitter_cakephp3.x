<h1>友達検索</h1>

<?php
  echo "ユーザー: {$user['name']}さん<br/>";
  echo "<br/>";
  echo "誰を検索しますか?";

  // フォームに値を残しておく為の処理
  if(!empty($content)){
    $name = $content;
  } else {
    $name = "";
  }

  echo $this->Form->create($entity,['url'=>['action'=>'search']]);
  echo $this->Form->input('Post.username',['label'=>'名前: ','placeholder'=>'名前またはユーザー名','default' => $name]);
  echo $this->Form->submit('検索');
  echo $this->Form->end();
  echo "<br/><hr></br/>";


  if(!empty($data)){
    $tweet_info = $data->toArray();

    for ($i=0; $i < count($tweet_info); $i++) {
      $user_info = $tweet_info[$i]['user'];

      if($user_info['username'] == $user['username']){
        echo "名前&nbsp;:&nbsp;{$user_info['name']}&nbsp;&nbsp;&nbsp;&nbsp;";
      } else {
        echo "名前&nbsp;:&nbsp;".$this->Html->link($user_info['name'],['controller'=>'Posts','action'=>'userpage','?'=>['id'=>$user_info['id'],'name'=>$user_info['name']]])."&nbsp;&nbsp;&nbsp;&nbsp;";
      }
      echo "@{$user_info['username']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
      echo "コメント&nbsp;:&nbsp;{$tweet_info[$i]['body']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
      echo "{$tweet_info[$i]['created']->i18nFormat('YYYY/MM/dd HH:mm:ss')}&nbsp;&nbsp;&nbsp;&nbsp;<br>";

      // 自分自身かどうかの判断
      $myself = true;
      if($user_info['username'] == $user['username']){
        // 自分自身ならスルー
        $myself = false;
      }

      // フォローしている人かどうかの判断
      $follow = false;
      foreach ($follow_id as $check) {
        if($user_info['id'] == $check->follow_id){
          $follow = true;
        }
      }

      // フォローボタン
      if($myself){
        if($follow){
          echo "<form action='/cakephp3/follows/unfollow' method='post'>";
          echo "<input name='user_id' type='hidden' value='".$user['id']."'>";
          echo "<input name='follow_id' type='hidden' value='".$user_info['id']."'>";
          echo "<input type='submit' value='unfollow'>";
          echo "</form>";
        }else {
          echo "<form action='/cakephp3/follows/follow' method='post'>";
          echo "<input name='user_id' type='hidden' value='".$user['id']."'>";
          echo "<input name='follow_id' type='hidden' value='".$user_info['id']."'>";
          echo "<input type='submit' value='follow'>";
          echo "</form>";
        }
      }
      echo "<hr>";
    }
  }

  echo "<br/><br/>";
  echo $this->Paginator->prev('<<前へ');
  echo $this->Paginator->next('>>次へ');


 ?>
