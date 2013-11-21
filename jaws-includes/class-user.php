<?php 
include '../jaws-includes/db.php';
function getUsers(){
    // Get all users from database
    // Create User classes and put them into an array
    // Return an array of all users
}

function getUser($personalNr) { // Returns a user from the database as a User class.
    $userData = loadUser();
    $user = new User($userData['personalNr'], $userData['name'], $userData['lastName'], $userData['streetAddress'], $userData['postAddress'], $userData['city'], $userData['phone']);
    return $user;
}

class User {
    protected $personalNr;
    protected $name;
    protected $lastName;
    protected $streetAddress;
    protected $postAddress;
    protected $city;
    protected $phone;

    public function __construct($personalNr, $name, $lastName, $streetAddress, $postAddress, $city, $phone) {
        $this->personalNr    = $personalNr;
        $this->name          = $name;
        $this->lastName      = $lastName;
        $this->streetAddress = $streetAddress;
        $this->postAddress   = $postAddress;
        $this->city          = $city;
        $this->phone         = $phone;
    }
    public function getPersonalNr() {
        return $this->personalNr;
    }
    
    public function setPersonalNr($personalNr) {
        $this->personalNr = $personalNr;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
         $this->name = $name;
    }
    
    public function getLastName() {
        return $this->lastName;
    }
    
    public function setLastName($lastName) {
         $this->lastName = $lastName;
    }
    
    public function getFullName() {
        return $this->name . " " . $this->lastName;
    }
    
    public function getStreetAddress() {
        return $this->streetAddress;
    }
    
    public function setStreetAddress($streetAddress) {
         $this->streetAddress = $streetAddress;
    }
    
    public function getPostAddress() {
        return $this->postAddress;
    }
    
    public function setPostAddress($postAddress) {
         $this->postAddress = $postAddress;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setCity($city) {
         $this->city = $city;
    }
    
    public function getPhone() {
        return $this->phone;
    }
    
    public function setPhone($phone) {
         $this->phone = $phone;
    }

    public function getCard() {
        // return a list of all cards associated with the user, if there is only one card, return that one, else return false
    }

    public function addCard() {
        // Add a new card associated with the user, return true if successful, else false.
    }

    public function removeCard() {
        // remove card associated with the user;
    }

    public function saveUser() {
        // Save userdata to database
    }
}

class Admin extends User {
    protected $isAdmin = true;
    
    public function isAdmin() {
        return $this->isAdmin;
    }
}


?>