<?php require_once 'classloader.php'; ?>
<?php
if (!$userObj->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (!$userObj->isAdmin()) {
    header("Location: ../freelancer/index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Client Dashboard</title>
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
        Hello there and welcome,
        <span class="text-green-600"><?php echo $_SESSION['username']; ?></span> 🎉
      </h1>
      <p class="text-gray-500 mt-2">Double click to edit your offers, then press enter to save.</p>
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

    <!-- Proposals Section -->
    <div class="space-y-8">
      <?php
        $getProposals = $proposalObj->getProposals();
        foreach ($getProposals as $proposal):
            $getOffersByProposalID = $offerObj->getOffersByProposalID($proposal['proposal_id']);
            $clientHasOffer = $offerObj->hasClientSubmittedOffer($_SESSION['user_id'], $proposal['proposal_id']);
      ?>
      <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

          <!-- Proposal Info -->
          <div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">
              <a href="other_profile_view.php?user_id=<?php echo $proposal['user_id'] ?>"
                 class="hover:text-green-600">
                <?php echo $proposal['username']; ?>
              </a>
            </h2>
            <img src="<?php echo '../images/'.$proposal['image']; ?>"
                 alt="Proposal Image"
                 class="w-full h-64 object-cover rounded-lg shadow mb-4">
            <p class="text-gray-600 mb-4"><?php echo $proposal['description']; ?></p>
            <div class="mb-4 text-sm text-gray-600">
              <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs"><?php echo htmlspecialchars($proposal['category_name']); ?></span>
              <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs ml-1"><?php echo htmlspecialchars($proposal['subcategory_name']); ?></span>
            </div>
            <h4 class="text-lg font-semibold text-gray-800">
              <i><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']);?> PHP</i>
            </h4>
          </div>

          <!-- Offers Section -->
          <div class="bg-gray-50 rounded-lg shadow-inner flex flex-col h-[600px]">
            <div class="p-4 border-b">
              <h3 class="text-lg font-bold text-gray-800">All Offers</h3>
            </div>

            <div class="flex-grow overflow-y-auto p-4 space-y-4">
              <?php foreach ($getOffersByProposalID as $offer): ?>
              <div class="offer bg-white p-4 rounded-lg shadow">
                <h4 class="text-md font-semibold text-gray-800">
                  <?php echo $offer['username']; ?>
                  <span class="text-green-600 text-sm">(<?php echo $offer['contact_number']; ?>)</span>
                </h4>
                <small class="text-gray-500 text-xs"><?php echo $offer['offer_date_added']; ?></small>
                <p class="text-gray-600 mt-2"><?php echo $offer['description']; ?></p>

                <?php if ($offer['user_id'] == $_SESSION['user_id']): ?>
                  <!-- Delete Offer -->
                  <form action="core/handleForms.php" method="POST" class="mt-2">
                    <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
                    <button type="submit" name="deleteOfferBtn"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                      Delete
                    </button>
                  </form>

                  <!-- Update Offer (toggle on dblclick) -->
                  <form action="core/handleForms.php" method="POST" class="updateOfferForm hidden mt-3 space-y-2">
                    <div>
                      <label class="block text-gray-700 text-sm font-medium mb-1">Description</label>
                      <input type="text" name="description"
                             value="<?php echo $offer['description']; ?>"
                             class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
                      <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
                    </div>
                    <button type="submit" name="updateOfferBtn"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm">
                      Update Offer
                    </button>
                  </form>
                <?php endif; ?>
              </div>
              <?php endforeach; ?>
            </div>

            <!-- Add New Offer -->
            <div class="p-4 border-t bg-white">
              <?php if ($clientHasOffer): ?>
                <p class="text-red-500 text-sm mb-2">
                  You have already submitted an offer for this proposal.
                </p>
              <?php endif; ?>
              <form action="core/handleForms.php" method="POST" class="space-y-2">
                <input type="text" name="description"
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:outline-none"
                       <?php echo $clientHasOffer ? 'disabled' : ''; ?>>
                <input type="hidden" name="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
                <button type="submit" name="insertOfferBtn"
                        class="w-full py-2 rounded-lg text-white
                               <?php echo $clientHasOffer ? 'bg-red-500 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'; ?>"
                        <?php echo $clientHasOffer ? 'disabled' : ''; ?>>
                  <?php echo $clientHasOffer ? 'Offer Already Submitted' : 'Submit Offer'; ?>
                </button>
              </form>
            </div>
          </div>

        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Double-click toggle script -->
  <script>
    $('.offer').on('dblclick', function () {
      var updateOfferForm = $(this).find('.updateOfferForm');
      updateOfferForm.toggleClass('hidden');
    });
  </script>
</body>
</html>