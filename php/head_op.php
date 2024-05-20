<?php
// session_start();
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
  <title><?php echo $title;?></title>
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

</head>
<style>
  :root {
    --blue: #007bff;
    --indigo: #6610f2;
    --purple: #6f42c1;
    --pink: #e83e8c;
    --red: #dc3545;
    --orange: #ee7624;
    --yellow: #ffc107;
    --green: #28a745;
    --teal: #20c997;
    --cyan: #17a2b8;
    --white: #fff;
    --gray: #6c757d;
    --gray-dark: #4F4F51;
    --primary: #ee7624;
    --secondary: #6c757d;
    --success: #53b66a;
    --info: #129aaf;
    --warning: #daa300;
    --danger: #e21b2f;
    --light: #f0f0f0;
    --dark: #32363a;
    --breakpoint-xs: 0;
    --breakpoint-sm: 576px;
    --breakpoint-md: 768px;
    --breakpoint-lg: 992px;
    --breakpoint-xl: 1200px;
    --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
  }

  .faixaFab {
    background-color: #007A5A;
    width: 100vw;
    height: 100px;
    margin: 0 !important;
  }


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
</style>