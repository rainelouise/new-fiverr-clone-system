<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../freelancer/index.php");
} 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Client Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <?php $userInfo = $userObj->getUsers($_SESSION['user_id']); ?>

  <!-- Page Header -->
  <div class="text-center py-8">
    <h1 class="text-3xl font-bold text-gray-800">Hello there and welcome!</h1>
    <p class="text-gray-500 mt-2">Manage your profile below</p>
  </div>

  <!-- Profile Section -->
  <div class="max-w-7xl mx-auto px-6">
    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col md:flex-row gap-8">

      <!-- Left Column: Profile Info -->
      <div class="md:w-1/2 flex flex-col items-center text-center md:text-left">
        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" 
             class="w-40 h-40 rounded-full object-cover mb-4" alt="Profile Picture">
        <h2 class="text-2xl font-bold text-gray-800"><?php echo $userInfo['username']; ?></h2>
        <p class="text-gray-600 mt-1"><?php echo $userInfo['email']; ?></p>
        <p class="text-gray-600 mt-1"><?php echo $userInfo['contact_number']; ?></p>
      </div>

      <!-- Right Column: Update Form -->
      <div class="md:w-1/2">
        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data" class="space-y-4">

          <div>
            <label class="block text-gray-700 font-medium mb-1">Username</label>
            <input type="text" value="<?php echo $userInfo['username']; ?>" disabled
                   class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" value="<?php echo $userInfo['email']; ?>" disabled
                   class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Contact Number</label>
            <input type="text" name="contact_number" value="<?php echo $userInfo['contact_number']; ?>" required
                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Bio</label>
            <textarea name="bio_description" 
                      class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"><?php echo $userInfo['bio_description']; ?></textarea>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Display Picture</label>
            <input type="file" name="display_picture" 
                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
          </div>

          <div class="flex justify-end">
            <button type="submit" name="updateUserBtn" 
                    class="bg-gradient-to-r from-green-600 to-emerald-500 text-white px-5 py-2 rounded-lg shadow-md hover:opacity-90 transition">
              Update Profile
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

</body>
</html>