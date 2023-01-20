<?php
session_start();
?>

<!--Incluyendo el header-->
<?php include ("templates/header.php"); ?>

<!--bs5-jumbotron-fluid-->
<br />
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Bienvenid@ al Sistema</h1>
      
      <p class="col-md-8 fs-4">Usuario: 
        <strong><?= $_SESSION['usuario'];?></strong>
      </p>

      <button class="btn btn-primary btn-lg" type="button">Example button</button>
    </div>
  </div>


  <!--Incluyendo el footer-->
<?php include ("templates/footer.php"); ?>