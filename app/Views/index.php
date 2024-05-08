<!-- Extend the template -->
<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

    <section class="py-5 bg-light pattern-background">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!-- This section will check if a user is logged in, if so then it will display different text to the landing page -->
                    <?php if (isset($name)): ?>
                        <h1 class="typed-out">Hello, <?= esc($name) ?>!</h1>
                    <?php else: ?>
                        <h1 class="typed-out">Welcome to EvalForm!</h1>
                    <?php endif ?>

                    <p class="lead">EvalForm helps users create, edit and view surveys.</p>

                    <?php if (isset($name)): ?>
                        <a href="<?= base_url('view-surveys')?>" class="btn btn-primary btn-lg mb-3 mb-lg-0">View Your Surveys</a>
                    <?php else: ?>
                        <a href="<?= base_url('login')?>" class="btn btn-primary btn-lg mb-3 mb-lg-0">Get Started</a>
                    <?php endif ?>
                    
                </div>
                <div class="col-lg-6">
                    <img src="<?= base_url('images/evalform-home.png') ?> " alt="HomePage Screenshot" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- This section loads the card values from the controller to display on the page -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Change the Way You Create Surveys!</h2>
            <div class="row">

                <?php foreach ($cards as $card) : ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?= esc($card['title']); ?></h4>
                                <p class="card-text"><?= esc($card['text']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

<?= $this->endSection() ?>