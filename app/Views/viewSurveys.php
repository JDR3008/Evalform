<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h1 class="text-center">Your Surveys</h1>
    <hr class="my-4">

    <div class="row row-cols-md-4">
        <?php foreach ($surveys as $survey): ?>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="images/survey-image.jpg" class="card-img-top" alt="Survey 1 Image">
                    <div class="card-body p-3">
                        
                        <div class="d-flex">
                            <h5 class="card-title me-1"><?= esc($survey['title']) ?></h5> 
                            <button 
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#changeTitleModal"
                                data-survey-id="<?= esc($survey['survey_id']) ?>"
                                data-survey-title="<?= esc($survey['title']) ?>">
                                <i class="bi bi-pencil"></i>

                            </button> 
                        </div>
                        <p class="card-text">Updated: <?= esc($survey['updated_at']) ?>.</p>
                        <div>
                            <form class="d-inline" action="<?= base_url('view-surveys/' . $survey['survey_id']); ?>" method="get">
                                <button type="submit" class="btn btn-primary" >View Survey</button>
                            </form>

                            <form class="d-inline" action="<?= base_url('view-surveys/responses/' . $survey['survey_id']); ?>" method="get">
                                <button type="submit" class="btn btn-secondary" >View Data</button>
                            </form>
                            
                            <form class="d-inline" action="<?= base_url('view-surveys/deleteSurvey/' . $survey['survey_id']); ?>" method="post">
                                <button type="submit" class="btn btn-danger" ><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="modal fade" id="changeTitleModal" tabindex="-1" aria-labelledby="changeTitleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeTitle">Change Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changetitleModal" action="<?= base_url('view-surveys/changeSurveyTitle'); ?>" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="title" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="id" name="survey_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


     <!-- Create Survey Button -->
    <div class="text-center">
        <button 
            class="btn btn-outline-primary btn-lg" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#createSurveyModal"> 
            <i class="bi bi-plus" style="font-size: 4rem; font-weight: bold; line-height: 4rem;"></i>
        </button>
    </div>

    <div class="modal fade" id="createSurveyModal" tabindex="-1" aria-labelledby="changeTitleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeTitle">Create New Survey</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changetitleModal" action="<?= base_url('view-surveys/createSurvey'); ?>" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="title" class="form-control" id="title" name="title">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</div>

  <script>
       
       var changeTitleModal = document.getElementById('changeTitleModal')
       changeTitleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-survey-id')

        var title = button.getAttribute('data-survey-title')

        var idInput = changeTitleModal.querySelector('.modal-body input[name=survey_id]')
        var titleInput = changeTitleModal.querySelector('.modal-body input[name=title]')
        
        idInput.value = id
        titleInput.value = title
       });

    </script>

  <?= $this->endSection() ?>