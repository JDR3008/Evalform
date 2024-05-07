<!-- This section will be included in multiple views on the website. 
It is responsible for displaying the questions and their respective options. -->
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
    <hr class="my-4">       
<?php endfor; ?>
