<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {

  public function initialize(array $config){
    $this->hasMany('Posts');
    $this->hasMany('Follow');
  }

  public function buildRules(RulesChecker $rules){
    $rules->add($rules->isUnique(['username'],'このユーザー名は既に使用されています。'));
    $rules->add($rules->isUnique(['password2'],'このパスワードは既に使用されています。'));
    return $rules;
  }

  public function validationDefault(Validator $validator){
    $validator
      ->notEmpty('name','名前を入力してください。')
      ->lengthBetween('name',['minLength'=>4,'maxLength'=>20],'4文字以上20文字以下で入力してください');
    $validator
      ->notEmpty('username','ユーザー名を入力してください。')
      ->alphaNumeric('username','アルファベット、ひらがな、カタカナ、漢字、数字以外入力しないでください。')
      ->lengthBetween('username',['minLength'=>4,'maxLength'=>20],'4文字以上20文字以下で入力してください');

    $validator
      ->notEmpty('password','パスワードを入力してください。')
      ->alphaNumeric('password','アルファベット、ひらがな、カタカナ、漢字、数字以外入力しないでください。')
      ->lengthBetween('password',['minLength'=>4,'maxLength'=>20],'4文字以上20文字以下で入力してください');

    $validator
       ->notEmpty('password2','パスワードを入力してください。')
       ->sameAs('password2','password','パスワードが一致していません');

    $validator
      ->notEmpty('email','メールアドレスを入力してください。')
      ->email('email','正しいメールアドレスを入力してください。');

    return $validator;
  }
}
