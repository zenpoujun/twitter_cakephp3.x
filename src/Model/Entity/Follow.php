<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Follow extends Entity {
  protected $_accessible = [
    '*' => true,
    'id' => false
  ];
}
