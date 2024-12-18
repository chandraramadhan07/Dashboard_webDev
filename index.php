<?php
include 'database/database.php';
session_start();
$error = "";
if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $account = $result->fetch_assoc();
        $_SESSION["username"] = $account["username"];
        $_SESSION["role"] = $account["role"];
        header('Location: dashboard.php');
        exit();
    } else{
    $error = "Username atau password salah.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Inventory Grocery</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  </head>
  <body>
    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
      <div class="card cards card-login shadow-sm p-4 border-0" style="width: 40%; background-color: #f8fafc">
        <img src="asset/logo-login.png" class="mx-auto d-block" width=150 alt="">
        <h4 class="text-center ">Inventory Grocery Store</h4>
        <p class="text-center fw-semibold fs-4">Sign in</p>
          <div class="card-body">
          <?php if ($error): ?>
            <p style="color: red;"><?php echo $error;?></p>
          <?php endif; ?>
          <form method="POST">
            <div class="form-group mb-3">
              <label for="username" class="fw-semibold">Username</label>
              <input type="text" class="login form-control border-0" id="username" name="username" required />
              <div class="border border-dark"></div>
            </div>
            <div class="form-group">
              <label for="password" class="fw-semibold">Password</label>
              <input type="password" class="login form-control border-0" id="password" name="password" required />
              <div class="border border-dark"></div>
            </div>
            <button type="submit" name="login" class="btn btn-primary mt-5 w-100 btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
  </body>
</html>
