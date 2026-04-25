<?php

namespace Model {
  class DbParam
  {
    public $name, $value, $type;

    public function __construct($name, $value, $type = \PDO::PARAM_STR)
    {
      $this->name = $name;
      $this->value = $value;
      $this->type = $type;
    }
  }
}
