<nav class="site-nav">
    <ul>
        <li>
            <a href="/products/2-consoles/">CONSOLES</a>
        </li> 
        <li><a href="/products/3-games/">GAMES</a></li>
        <li><a href="/products/4-accessories/">ACCESSORIES</a></li>
        <?php if(!isset($_SESSION['SSNr'])){ ?><li><a href="/login/">Login/Register</a></li><?php } elseif (!isset($_SESSION['IsAdmin'])) { ?>
        <li>
        	<a href="/settings/">Settings</a>
        	<ul>
				<li><a href="/settings/orders/">Orders</a></li>
				<li><a href="/settings/user/">User</a></li>
			</ul>
        </li>
        <li><a href="/logout/">Logout</a></li><?php } else {?>
        <li><a href="/admin/">Admin</a></li><?php } ?>
        
    </ul>
</nav>