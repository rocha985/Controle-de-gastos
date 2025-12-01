<?php $this->extend('admin/template') ?>

<?php $this->section('conteudo') ?>

<?php echo $this->include('transacoes/components/header') ?>

<?php echo $this->include('transacoes/components/table') ?>

<?php echo $this->include('transacoes/components/alerts') ?>

<?php echo $this->include('transacoes/components/modal_create') ?>

<?php $this->endSection() ?>