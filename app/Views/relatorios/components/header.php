<?php
  $tituloDinamico = isset($filtroMes) ? 'Relatório Mensal' : 'Relatório Anual';
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="display-6 fw-bold text-dark"><?php echo $tituloDinamico?></h1>
    </div>

    <form class="d-flex align-items-center bg-white p-2 rounded shadow-sm border" method="GET">

        <?php if (isset($filtroMes)): ?>
            <label class="me-2 fw-bold text-muted small">MÊS:</label>
            <select name="mes" class="form-select border-0 bg-light fw-bold me-3" style="width: 130px;"
                onchange="this.form.submit()">
                <?php
                  $meses = [
                    1  => 'Janeiro',
                    2  => 'Fevereiro',
                    3  => 'Março',
                    4  => 'Abril',
                    5  => 'Maio',
                    6  => 'Junho',
                    7  => 'Julho',
                    8  => 'Agosto',
                    9  => 'Setembro',
                    10 => 'Outubro',
                    11 => 'Novembro',
                    12 => 'Dezembro',
                  ];
                foreach ($meses as $num => $nome): ?>
                    <option value="<?php echo $num?>" <?php echo ($num == $filtroMes) ? 'selected' : ''?>>
                        <?php echo $nome?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <label class="me-2 fw-bold text-muted small">ANO:</label>
        <select name="ano" class="form-select border-0 bg-light fw-bold" style="width: 100px;"
            onchange="this.form.submit()">
            <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                <option value="<?php echo $y?>" <?php echo ($y == $filtroAno) ? 'selected' : ''?>><?php echo $y?></option>
            <?php endfor; ?>
        </select>
    </form>
</div>