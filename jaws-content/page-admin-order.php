<?php jaws_header(); 
      if(isset($_POST['order-delete'])) {
          if($db->dbDeleteOrder($_GET['order'])){
              registerError("Order deleted","success");
              redirect("/admin/orders/");
          }else {
              registerError("Order couldn't be removed","danger");
              redirect();
          }
          
      }
      listAdminSingleOrder($_GET['order']);
      ?>
lololol
      <!-- START THE FEATURETTES -->
<?php jaws_footer(); ?>