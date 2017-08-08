<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset("utf-8"); ?>
    <title><?php echo $title_for_layout; ?> / ログインするだけのサイト</title>
    <?php echo $this->Html->css('main'); ?>
  </head>
  <body>
  <div id="container">
    <div id="header">
      <div id="header_menu">
        <?php
          if(isset($user)):
            echo $this->Html->link('ホーム/ ',['controller'=>'Posts','action'=>'index']);
            echo $this->Html->link('マイページ/ ',['controller'=>'Posts','action'=>'mypage']);
            echo $this->Html->link('友達検索/ ',['controller'=>'Posts','action'=>'search']);
            echo $this->Html->link('ログアウト',['controller'=>'Users','action'=>'logout'],['confirm'=>'ログアウトします。よろしいですか?']);
          else:
            echo $this->Html->link('ホーム/ ',['controller'=>'Users','action'=>'home']);
            echo $this->Html->link('新規登録/ ',['controller'=>'Users','action'=>'register']);
            echo $this->Html->link('ログイン',['controller'=>'Users','action'=>'login']);
          endif;
        ?>
      </div>
      <div id="header_logo">
        <?php
         if(isset($user)){
          echo  $this->Html->image('twitter.jpg',['alt'=>'twitter_log','url'=>['controller'=>'Posts','action'=>'index'],'width'=>'240','height'=>'100']);
         }else {
          echo  $this->Html->image('twitter.jpg',['alt'=>'twitter_log','url'=>['controller'=>'Users','action'=>'home'],'width'=>'240','height'=>'100']);
         }
         ?>
      </div>
      <div id="content">
        <?php echo $this->fetch('content'); ?>
      </div>
    </div>
  </body>
</html>
