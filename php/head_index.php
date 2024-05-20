<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_354996bcb85d6a2dac07942e7066358d.png" />
  <title>Fábrica</title>
  <link href="css/reset.css" rel="stylesheet" />
  <!-- <link href="css/styles.css" rel="stylesheet" /> -->
  <link href="css/system.css" rel="stylesheet" />
  <link href="css/jquery-ui.css" rel="stylesheet" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../src/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../src/js/bootstrap.min.js" />
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

</head>
<style>
  .btn-fab {
    color: #fff;
    background-color: #007A5A;
    border-color: #007A5A;
  }

  .btn-fab:hover {
    color: #fff;
    background-color: #53B05C;
    border-color: #53B05C;
  }

  .btn-fab:focus,
  .btn-fab.focus {
    color: #fff;
    background-color: #53B05C;
    border-color: #53B05C;
    box-shadow: 0 0 0 0.2rem rgba(76, 76, 77, 0.5);
  }

  .btn-fab.disabled,
  .btn-fab:disabled {
    color: #fff;
    background-color: var(--secondary);
    border-color: var(--secondary);
  }

  .btn-fab:not(:disabled):not(.disabled):active,
  .btn-fab:not(:disabled):not(.disabled).active,
  .show>.btn-fab.dropdown-toggle {
    color: #fff;
    background-color: var(--secondary);
    border-color: var(--secondary);
  }

  .btn-fab:not(:disabled):not(.disabled):active:focus,
  .btn-fab:not(:disabled):not(.disabled).active:focus,
  .show>.btn-fab.dropdown-toggle:focus {
    box-shadow: 0 0 0 0.2rem rgba(37, 42, 48, 0.5);
  }


  .text-fab {
    color: #007A5A !important;
  }

  a.text-fab:hover,
  a.text-fab:focus {
    color: #53B05C !important;
  }

  .text-white {
    color: #fff !important;
  }

  a.text-white:hover,
  a.text-white:focus {
    color: #000 !important;
  }

  .nav-pills .nav-link,
  .nav-link-agenda {
    border: solid 0px transparent;
    font-size: 0.7rem;
    color: #85898d;
    font-weight: bold;
    background-color: transparent !important;
    margin: 0px;
    margin-top: -10px;
    margin-left: -10px;
  }

  .nav-pills .nav-link.active,
  .nav-pills .show>.nav-link,
  .nav-link-agenda.active {
    color: #007A5A !important;
    border-bottom: solid 3px #007A5A !important;
    border-width: 80%;
    background-color: #fff;
  }

  .btn-outline-fab {
    color: #007A5A;
    border-color: #007A5A;
    opacity: 0.8;
  }

  .btn-outline-fab:hover {
    opacity: 1;
    color: #007A5A;
    background-color: #007A5A;
    border-color: #007A5A;
  }

  .btn-outline-fab:focus,
  .btn-outline-fab.focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 115, 0, 0.5);
  }

  .btn-outline-fab.disabled,
  .btn-outline-fab.disabled:hover,
  .btn-outline-fab:disabled {
    color: #007A5A;
    background-color: transparent;
  }

  .btn-outline-fab:not(:disabled):not(.disabled):active,
  .btn-outline-fab:not(:disabled):not(.disabled).active,
  .show>.btn-outline-fab.dropdown-toggle {
    color: #fff;
    background-color: #007A5A;
    border-color: #007A5A;
  }

  .btn-outline-fab:not(:disabled):not(.disabled):active:focus,
  .btn-outline-fab:not(:disabled):not(.disabled).active:focus,
  .show>.btn-outline-fab.dropdown-toggle:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 115, 0, 0.5);
  }
</style>