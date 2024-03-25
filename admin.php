<?php
require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn()){
	Redirect::to('login.php');
	else{
	?>
	<h1>Welcome</h1>
	<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?> !</a> 
		<ul>
			<li><a href="logout.php">Logout</a></li>
			<li><a href="update.php">Update profile</a></li>
			<li><a href="changepassword.php">Change password</a></li>
		</ul>
	</p>
<?php
    }
}
else{
	echo "<p>You need to <a href='register.php'>register</a></p>";
	echo "<p>You need to <a href='login.php'>login</a></p>";
}

