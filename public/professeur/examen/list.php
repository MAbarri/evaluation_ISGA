<?php include "../../templates/header.php"; ?>

<?php include "../../shared/publicnavbar.php"; ?>
<?php

require_once '../../../connection.php';

  try  {
    $sql = "SELECT exams.date, CONCAT(users.firstName ,' ', users.lastName) as owner, typeExam.name as type
    FROM exams
        INNER JOIN users ON users.id = exams.userId
        INNER JOIN typeExam ON typeExam.id = exams.typeExamId";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
?>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card card-body bg-light mt-5">
          <div class="row">
            <div class="col-md-10">
              <h2>Base de données Examens</h2>
            </div>
            <div class="col-md-2">
              <a class="btn btn-default pull-right" href="/evaluation_ISGA/public/professeur/examen/generate.php">Generer un Examen</a>
            </div>
          </div>
          <div class="row">

            <table class="col-md-12 table table-hover">
              <tr>
                <td>Propriétaire</td>
                <td>Type</td>
                <td>Nombre de Question</td>
                <td>Date</td>
              </tr>

              <?php foreach ($result as $row) : ?>
              <tr>
                <td><?php echo $row["owner"]; ?></td>
                <td><?php echo $row["type"]; ?></td>
                <td><?php echo "nb Question" /*$row["choix"];*/ ?></td>
                <td><?php echo $row["date"]; ?></td>
              </tr>
            <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include "../../templates/footer.php"; ?>
