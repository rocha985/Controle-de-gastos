<?php $pager->setSurroundCount(2)?>

<style>
    .pagination-dark .page-link {
        color: #000;
        background: transparent;
        margin: 0 2px;
        border-radius: 4px;
    }

    .pagination-dark .page-link:hover {
        color: #000;
        background-color: #fff;
    }

    .pagination-dark .page-item.active .page-link {
        border-color: #000;
        color: #000;
    }

    .pagination-dark .page-link:focus {
        box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.25);
    }
</style>

<nav>
    <ul class="pagination pagination-dark justify-content-center mb-0 mt-3">
        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $pager->getPrevious()?>">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        <?php endif?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?php echo $link['active'] ? 'active' : ''?>">
                <a class="page-link" href="<?php echo $link['uri']?>"><?php echo $link['title']?></a>
            </li>
        <?php endforeach?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $pager->getNext()?>">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        <?php endif?>
    </ul>
</nav>