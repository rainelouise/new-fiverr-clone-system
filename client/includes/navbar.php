<nav class="bg-gradient-to-r from-green-600 to-emerald-500 shadow-md">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
    <a href="index.php" class="text-white text-2xl font-bold tracking-wide">Client Panel</a>

    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center space-x-6">
      <!-- Categories Dropdown -->
      <div class="relative group">
        <button class="text-white hover:text-gray-100 flex items-center space-x-1">
          <span>Categories</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <div class="absolute top-full left-0 mt-2 w-80 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
          <div class="p-4">
            <div class="grid grid-cols-1 gap-4">
              <?php
                $categories = $categoryObj->getCategories();
                foreach ($categories as $category):
              ?>
              <div class="group/category">
                <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                  <a href="browse.php?category=<?php echo $category['category_id']; ?>"
                     class="text-gray-800 font-medium hover:text-green-600">
                    <?php echo htmlspecialchars($category['category_name']); ?>
                  </a>
                  <svg class="w-4 h-4 text-gray-400 group-hover/category:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </div>

                <!-- Subcategories -->
                <div class="ml-4 mt-1 space-y-1 opacity-0 invisible group-hover/category:opacity-100 group-hover/category:visible transition-all duration-200">
                  <?php
                    $subcategories = $subcategoryObj->getSubcategories(null, $category['category_id']);
                    foreach ($subcategories as $subcategory):
                  ?>
                  <a href="browse.php?category=<?php echo $category['category_id']; ?>&subcategory=<?php echo $subcategory['subcategory_id']; ?>"
                     class="block text-sm text-gray-600 hover:text-green-600 hover:bg-gray-50 px-2 py-1 rounded">
                    <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                  </a>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <?php if (isset($_SESSION['is_fiverr_administrator']) && $_SESSION['is_fiverr_administrator']): ?>
        <a href="admin_dashboard.php" class="text-white hover:text-gray-100 bg-red-600 px-3 py-1 rounded">Admin Panel</a>
      <?php endif; ?>
      <a href="project_offers_submitted.php" class="text-white hover:text-gray-100">Project Offers Submitted</a>
      <a href="profile.php" class="text-white hover:text-gray-100">Profile</a>
      <a href="core/handleForms.php?logoutUserBtn=1" class="text-white hover:text-gray-100">Logout</a>
    </div>

    <!-- Mobile Menu Button -->
    <button id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false"
            class="md:hidden text-white focus:outline-none">
      <svg class="hamburger w-6 h-6 block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <svg class="close w-6 h-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Mobile Menu (hidden by default) -->
  <div id="mobile-menu" class="md:hidden hidden px-6 pb-4">
    <ul class="space-y-2">
      <!-- Mobile Categories -->
      <li class="border-b border-green-400 pb-2">
        <h3 class="text-white font-semibold mb-2">Categories</h3>
        <div class="space-y-2">
          <?php foreach ($categories as $category): ?>
          <div>
            <a href="browse.php?category=<?php echo $category['category_id']; ?>"
               class="block text-green-100 hover:text-white py-1">
              <?php echo htmlspecialchars($category['category_name']); ?>
            </a>
            <div class="ml-4 space-y-1">
              <?php
                $subcategories = $subcategoryObj->getSubcategories(null, $category['category_id']);
                foreach ($subcategories as $subcategory):
              ?>
              <a href="browse.php?category=<?php echo $category['category_id']; ?>&subcategory=<?php echo $subcategory['subcategory_id']; ?>"
                 class="block text-green-200 hover:text-white text-sm py-1">
                • <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </li>

      <?php if (isset($_SESSION['is_fiverr_administrator']) && $_SESSION['is_fiverr_administrator']): ?>
        <li><a href="admin_dashboard.php" class="block text-white hover:text-gray-100 bg-red-600 px-3 py-1 rounded">Admin Panel</a></li>
      <?php endif; ?>
      <li><a href="project_offers_submitted.php" class="block text-white hover:text-gray-100">Project Offers Submitted</a></li>
      <li><a href="profile.php" class="block text-white hover:text-gray-100">Profile</a></li>
      <li><a href="core/handleForms.php?logoutUserBtn=1" class="block text-white hover:text-gray-100">Logout</a></li>
    </ul>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu) return;

    const hamburger = btn.querySelector('.hamburger');
    const closeIcon = btn.querySelector('.close');

    btn.addEventListener('click', function () {
      const isNowHidden = menu.classList.toggle('hidden');
      if (hamburger) hamburger.classList.toggle('hidden');
      if (closeIcon) closeIcon.classList.toggle('hidden');
      btn.setAttribute('aria-expanded', String(!isNowHidden));
    });
  });
</script>