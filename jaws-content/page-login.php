		
		<section class="wrapper">
			<article class="main-content">
				<?php var_dump($_POST);
				if (isset($_POST['register'])){
					if (!preg_match('^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]{1,}@[a-z0-9.-]+\.[a-z]{2,4}^', $_POST['email'])){
						echo "Name invalid!";
					} elseif (!preg_match('^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]{1,}@[a-z0-9.-]+\.[a-z]{2,4}^', $_POST['email'])){
						echo "LastName invalid!";
					} elseif (!preg_match('^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]{1,}@[a-z0-9.-]+\.[a-z]{2,4}^', $_POST['email'])){
						echo "E-Mail invalid!";
					}
				}
				
				if (isset($_POST['login'])){
					if (!preg_match('^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]{1,}@[a-z0-9.-]+\.[a-z]{2,4}^', $_POST['email'])){
						echo "Name invalid!";
					} elseif (!preg_match('^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]{1,}@[a-z0-9.-]+\.[a-z]{2,4}^', $_POST['email'])){
						echo "LastName invalid!";
					} elseif (!preg_match('^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]{1,}@[a-z0-9.-]+\.[a-z]{2,4}^', $_POST['email'])){
						echo "E-Mail invalid!";
					}
				}
				
				?>
				<form action="/login/" method="post">
					<input type="text" name="firstName" pattern="^.+$" required placeholder="first name..."></br>
					<input type="text" name="lastName" pattern="^.+$" required placeholder="last name..."></br>
					<input type="text" name="streetAdress" pattern="^.+$" required placeholder="street address..."></br>
					<input type="text" name="postAddress" pattern="^([0-9]\s)+$" required placeholder="post address..."></br>
					<input type="text" name="city" pattern="^[a-zåäöÅÄÖ]+$" required placeholder="city..."></br>
					<input type="text" name="phone" pattern="^(\+46|0)[0-9]*$" required placeholder="phone..."></br>
					<input type="text" name="email" required pattern="^[a-z0-9åäöÅÄÖ._%+-]+[a-zåäöÅÄÖ0-9]{1,}@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="email..."></br>
					<input type="password" name="password" pattern="^[a-zA-ZåäöÅÄÖ0-9]{6,30}$" required id="password" placeholder="password..."></br>
					<select name="country" placeholder="country...">
						<option value="sweden">Sweden</option>
						<option value="norway">Norway</option>
						<option value="usa">United States of America</option>
						<option value="china">China</option>
					</select></br>
					<input type="submit" name="register" value="Register">	
				</form>								
				
			</article>
		</section><!-- .wrapper -->
