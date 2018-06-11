<?php include "../templates/header.php"; ?>

<?php include "../shared/studentnavbar.php"; ?>
<?php

require_once '../../connection.php';

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
              <h2>Examen QCM XXXX<small> Veulliez selectionnez la/les réponses correct </small></h2>
            </div>
            <div class="col-md-2">
              <a class="btn btn-success pull-right">C'est fini</a>
            </div>
          </div>
          <div class="row">

            <table class="col-md-12 table table-hover">
              <tr>
                <td class="col-md-8">Question</td>
                <td class="col-md-4">Choix</td>
              </tr>

              <?php foreach ($result as $row) : ?>
              <tr>
                <td>4+4 = ?</td>
                <td>
                  <div class="checkbox">
                    <label><input type="checkbox"> 8</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox"> 12</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox"> 73</label>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include "../templates/footer.php"; ?>
