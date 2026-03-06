<script setup>
const restaurantInfo = {
  name: 'Authentic Chinese Cuisine',
  hours: {
    lunch: 'Monday - Sunday: 11:00 AM - 3:00 PM',
    dinner: 'Monday - Sunday: 6:00 PM - 11:00 PM'
  },
  phone: '+1 (555) 123-4567',
  email: 'info@restaurant.com',
  address: '123 Main Street, Your City, ST 12345',
  social: {
    facebook: 'https://facebook.com',
    instagram: 'https://instagram.com',
    twitter: 'https://twitter.com'
  }
};
</script>

<template>
  <footer class="bg-gray-900 text-gray-300">
    <div class="max-w-6xl mx-auto px-6 py-12">
      <!-- Footer Grid -->
      <div class="grid md:grid-cols-4 gap-8 mb-12">
        <!-- About Section -->
        <div>
          <h3 class="text-white text-lg font-bold mb-4">{{ restaurantInfo.name }}</h3>
          <p class="text-sm leading-relaxed">
            Experience authentic Chinese cuisine with fresh ingredients and traditional recipes served with exceptional service.
          </p>
        </div>

        <!-- Hours Section -->
        <div>
          <h4 class="text-white text-lg font-bold mb-4">Opening Hours</h4>
          <div class="text-sm space-y-3">
            <div>
              <p class="font-semibold text-gray-200">Lunch</p>
              <p>{{ restaurantInfo.hours.lunch }}</p>
            </div>
            <div>
              <p class="font-semibold text-gray-200">Dinner</p>
              <p>{{ restaurantInfo.hours.dinner }}</p>
            </div>
          </div>
        </div>

        <!-- Contact Section -->
        <div>
          <h4 class="text-white text-lg font-bold mb-4">Contact Us</h4>
          <div class="text-sm space-y-3">
            <div>
              <p class="font-semibold text-gray-200">Phone</p>
              <a 
                :href="`tel:${restaurantInfo.phone}`" 
                class="hover:text-red-500 transition"
              >
                {{ restaurantInfo.phone }}
              </a>
            </div>
            <div>
              <p class="font-semibold text-gray-200">Email</p>
              <a 
                :href="`mailto:${restaurantInfo.email}`" 
                class="hover:text-red-500 transition"
              >
                {{ restaurantInfo.email }}
              </a>
            </div>
            <div>
              <p class="font-semibold text-gray-200">Address</p>
              <p>{{ restaurantInfo.address }}</p>
            </div>
          </div>
        </div>

        <!-- Social Links -->
        <div>
          <h4 class="text-white text-lg font-bold mb-4">Follow Us</h4>
          <div class="flex gap-4">
            <a 
              href="https://facebook.com"
              target="_blank"
              rel="noopener noreferrer"
              class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition"
              title="Facebook"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
            <a 
              href="https://instagram.com"
              target="_blank"
              rel="noopener noreferrer"
              class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition"
              title="Instagram"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm4.441 15.892c-1.002 1.541-2.886 2.555-5.041 2.555-3.125 0-5.658-2.533-5.658-5.658 0-2.155 1.014-4.039 2.555-5.041.79-.516 1.734-.816 2.748-.816s1.959.3 2.748.816c1.541 1.002 2.555 2.886 2.555 5.041 0 2.155-1.014 4.039-2.555 5.041zm0 0"/>
              </svg>
            </a>
            <a 
              href="https://twitter.com"
              target="_blank"
              rel="noopener noreferrer"
              class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition"
              title="Twitter"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 9-7 9-7z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>

      <!-- Divider -->
      <div class="border-t border-gray-800 pt-8 mb-8">
        <!-- Quick Links -->
        <div class="grid md:grid-cols-3 gap-8 mb-8">
          <div>
            <h5 class="text-white font-bold mb-4">Quick Links</h5>
            <ul class="space-y-2 text-sm">
              <li><a href="/#menu" class="hover:text-red-500 transition">View Menu</a></li>
              <li><a href="/#reservation" class="hover:text-red-500 transition">Make Reservation</a></li>
              <li><a href="/#about" class="hover:text-red-500 transition">About Us</a></li>
            </ul>
          </div>
          <div>
            <h5 class="text-white font-bold mb-4">Policies</h5>
            <ul class="space-y-2 text-sm">
              <li><a href="#" class="hover:text-red-500 transition">Privacy Policy</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Terms of Service</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Cancellation Policy</a></li>
            </ul>
          </div>
          <div>
            <h5 class="text-white font-bold mb-4">Special</h5>
            <ul class="space-y-2 text-sm">
              <li><a href="#" class="hover:text-red-500 transition">Group Reservations</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Catering Services</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Event Hosting</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="border-t border-gray-800 pt-8 text-center text-sm">
        <p>&copy; 2026 {{ restaurantInfo.name }}. All rights reserved. | Designed with 🍜 for food lovers</p>
      </div>
    </div>
  </footer>
</template>
