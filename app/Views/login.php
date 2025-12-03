<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-4">

      <h2 class="text-center mb-4 fw-bold">Entrar</h2>

      <?php if (isset($msg) && $msg != ''): ?>
        <div class="alert alert-danger text-center"><?php echo $msg ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuário</label>
          <input type="text" name="usuario" id="usuario" class="form-control" required autofocus>
        </div>

        <div class="mb-4">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" name="senha" id="senha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-dark w-100 btn-lg">Acessar</button>
      </form>

      <div class="text-center mt-3">
        <a href="<?php echo base_url('registrar') ?>">Criar uma conta</a>
      </div>

    </div>
  </div>

</body>

</html>