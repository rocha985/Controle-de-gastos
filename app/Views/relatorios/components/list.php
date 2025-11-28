<div class="card border-0 shadow-sm h-100">

    <div class="card-header bg-white border-0 pt-3">
        <h5 class="fw-bold text-dark">Gastos por Categoria</h5>
    </div>

    <div class="card-body overflow-auto" style="max-height: 340px;">

        <?php
          $cores = [
            "#FF6384",
            "#4BC0C0",
            "#FF9F40",
            "#9966FF",
            "#36A2EB",
            "#F08080",
            "#20C997",
            "#C9CBCF",
            "#FFCD56",
          ];

          $i = 0;
        ?>

        <ul class="list-group list-group-flush">

            <?php foreach ($lista as $d):

                $pct = ($totalBase > 0) ? ($d->total / $totalBase) * 100 : 0;

                $cor = $cores[$i % count($cores)];
                $i++;

              ?>
		            <li class="list-group-item px-0 border-0 mb-3">

		                <div class="d-flex justify-content-between mb-1">
		                    <span class="fw-semibold text-dark"><?php echo $d->categoria ?></span>
		                    <span class="fw-bold text-secondary">R$		                                                            <?php echo number_format($d->total, 2, ',', '.') ?></span>
		                </div>

		                <div class="progress" style="height: 8px;">
		                    <div class="progress-bar"
		                         role="progressbar"
		                         style="width:		                                       <?php echo $pct ?>%; background-color:<?php echo $cor ?>;">
		                    </div>
		                </div>

		                <small class="text-muted"><?php echo number_format($pct, 1) ?>% do total</small>
		            </li>

		            <?php endforeach; ?>

        </ul>

    </div>

</div>
