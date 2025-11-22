<?php
include('layouts/header.php');

if (!isset($_POST['data_nascimento']) || empty($_POST['data_nascimento'])) {
  echo '<div class="alert alert-danger">Data de nascimento não fornecida.</div>';
  echo '<a href="index.php" class="btn btn-secondary">Voltar</a>';
  include('layouts/footer.php');
  exit;
}

$data_nascimento = $_POST['data_nascimento']; // formato: YYYY-MM-DD
$data_user = new DateTime($data_nascimento);
$dia_mes = $data_user->format('d/m'); // ex: 15/09

// Carrega o XML
$signos = simplexml_load_file("signos.xml");

$signo_encontrado = null;
$ano_atual = date('Y');

foreach ($signos->signo as $signo) {
  $inicio = DateTime::createFromFormat('d/m', $signo->dataInicio);
  $fim = DateTime::createFromFormat('d/m', $signo->dataFim);

  // Ajustar anos para comparação, considerando virada de ano (ex: Capricórnio: 22/12 a 20/01)
  if ($inicio > $fim) {
    // Signo cruza o Ano Novo: ex: 22/12 a 20/01 → dividimos em dois intervalos
    $inicio->setDate($ano_atual, (int)$inicio->format('m'), (int)$inicio->format('d'));
    $fim->setDate($ano_atual + 1, (int)$fim->format('m'), (int)$fim->format('d'));
    $data_teste = clone $data_user;
    $data_teste->setDate($ano_atual, (int)$data_user->format('m'), (int)$data_user->format('d'));
  } else {
    $inicio->setDate($ano_atual, (int)$inicio->format('m'), (int)$inicio->format('d'));
    $fim->setDate($ano_atual, (int)$fim->format('m'), (int)$fim->format('d'));
    $data_teste = clone $data_user;
    $data_teste->setDate($ano_atual, (int)$data_user->format('m'), (int)$data_user->format('d'));
  }

  if ($data_teste >= $inicio && $data_teste <= $fim) {
    $signo_encontrado = $signo;
    break;
  }
}

if ($signo_encontrado) {
  echo '<div class="card mx-auto" style="max-width: 600px;">';
  echo '<div class="card-header bg-success text-white text-center">';
  echo '<h2>' . htmlspecialchars($signo_encontrado->signoNome) . '</h2>';
  echo '</div>';
  echo '<div class="card-body text-center">';
  echo '<p class="lead">' . htmlspecialchars($signo_encontrado->descricao) . '</p>';
  echo '<a href="index.php" class="btn btn-primary">Nova consulta</a>';
  echo '</div>';
  echo '</div>';
} else {
  echo '<div class="alert alert-warning">Não foi possível determinar seu signo.</div>';
  echo '<a href="index.php" class="btn btn-secondary">Voltar</a>';
}

include('layouts/footer.php');