<?php
    class User{
        public $SSNr;
        public $Mail;
        public $Password;
        public $FirstName;
        public $LastName;
        public $StreetAddress;
        public $PostAddress;
        public $City;
        public $Telephone;
        public $SessionKey;
        public $IsAdmin;

        public function __construct($SSNr,$Mail,$Password,$FirstName,$LastName,$StreetAddress,$PostAddress,$City,$Telephone,$SessionKey,$IsAdmin) {
            $this->SSNr         = $SSNr;
            $this->Mail         = $Mail;
            $this->Password     = $Password;
            $this->FirstName    = $FirstName;
            $this->LastName     = $LastName;
            $this->StreetAddress= $StreetAddress;
            $this->PostAddress  = $PostAddress;
            $this->City         = $City;
            $this->Telephone    = $Telephone;
            $this->SessionKey   = $SessionKey;
            $this->IsAdmin      = $IsAdmin;
        }
    }

?>