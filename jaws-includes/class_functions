<?php
    // -------------------------------------
    //  USER START
    // -------------------------------------
    function getUser($SSNr) { // Returns a product from the product as a Product class.
        global $db;
        //Call function in db.php to get the array of users
        $data=$db->dbGetUser($SSNr);

        $user=NULL;
        if($data!=NULL){
            $user=new User($data['SSNr'],$data['Mail'],$data['Password'],$data['FirstName'],$data['LastName'],$data['StreetAddress'],$data['PostAddress'],$data['City'],$data['Telephone'],$data['SessionKey'],$data['IsAdmin']);
        }
        return $user;
    }

    function getAllUsers(){
        global $db;

        $data=$db->dbGetUsersAll();

        $users=NULL;
        for($i=0;$i<count($data);$i++){
            $users=new User($data[$i]['SSNr'],$data[$i]['Mail'],$data[$i]['Password'],$data[$i]['FirstName'],$data[$i]['LastName'],$data[$i]['StreetAddress'],$data[$i]['PostAddress'],$data[$i]['City'],$data[$i]['Telephone'],$data[$i]['SessionKey'],$data[$i]['IsAdmin']);
        }
        return $users;
    }
    // END USER ------------------------------------|

    // -------------------------------------
    //  PRODUCT
    // -------------------------------------
    function getProduct($ProductId) { // Returns a product from the product as a Product class.
        global $db;
        $data=dbGetProduct($ProductId);
        $product=NULL;
        if($data!=NULL){
            $products=new Product($data['ProductId'],$data['Name'],$data['Description'],$data['ImgUrl'],$data['Taxanomy'],$data['Price'],$data['Stock'],$data['ProductWeight']);
        }
        return $product;
    }
    function getAllProducts(){
        global $db;
        $data=dbGetProductsAll();
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock'],$data[$i]['ProductWeight']);
        }
        return $products;
    }
    function getProductsFromTaxanomy($TaxanomyId){
        global $db;
        $data=dbGetProductsFromTaxanomy($TaxanomyId);
        $products=NULL;
        for($i=0;$i<count($data);$i++){
            $products[$i]=new Product($data[$i]['ProductId'],$data[$i]['Name'],$data[$i]['Description'],$data[$i]['ImgUrl'],$data[$i]['Taxanomy'],$data[$i]['Price'],$data[$i]['Stock'],$data[$i]['ProductWeight']);
        }
        return $products;

    }

    // END PRODUCT ---------------------------------|


    // -------------------------------------
    //  ORDER
    // -------------------------------------
    function getOrder($OrderId) { // Returns an order from the order as an Order class.
        global $db;
        //Call function in db.php to get the array of users
        $data=dbGetOrder($OrderId);

        $order=NULL;
        if($data!=NULL){
            $order=new Order($data['OrderId'],$data['SSNr'],$data['OrderDate'],$data['Discount'],$data['ChargedCard'],$data['OrderIP'],$data['ProductList']);
        }
        return $order;
    }
    function getAllOrders() { // Returns an order from the order as an Order class.
        global $db;
        $data=dbGetOrdersAll();
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    function getUsersOrders($SSNr) { // Returns an order from the order as an Order class.
        global $db;
        $data=dbGetUsersOrders($SSNr);
        $orders=NULL;
        for($i=0;$i<count($data);$i++){
            $orders[$i]=new Order($data[$i]['OrderId'],$data[$i]['SSNr'],$data[$i]['OrderDate'],$data[$i]['Discount'],$data[$i]['ChargedCard'],$data[$i]['OrderIP'],NULL);
        }
        return $orders;
    }
    // END ORDER ----------------------------------|

?>