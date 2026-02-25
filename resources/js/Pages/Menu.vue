<script setup>
import { Link } from '@inertiajs/vue3';
import PDFViewer from '@/Components/PDFViewer.vue';
</script>

<template>
    <div class="min-h-screen bg-yellow-50">
        <!-- Header -->
        <div class="bg-red-600 text-white py-8">
            <div class="max-w-6xl mx-auto px-6">
                <h1 class="text-4xl font-bold mb-2">Our Menu</h1>
                <p class="mb-4">Browse our authentic Chinese cuisine</p>
                <Link
                    href="/"
                    class="text-white hover:underline"
                >
                    ← Back to Home
                </Link>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-6 py-12">
            <PDFViewer
                pdf-url="/menus/menu.pdf"
                title="Restaurant Menu"
            />
        </div>
    </div>
</template>
