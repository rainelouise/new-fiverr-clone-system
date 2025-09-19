<?php
ob_start();
?>

<div class="text-center my-10">
  <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Welcome to the Fiverr Clone!</h1>
</div>

<div class="grid md:grid-cols-2 gap-8">
  <!-- Client Card -->
  <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">
    <img src="https://images.unsplash.com/photo-1549923746-c502d488b3ea?q=80&w=1171&auto=format&fit=crop" class="w-full h-64 object-cover">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-3">Are you looking for a talent?</h2>
      <p class="mb-4 text-gray-600">Find skilled freelancers who can bring your ideas to life — from writing and design to development and beyond.</p>
      <a href="client/login.php" class="inline-block bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition">Get started as Client</a>
    </div>
  </div>

  <!-- Freelancer Card -->
  <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">
    <img src="https://plus.unsplash.com/premium_photo-1661582394864-ebf82b779eb0?q=80&w=1170&auto=format&fit=crop" class="w-full h-64 object-cover">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-3">Are you looking for a job?</h2>
      <p class="mb-4 text-gray-600">Showcase your skills, connect with clients, and land projects that match your expertise.</p>
      <a href="freelancer/login.php" class="inline-block bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition">Get started as Freelancer</a>
    </div>
  </div>
</div>

<!-- Testimonials -->
<div class="text-center my-12">
  <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Testimonials From Users</h2>
</div>

<div class="grid md:grid-cols-3 gap-8">
  <!-- Sophia -->
  <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
    <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=600&q=80" class="w-full h-56 object-cover" alt="Sophia">
    <div class="p-5">
      <h3 class="text-xl font-semibold">Sophia M.</h3>
      <p class="text-gray-600 mt-2">This talent search app helped me discover amazing job opportunities quickly. The personalized matches made all the difference!</p>
    </div>
  </div>

  <!-- Liam -->
  <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
    <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80" class="w-full h-56 object-cover" alt="Liam">
    <div class="p-5">
      <h3 class="text-xl font-semibold">Liam K.</h3>
      <p class="text-gray-600 mt-2">Easy to use and very effective. Found a great match for my skills within a week. Highly recommend for job seekers.</p>
    </div>
  </div>

  <!-- Emma -->
  <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
    <img src="https://images.unsplash.com/photo-1520813792240-56fc4a3765a7?auto=format&fit=crop&w=600&q=80" class="w-full h-56 object-cover" alt="Emma">
    <div class="p-5">
      <h3 class="text-xl font-semibold">Emma T.</h3>
      <p class="text-gray-600 mt-2">The app’s user interface is smooth and the application process was seamless. It really boosted my career search experience.</p>
    </div>
  </div>

  <!-- Olivia -->
  <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80" class="w-full h-56 object-cover" alt="Olivia">
    <div class="p-5">
      <h3 class="text-xl font-semibold">Olivia W.</h3>
      <p class="text-gray-600 mt-2">I love how the app customizes recommendations based on my profile. It truly feels personalized and effective.</p>
    </div>
  </div>

  <!-- Ethan -->
  <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
    <img src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?auto=format&fit=crop&w=600&q=80" class="w-full h-56 object-cover" alt="Ethan">
    <div class="p-5">
      <h3 class="text-xl font-semibold">Ethan L.</h3>
      <p class="text-gray-600 mt-2">The interview scheduling feature saved me so much time. The app is intuitive and recruiter communication is excellent.</p>
    </div>
  </div>

  <!-- Adam -->
  <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
    <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=600&q=80" class="w-full h-56 object-cover" alt="Adam">
    <div class="p-5">
      <h3 class="text-xl font-semibold">Adam R.</h3>
      <p class="text-gray-600 mt-2">Found roles that matched my skill set perfectly. The app helped me showcase my talents in the best light. So thankful!</p>
    </div>
  </div>

<?php
$content = ob_get_clean();
include 'templates/layout.php';
?>