<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, watch, onMounted, onUnmounted } from 'vue';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';

const page = usePage();
const showSuccessModal = ref(false);
const currentSlide = ref(0);
let autoRotateInterval = null;

// Food slider images with descriptions
const foodSlides = [
  {
    title: 'Sweet and Sour Chicken',
    description: 'Crispy chicken with tangy sweet and sour sauce',
    price: '€9.90',
    image: 'https://images.unsplash.com/photo-1626082927389-6cd097cda1ec?w=800&h=500&fit=crop'
  },
  {
    title: 'Fried Rice',
    description: 'Fluffy fried rice with fresh vegetables and proteins',
    price: '€7.90',
    image: 'https://images.unsplash.com/photo-1609501676725-7186f017a4b8?w=800&h=500&fit=crop'
  },
  {
    title: 'Noodles',
    description: 'Authentic hand-pulled noodles with savory broth',
    price: '€8.90',
    image: 'https://images.unsplash.com/photo-1612874742237-6526221fcf4f?w=800&h=500&fit=crop'
  },
  {
    title: 'Kung Pao Chicken',
    description: 'Spicy stir-fried chicken with peanuts and peppers',
    price: '€10.50',
    image: 'https://images.unsplash.com/photo-1603894542802-f1b3c27f0b1c?w=800&h=500&fit=crop'
  },
  {
    title: 'Spring Rolls',
    description: 'Crispy spring rolls with sweet dipping sauce',
    price: '€5.90',
    image: 'https://images.unsplash.com/photo-1582707471075-e85efb9f3400?w=800&h=500&fit=crop'
  }
];

// Watch for any changes in page props (Inertia flash messages)
watch(
  () => page.props,
  (newProps) => {
    console.log('📋 Page props updated:', newProps);
    if (newProps.flash?.reservation_success) {
      console.log('✅ Success message detected:', newProps.flash.reservation_success);
      showSuccessModal.value = true;
    }
  },
  { deep: true }
);

const closeModal = () => {
  showSuccessModal.value = false;
};

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % foodSlides.length;
  resetAutoRotate();
};

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + foodSlides.length) % foodSlides.length;
  resetAutoRotate();
};

const goToSlide = (index) => {
  currentSlide.value = index;
  resetAutoRotate();
};

const startAutoRotate = () => {
  autoRotateInterval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % foodSlides.length;
  }, 20000); // 20 seconds
};

const resetAutoRotate = () => {
  if (autoRotateInterval) {
    clearInterval(autoRotateInterval);
  }
  startAutoRotate();
};

onMounted(() => {
  startAutoRotate();
  // Check if there's already a success flash message on first load
  if (page.props.flash?.reservation_success) {
    console.log('🎉 Modal shown on component mount');
    showSuccessModal.value = true;
  }
});

onUnmounted(() => {
  if (autoRotateInterval) {
    clearInterval(autoRotateInterval);
  }
});
</script>

<template>
    <Header />

    <!-- HERO with Image Carousel -->
    <section id="home" class="bg-gradient-to-b from-red-50 to-white py-0">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <h1 class="text-5xl font-bold text-center mb-2">Authentic Chinese Cuisine</h1>
            <p class="text-xl text-center text-gray-600 mb-12">Fresh ingredients and traditional recipes</p>

            <!-- Carousel Container -->
            <div class="relative w-full h-screen md:h-96 lg:h-[500px] rounded-2xl overflow-hidden shadow-2xl">
                <!-- Slides -->
                <div class="relative w-full h-full">
                    <div v-for="(slide, index) in foodSlides" :key="index"
                        class="absolute w-full h-full transition-opacity duration-1000"
                        :class="{ 'opacity-100': currentSlide === index, 'opacity-0': currentSlide !== index }">
                        
                        <!-- Background Image -->
                        <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover" />
                        
                        <!-- Dark Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                        
                        <!-- Content Overlay -->
                        <div class="absolute inset-0 flex flex-col justify-end p-8 bg-gradient-to-t from-black to-transparent">
                            <h2 class="text-4xl font-bold text-white mb-2">{{ slide.title }}</h2>
                            <p class="text-xl text-gray-200 mb-4">{{ slide.description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-red-500">{{ slide.price }}</span>
                                <a href="#reservation" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                    Reserve Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button @click="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-black rounded-full p-3 z-10 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button @click="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-black rounded-full p-3 z-10 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots Navigation -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <button v-for="(_, index) in foodSlides" :key="index"
                        @click="goToSlide(index)"
                        class="w-3 h-3 rounded-full transition"
                        :class="currentSlide === index ? 'bg-red-600 scale-125' : 'bg-white bg-opacity-50 hover:bg-opacity-75'">
                    </button>
                </div>

                <!-- Auto-rotate Indicator -->
                <div class="absolute top-4 right-4 bg-white bg-opacity-75 px-4 py-2 rounded-lg text-sm text-gray-700 z-10">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    Auto-rotating
                </div>
            </div>
        </div>
    </section>

    <!-- MENU -->

    <section id="menu" class="py-20">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-10">Popular Dishes</h2>

            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div class="border rounded-lg p-6">
                    <h3 class="text-xl font-bold">Sweet and Sour Chicken</h3>

                    <p>€9.90</p>
                </div>

                <div class="border rounded-lg p-6">
                    <h3 class="text-xl font-bold">Fried Rice</h3>

                    <p>€7.90</p>
                </div>

                <div class="border rounded-lg p-6">
                    <h3 class="text-xl font-bold">Noodles</h3>

                    <p>€8.90</p>
                </div>
            </div>

            <div class="text-center">
                <Link
                    href="/menu"
                    class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 inline-block"
                >
                    View Full Menu with PDF
                </Link>
            </div>
        </div>
    </section>

    <!-- RESERVATION -->

    <section id="reservation" class="bg-gray-100 py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">Reservation</h2>

            <div class="text-center">
                <Link
                    href="/reservations/create"
                    class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 inline-block"
                >
                    Reserve Your Table Online
                </Link>
            </div>
        </div>
    </section>    

    <Footer />

    <!-- Success Modal -->
    <Teleport to="body" v-if="showSuccessModal">
      <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-8 text-center">
          <div class="mb-4">
            <svg class="w-16 h-16 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-gray-800 mb-2">The reservation is successful</h2>
          <p class="text-gray-600 mb-6">Thank you for your reservation. A confirmation email has been sent to you.</p>
          <button
            @click="closeModal"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200"
          >
            Continue
          </button>
        </div>
      </div>
    </Teleport>
</template>
