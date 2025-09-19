<?php require_once 'classloader.php'; ?>
<?php
if (!$userObj->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($userObj->isClient()) {
    header("Location: ../client/index.php");
    exit();
}

// Get category and subcategory parameters
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
$subcategory_id = isset($_GET['subcategory']) ? (int)$_GET['subcategory'] : null;

// Get category and subcategory information
$category = null;
$subcategory = null;
$proposals = [];

if ($category_id) {
    $category = $categoryObj->getCategories($category_id);
    if ($subcategory_id) {
        $subcategory = $subcategoryObj->getSubcategories($subcategory_id);
    }

    // Get proposals based on filters
    $proposals = $proposalObj->getProposalsByCategory($category_id, $subcategory_id);
}

// Get all categories for sidebar
$all_categories = $categoryObj->getCategories();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $category ? htmlspecialchars($category['category_name']) : 'Browse Categories'; ?> - Freelancer Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-8">

    <!-- Breadcrumb -->
    <nav class="mb-6">
      <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li><a href="index.php" class="hover:text-green-600">Home</a></li>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <a href="browse.php" class="hover:text-green-600">Categories</a>
        </li>
        <?php if ($category): ?>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-800"><?php echo htmlspecialchars($category['category_name']); ?></span>
        </li>
        <?php if ($subcategory): ?>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-800"><?php echo htmlspecialchars($subcategory['subcategory_name']); ?></span>
        </li>
        <?php endif; ?>
        <?php endif; ?>
      </ol>
    </nav>

    <div class="grid lg:grid-cols-4 gap-8">

      <!-- Sidebar -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">All Categories</h3>
          <div class="space-y-2">
            <?php foreach ($all_categories as $cat): ?>
            <div>
              <a href="browse.php?category=<?php echo $cat['category_id']; ?>"
                 class="block text-gray-700 hover:text-green-600 hover:bg-gray-50 px-3 py-2 rounded <?php echo ($category_id == $cat['category_id']) ? 'bg-green-50 text-green-700 font-medium' : ''; ?>">
                <?php echo htmlspecialchars($cat['category_name']); ?>
              </a>
              <div class="ml-4 mt-1 space-y-1">
                <?php
                  $subcats = $subcategoryObj->getSubcategories(null, $cat['category_id']);
                  foreach ($subcats as $subcat):
                ?>
                <a href="browse.php?category=<?php echo $cat['category_id']; ?>&subcategory=<?php echo $subcat['subcategory_id']; ?>"
                   class="block text-sm text-gray-600 hover:text-green-600 hover:bg-gray-50 px-3 py-1 rounded <?php echo ($subcategory_id == $subcat['subcategory_id']) ? 'bg-green-50 text-green-700 font-medium' : ''; ?>">
                  • <?php echo htmlspecialchars($subcat['subcategory_name']); ?>
                </a>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="lg:col-span-3">

        <!-- Header -->
        <div class="mb-6">
          <?php if ($category): ?>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
              <?php echo htmlspecialchars($category['category_name']); ?>
              <?php if ($subcategory): ?>
                <span class="text-gray-600">- <?php echo htmlspecialchars($subcategory['subcategory_name']); ?></span>
              <?php endif; ?>
            </h1>
            <p class="text-gray-600">
              <?php echo htmlspecialchars($category['category_description']); ?>
            </p>
            <?php if ($subcategory): ?>
            <p class="text-gray-500 mt-2">
              <?php echo htmlspecialchars($subcategory['subcategory_description']); ?>
            </p>
            <?php endif; ?>
          <?php else: ?>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Browse Categories</h1>
            <p class="text-gray-600">Explore services by category and subcategory</p>
          <?php endif; ?>
        </div>

        <!-- Proposals Grid -->
        <?php if (!empty($proposals)): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($proposals as $proposal): ?>
          <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <img src="../images/<?php echo htmlspecialchars($proposal['image']); ?>"
                 alt="Proposal Image"
                 class="w-full h-48 object-cover">
            <div class="p-6">
              <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold text-gray-800">
                  <a href="other_profile_view.php?user_id=<?php echo $proposal['user_id']; ?>"
                     class="hover:text-green-600">
                    <?php echo htmlspecialchars($proposal['username']); ?>
                  </a>
                </h3>
                <span class="text-xs text-gray-500"><?php echo $proposal['proposals_date_added']; ?></span>
              </div>

              <p class="text-gray-600 mb-3 line-clamp-2"><?php echo htmlspecialchars($proposal['description']); ?></p>

              <div class="mb-3">
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs"><?php echo htmlspecialchars($proposal['category_name']); ?></span>
                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs ml-1"><?php echo htmlspecialchars($proposal['subcategory_name']); ?></span>
              </div>

              <div class="flex items-center justify-between">
                <span class="text-lg font-semibold text-green-600">
                  <?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']); ?> PHP
                </span>
                <a href="index.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                  View Details
                </a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php elseif ($category_id): ?>
        <div class="text-center py-12">
          <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-600 mb-2">No proposals found</h3>
          <p class="text-gray-500">
            <?php if ($subcategory): ?>
              No proposals found in this subcategory yet.
            <?php else: ?>
              No proposals found in this category yet.
            <?php endif; ?>
          </p>
        </div>
        <?php else: ?>
        <div class="text-center py-12">
          <h3 class="text-xl font-semibold text-gray-600 mb-2">Select a category to browse</h3>
          <p class="text-gray-500">Choose a category from the sidebar to view available proposals.</p>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

</body>
</html>