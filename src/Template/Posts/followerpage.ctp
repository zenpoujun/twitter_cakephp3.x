<h1>フォローされている人</h1>
<p>
 <?php
  echo "ユーザー: {$user['name']}さん<br/>";
 ?>
</p>

<?php
  echo "<hr>";
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

  echo "<br/><br/>";
  echo $this->Paginator->prev('<<前へ');
  echo $this->Paginator->next('>>次へ');
 ?>
