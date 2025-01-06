<?php include "./../../../config.php"; ?>
<?php
$msg_login = "";
$flag = 1;
if (isset($_POST['submit'])) {
  session_start();
  $email = $_POST['email'];
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);
  $stmt->execute();
  // بررسی نتایج
  if ($stmt->rowCount() > 0) {
    // کاربر پیدا شد
    $_SESSION['login'] = true;
    header("Location: ./../../");
    exit();
  } else {
    // کاربر پیدا نشد
    $msg_login = "ایمیل یا رمز عبور اشتباه است.";
  }
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>php tutorial || blog project</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />

  <link rel="stylesheet" href="../../assets/css/style.css" />
</head>

<body class="auth">
  <main class="form-signin w-100 m-auto">
    <form action="login.php" method="post">
      <div class="fs-2 fw-bold text-center mb-4"><a href="./../../../">weblog</a></div>
      <div class="mb-3">
        <label class="form-label">ایمیل</label>
        <input type="email" class="form-control" name="email" required />
      </div>

      <div class="mb-3">
        <label class="form-label">رمز عبور</label>
        <input type="password" class="form-control" name="password" required />
      </div>
      <button class="w-100 btn btn-dark mt-4" type="submit" name="submit">ورود</button>
      <div class="form-text text-danger"><?= $msg_login ?></div>

    </form>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>