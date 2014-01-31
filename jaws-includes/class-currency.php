<?php
    class Currency{
        public $Id;
        public $Name;
        public $Multiplier;
        public $Sign;
        public function __construct($id,$name,$multiplier,$sign){
            $this->Id       = $id;
            $this->Name     = $name;
            $this->Multiplier= $multiplier;
            $this->Sign     = $sign;
        }
    }
?>