<h1>ログイン</h1>
<?php
 echo $this->Flash->render('auth');
 echo $this->Form->create($entity,['url'=>['action'=>'login']]);
 echo $this->Form->input('username',['label'=>'ユーザー名: ','placeholder'=>'ユーザー名を入力してください']);
 echo $this->Form->input('password',['label'=>'パスワード: ','placeholder'=>'パスワードを入力してください。']);
 echo $this->Form->submit('Login!');
 echo $this->Form->end();
 ?>
