<?php
    //Includes
    include_once 'db.php';
    include 'config.php';

    //Initialize the class Database
    $db=new Database($dbHost,$dbUser,$dbPassword,$dbName);
    //Functions

    function getUsers() { // Returns a product from the product as a Product class.
        $arg_list=func_get_args();

        //Call function in db.php to get the array of users
        $data=call_user_func_array(array($this->db,"dbGetUsers()"),$arg_list);

        $user=NULL;
        for($i=0;$i<count($data);$i++){
            $user[$i]=new User($data[$i]['SSNr'],$data[$i]['Mail'],$data[$i]['Password'],$data[$i]['FirstName'],$data[$i]['LastName'],$data[$i]['StreetAddress'],$data[$i]['PostAddress'],$data[$i]['City'],$data[$i]['Telephone'],$data[$i]['SessionKey'],$data[$i]['IsAdmin']);
        }
        return $user;
    }

    class User{
        protected $SSNr;
        protected $Mail;
        protected $Password;
        protected $FirstName;
        protected $LastName;
        protected $StreetAddress;
        protected $PostAddress;
        protected $City;
        protected $Telephone;
        protected $SessionKey;
        protected $IsAdmin;

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
        public function getUserId(){
            return $this->SSNr;
        }

        public function setUserId($SSNr){
            global $db;
            if($db->dbEditUser($this->SSNr,"SSNr",$SSNr)==TRUE){
                $this->SSNr=$SSNr;
            }
            return $this->getUserId();
        }

        public function getMail(){
            return $this->Mail;
        }

        public function setMail($Mail){
            global $db;
            if($db->dbEditUser($this->SSNr,"Mail",$Mail)==TRUE){
                $this->Mail=$Mail;
            }
            return $this->getMail();
        }

        public function getPassword(){
            return $this->Password;
        }

        public function setPassword($Password){
            global $db;
            if($db->dbEditUser($this->SSNr,"Password",$Password)==TRUE){
                $this->Password=$Password;
            }
            return $this->getPassword();
        }

        public function getFirstName(){
            return $this->FirstName;
        }

        public function setFirstName($FirstName){
            global $db;
            if($db->dbEditUser($this->SSNr,"FirstName",$FirstName)==TRUE){
                $this->FirstName=$FirstName;
            }
            return $this->FirstName;
        }

        public function getLastName(){
            return $this->LastName;
        }

        public function setLastName($LastName){
            global $db;
            if($db->dbEditUser($this->SSNr,"LastName",$LastName)==TRUE){
                $this->LastName=$LastName;
            }
            return $this->getLastName();
        }
        public function getStreetAddress(){
            return $this->StreetAddress;
        }

        public function setStreetAddress($StreetAddress){
            global $db;
            if($db->dbEditUser($this->SSNr,"StreetAddress",$StreetAddress)==TRUE){
                $this->StreetAddress=$StreetAddress;
            }
            return $this->getStreetAddress();
        }

        public function getPostAddress(){
            return $this->PostAddress;
        }

        public function setPostAddress($PostAddress){
            global $db;
            if($db->dbEditUser($this->SSNr,"PostAddress",$PostAddress)==TRUE){
                $this->PostAddress=$PostAddress;
            }
            return $this->getPostAddress();
        }

        public function getCity(){
            return $this->City;
        }

        public function setCity($City){
            global $db;
            if($db->dbEditUser($this->SSNr,"City",$City)==TRUE){
                $this->City=$City;
            }
            return $this->getCity();
        }

        public function getTelephone(){
            return $this->Telephone;
        }

        public function setTelephone($Telephone){
            global $db;
            if($db->dbEditUser($this->SSNr,"Telephone",$Telephone)==TRUE){
                $this->Telephone=$Telephone;
            }
            return $this->getTelephone();
        }

        public function getSessionKey(){
            return $this->SessionKey;
        }

        public function setSessionKey($SessionKey){
            global $db;
            if($db->dbEditUser($this->SSNr,"SessionKey",$SessionKey)==TRUE){
                $this->SessionKey=$SessionKey;
            }
            return $this->getSessionKey();
        }

        public function getIsAdmin(){
            return $this->IsAdmin;
        }

        public function setIsAdmin($IsAdmin){
            global $db;
            if($db->dbEditUser($this->SSNr,"IsAdmin",$IsAdmin)==TRUE){
                $this->IsAdmin=$IsAdmin;
            }
            return $this->getIsAdmin();
        }
    }

?>