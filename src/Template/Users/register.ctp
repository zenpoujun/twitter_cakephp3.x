<h1>新規登録</h1>
<?php
 echo $this->Form->create($entity,['url'=>['action'=>'register']]);
 // name
 echo $this->Form->input('name',['error'=>false,'label'=>'名前: ','placeholder'=>'名前を入力してください。']);
 echo $this->Form->error('name').'<br/>';

 // username
 echo $this->Form->input('username',['error'=>false,'label'=>'ユーザー名: ','placeholder'=>'ユーザー名を入力してください。']);
 echo $this->Form->error('username').'<br/>';

 // password
 echo $this->Form->input('password',['error'=>false,'label'=>'パスワード: ','placeholder'=>'パスワードを入力してください。']);
 echo $this->Form->error('password').'<br/>';

 // password2
 echo $this->Form->input('password2',['error'=>false,'label'=>'パスワード(確認): ','placeholder'=>'パスワード(確認)を入力してください。']);
 echo $this->Form->error('password2').'<br/>';

 // email
 echo $this->Form->input('email',['error'=>false,'label'=>'メールアドレス: ','placeholder'=>'メールアドレスを入力してください。']);
 echo $this->Form->error('email').'<br/>';

 echo $this->Form->submit('登録');
 echo $this->Form->end();
 ?>
