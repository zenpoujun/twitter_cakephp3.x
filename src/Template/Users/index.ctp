ログインしました:
<?php
 echo "&nbsp;{$user['name']}さん<br/><br/>";
 echo "twitterへようこそ!<br/>";
 echo $this->Html->link('始める!',['controller'=>'Posts','action'=>'index']);
 ?>
