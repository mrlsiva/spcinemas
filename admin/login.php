<?php
session_start();

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config = require __DIR__ . '/admin_config.php';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (hash_equals($config['username'], $username) && password_verify($password, $config['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta content="width=device-width, initial-scale=1.0" name="viewport">
 <title>SP Cinemas || Admin Login</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
 <div class="container" style="max-width:400px; margin-top:80px;">
  <h3 align="center">Admin Login</h3>
  <?php if ($error): ?>
   <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
  <form method="POST">
   <div class="form-group">
    <label>Username</label>
    <input type="text" name="username" class="form-control" required autofocus />
   </div>
   <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required />
   </div>
   <button type="submit" class="btn btn-success btn-block">Login</button>
  </form>
 </div>
</body>
</html>
