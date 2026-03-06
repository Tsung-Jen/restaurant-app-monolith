<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isMenuOpen = ref(false);

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

const closeMenu = () => {
  isMenuOpen.value = false;
};

const navLinks = [
  { label: 'Home', href: '/#home' },
  { label: 'Menu', href: '/#menu' },
  { label: 'Reservation', href: '/#reservation' },
  { label: 'About Us', href: '/#about' },
];
</script>

<template>
  <header class="bg-white shadow-md sticky top-0 z-40">
    <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
      <!-- Logo -->
      <div class="flex items-center">
        <Link href="/" class="text-2xl font-bold text-red-600">
          🍜 Restaurant
        </Link>
      </div>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center gap-8">
        <a 
          v-for="link in navLinks" 
          :key="link.href"
          :href="link.href"
          class="text-gray-700 hover:text-red-600 font-medium transition"
        >
          {{ link.label }}
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <button
        @click="toggleMenu"
        class="md:hidden flex flex-col gap-1.5 p-2 rounded hover:bg-gray-100 transition"
        aria-label="Toggle menu"
      >
        <span 
          class="w-6 h-0.5 bg-gray-700 transition-transform duration-300"
          :class="{ 'rotate-45 translate-y-2': isMenuOpen }"
        ></span>
        <span 
          class="w-6 h-0.5 bg-gray-700 transition-opacity duration-300"
          :class="{ 'opacity-0': isMenuOpen }"
        ></span>
        <span 
          class="w-6 h-0.5 bg-gray-700 transition-transform duration-300"
          :class="{ '-rotate-45 -translate-y-2': isMenuOpen }"
        ></span>
      </button>
    </nav>

    <!-- Mobile Navigation Menu -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="transform opacity-0 -translate-y-2"
      enter-to-class="transform opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="transform opacity-100 translate-y-0"
      leave-to-class="transform opacity-0 -translate-y-2"
    >
      <div 
        v-if="isMenuOpen" 
        class="md:hidden bg-gray-50 border-t border-gray-200 absolute top-full left-0 right-0"
      >
        <div class="max-w-6xl mx-auto px-6 py-4 flex flex-col gap-4">
          <a 
            v-for="link in navLinks" 
            :key="link.href"
            :href="link.href"
            @click="closeMenu"
            class="text-gray-700 hover:text-red-600 font-medium transition py-2"
          >
            {{ link.label }}
          </a>
        </div>
      </div>
    </transition>
  </header>
</template>

<style scoped>
/* Smooth transitions for hamburger menu */
</style>
