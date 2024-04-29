<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h1 class="text-center"><?= esc($title) ?></h1>
    <hr class="my-4">

    <div class="text-center">
      <button type="button" class="btn btn-outline-primary btn-lg" style="width: 100%;">
          <i class="bi bi-plus"></i> Generate QR Code
      </button>

      <div class="mb-3"></div>

      <a href="create-survey.html" class="btn btn-outline-success btn-lg" style="width: 100%;">
        <i class="bi bi-save"></i> Edit
      </a>

      <div class="mb-3"></div>

      <a href="view-surveys.html" class="btn btn-outline-danger btn-lg" style="width: 100%;">
        <i class="bi bi-save"></i> Back to Surveys
      </a>

    </div>


</div>



<?= $this->endSection() ?>