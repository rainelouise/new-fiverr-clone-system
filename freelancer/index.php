<?php require_once 'classloader.php'; ?>
<?php
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../freelancer/index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Freelancer Panel</title>
</head>
<body class="font-sans bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="text-3xl md:text-4xl font-bold text-center mb-6">
      Welcome!
      <span class="text-green-600"><?php echo $_SESSION['username']; ?></span>
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

      <!-- Add Proposal Form -->
      <div class="md:col-span-2">
        <div class="bg-white shadow rounded-lg p-6">
          <?php
          if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
            $color = $_SESSION['status'] == "200" ? "text-green-600" : "text-red-600";
            echo "<p class='mb-4 font-semibold $color'>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
            unset($_SESSION['status']);
          }
          ?>

          <h2 class="text-xl font-semibold mb-4">Add Proposal</h2>
          <form action="core/handleForms.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-1">Category</label>
              <select name="category_id" required id="categorySelect"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">Select a category</option>
                <?php
                  $categories = $categoryObj->getCategories();
                  foreach ($categories as $category):
                ?>
                <option value="<?php echo $category['category_id']; ?>">
                  <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Subcategory</label>
              <select name="subcategory_id" required id="subcategorySelect"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">Select a subcategory</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Description</label>
              <input type="text" name="description" required
                     class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Minimum Price</label>
              <input type="number" name="min_price" required
                     class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Maximum Price</label>
              <input type="number" name="max_price" required
                     class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Image</label>
              <input type="file" name="image" required
                     class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none">
            </div>
            <div class="text-right">
              <button type="submit" name="insertNewProposalBtn"
                      class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Proposals List -->
      <div class="md:col-span-3 space-y-6">
        <?php $getProposals = $proposalObj->getProposals(); ?>
        <?php foreach ($getProposals as $proposal) { ?>
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-green-700">
              <a href="other_profile_view.php?user_id=<?php echo $proposal['user_id']; ?>">
                <?php echo $proposal['username']; ?>
              </a>
            </h3>
            <img src="<?php echo '../images/' . $proposal['image']; ?>" alt="Proposal Image" class="w-full rounded-lg mt-3">
            <p class="mt-2 text-sm text-gray-500 italic"><?php echo $proposal['proposals_date_added']; ?></p>
            <p class="mt-3"><?php echo $proposal['description']; ?></p>
            <p class="mt-2 text-green-600 font-semibold">
              <?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']); ?> PHP
            </p>
            <div class="mt-2 text-sm text-gray-600">
              <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs"><?php echo htmlspecialchars($proposal['category_name']); ?></span>
              <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs ml-1"><?php echo htmlspecialchars($proposal['subcategory_name']); ?></span>
            </div>
            <div class="mt-4 text-right">
              <a href="#" class="text-green-600 hover:underline font-medium">Check out services</a>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>

    </div>
  </div>

  <script>
    // Handle category/subcategory dropdown interaction
    document.getElementById('categorySelect').addEventListener('change', function() {
      const categoryId = this.value;
      const subcategorySelect = document.getElementById('subcategorySelect');

      // Clear subcategory options
      subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';

      if (categoryId) {
        // Fetch subcategories for the selected category
        fetch('core/getSubcategories.php?category_id=' + categoryId)
          .then(response => response.json())
          .then(data => {
            data.forEach(subcategory => {
              const option = document.createElement('option');
              option.value = subcategory.subcategory_id;
              option.textContent = subcategory.subcategory_name;
              subcategorySelect.appendChild(option);
            });
          })
          .catch(error => {
            console.error('Error fetching subcategories:', error);
          });
      }
    });
  </script>
</body>
</html>