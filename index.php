<?php include('layouts/header.php'); ?>

<h2 class="text-center mb-4">Informe sua data de nascimento</h2>

<form id="signo-form" method="POST" action="show_zodiac_sign.php" class="row justify-content-center">
  <div class="col-md-6 mb-3">
    <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required />
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary">Descobrir meu signo</button>
  </div>
</form>

<?php include('layouts/footer.php'); ?>