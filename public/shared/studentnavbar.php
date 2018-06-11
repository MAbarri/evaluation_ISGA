<?php
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
    header('location: ../authentication/login.php');
  exit;
} else {
  if(strtoupper($_SESSION['role']) !== 'ETUDIENT')
      header('location: ../authentication/login.php');
}
 ?>
<header>
<div class="top_bar">
<div class="container">
<div class="col-md-6"></div>

<div class="col-md-6">
<ul class="rightc">
<li><i class="fa fa-envelope-o"></i> <?php echo $_SESSION['email']; ?>  </li>
<li><i class="fa fa-user"></i> <a href="webenlance.com" ><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></a></li>
</ul>
</div>
</div>
</div>
<!--top_bar-->
<nav class="navbar navbar-default" role="navigation">
    	<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/evaluation_ISGA/public/student/myExams.php"><img style="height: 40px; margin: 5px;" src="/evaluation_ISGA/public/img/logo.png"></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
    					<li class="dropdown">
    						<a href="/evaluation_ISGA/public/student/myExams.php"> Evaluation</a>
    					</li>
          <li><a href="/evaluation_ISGA/public/authentication/logout.php">Logout</a></li>

				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
