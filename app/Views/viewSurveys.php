<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h1 class="text-center">Your Surveys</h1>
    <hr class="my-4">

    <div class="row row-cols-md-4">
        <!-- Survey Card 1 -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="images/survey-image.jpg" class="card-img-top" alt="Survey 1 Image">
                <div class="card-body p-3">
                    <h5 class="card-title">Survey 1</h5>
                    <p class="card-text">Last Updated 25th of March 2024.</p>
                    <a href="survey.html" class="btn btn-primary">View Survey</a>
                    <a href="responses.html" class="btn btn-secondary">View Data</a>
                    <a href="#" class="btn btn-danger" ><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>

        <!-- Survey Card 2 -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="<?php echo base_url('images/survey-image.jpg'); ?>" class="card-img-top" alt="Survey 2 Image">
                <div class="card-body p-3">
                    <h5 class="card-title">Survey 2</h5>
                    <p class="card-text">Last Updated 25th of March 2024.</p>
                    <a href="#" class="btn btn-primary">View Survey</a>
                    <a href="#" class="btn btn-secondary">View Data</a>
                    <a href="#" class="btn btn-danger" ><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>
        <!-- Survey Card 3 -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="images/survey-image.jpg" class="card-img-top" alt="Survey 3 Image">
                <div class="card-body p-3">
                    <h5 class="card-title">Survey 3</h5>
                    <p class="card-text">Last Updated 25th of March 2024.</p>
                    <a href="#" class="btn btn-primary">View Survey</a>
                    <a href="#" class="btn btn-secondary">View Data</a>
                    <a href="#" class="btn btn-danger" ><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>

        <!-- Survey Card 4 -->
        <div class="col-md-3 mb-3">
          <div class="card">
              <img src="images/survey-image.jpg" class="card-img-top" alt="Survey 3 Image">
              <div class="card-body">
                  <h5 class="card-title">Survey 4</h5>
                  <p class="card-text">Last Updated 25th of March 2024.</p>
                  <a href="#" class="btn btn-primary">View Survey</a>
                  <a href="#" class="btn btn-secondary">View Data</a>
                  <a href="#" class="btn btn-danger" ><i class="bi bi-trash"></i></a>

              </div>
          </div>
      </div>
  </div>

     <!-- Create Survey Button -->
  <div class="text-center">
    <a href="<?php echo base_url('edit-survey'); ?>" class="btn btn-outline-primary btn-lg d-flex justify-content-center align-items-center mb-3" style="width: 100%;">
      <i class="bi bi-plus" style="font-size: 4rem; font-weight: bold; line-height: 4rem;"></i>
    </a>
  </div>

    
  </div>

  <?= $this->endSection() ?>