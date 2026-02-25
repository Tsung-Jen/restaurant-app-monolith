<script setup>
import { Link } from '@inertiajs/vue3';
//import Header from "@/Components/Restaurant/Header.vue";
//import Footer from "@/Components/Restaurant/Footer.vue";
</script>

<template>
    <Header />

    <!-- HERO -->

    <section id="home" class="bg-yellow-50">
        <div class="max-w-6xl mx-auto px-6 py-20 text-center">
            <h1 class="text-5xl font-bold mb-6">Authentic Chinese Cuisine</h1>

            <p class="text-xl mb-8">
                Fresh ingredients and traditional recipes
            </p>

            <a
                href="#reservation"
                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700"
            >
                Reserve Table
            </a>
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

            <p>Reserve your table online</p>
        </div>
    </section>

    <!-- CONTACT -->

    <section id="contact" class="py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">Contact</h2>

            <p>Phone: 0123456789</p>
        </div>
    </section>

    <Footer />
</template>
