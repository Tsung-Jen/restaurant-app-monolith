<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-950 to-slate-900 text-slate-100">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-slate-950/80 backdrop-blur-md border-b border-red-600/20">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="text-2xl font-bold text-red-600">🟥</span>
          <h1 class="text-2xl font-bold text-white">China Restaurant</h1>
        </div>
        <ul class="hidden md:flex gap-8 items-center">
          <li><a href="#menu" class="hover:text-red-500 transition">Menu</a></li>
          <li><a href="#about" class="hover:text-red-500 transition">About</a></li>
          <li><a href="#hours" class="hover:text-red-500 transition">Hours</a></li>
          <li><a href="#contact" class="hover:text-red-500 transition">Contact</a></li>
        </ul>
        <button class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-lg font-semibold transition">
          Reserve
        </button>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 text-center">
      <div class="max-w-4xl mx-auto">
        <h2 class="text-5xl sm:text-7xl font-bold mb-6 bg-gradient-to-r from-red-500 to-orange-400 bg-clip-text text-transparent">
          Welcome to China Restaurant
        </h2>
        <p class="text-xl text-slate-300 mb-8">
          Authentic flavors, traditional recipes, and culinary excellence
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <button class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 px-8 py-3 rounded-lg font-semibold text-lg transition transform hover:scale-105">
            Order Online
          </button>
          <button class="border-2 border-red-600 hover:bg-red-600/10 px-8 py-3 rounded-lg font-semibold text-lg transition">
            View Menu
          </button>
        </div>
      </div>
    </section>

    <!-- Featured Dishes -->
    <section id="menu" class="py-20 px-4 sm:px-6 lg:px-8">
      <div class="max-w-6xl mx-auto">
        <h3 class="text-4xl font-bold text-center mb-16 text-red-500">Featured Dishes</h3>
        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="dish in featuredDishes" :key="dish.id" class="group bg-slate-800/50 border border-red-600/20 rounded-lg overflow-hidden hover:border-red-600/50 transition">
            <div class="bg-gradient-to-br from-orange-500 to-red-600 h-40 flex items-center justify-center text-4xl">
              {{ dish.emoji }}
            </div>
            <div class="p-6">
              <h4 class="text-xl font-bold mb-2 text-white">{{ dish.name }}</h4>
              <p class="text-slate-400 mb-4">{{ dish.description }}</p>
              <div class="flex justify-between items-center">
                <span class="text-red-500 font-bold text-lg">${{ dish.price }}</span>
                <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-semibold transition">
                  Add
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-4 sm:px-6 lg:px-8 bg-slate-800/30">
      <div class="max-w-4xl mx-auto">
        <h3 class="text-4xl font-bold text-center mb-8 text-red-500">About Us</h3>
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div class="text-lg text-slate-300 space-y-6">
            <p>
              Since 1995, China Restaurant has been serving authentic Chinese cuisine to our community. Our chefs bring decades of culinary expertise from the heart of China.
            </p>
            <p>
              We use only the freshest ingredients, traditional cooking methods, and secret family recipes passed down through generations to create unforgettable dining experiences.
            </p>
            <div class="space-y-3">
              <div class="flex items-center gap-3">
                <span class="text-red-500">✓</span>
                <span>Authentic recipes from China</span>
              </div>
              <div class="flex items-center gap-3">
                <span class="text-red-500">✓</span>
                <span>Fresh, premium ingredients</span>
              </div>
              <div class="flex items-center gap-3">
                <span class="text-red-500">✓</span>
                <span>Family-owned since 1995</span>
              </div>
              <div class="flex items-center gap-3">
                <span class="text-red-500">✓</span>
                <span>Award-winning chef team</span>
              </div>
            </div>
          </div>
          <div class="bg-gradient-to-br from-red-600/20 to-orange-600/20 rounded-lg p-8 border border-red-600/30">
            <div class="text-6xl text-center mb-4">👨‍🍳</div>
            <p class="text-center text-slate-300">
              Our team of expert chefs are dedicated to bringing you the most authentic and delicious Chinese cuisine.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Hours -->
    <section id="hours" class="py-20 px-4 sm:px-6 lg:px-8">
      <div class="max-w-4xl mx-auto">
        <h3 class="text-4xl font-bold text-center mb-12 text-red-500">Hours of Operation</h3>
        <div class="grid md:grid-cols-2 gap-12">
          <div class="bg-slate-800/50 border border-red-600/20 rounded-lg p-8">
            <h4 class="text-xl font-bold text-red-500 mb-6">Regular Hours</h4>
            <ul class="space-y-3 text-slate-300">
              <li class="flex justify-between">
                <span>Monday - Thursday</span>
                <span class="font-semibold">11:00 AM - 10:00 PM</span>
              </li>
              <li class="flex justify-between">
                <span>Friday - Saturday</span>
                <span class="font-semibold">11:00 AM - 11:00 PM</span>
              </li>
              <li class="flex justify-between">
                <span>Sunday</span>
                <span class="font-semibold">12:00 PM - 10:00 PM</span>
              </li>
            </ul>
          </div>
          <div class="bg-slate-800/50 border border-red-600/20 rounded-lg p-8">
            <h4 class="text-xl font-bold text-red-500 mb-6">Special Hours</h4>
            <ul class="space-y-3 text-slate-300">
              <li class="flex justify-between">
                <span>Lunch Special</span>
                <span class="font-semibold">11:00 AM - 3:00 PM</span>
              </li>
              <li class="flex justify-between">
                <span>Happy Hour</span>
                <span class="font-semibold">4:00 PM - 6:00 PM</span>
              </li>
              <li class="flex justify-between">
                <span>Closed</span>
                <span class="font-semibold">Christmas Day</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-slate-800/30 to-slate-900">
      <div class="max-w-4xl mx-auto">
        <h3 class="text-4xl font-bold text-center mb-12 text-red-500">Contact Us</h3>
        <div class="grid md:grid-cols-3 gap-8 mb-12">
          <div class="text-center">
            <div class="text-4xl mb-4">📍</div>
            <h4 class="font-bold text-lg mb-2">Address</h4>
            <p class="text-slate-400">
              123 Fortune Street<br />
              Downtown District<br />
              City, State 12345
            </p>
          </div>
          <div class="text-center">
            <div class="text-4xl mb-4">📞</div>
            <h4 class="font-bold text-lg mb-2">Phone</h4>
            <p class="text-slate-400">
              +1 (555) 123-4567<br />
              +1 (555) 987-6543<br />
              <span class="text-red-500">24/7 Support</span>
            </p>
          </div>
          <div class="text-center">
            <div class="text-4xl mb-4">✉️</div>
            <h4 class="font-bold text-lg mb-2">Email</h4>
            <p class="text-slate-400">
              orders@chinarestaurant.com<br />
              info@chinarestaurant.com<br />
              <span class="text-red-500">Fast Response</span>
            </p>
          </div>
        </div>

        <!-- Reservation Form -->
        <div class="bg-slate-800/50 border border-red-600/30 rounded-lg p-8 max-w-2xl mx-auto">
          <h4 class="text-2xl font-bold text-white mb-6">Make a Reservation</h4>
          <form @submit.prevent="handleReservation" class="space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
              <input
                v-model="reservation.name"
                type="text"
                placeholder="Your Name"
                class="bg-slate-700 border border-slate-600 rounded px-4 py-2 text-white placeholder-slate-400 focus:outline-none focus:border-red-500 transition"
                required
              />
              <input
                v-model="reservation.email"
                type="email"
                placeholder="Your Email"
                class="bg-slate-700 border border-slate-600 rounded px-4 py-2 text-white placeholder-slate-400 focus:outline-none focus:border-red-500 transition"
                required
              />
            </div>
            <div class="grid md:grid-cols-2 gap-4">
              <input
                v-model="reservation.date"
                type="date"
                class="bg-slate-700 border border-slate-600 rounded px-4 py-2 text-white focus:outline-none focus:border-red-500 transition"
                required
              />
              <select
                v-model="reservation.time"
                class="bg-slate-700 border border-slate-600 rounded px-4 py-2 text-white focus:outline-none focus:border-red-500 transition"
                required
              >
                <option value="">Select Time</option>
                <option value="18:00">6:00 PM</option>
                <option value="18:30">6:30 PM</option>
                <option value="19:00">7:00 PM</option>
                <option value="19:30">7:30 PM</option>
                <option value="20:00">8:00 PM</option>
              </select>
            </div>
            <input
              v-model="reservation.guests"
              type="number"
              min="1"
              max="12"
              placeholder="Number of Guests"
              class="w-full bg-slate-700 border border-slate-600 rounded px-4 py-2 text-white placeholder-slate-400 focus:outline-none focus:border-red-500 transition"
              required
            />
            <textarea
              v-model="reservation.message"
              placeholder="Special Requests (optional)"
              rows="3"
              class="w-full bg-slate-700 border border-slate-600 rounded px-4 py-2 text-white placeholder-slate-400 focus:outline-none focus:border-red-500 transition"
            ></textarea>
            <button
              type="submit"
              class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 px-6 py-3 rounded-lg font-semibold transition transform hover:scale-105"
            >
              Reserve Table
            </button>
          </form>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-red-600/20 py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
          <div>
            <h5 class="text-red-500 font-bold mb-4">Restaurant</h5>
            <ul class="space-y-2 text-sm text-slate-400 hover:text-slate-300">
              <li><a href="#" class="hover:text-red-500 transition">About</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Careers</a></li>
              <li><a href="#" class="hover:text-red-500 transition">News</a></li>
            </ul>
          </div>
          <div>
            <h5 class="text-red-500 font-bold mb-4">Dining</h5>
            <ul class="space-y-2 text-sm text-slate-400 hover:text-slate-300">
              <li><a href="#" class="hover:text-red-500 transition">Menu</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Reservations</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Catering</a></li>
            </ul>
          </div>
          <div>
            <h5 class="text-red-500 font-bold mb-4">Connect</h5>
            <ul class="space-y-2 text-sm text-slate-400 hover:text-slate-300">
              <li><a href="#" class="hover:text-red-500 transition">Facebook</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Instagram</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Twitter</a></li>
            </ul>
          </div>
          <div>
            <h5 class="text-red-500 font-bold mb-4">Legal</h5>
            <ul class="space-y-2 text-sm text-slate-400 hover:text-slate-300">
              <li><a href="#" class="hover:text-red-500 transition">Privacy</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Terms</a></li>
              <li><a href="#" class="hover:text-red-500 transition">Cookies</a></li>
            </ul>
          </div>
        </div>
        <div class="border-t border-slate-800 pt-8 text-center text-slate-400">
          <p>&copy; 2024 China Restaurant. All rights reserved. 🥡</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'

