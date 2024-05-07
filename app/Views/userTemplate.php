<?= $this->extend('baseTemplate') ?>
<?= $this->section('content') ?>

    <!-- Navbar for User -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <?php if (isset($userType)): ?>
                <?php if ($userType == 'admin'): ?>
                    <a class="navbar-brand" href="#">EvalForm Admin</a>
                <?php else: ?>
                    <a class="navbar-brand" href="#">EvalForm</a>
                <?php endif ?>
            <?php else: ?>
                <a class="navbar-brand" href="#">EvalForm</a>
            <?php endif ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <?php if (isset($userType)): ?>
                        <?php if ($userType == 'user'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('')?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('view-surveys')?>">View Surveys</a>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                </ul>
                
                        
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($userType)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout')?>">Sign Out</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('login')?>">Sign In</a>
                        </li>
                    <?php endif ?>
                </ul>
                
            </div>
        </div>  
    </nav>

    <main>
        <!-- Unique page content -->
        <?= $this->renderSection('content') ?> 

    </main>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> EvalForm</p>
        </div>
    </footer>

<?= $this->endSection() ?>