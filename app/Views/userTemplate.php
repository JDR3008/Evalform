<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvalForm</title>
    <!-- Import Bootstrap Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- Import Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    
</head>
<body class="page-container">
    
    <!-- Navbar for User -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EvalForm</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <?php if (isset($name)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('')?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('view-surveys')?>">View Surveys</a>
                        </li>
                    <?php endif ?>
                </ul>
                
                        
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($name)): ?>
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

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>