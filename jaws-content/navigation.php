    <body>
        <div class="navbar-wrapper">
          <div class="container">
    
            <div class="navbar navbar-inverse navbar-static-top" role="navigation">
              <div class="container">
                <div class="navbar-header">
                  <?php if(isLoggedIn()) { ?>
                  <li class="shoppingCart"><a href="/cart/"><span class="glyphicon glyphicon-shopping-cart"></a></li>
                  <?php } ?>
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">
                    <img src="/jaws-content/themes/default/img/logotype.png">
                  </a>
                </div>
                <div class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/products/">Products</a></li>
                    <?php if(isLoggedIn()) { ?>
                    <li><a href="/settings/">Settings</a></li>
                    <?php if(isAdmin()) { ?>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="/admin/orders/">Orders</a></li>
                        <li><a href="/admin/products/">Products</a></li>
                        <li><a href="/admin/users/">Users</a></li>
                        <li><a href="/admin/categories/">Categories</a></li>
                      </ul>
                    </li>
                    <?php } ?>
                    <li><a href="/logout/">Logout</a></li>
                    <?php } else { ?>
                    <li><a href="/login/">Login for testing</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login/Register<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="/login/">Login</a></li>
                        <li><a href="/register/">Register</a></li>
                      </ul>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
    
          </div>
        </div>