<?php require_once 'classloader.php'; ?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Client Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Register Form Section -->
  <div class="flex-grow flex items-center justify-center px-4">
    <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-8">
      <!-- Header -->
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Welcome to the Client Panel</h2>
        <p class="text-gray-500 text-sm">Register now to access your account!</p>
      </div>

      <!-- Flash Messages -->
      <?php  
        if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
          $color = ($_SESSION['status'] == "200") ? "green" : "red";
          echo "<div class='mb-4 p-3 text-white bg-$color-500 rounded-md text-center text-sm'>{$_SESSION['message']}</div>";
        }
        unset($_SESSION['message']);
        unset($_SESSION['status']);
      ?>

      <!-- Registration Form -->
      <form action="core/handleForms.php" method="POST" class="space-y-5">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Username</label>
          <input type="text" name="username" required
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Email</label>
          <input type="email" name="email" required
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Password</label>
          <input type="password" name="password" required
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
          <input type="password" name="confirm_password" required
                 class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        <div class="flex items-center justify-between">
          <p class="text-sm text-gray-600">
            Already have an account? 
            <a href="login.php" class="text-green-600 hover:underline">Login</a>
          </p>
          <button type="submit" name="insertNewUserBtn"
                  class="bg-gradient-to-r from-green-600 to-emerald-500 hover:opacity-90 text-white px-5 py-2 rounded-lg shadow-md transition">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>