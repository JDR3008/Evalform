<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>


<div class="container mt-3">
    <h1 class="text-center"><?= esc($title) ?></h1>
    <hr class="my-4">

    <?php include('surveyForLoop.php')?>

    <div class="text-center">
      <form action="<?= base_url('view-surveys/' . $id . '/qrcode'); ?>" method="get">
        <button type="submit" class="btn btn-outline-primary btn-lg" style="width: 100%;">
          <i class="bi bi-plus"></i> Generate QR Code
        </button>
      </form>

      <div class="mb-3"></div>

      <div class="text-center">
      <form action="<?= base_url('view-surveys/' . $id . '/edit-survey'); ?>" method="get">
        <button type="submit" class="btn btn-outline-success btn-lg" style="width: 100%;">
          <i class="bi bi-save"></i> Edit
        </button>
      </form>

      <div class="mb-3"></div>

      <a href="<?= base_url('view-surveys')?>" class="btn btn-outline-danger btn-lg" style="width: 100%;">
        <i class="bi bi-save"></i> Back to Surveys
      </a>
    </div>

</div>

<?= $this->endSection() ?>