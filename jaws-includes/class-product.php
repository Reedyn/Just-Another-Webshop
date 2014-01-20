<?php
    class Product{
        public $ProductId;
        public $Name;
        public $Description;
        public $ImgUrl;
        public $Taxanomy;
        public $Price;
        public $Stock;
        public $ProductWeight;

        public function __construct($ProductId,$Name,$Description,$ImgUrl,$Taxanomy,$Price,$Stock,$ProductWeight) {
            $this->ProductId    = $ProductId;
            $this->Name         = $Name;
            $this->Description  = $Description;
            $this->ImgUrl       = $ImgUrl;
            $this->Taxanomy     = $Taxanomy;
            $this->Price        = $Price;
            $this->Stock        = $Stock;
            $this->ProductWeight= $ProductWeight;
        }
    }

?>