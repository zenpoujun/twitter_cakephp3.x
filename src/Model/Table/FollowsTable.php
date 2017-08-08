<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FollowsTable extends Table {
  public function initialize(array $config){
    $this->belongsTo('Users');
  }
}
