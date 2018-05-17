<?php include "templates/header.php"; ?>

  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card card-body bg-light mt-5">
          <h2>Dashboard <small class="text-muted"><?php echo $_SESSION['role']; ?></small></h2>
          <p>Welcome to the dashboard</p>
          <button><a href="authentication/logout.php">Logout</a></button>
        </div>
      </div>
    </div>
  </div>
<?php include "templates/footer.php"; ?>
