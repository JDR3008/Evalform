<!-- Extend the template -->
<?= $this->extend('userTemplate') ?>
<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container table-container">
        <h1 style="margin-bottom: 40px;">Hello, <?= esc($name) ?>!</h1>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>User Management</h2>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">

                    <!-- A get request is sent for when the search button is clicked -->
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

            <!-- Create a table which displays all the users so admins can view them -->
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

                    <!-- Use a foreach loop to iterate over the users returned from the controller. This then inserts them in the table -->
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
                                            data-user-id="<?= esc($user->id) ?>" 
                                            data-email="<?= esc($user->secret) ?>"
                                            data-username="<?= esc($user->username) ?>">
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
    <!-- Note that, it will automatically enter the user unique ID number -->
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

    <!-- This section allows a pop-up menu to edit a user -->
    <!-- Note that, it will automatically enter the user unique ID number (this value is readonly and cannot be edited) -->
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

    <script>
       
    // This section is responsible for loading the data into the modal when editing a user
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

<?= $this->endSection() ?>

