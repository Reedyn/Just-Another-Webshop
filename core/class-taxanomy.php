<?php
    class Taxanomy{
        public $Id;
        public $Name;
        public $Parent;
        public function __construct($id,$name,$parent){
            $this->Id       = $id;
            $this->Name     = $name;
            $this->Parent   = $parent;
        }
    }
?>