interface Dish {
  id: number
  name: string
  description: string
  price: number
  emoji: string
}

interface Reservation {
  name: string
  email: string
  date: string
  time: string
  guests: number
  message: string
}

const featuredDishes = ref<Dish[]>([
  {
    id: 1,
    name: 'Kung Pao Chicken',
    description: 'Tender chicken with peanuts, red peppers, and our signature spice blend',
    price: 14.99,
    emoji: '🍗'
  },
  {
    id: 2,
    name: 'Peking Duck',
    description: 'Crispy duck served with thin pancakes, cucumber, and sweet bean sauce',
    price: 24.99,
    emoji: '🦆'
  },
  {
    id: 3,
    name: 'Mapo Tofu',
    description: 'Silky tofu with beef in a spicy and numbing chili sauce',
    price: 12.99,
    emoji: '🌶️'
  },
  {
    id: 4,
    name: 'Chow Mein',
    description: 'Stir-fried noodles with vegetables, chicken, and authentic soy glaze',
    price: 11.99,
    emoji: '🍜'
  },
  {
    id: 5,
    name: 'Dim Sum Platter',
    description: 'Assorted dumplings, buns, and rolls from our dim sum selection',
    price: 16.99,
    emoji: '🥟'
  },
  {
    id: 6,
    name: 'Mongolian Beef',
    description: 'Sliced beef with onions, scallions in a savory and slightly sweet sauce',
    price: 15.99,
    emoji: '🥩'
  }
])

const reservation = reactive<Reservation>({
  name: '',
  email: '',
  date: '',
  time: '',
  guests: 2,
  message: ''
})

const handleReservation = () => {
  alert(`Reservation request submitted for ${reservation.name} on ${reservation.date} at ${reservation.time}!`)
  // Reset form
  Object.assign(reservation, {
    name: '',
    email: '',
    date: '',
    time: '',
    guests: 2,
    message: ''
  })
}
</script>

<style scoped>
/* Add smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* Gradient text animation */
@keyframes gradientShift {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}
</style>
