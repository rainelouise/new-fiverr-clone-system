<?php
// Include database classes for category/subcategory data
require_once 'client/classes/Database.php';
require_once 'client/classes/Category.php';
require_once 'client/classes/Subcategory.php';

$categoryObj = new Category();
$subcategoryObj = new Subcategory();
$categories = $categoryObj->getCategories();
?>

<nav class="bg-gradient-to-r from-green-600 to-emerald-500 shadow-md">
  <div class="max-w-7xl mx-auto px-6 py-4">
    <div class="flex items-center justify-between">
      <!-- Brand -->
      <a href="index.php" class="text-white text-2xl font-bold tracking-wide">Fiverr Clone</a>

      <!-- Desktop Navigation -->
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
                <?php foreach ($categories as $category): ?>
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

        <!-- Other Navigation Links -->
        <a href="client/login.php" class="text-white hover:text-gray-100">For Clients</a>
        <a href="freelancer/login.php" class="text-white hover:text-gray-100">For Freelancers</a>
      </div>

      <!-- Mobile menu button -->
      <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
      <div class="space-y-2">
        <!-- Mobile Categories -->
        <div class="border-b border-green-400 pb-2">
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
        </div>

        <!-- Other Mobile Links -->
        <a href="client/login.php" class="block text-white hover:text-gray-100 py-2">For Clients</a>
        <a href="freelancer/login.php" class="block text-white hover:text-gray-100 py-2">For Freelancers</a>
      </div>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', function() {
      mobileMenu.classList.toggle('hidden');
    });
  }
});
</script>