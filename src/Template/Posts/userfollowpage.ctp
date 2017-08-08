<h1>フォローしている人</h1>
<h2><?php echo "{$name}さん"; ?></h2>

<p>
  <?php echo "ユーザー:{$user["username"]}さん"; ?>
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
      echo "<form action='/cakephp3/follows/userunfollow' method='post'>";
      echo "<input name='user_id' type='hidden' value='".$user['id']."'>";
      echo "<input name='follow_id' type='hidden' value='".$user_info['id']."'>";
      echo "<input type='submit' value='unfollow'>";
      echo "</form>";
      echo "<hr>";

    }

  echo "<br/><br/>";
  echo $this->Paginator->prev('<<前へ');
  echo $this->Paginator->next('>>次へ');
 ?>
