<h1>今何してる?</h1><?php echo "ユーザー名: {$user['username']}さん"; ?>

<?php
 echo "<br/><br/>";
 echo $this->Form->create($entity,['url'=>['action'=>'addRecord']]);
 echo $this->Form->hidden('user_id',['value'=>$user['id']]);
 echo $this->Form->input('body',['placeholder'=>'140文字以内で入力','label'=>false]);
 echo $this->Form->submit('ツイート');
 echo $this->Form->end();
 echo "<br/><hr>";


 // ツイートの表示
 $data = $data->toArray();

 for ($i=0; $i < count($data); $i++) {
   $tweet_info = $data[$i];
   $user_info = $data[$i]['user'];
  //  echo "<pre>";
  //  print_r($tweet_info['id']);
  //  echo "</pre>";
  //  自分自身かどうかの処理
   $myself = true;
   if($user_info['username'] == $user['username']){
     // 自分自身ならスルー
     $myself = false;
   }

   if($myself){
     echo "名前&nbsp;:&nbsp;".$this->Html->link($user_info['name'],['controller'=>'Posts','action'=>'userpage','?'=>['id'=>$user_info['id'],'name'=>$user_info['name']]])."&nbsp;&nbsp;&nbsp;&nbsp;";
    //  echo "名前&nbsp;:&nbsp;{$user_info['name']}&nbsp;&nbsp;&nbsp;&nbsp;";
     echo "@{$user_info['username']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
     echo "コメント&nbsp;:&nbsp;{$tweet_info['body']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
     echo "{$tweet_info['created']->i18nFormat('YYYY/MM/dd HH:mm:ss')}&nbsp;&nbsp;&nbsp;&nbsp;<br>";
     echo "<form action='/cakephp3/follows/homeunfollow' method='post'>";
     echo "<input name='user_id' type='hidden' value='".$user['id']."'>";
     echo "<input name='follow_id' type='hidden' value='".$user_info['id']."'>";
     echo "<input type='submit' value='unfollow'>";
     echo "</form>";
     echo "<hr>";
   }else {
     echo "名前&nbsp;:&nbsp;{$user_info['name']}&nbsp;&nbsp;&nbsp;&nbsp;";
     echo "@{$user_info['username']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
     echo "コメント&nbsp;:&nbsp;{$tweet_info['body']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
     echo "{$tweet_info['created']->i18nFormat('YYYY/MM/dd HH:mm:ss')}&nbsp;&nbsp;&nbsp;&nbsp;<br>";
     echo $this->Html->link('削除',['controller'=>'Posts','action'=>'tweetdelete','?'=>['id'=>$tweet_info['id']]],['confirm'=>'ツイートを削除します。よろしいですか?']);
     echo "<hr>";
   }
 }


 echo "<br/><br/>";
 echo $this->Paginator->prev('<<前へ');
 echo $this->Paginator->next('>>次へ');
 ?>
