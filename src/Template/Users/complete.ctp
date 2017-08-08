<h1>Twitterへようこそ!</h1>
ログインしてtwitterを始めよう!
<?php
 echo $this->Form->create($entity,['url'=>['action'=>'login']]);
 echo $this->Form->submit('twitterを始める!');
 echo $this->Form->end();
 ?>
