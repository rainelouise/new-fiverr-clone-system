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
  <title>Client Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Page Content -->
  <main class="flex-grow max-w-7xl mx-auto px-6 py-8">
    <!-- Welcome Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">
        Hello there and welcome, 
        <span class="text-green-600"><?php echo $_SESSION['username']; ?></span> 🎉
      </h1>
      <p class="text-gray-500 mt-2">Here are all the submitted project offers.</p>
    </div>

    <!-- Offers Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php $getOffers = $offerObj->getOffers(); ?>
      <?php foreach ($getOffers as $offer) { ?>
      <div class="bg-white rounded-xl shadow-md p-6 flex flex-col">
        <h2 class="text-lg font-semibold text-gray-800 mb-2"><?php echo $offer['username']; ?></h2>
        <p class="text-gray-600 mb-2"><?php echo $offer['description']; ?></p>
        <small class="text-gray-400 mb-4"><?php echo $offer['offer_date_added']; ?></small>

        <!-- Actions if offer belongs to logged-in user -->
        <?php if ($offer['user_id'] == $_SESSION['user_id']) { ?>
        <div class="flex space-x-2 mt-auto">
          <!-- Delete Button -->
          <form action="core/handleForms.php" method="POST" class="flex-1">
            <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
            <button type="submit" name="deleteOfferBtn"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm">
              Delete
            </button>
          </form>

          <!-- Update Button -->
          <form action="core/handleForms.php" method="POST" class="flex-1">
            <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
            <button type="submit" name="updateOfferBtn"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm">
              Update
            </button>
          </form>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
  </main>

</body>
</html>