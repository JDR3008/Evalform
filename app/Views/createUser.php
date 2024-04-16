<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f8f9fa;
    }
    .form-container {
      max-width: 400px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      color: #007bff;
      margin-bottom: 30px;
    }
    .btn-register {
      font-size: 1.2rem;
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mb-4">EvalForm</h1>
    <div class="row justify-content-center">
      <div class="col-md-8 form-container">
        <h2 class="text-center mb-4">Create an Account</h2>
        <form id="registerForm" action="home.html" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <button type="submit" class="btn btn-primary btn-register">Register</button>
        </form>
        <div class="text-center mt-3">
          <p>Already have an account? <a href="<?= base_url('')?>">Login</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
