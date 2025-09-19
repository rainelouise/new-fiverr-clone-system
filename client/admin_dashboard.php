<?php require_once 'classloader.php'; ?>
<?php
if (!$userObj->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (!$userObj->isFiverrAdministrator()) {
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Category Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Page Content -->
  <main class="flex-grow max-w-7xl mx-auto px-6 py-8">
    <!-- Welcome Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">
        Admin Dashboard -
        <span class="text-green-600"><?php echo $_SESSION['username']; ?></span> 
      </h1>
      <p class="text-gray-500 mt-2">Manage categories and subcategories for the platform</p>
    </div>

    <!-- Flash Messages -->
    <div class="text-center mb-6">
      <?php
        if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
            $color = ($_SESSION['status'] == "200") ? "green" : "red";
            echo "<div class='inline-block px-4 py-2 rounded-lg bg-{$color}-100 text-{$color}-700 font-medium'>{$_SESSION['message']}</div>";
        }
        unset($_SESSION['message']);
        unset($_SESSION['status']);
      ?>
    </div>

    <!-- Admin Actions -->
    <div class="mb-8 text-center">
      <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg mr-4">
        Switch to Client View
      </a>
      <a href="../freelancer/index.php" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg">
        Switch to Freelancer View
      </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">

      <!-- Categories Management -->
      <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="bg-green-600 text-white p-4">
          <h2 class="text-xl font-bold">Categories Management</h2>
        </div>

        <div class="p-6">
          <!-- Add Category Form -->
          <form action="core/handleAdminForms.php" method="POST" class="mb-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Add New Category</h3>
            <div>
              <label class="block text-gray-700 font-medium mb-1">Category Name</label>
              <input type="text" name="category_name" required
                     class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
            </div>
            <div>
              <label class="block text-gray-700 font-medium mb-1">Description</label>
              <textarea name="category_description" rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"></textarea>
            </div>
            <button type="submit" name="addCategoryBtn"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
              Add Category
            </button>
          </form>

          <!-- Categories List -->
          <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Existing Categories</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
              <?php
                $categories = $categoryObj->getCategories();
                foreach ($categories as $category):
              ?>
              <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-start">
                  <div class="flex-grow">
                    <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($category['category_name']); ?></h4>
                    <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($category['category_description']); ?></p>
                    <p class="text-xs text-gray-500 mt-2">Added: <?php echo $category['date_added']; ?></p>
                  </div>
                  <div class="ml-4 space-x-2">
                    <button onclick="editCategory(<?php echo $category['category_id']; ?>, '<?php echo htmlspecialchars($category['category_name']); ?>', '<?php echo htmlspecialchars($category['category_description']); ?>')"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                      Edit
                    </button>
                    <form action="core/handleAdminForms.php" method="POST" class="inline">
                      <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                      <button type="submit" name="deleteCategoryBtn"
                              class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                              onclick="return confirm('Are you sure you want to delete this category? This will also delete all its subcategories.')">
                        Delete
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Subcategories Management -->
      <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="bg-purple-600 text-white p-4">
          <h2 class="text-xl font-bold">Subcategories Management</h2>
        </div>

        <div class="p-6">
          <!-- Add Subcategory Form -->
          <form action="core/handleAdminForms.php" method="POST" class="mb-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Add New Subcategory</h3>
            <div>
              <label class="block text-gray-700 font-medium mb-1">Category</label>
              <select name="category_id" required
                      class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['category_id']; ?>">
                  <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="block text-gray-700 font-medium mb-1">Subcategory Name</label>
              <input type="text" name="subcategory_name" required
                     class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>
            <div>
              <label class="block text-gray-700 font-medium mb-1">Description</label>
              <textarea name="subcategory_description" rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none"></textarea>
            </div>
            <button type="submit" name="addSubcategoryBtn"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg">
              Add Subcategory
            </button>
          </form>

          <!-- Subcategories List -->
          <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Existing Subcategories</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
              <?php
                $subcategories = $subcategoryObj->getSubcategories();
                foreach ($subcategories as $subcategory):
              ?>
              <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-start">
                  <div class="flex-grow">
                    <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($subcategory['subcategory_name']); ?></h4>
                    <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($subcategory['subcategory_description']); ?></p>
                    <p class="text-xs text-purple-600 mt-1">Category: <?php echo htmlspecialchars($subcategory['category_name']); ?></p>
                    <p class="text-xs text-gray-500 mt-2">Added: <?php echo $subcategory['date_added']; ?></p>
                  </div>
                  <div class="ml-4 space-x-2">
                    <button onclick="editSubcategory(<?php echo $subcategory['subcategory_id']; ?>, <?php echo $subcategory['category_id']; ?>, '<?php echo htmlspecialchars($subcategory['subcategory_name']); ?>', '<?php echo htmlspecialchars($subcategory['subcategory_description']); ?>')"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                      Edit
                    </button>
                    <form action="core/handleAdminForms.php" method="POST" class="inline">
                      <input type="hidden" name="subcategory_id" value="<?php echo $subcategory['subcategory_id']; ?>">
                      <button type="submit" name="deleteSubcategoryBtn"
                              class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                              onclick="return confirm('Are you sure you want to delete this subcategory?')">
                        Delete
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Edit Category Modal -->
  <div id="editCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4">Edit Category</h3>
        <form action="core/handleAdminForms.php" method="POST" class="space-y-4">
          <input type="hidden" name="category_id" id="editCategoryId">
          <div>
            <label class="block text-gray-700 font-medium mb-1">Category Name</label>
            <input type="text" name="category_name" id="editCategoryName" required
                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="category_description" id="editCategoryDescription" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"></textarea>
          </div>
          <div class="flex space-x-3">
            <button type="submit" name="updateCategoryBtn"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
              Update
            </button>
            <button type="button" onclick="closeEditCategoryModal()"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded-lg">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Subcategory Modal -->
  <div id="editSubcategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4">Edit Subcategory</h3>
        <form action="core/handleAdminForms.php" method="POST" class="space-y-4">
          <input type="hidden" name="subcategory_id" id="editSubcategoryId">
          <div>
            <label class="block text-gray-700 font-medium mb-1">Category</label>
            <select name="category_id" id="editSubcategoryCategoryId" required
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">
              <option value="">Select a category</option>
              <?php foreach ($categories as $category): ?>
              <option value="<?php echo $category['category_id']; ?>">
                <?php echo htmlspecialchars($category['category_name']); ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Subcategory Name</label>
            <input type="text" name="subcategory_name" id="editSubcategoryName" required
                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="subcategory_description" id="editSubcategoryDescription" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none"></textarea>
          </div>
          <div class="flex space-x-3">
            <button type="submit" name="updateSubcategoryBtn"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg">
              Update
            </button>
            <button type="button" onclick="closeEditSubcategoryModal()"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded-lg">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function editCategory(id, name, description) {
      document.getElementById('editCategoryId').value = id;
      document.getElementById('editCategoryName').value = name;
      document.getElementById('editCategoryDescription').value = description;
      document.getElementById('editCategoryModal').classList.remove('hidden');
    }

    function closeEditCategoryModal() {
      document.getElementById('editCategoryModal').classList.add('hidden');
    }

    function editSubcategory(id, categoryId, name, description) {
      document.getElementById('editSubcategoryId').value = id;
      document.getElementById('editSubcategoryCategoryId').value = categoryId;
      document.getElementById('editSubcategoryName').value = name;
      document.getElementById('editSubcategoryDescription').value = description;
      document.getElementById('editSubcategoryModal').classList.remove('hidden');
    }

    function closeEditSubcategoryModal() {
      document.getElementById('editSubcategoryModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('editCategoryModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeEditCategoryModal();
      }
    });

    document.getElementById('editSubcategoryModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeEditSubcategoryModal();
      }
    });
  </script>
</body>
</html>