<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>
  
  <div class="container mt-3">
    <h1 class="text-center">Survey 1</h1>
    <hr class="my-4">
    
    <!-- Pre-written Multiple Choice Questions -->
    <div class="mb-3">
      <h2>Question 1</h2>
      <p>This is a pre-written multiple choice question.</p>
      <form>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="option" id="option1" value="option1">
          <label class="form-check-label" for="option1">Option 1</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="option" id="option2" value="option2">
          <label class="form-check-label" for="option2">Option 2</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="option" id="option3" value="option3">
          <label class="form-check-label" for="option3">Option 3</label>
        </div>
      </form>
      <div class="mt-3">
        <button type="button" class="btn btn-outline-primary btn-lg">Edit</button>
        <button type="button" class="btn btn-outline-primary btn-lg">Delete</button>
      </div>
    </div>

    <!-- Add Buttons -->
    <div class="text-center">
      <button type="button" class="btn btn-outline-primary btn-lg" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
          <i class="bi bi-plus"></i> Add Question
      </button>

      <div class="mb-3"></div>

      <a href="<?= base_url('view-surveys')?>" class="btn btn-outline-success btn-lg" style="width: 100%;">
        <i class="bi bi-save"></i> Save
      </a>
    </div>
    

  </div>

  <!-- This section uses a modal to generate a pop-up menu to choose whether the user wants to add a multiple choice question or a short response question-->
  <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addQuestionModalLabel">Add Question</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p>Select the type of question you want to add:</p>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="questionType" id="multipleChoice" value="multipleChoice">
                      <label class="form-check-label" for="multipleChoice">Multiple Choice</label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="questionType" id="shortResponse" value="shortResponse">
                      <label class="form-check-label" for="shortResponse">Short Response</label>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Add</button>
              </div>
          </div>
      </div>
  </div>

  <?= $this->endSection() ?>