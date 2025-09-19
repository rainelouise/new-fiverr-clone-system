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
  <title>Client Offers</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Page Header -->
  <div class="text-center py-8">
    <h1 class="text-3xl font-bold text-gray-800">Hello there and welcome!</h1>
    <p class="text-gray-500 mt-2">Here are all the submitted offers for your projects</p>
  </div>

  <!-- Proposals & Offers -->
  <div class="max-w-7xl mx-auto px-6 space-y-8">
    <?php $getProposalsByUserID = $proposalObj->getProposalsByUserID($_SESSION['user_id']); ?>
    <?php foreach ($getProposalsByUserID as $proposal) { ?>
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

          <!-- Proposal Info -->
          <div>
            <h2 class="text-xl font-bold text-gray-800 mb-2"><?php echo $proposal['username']; ?></h2>
            <img src="<?php echo '../images/'.$proposal['image']; ?>" 
                 alt="Proposal Image" 
                 class="w-full h-64 object-cover rounded-lg shadow mb-4">
            <p class="text-gray-600 mb-4"><?php echo $proposal['description']; ?></p>
            <h4 class="text-lg font-semibold text-gray-800 mb-2">
              <i><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']);?> PHP</i>
            </h4>
            <a href="#" class="text-green-600 hover:underline">Check out services</a>
          </div>

          <!-- Offers Section -->
          <div class="bg-gray-50 rounded-lg shadow-inner flex flex-col h-[600px]">
            <div class="p-4 border-b">
              <h3 class="text-lg font-bold text-gray-800">All Offers</h3>
            </div>
            <div class="flex-grow overflow-y-auto p-4 space-y-4">
              <?php $getOffersByProposalID = $offerObj->getOffersByProposalID($proposal['proposal_id']); ?>
              <?php foreach ($getOffersByProposalID as $offer) { ?>
                <div class="bg-white p-4 rounded-lg shadow">
                  <h4 class="text-md font-semibold text-gray-800">
                    <?php echo $offer['username']; ?> 
                    <span class="text-green-600 text-sm">(<?php echo $offer['contact_number']; ?>)</span>
                  </h4>
                  <small class="text-gray-500 text-xs"><?php echo $offer['offer_date_added']; ?></small>
                  <p class="text-gray-600 mt-2"><?php echo $offer['description']; ?></p>
                </div>
              <?php } ?>
            </div>
          </div>

        </div>
      </div>
    <?php } ?>
  </div>

</body>
</html>