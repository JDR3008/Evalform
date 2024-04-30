<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h1 class="text-center"><?= esc($title) ?></h1>
    <hr class="my-4">
    
    <?php for ($i = 0; $i < count($questions); $i++): ?>
        <h2>Question <?= $i + 1 ?> </h2>
        <p><?= $questions[$i]['question'] ?></p> 

        <?php if (!empty($options[$questions[$i]['question_id']])): ?>
            <?php foreach ($options[$questions[$i]['question_id']] as $option): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="option" id="option" value="option">
                    <label class="form-check-label" for="option"><?= $option['option_text'] ?></label>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="mb-3">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Please Enter Answer"></textarea>
            </div>
        <?php endif; ?>
        <hr class="my-4">
    <?php endfor; ?>

    <?= $this->renderSection('buttons') ?>

</div>


<?= $this->endSection() ?>