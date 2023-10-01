<section>

  <style>
    .error {
      text-align: center;
      padding: 30px 0;
    }

    .imgError {
      max-width: 160px;
    }
  </style>

  <div class="error rounded m-3 bg-gray-400">
    <img src="../images/<?= $_SESSION['logo'] ?>" alt="logo mini Antuco" class="imgError">
    <h1>Pagina no encontrada</h1>
    <a href="panel.php" class="btn btn-info">Ir a inicio</a>
  </div>

</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>