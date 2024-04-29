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
              <a class="nav-link" href="<?= base_url('logout')?>">Sign Out</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Table of users -->
    <section class="py-5">
        <div class="container table-container">
        <h1 style="margin-bottom: 40px;">Hello, <?= esc($name) ?>!</h1>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>User Management</h2>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <form method="get" action="<?= base_url('admin/'); ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div> 
                    </form>
                    
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
                            <th>ID</th>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= esc($user->id) ?></td>
                                <td><?= esc($user->username) ?></td>
                                <td><?= esc($user->group) ?></td>
                                <td><?= esc($user->secret) ?></td>
                                <td><?= esc($user->updated_at) ?></td>

                                <?php if ($user->active): ?>
                                    <td style="color: white" class="bg-success">Active</td>
                                <?php else: ?>
                                    <td style="color: white" class="bg-danger">Inactive</td>
                                <?php endif ?>

                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-primary me-2 edit-user-btn" 
                                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                                            data-user-id="<?= $user->id ?>" 
                                            data-email="<?= $user->secret ?>"
                                            data-username="<?= $user->username ?>">
                                            Edit
                                        </button>

                                        <form action="<?= base_url('admin/changeStatus/' . $user->id); ?>" method="post">
                                            <button type="submit" class="btn btn-sm btn-primary me-2">Change Status</button>
                                        </form>
                                    </div>
                                <td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>               
            
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?= $pager->links() ?>
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
                    <form id="addUserForm" action="<?= base_url('admin/add'); ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
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


    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" action="<?= base_url('admin/edit'); ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id"  readonly="readonly">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
       
       var editUserModal = document.getElementById('editUserModal')
       editUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var email = button.getAttribute('data-email')
        var username = button.getAttribute('data-username')
        var id = button.getAttribute('data-user-id')

        var modalTitle = editUserModal.querySelector('.modal-title')
        var idInput = editUserModal.querySelector('.modal-body input[name=id]')
        var emailInput = editUserModal.querySelector('.modal-body input[name=email]')
        var usernameInput = editUserModal.querySelector('.modal-body input[name=username]')

        
        modalTitle.textContent = "Edit User " + id
        idInput.value = id
        emailInput.value = email
        usernameInput.value = username
       });

    </script>
</body>
</html>

