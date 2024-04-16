<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvalForm | Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Custom styles for elements */
        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
        }

        .page-container {
            display: grid;
            grid-template-rows: auto 1fr auto;
            min-height: 100vh;
        }

        @media (max-width: 575px) {
            .table-container {
                max-width: 100vw;
            }
        }
    </style>
</head>
<body class="page-container">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">EvalForm Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <!-- Sign Out option -->
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('')?>">Sign Out</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Table of users -->
    <section class="py-5">
        <div class="container table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>User Management</h2>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <button class="btn btn-primary" type="button">Search</button>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
                </div>
            </div>
            <!-- Enter pre-written data -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>s1234567</td>
                            <td>James</td>
                            <td>De Raat</td>
                            <td>jamesderaat@example.com</td>
                            <td>2024-03-26</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-2">Edit</button>
                                <button class="btn btn-sm btn-danger me-2">Make Inactive</button>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>billsmith</td>
                            <td>Bill</td>
                            <td>Smith</td>
                            <td>billsmith@example.com</td>
                            <td>2024-03-27</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-2">Edit</button>
                                <button class="btn btn-sm btn-success me-2">Make Active</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>               
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>

    <!-- This section allows a pop-up menu to add a user -->
    <!-- Note that, it will automatically enter the user unique ID number (default set to three for mock up) -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="userId" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="userId" value="3" disabled> <!-- Disabled so user cannot change value -->
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; <?= date('Y') ?> EvalForm</p>
        </div>
    </footer>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

