<?php
class Currency
{
    private $id;
    private $name;
    private $code;
    private $num;
    private $simbol;

    public function __GET($k){ return $this->$k; }
    public function __SET($k, $v){ return $this->$k = $v; }
}