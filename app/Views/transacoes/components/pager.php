<?php $pager->setSurroundCount(2) ?>

<link rel="stylesheet" href="<?php echo base_url('css/pager.css') ?>">

<nav aria-label="Navegação de página">
  <ul class="pagination pagination-custom justify-content-center mb-0 mt-4">

    <?php if ($pager->getFirst()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="Primeira">
          <span aria-hidden="true"><i class="bi bi-chevron-double-left"></i></span>
        </a>
      </li>
    <?php endif ?>

    <?php if ($pager->hasPrevious()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Anterior">
          <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
        </a>
      </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>">
          <?= $link['title'] ?>
        </a>
      </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Próximo">
          <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
        </a>
      </li>
    <?php endif ?>

    <?php if ($pager->getLast()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Última">
          <span aria-hidden="true"><i class="bi bi-chevron-double-right"></i></span>
        </a>
      </li>
    <?php endif ?>
  </ul>
</nav>