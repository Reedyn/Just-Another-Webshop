<?php
    class Order {
        public $OrderId;
        public $SSNr;
        public $OrderDate;
        public $Discount;
        public $ChargedCard;
        public $OrderIP;
        public $ProductList;
        public $OrderPrice;

        public function __construct($OrderId,$SSNr,$OrderDate,$Discount,$ChargedCard,$OrderIP,$ProductList) {
            $this->OrderId      = $OrderId;
            $this->SSNr         = $SSNr;
            $this->OrderDate    = $OrderDate;
            $this->Discount     = $Discount;
            $this->ChargedCard  = $ChargedCard;
            $this->OrderIP      = $OrderIP;
            $this->ProductList  = NULL;
            $this->OrderPrice   = 0;
            if($ProductList==NULL){
            }else{
                for($i=0;$i<count($ProductList);$i++){
                    $this->ProductList[$i]=new ListedProduct($ProductList[$i][0],$ProductList[$i][1],$ProductList[$i][2]);
                }
            }
            for($i=0;$i<count($ProductList);$i++){
                $this->OrderPrice   += $this->ProductList[$i]->ProductPriceTotal;
            }
        }
    }

    class ListedProduct {
        public $OrderId;
        public $ProductId;
        public $ProductWeight;
        public $ProductPrice;
        public $Amount;
        public $Name;
        public $ProductPriceTotal;

        public function __construct($OrderId,$ProductId,$Amount) {
            $this->OrderId      = $OrderId;
            $this->ProductId    = $ProductId;
            $this->Amount       = $Amount;
            global $db;
            $ProductInfo=$db->dbGetProduct($this->ProductId);
            $this->ProductWeight= $ProductInfo['ProductWeight'];
            $this->ProductPrice = $ProductInfo['ProductPrice'];
            $this->Name         = $ProductInfo['Name'];
            $this->ProductPriceTotal = $Amount*$this->ProductPrice;
        }
    }

?>