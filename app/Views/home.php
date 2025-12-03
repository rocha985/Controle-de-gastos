<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero { padding: 60px 0; text-align: center; }
        .feature-card { border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <section class="hero bg-light">
        <div class="container">
            <h1 class="display-4">Controle suas finanças com facilidade</h1>
            <p class="lead">Junte-se a <strong><?= $total_usuarios ?></strong> usuários que já organizam seu dinheiro.</p>
            
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="<?= base_url('registrar') ?>" class="btn btn-lg btn-dark">
                    Criar Conta Grátis
                </a>

                <a href="<?= base_url('login') ?>" class="btn btn-lg btn-dark">
                    Já tenho conta
                </a>
            </div>

        </div>
    </section>

    <?php if (!empty($categorias)): ?>
    <section class="container py-5">
        <h2 class="text-center mb-4">O que você pode organizar?</h2>
        <div class="row">
            <?php foreach ($categorias as $cat): ?>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <h4><?= esc($cat['nome']) ?></h4>
                        <p class="text-muted"><?= esc($cat['descricao']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</body>
</html>