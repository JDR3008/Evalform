<!-- Extend the base template -->
<?= $this->extend('baseTemplate') ?>
<?= $this->section('content') ?>

    <!-- This section of the code is responsible for displaying the relevant information on the NavBar.
    Depending on what user is logged in (i.e. user or admin), it will display different information -->
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

                    <!-- If user is logged in, display the relevant pages on NavBar -->
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
                
                <!-- Sign In / Sign Out Section of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($userType)): ?>
                        <li class="nav-item">
                            <a style="cursor:pointer;" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">Sign Out</a>
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
        <!-- This will display an error message if a user tries to access the admin page -->
        <?php if (isset($userType)): ?>
            <?php if ($userType == 'user'): ?>
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger" id="flash-message"><?= session('error') ?></div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('flash-message').style.display = 'none';
                        }, 4000); 
                    </script>
                <?php endif; ?>
            <?php endif ?>
        <?php endif ?>
        
        <!-- Unique page content -->
        <?= $this->renderSection('content') ?> 

    </main>
    
    <!-- This modal is used to ask whether the user wishes to log out or not -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logout">Log Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                    <form id="logout" action="<?= base_url('logout'); ?>" method="get">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> EvalForm</p>
        </div>
    </footer>

<?= $this->endSection() ?>