<!-- Extend the template -->
<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

    
    <div class="container mt-3">
        <h1 class="text-center"><?= esc($title) ?></h1>
        <hr class="my-4">

        <!-- This section of the code places the already existing questions on the screen.
        It does so by using a for loop, which will iterate over each question and (i) is used for determining the question number.
        Importantly, each question that is produced will have a bin icon which will send a post request. -->
        <?php for ($i = 0; $i < count($questions); $i++): ?>
            <h2>Question <?= $i + 1 ?> </h2>
            <p><?= $questions[$i]['question'] ?></p> 

            <?php if (!empty($options[$questions[$i]['question_id']])): ?> 
                <?php foreach ($options[$questions[$i]['question_id']] as $option): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_<?= $i + 1 ?>" id="option_<?= $option['option_id'] ?>" value="<?= $option['option_text'] ?>"> 
                        <label class="form-check-label" for="option_<?= $option['option_id'] ?>"><?= $option['option_text'] ?></label>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="mb-3">
                    <textarea class="form-control" name="text_answer_<?= $i + 1 ?>" id="exampleFormControlTextarea1" rows="2" placeholder="Please Enter Answer"></textarea>
                </div>
            <?php endif; ?>
            
            <!-- Delete button for each question -->
            <form class="d-inline" action="<?= base_url('view-surveys/' . $id . '/edit-survey/deleteQuestion'); ?>" method="post">
                <button type="submit" class="btn btn-danger" ><i class="bi bi-trash"></i></button>
                <input type="hidden" value=<?=$questions[$i]['question_id']?> name="question_id" />
            </form>

            <hr class="my-4">       
        <?php endfor; ?>

        
        <!-- Buttons that are placed below the questions -->
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


    <!-- This modal is responsible for being able to add questions on surveys. When the "Add Question" button it clicked, this modal
    will be displayed which gives the user the opportunity to write a question and provide up to 4 multiple choice options.
    The data is then sent as a post request and the relevant tables are updated in the controller. -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionlLabel">Add New Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" action="<?= base_url('view-surveys/' . $id . '/edit-survey/addQuestion'); ?>" method="post">
                        <div class="mb-3">
                            <label for="text" class="form-label">Question</label>
                            <input type="text" class="form-control" id="question" name="question">
                        </div>
                        <div class="mb-3">
                            <label for="option1" class="form-label">Add Options? (You Can Add Up to 4)</label>
                            <input type="text" class="form-control" id="option1" name="option1">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="option2" name="option2">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="option3" name="option3">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="option4" name="option4">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>