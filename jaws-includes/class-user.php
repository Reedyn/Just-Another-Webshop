<?php 
include '../jaws-includes/functions.php';
include '../jaws-includes/db.php';

$marcus = new User('574549586345');

$marcus->Card->addCard();


class User{
    private $personalNr;
    private $personalNr;
    private $lastName;
    private $streetAddress;
    private $postAddress;
    private $city;
    private $telephone;
    
    public function __construct() {
        
    }
    
    public function getCards(){
        // return a list of all cards associated with the user, if there is only one card, return that one, else return false
    }
    
    public function addCard(){
        // Add a new card associated with the user, return true if successful, else false.
    }
    
    public function removeCard($cardId) {
        // remove card associated with the user;
    }
}

?>