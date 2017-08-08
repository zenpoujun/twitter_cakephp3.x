<h1>マイページ</h1>
<?php
 echo "ユーザー: {$user['name']}さん<br/>";
 echo "フォロー数&nbsp;:&nbsp;".$this->Html->link($follow,['controller'=>'Posts','action'=>'followpage'])."<br/>";
 echo "フォロワー数&nbsp;:&nbsp;".$this->Html->link($follower,['controller'=>'Posts','action'=>'followerpage'])."<br/>";
 echo "ツイート数&nbsp;:&nbsp;".$this->Html->link($tweet,['controller'=>'Posts','action'=>'tweet'])."<br/>";
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
   echo $this->Html->link('削除',['controller'=>'Posts','action'=>'mytweetdelete','?'=>['id'=>$tweet_info['id']]],['confirm'=>'ツイートを削除します。よろしいですか?']);
   echo "<hr>";
   }
 }

 echo "<br/><br/>";
 echo $this->Paginator->prev('<<前へ');
 echo $this->Paginator->next('>>次へ');

 ?>
