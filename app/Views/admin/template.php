<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Gastos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('css/admin.css') ?>">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark shadow-sm d-lg-none px-3 navbar-mobile">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <button class="btn btn-outline-light border-0 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-1"></i>
            </button>
        </div>
    </nav>

    <div class="wrapper">

        <aside class="sidebar bg-dark text-white shadow collapse d-lg-flex flex-column" id="sidebarMenu">

            <nav class="mt-3 mb-3 nav flex-column flex-grow-1 px-3 pt-3 pt-lg-0">
                <a class="nav-link rounded mb-2 text-white-50                                                                                                                                                                                                                                                     <?php echo(isset($active) && $active == 'lancamentos' ? ' active text-white fw-bold bg-primary bg-opacity-25' : '') ?>"
                    href="<?php echo base_url('transacoes') ?>">
                    Lançamentos
                </a>

                <?php
                  $isRelatorio = (isset($active) && strpos($active, 'relatorios') === 0);
                ?>

                <div class="nav-link rounded mb-1 d-flex justify-content-between align-items-center                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo $isRelatorio ? 'text-primary' : 'text-white-50' ?>">
                    <span class="fw-semibold">
                        Relatórios
                    </span>
                </div>

                <div id="submenuRelatorios" class="ms-3 border-start border-secondary border-opacity-25">
                    <div class="card card-body bg-transparent border-0 py-0 ps-3">

                        <a href="<?php echo base_url('relatorios/mensal') ?>"
                            class="nav-link small mb-1 rounded                                                                                                                                                                                                                                                         <?php echo(isset($active) && $active == 'relatorios-mensal') ? 'bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50' ?>">
                            Mensal
                        </a>

                        <a href="<?php echo base_url('relatorios') ?>"
                            class="nav-link small mb-1 rounded                                                                                                                                                                                                                                                         <?php echo(isset($active) && $active == 'relatorios-anual') ? 'bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50' ?>">
                            Anual
                        </a>

                        <a href="<?php echo base_url('relatorios/geral') ?>"
                            class="nav-link small mb-1 rounded                                                                                                                                                                                                                                                         <?php echo(isset($active) && $active == 'relatorios-geral') ? 'bg-primary bg-opacity-25 text-white fw-bold' : 'text-white-50' ?>">
                            Visão Geral
                        </a>

                    </div>
                </div>
            </nav>

            <div class="mt-auto border-top border-secondary p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center overflow-hidden">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2 flex-shrink-0" style="width: 32px; height: 32px;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="text-truncate">
                            <small class="text-white-50 d-block" style="font-size: 10px; line-height: 1;">Bem-vindo,</small>
                            <span class="text-white fw-semibold small">
                                <?php echo session()->get('nome') ?? 'Usuário' ?>
                            </span>
                        </div>
                    </div>

                    <a href="<?php echo base_url('login/logout') ?>" class="btn btn-sm btn-outline-danger ms-2" title="Sair">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
            </div>

        </aside>

        <div class="main-content w-100">
            <?php echo $this->renderSection('conteudo') ?>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebarMenu = document.getElementById('sidebarMenu');
        if (sidebarMenu) {
            sidebarMenu.addEventListener('show.bs.collapse', () => {
                document.body.style.overflow = 'hidden';
            });
            sidebarMenu.addEventListener('hide.bs.collapse', () => {
                document.body.style.overflow = '';
            });
        }
    </script>

    <script>
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebarMenu');
        const button = document.querySelector('[data-bs-target="#sidebarMenu"]');
        const isOpen = sidebar.classList.contains('show');
        if (!isOpen) return;
        if (sidebar.contains(event.target)) return;
        if (button.contains(event.target)) return;
        const collapse = bootstrap.Collapse.getInstance(sidebar);
        collapse.hide();
    });
    </script>

    <?php if (isset($abrir_modal) && $abrir_modal === true): ?>
        <script>
            $(document).ready(function () {
                var myModal = new bootstrap.Modal(document.getElementById('modalNovaTransacao'));
                myModal.show();
            });
        </script>
    <?php endif; ?>

</body>
</html>
