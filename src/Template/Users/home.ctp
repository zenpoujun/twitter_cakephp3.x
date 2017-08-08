<h1>Twitterを始めよう!</h1>

<?php
 echo "登録がまだなら";
 echo $this->Html->link('ユーザー登録へ!',['action'=>'register']).'<br/><br/>';
 echo "登録済みなら";
 echo $this->Html->link('ログインへ!',['action'=>'login']);
 ?>
