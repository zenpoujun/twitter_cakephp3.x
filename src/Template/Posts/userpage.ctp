<h1>ユーザーページ</h1>
<?php
 echo "ユーザー: {$user['name']}さん<br/><hr>";
 echo "{$name}さんのページ<br/>";
 echo "フォロー数&nbsp;:&nbsp;".$this->Html->link($follow,['controller'=>'Posts','action'=>'userfollowpage','?'=>['id'=>$id,'name'=>$name]])."<br/>";
 echo "フォロワー数&nbsp;:&nbsp;".$this->Html->link($follower,['controller'=>'Posts','action'=>'userfollowerpage','?'=>['id'=>$id,'name'=>$name]])."<br/>";
 echo "ツイート数&nbsp;:&nbsp;".$this->Html->link($tweet,['controller'=>'Posts','action'=>'usertweet','?'=>['id'=>$id,'name'=>$name]])."<br/>";
 echo "<hr>";

 if(!empty($data)){

 $data = $data->toArray();
 for ($i=0; $i < count($data); $i++) {

   $tweet_info = $data[$i];
   $user_info = $data[$i]['user'];

   echo "名前&nbsp;:&nbsp;{$user_info['name']}&nbsp;&nbsp;&nbsp;&nbsp;";
   echo "@{$user_info['username']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
   echo "コメント&nbsp;:&nbsp;{$tweet_info['body']}&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
   echo "{$tweet_info['created']->i18nFormat('YYYY/MM/dd HH:mm:ss')}&nbsp;&nbsp;&nbsp;&nbsp;<br>";
   echo "<hr>";
   }
 }

 echo "<br/><br/>";
 echo $this->Paginator->prev('<<前へ');
 echo $this->Paginator->next('>>次へ');

 ?>
