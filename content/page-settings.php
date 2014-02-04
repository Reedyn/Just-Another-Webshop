<?php includeHeader(); ?>	
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading ">Profile</div>
        <div class="panel-body">
            <?php
                listProfile();
            ?>
          <a href="/settings/user/" class="btn btn-default">Edit</a>
          <a href="/logout/" class="btn btn-default">Logout</a>

        </div>
        <div class="panel-heading ">Orders</div>
        <div class="panel-body">
          <a href="/settings/orders/"><p>Follow your orders here</p></a>
        </div>
     </div>
<?php includeFooter(); ?>	