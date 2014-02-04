<?php
    class Currency{
        public $Id;
        public $Name;
        public $Multiplier;
        public $Sign;
        public $Layout;
        public function __construct($id,$name,$multiplier,$sign,$layout){
            $this->Id       = $id;
            $this->Name     = $name;
            $this->Multiplier= $multiplier;
            $this->Sign     = $sign;
            $this->Layout   = $layout;
        }
    }
?>