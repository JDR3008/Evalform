<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

    <div class="container mt-3">
        <h1 class="text-center"><?= esc($title) ?></h1>
        <hr class="my-4">

        <form action="<?= base_url('respondent-survey/' . $id . '/submitResponses') ?>" method="post">
            <?php include('surveyForLoop.php')?>
        
            <div class="text-center">
                    <button type="submit" class="btn btn-outline-success btn-lg" style="width: 100%;">
                        <i class="bi bi-plus"></i> Submit Responses
                    </button>
            </div>
        </form>
    </div>

<?= $this->endSection() ?>