<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../client/index.php");
}  
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Your Proposals</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Page Header -->
  <div class="text-center py-8">
    <h1 class="text-3xl font-bold text-gray-800">Double click to edit your proposals!</h1>
    <div class="mt-2">
      <?php  
      if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
          $color = ($_SESSION['status'] == "200") ? "green" : "red";
          echo "<div class='inline-block px-4 py-2 rounded-md bg-$color-100 text-$color-700 font-medium'>{$_SESSION['message']}</div>";
      }
      unset($_SESSION['message']);
      unset($_SESSION['status']);
      ?>
    </div>
  </div>

  <!-- Proposals List -->
  <div class="max-w-4xl mx-auto px-6 space-y-6">
    <?php $getProposalsByUserID = $proposalObj->getProposalsByUserID($_SESSION['user_id']); ?>
    <?php foreach ($getProposalsByUserID as $proposal) { ?>
      <div class="bg-white rounded-xl shadow-md overflow-hidden proposalCard">
        <div class="p-6 space-y-4">
          <h2 class="text-xl font-bold text-gray-800"><?php echo $proposal['username']; ?></h2>
          <img src="<?php echo "../images/".$proposal['image']; ?>" 
               alt="Proposal Image" 
               class="w-full h-64 object-cover rounded-lg shadow">
          <p class="text-gray-500 text-sm"><i><?php echo $proposal['proposals_date_added']; ?></i></p>
          <p class="text-gray-700"><?php echo $proposal['description']; ?></p>
          <h4 class="text-gray-800 font-semibold"><i><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']);?></i></h4>

          <!-- Delete Proposal -->
          <form action="core/handleForms.php" method="POST" class="text-right">
            <input type="hidden" name="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
            <input type="hidden" name="image" value="<?php echo $proposal['image']; ?>">
            <button type="submit" name="deleteProposalBtn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Delete</button>
          </form>

          <!-- Update Proposal (hidden by default) -->
          <form action="core/handleForms.php" method="POST" class="updateProposalForm hidden space-y-4 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-medium mb-1">Minimum Price</label>
                <input type="number" name="min_price" value="<?php echo $proposal['min_price']; ?>" 
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
              </div>
              <div>
                <label class="block text-gray-700 font-medium mb-1">Maximum Price</label>
                <input type="number" name="max_price" value="<?php echo $proposal['max_price']; ?>" 
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
              </div>
            </div>
            <div>
              <label class="block text-gray-700 font-medium mb-1">Description</label>
              <textarea name="description" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"><?php echo $proposal['description']; ?></textarea>
              <input type="hidden" name="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
            </div>
            <button type="submit" name="updateProposalBtn" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg shadow-md transition">Update Proposal</button>
          </form>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Double-click toggle script -->
  <script>
    $('.proposalCard').on('dblclick', function () {
      $(this).find('.updateProposalForm').toggleClass('hidden');
    });
  </script>
</body>
</html>