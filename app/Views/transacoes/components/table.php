<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="py-4 ps-4 border-0">Data</th>
                        <th class="py-4 border-0">Descrição</th>
                        <th class="py-4 border-0">Categoria</th>
                        <th class="py-4 border-0">Pagamento</th>
                        <th class="py-4 text-end border-0">Valor</th>
                        <th class="py-4 pe-4 text-center border-0" style="width: 80px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transacoes)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                Nenhuma movimentação registrada ainda.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transacoes as $t): ?>
                            <tr>
                                <td class="ps-4 text-muted"><?php echo date('d/m/Y', strtotime($t->data)) ?></td>
                                <td class="text-dark "><?php echo $t->titulo ?></td>

                                <td>
                                    <span class="badge rounded-pill                                                                    <?php echo($t->tipo_fluxo == 'receita') ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger'; ?>">
                                        <?php echo $t->tipo_nome ?>
                                    </span>
                                </td>

                                <td class="text-muted"><small><?php echo $t->forma_nome ?></small></td>

                                <td class="text-end fw-bold                                                            <?php echo($t->tipo_fluxo == 'receita') ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo($t->tipo_fluxo == 'receita' ? '+' : '-') . ' R$ ' . number_format($t->valor, 2, ',', '.') ?>
                                </td>

                                <td class="text-center pe-4">
                                    <a href="<?php echo base_url('transacoes/excluir/' . $t->id) ?>"
                                       class="btn btn-sm btn-outline-danger" title="Excluir"
                                       onclick="return confirm('Tem certeza que deseja apagar este lançamento?');">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-white border-0 py-3">
        <div class="d-flex justify-content-center">
            <?php if (isset($pager)): ?>
                <?php echo $pager->links('default', 'bootstrap_pagination')?>
            <?php endif; ?>
        </div>
    </div>
</div>