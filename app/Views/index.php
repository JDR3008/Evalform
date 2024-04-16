<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
    .btn-login {
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
        <h2 class="text-center mb-4">Login</h2>
        <form id="loginForm" action="<?= base_url('home')?>">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-login">Login</button>
        </form>
        <div class="text-center mt-3">
          <p>Not registered? <a href="<?= base_url('create-account')?>">Create an Account</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
