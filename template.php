<div class="navbar" id="myNavbar">
<a href="index.php">Home</a>
<a href="#">News</a>
<a href="#">Contact</a>
<a href="#">About</a>
<a href="javascript:void(0);" class="icon" onclick="openNav()">&#9776;</a>
<?php include('login.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['userid'])) { ?>
  <a class="loginBtn" href="javascript:void(0);" onclick="document.getElementById('id01').style.display='block'">Login</a>
<?php
} else { ?>
  <div class="loginBtn">
    <a href="#" class="loginBtn"><i class="material-icons">person</i></a>
  </div>
<?php } ?>


<div class="modal" id="id01">
	<div class="modal-content animate">

	  <div class="closeContainer">
	  <span onclick="document.getElementById('id01').style.display ='none'" class="close">&times;</span>
	  </div>

	  <div class="tab">
		  <button id="defaultOpen" class="tablinks" onclick="openLogin(event, 'Login')">Login</button>
		  <button class="tablinks" onclick="openLogin(event, 'SignUp')">SignUp</button>
	  </div>

	  <div id="Login" class="tabcontent">
	  <img src="avatar.png" alt="Avatar" class="avatar"></img>
	  <form class="login" action="login.php" method="post">
		  <input type="text" placeholder="E-Mail" name="email" required>
		  <input type="password" placeholder="Password" name="password" required>
      <label class="rememberMe"><input type="checkbox" name="angemeldet_bleiben" value="1"> Angemeldet bleiben</label>
		  <button type="submit">Login</button>
	  </form>
	  </div>

	  <div id="SignUp" class="tabcontent">
	  <img src="avatar.png" alt="Avatar" class="avatar"></img>
	  <form class="signUp" action="register.php" method="post" name="register">
		  <input type="email" placeholder="Email" name="email" required>
		  <input type="text" placeholder="Firstname" name="firstname" required>
      <input type="text" placeholder="Lastname" name="lastname" required>
		  <input type="password" placeholder="Password" name="password" required>
      <input type="password" placeholder="Repeat Password" name="password2" required>
		  <button type="submit">Sign Up</button>
	  </form>
	  </div>
	</div>
</div>

</div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="index.php">Home</a>
  <?php if(isset($_SESSION['userid'])) { ?>
  <a href="myEvents.php">My Events</a>
  <a href="admin.php">Add Event</a>
  <a href="logout.php">Log out</a>
<?php } ?>
</div>
