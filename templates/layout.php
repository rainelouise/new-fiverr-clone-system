<?php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Fiverr Clone</title>
</head>
<body class="font-sans text-gray-800 bg-gray-50">

  <!-- Navbar -->
  <?php include 'navbar.php'; ?>

  <!-- Page Content -->
  <main class="max-w-7xl mx-auto px-6 py-10">
    <?php if (isset($content)) echo $content; ?>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300 mt-10">
    <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-white font-bold mb-3">Categories</h3>
        <ul class="space-y-2">
          <?php foreach ($categories as $category): ?>
          <li><a href="browse.php?category=<?php echo $category['category_id']; ?>" class="hover:text-white"><?php echo htmlspecialchars($category['category_name']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div>
        <h3 class="text-white font-bold mb-3">About</h3>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-white">Careers</a></li>
          <li><a href="#" class="hover:text-white">Press</a></li>
          <li><a href="#" class="hover:text-white">Partnerships</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-white font-bold mb-3">Support</h3>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-white">Help Center</a></li>
          <li><a href="#" class="hover:text-white">Trust & Safety</a></li>
          <li><a href="#" class="hover:text-white">Community</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-white font-bold mb-3">Follow Us</h3>
        <div class="flex space-x-4">
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384005.png" class="w-6 h-6"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" class="w-6 h-6"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" class="w-6 h-6"></a>
        </div>
      </div>
    </div>
    <div class="border-t border-gray-700 text-center py-4 text-sm text-gray-400">
      © <?php echo date("Y"); ?> Fiverr Clone. All rights reserved.
    </div>
  </footer>

</body>
</html>