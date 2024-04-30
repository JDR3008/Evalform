<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

<style>
    .table-responsive{
    max-height: clamp(10em,10vh,250px);
    overflow: auto;
    }

    #chart-container-1 { /* Replace with the specific container ID */
    width: 300px; 
    height: 250px;
}
</style>

<div class="container mt-3">
<h1 class="text-center"><?= esc($title) ?> Response Data</h1>
    <hr class="my-4">
    
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

        <h4>Responses</h4>
        
        <?php if (!empty($responses)): ?> 
            <div class="table-responsive"> 
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead class="sticky-top bg-white">
                        <tr>
                            <th>Response ID</th>
                            <th>Response</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($responses as $response): ?>
                            <?php if ($response['question_id'] == $questions[$i]['question_id']): ?> 
                                <tr>
                                    <td><?= $response['response_id'] ?></td>
                                    <td><?= $response['response'] ?></td>
                                </tr>
                            <?php endif; ?> 
                        <?php endforeach; ?> 
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No responses for this question yet.</p>
        <?php endif; ?>

        <?php if (!empty($options[$questions[$i]['question_id']])): ?> 
            <div id="chart-container-<?= $questions[$i]['question_id'] ?>" style="width: 50%; height: 50%; margin:auto;">
                <canvas id="questionChart-<?= $questions[$i]['question_id'] ?>"></canvas>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const questionChart = document.getElementById('questionChart-<?= $questions[$i]['question_id'] ?>');
                const optionLabels = [];
                const responseCounts = {};

                // Collect options and count responses
                <?php foreach ($options[$questions[$i]['question_id']] as $option): ?>
                    optionLabels.push('<?= $option['option_text'] ?>');
                <?php endforeach; ?>

                <?php foreach ($responses as $response): ?>
                    <?php if ($response['question_id'] == $questions[$i]['question_id']): ?>
                        responseCounts['<?= $response['response'] ?>'] = (responseCounts['<?= $response['response'] ?>'] || 0) + 1; 
                    <?php endif; ?> 
                <?php endforeach; ?>

                // Create the Chart
                new Chart(questionChart, {
                    type: 'pie', 
                    data: {
                        labels: optionLabels, 
                        datasets: [{
                            label: '# of Responses', 
                            data: optionLabels.map((label) => responseCounts[label] || 0), 
                        }]
                    },
                });
            </script>
        <?php endif; ?>

        <hr class="my-4">

    <?php endfor; ?>

    <!-- Add Buttons -->
    <div class="text-center" >

        <form action="<?= base_url('view-surveys/responses/' . $id . '/export'); ?>" method="post">
            <button type="submit" class="btn btn-outline-primary btn-lg" style="width: 100%;">
                <i class="bi bi-plus"></i> Export Responses For This Survey
            </button>
        </form>

        <div class="mb-3"></div>

        <a href="<?= base_url('view-surveys')?>" class="btn btn-outline-danger btn-lg" style="width: 100%;">
            <i class="bi bi-save"></i> Back to Surveys
        </a>

    </div>
  </div>

  
  
<?= $this->endSection() ?>


 