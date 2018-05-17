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
				<a class="navbar-brand" href="/evaluation_ISGA/public/admin"><img src="http://placehold.it/150x50&text=Logo"></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Utilisateurs</a>
						<ul class="dropdown-menu">
							<li><a href="/evaluation_ISGA/public/admin/users/index.php">Gestion des utilisateurs</a></li>
							<li><a href="/evaluation_ISGA/public/admin/usertypes/index.php">Gestion des types d'utilisateurs</a></li>
						</ul>
					</li>
  					<li class="dropdown">
  						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Administration</a>
  						<ul class="dropdown-menu">
  							<li><a href="/evaluation_ISGA/public/admin/niveux/index.php">Gestion des niveaux</a></li>
  							<li><a href="/evaluation_ISGA/public/admin/filieres/index.php">Gestion des filliéres</a></li>
  							<li><a href="/evaluation_ISGA/public/admin/modules/index.php">Gestion des modules</a></li>
  						</ul>
  					</li>
    					<li class="dropdown">
    						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Evaluation</a>
    						<ul class="dropdown-menu">
    							<li><a href="/evaluation_ISGA/public/admin/question/index.php">Gestion des Questions</a></li>
    							<li><a href="/evaluation_ISGA/public/admin/questiontypes/index.php">Gestion des types de Questions</a></li>
                  <li class="divider"></li>
                  <li><a href="/evaluation_ISGA/public/admin/examens/index.php">Gestion des Examens</a></li>
    							<li><a href="/evaluation_ISGA/public/admin/examentypes/index.php">Gestion des types de Examens</a></li>
    						</ul>
    					</li>
          <li><a href="/evaluation_ISGA/public/authentication/logout.php">Logout</a></li>

				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
