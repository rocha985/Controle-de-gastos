<?php if (session()->getFlashdata('msg')): ?>
  <div class="alert alert-<?php echo session()->getFlashdata('msg_icon') ?> alert-dismissible fade show shadow"
    role="alert" style="position: fixed; bottom: 15px; left: 15px; z-index: 9999; width: 300px;">

    <strong><?php echo session()->getFlashdata('msg') ?></strong>

    <?php if (session()->getFlashdata('erros')): ?>
      <ul class="mb-0 mt-1 small">
        <?php foreach (session()->getFlashdata('erros') as $erro): ?>
          <li><?php echo $erro ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>