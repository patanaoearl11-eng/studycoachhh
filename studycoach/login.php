<?php
session_start();
include 'db_connect.php';

// --- SIGNUP ---
if (isset($_POST['signup'])) {
  $fullname = trim($_POST['fullname']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Check if email already exists
  $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    echo "<script>alert('Email already registered.'); window.location='login_register.php';</script>";
    exit;
  }

  // Hash password for security
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $insert = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
  $insert->bind_param("sss", $fullname, $email, $hashed_password);

  if ($insert->execute()) {
    echo "<script>alert('Account created successfully! Please log in.'); window.location='login_register.php';</script>";
  } else {
    echo "<script>alert('Error creating account.');</script>";
  }
  $insert->close();
}

// --- LOGIN ---
if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user['fullname'];
      echo "<script>alert('Login successful!'); window.location='dashboard.php';</script>";
    } else {
      echo "<script>alert('Incorrect password.');</script>";
    }
  } else {
    echo "<script>alert('No account found with that email.');</script>";
  }

  $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudyCoach | Login & Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .container {
      position: relative;
      width: 1000px;
      height: 600px;
      background: #fff;
      border-radius: 25px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
      transition: all 0.6s ease-in-out;
    }
    .form-container { position: absolute; top: 0; height: 100%; width: 50%; display: flex; align-items: center; justify-content: center; padding: 2rem; transition: all 0.6s ease-in-out; }
    .sign-in-container { left: 0; z-index: 2; background: white; }
    .sign-up-container { left: 0; opacity: 0; z-index: 1; background: white; }
    .container.right-panel-active .sign-in-container { transform: translateX(100%); }
    .container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; }
    .overlay-container { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100; }
    .overlay { background: linear-gradient(to right, #0f172a, #1e3a8a, #1d4ed8); color: #fff; position: relative; left: -100%; height: 100%; width: 200%; transform: translateX(0); transition: transform 0.6s ease-in-out; display: flex; }
    .container.right-panel-active .overlay-container { transform: translateX(-100%); }
    .container.right-panel-active .overlay { transform: translateX(50%); }
    .overlay-panel { position: absolute; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; top: 0; height: 100%; width: 50%; padding: 3rem; transition: all 0.6s ease-in-out; background: linear-gradient(to bottom right, #1e3a8a, #1d4ed8, #2563eb); }
    .overlay-left { left: 0; transform: translateX(-20%); }
    .container.right-panel-active .overlay-left { transform: translateX(0); }
    .overlay-right { right: 0; }
    .container.right-panel-active .overlay-right { transform: translateX(20%); }
    input { height: 50px; }
    button { transition: all 0.3s ease; }
    button:hover { transform: translateY(-2px); }
  </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800">
  <div class="container" id="container">

    <!-- Sign Up -->
    <div class="form-container sign-up-container">
      <form method="POST" class="flex flex-col w-96 space-y-6">
        <h2 class="text-4xl font-bold text-blue-900 mb-6 text-center">Create Account</h2>
        <input name="fullname" type="text" placeholder="Full Name" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-700" required />
        <input name="email" type="email" placeholder="Email" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-700" required />
        <input name="password" type="password" placeholder="Password" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-700" required />
        <button name="signup" class="bg-blue-800 hover:bg-blue-900 text-white font-semibold rounded-lg py-3 transition">Sign Up</button>
      </form>
    </div>

    <!-- Sign In -->
    <div class="form-container sign-in-container">
      <form method="POST" class="flex flex-col w-96 space-y-6">
        <h2 class="text-4xl font-bold text-blue-900 mb-6 text-center">Login to StudyCoach</h2>
        <input name="email" type="email" placeholder="Email" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-700" required />
        <input name="password" type="password" placeholder="Password" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-700" required />
        <button name="login" class="bg-blue-800 hover:bg-blue-900 text-white font-semibold rounded-lg py-3 transition">Login</button>
      </form>
    </div>

    <!-- Overlay Section -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2 class="text-4xl font-bold mb-2">Welcome Back!</h2>
          <p class="mb-6 text-base">Sign in to continue learning with StudyCoach.</p>
          <button id="signIn" class="bg-white text-blue-900 font-semibold px-8 py-3 rounded-full hover:bg-gray-100">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h2 class="text-4xl font-bold mb-2">Hello, Friend!</h2>
          <p class="mb-6 text-base">Enter your details to start your learning journey!</p>
          <button id="signUp" class="bg-white text-blue-900 font-semibold px-8 py-3 rounded-full hover:bg-gray-100">Sign Up</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const container = document.getElementById("container");
    document.getElementById("signUp").addEventListener("click", () => container.classList.add("right-panel-active"));
    document.getElementById("signIn").addEventListener("click", () => container.classList.remove("right-panel-active"));
  </script>
</body>
</html>
