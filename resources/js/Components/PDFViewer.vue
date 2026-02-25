<script setup>
import { ref, onMounted, nextTick } from 'vue';
import * as pdfjsLib from 'pdfjs-dist';
import PdfjsWorker from 'pdfjs-dist/build/pdf.worker.mjs?url';

const props = defineProps({
    pdfUrl: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        default: 'Menu',
    },
});

const canvas = ref(null);
const currentPage = ref(1);
const totalPages = ref(0);
const loading = ref(true);
const error = ref(null);
const pdfLoaded = ref(false);
let pdfDoc = null;

// Set up PDF.js worker with local worker file
pdfjsLib.GlobalWorkerOptions.workerSrc = PdfjsWorker;

const renderPage = async (pageNum) => {
    if (!pdfDoc) {
        console.error('PDF document not loaded');
        return;
    }

    try {
        // Make sure canvas is mounted
        if (!canvas.value) {
            console.warn('Canvas not yet mounted, waiting...');
            await nextTick();
            // Try one more time
            if (!canvas.value) {
                throw new Error('Canvas element could not be mounted');
            }
        }

        const page = await pdfDoc.getPage(pageNum);
        const scale = 1.5;
        const viewport = page.getViewport({ scale });

        const context = canvas.value.getContext('2d');
        if (!context) {
            throw new Error('Failed to get canvas 2D context');
        }
        
        canvas.value.width = viewport.width;
        canvas.value.height = viewport.height;

        await page.render({
            canvasContext: context,
            viewport: viewport,
        }).promise;
        
        console.log('Page rendered successfully:', pageNum);
    } catch (err) {
        console.error('Error rendering page:', err);
        error.value = `Error rendering page: ${err.message}`;
        pdfLoaded.value = false;
    }
};

const loadPDF = async () => {
    loading.value = true;
    error.value = null;
    pdfLoaded.value = false;
    
    try {
        console.log('Starting PDF load from:', props.pdfUrl);
        const pdf = await pdfjsLib.getDocument(props.pdfUrl).promise;
        pdfDoc = pdf;
        totalPages.value = pdfDoc.numPages;
        console.log('PDF loaded successfully, total pages:', totalPages.value);
        
        loading.value = false;
        pdfLoaded.value = true;
        
        // Wait for DOM to be ready, then render
        await nextTick();
        console.log('Rendering page 1...');
        await renderPage(currentPage.value);
    } catch (err) {
        console.error('Error loading PDF:', err);
        error.value = `Error loading PDF: ${err.message}`;
        loading.value = false;
        pdfLoaded.value = false;
    }
};

const previousPage = async () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        await renderPage(currentPage.value);
    }
};

const nextPage = async () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        await renderPage(currentPage.value);
    }
};

onMounted(() => {
    console.log('PDFViewer component mounted');
    loadPDF();
});
</script>

<template>
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">{{ title }}</h2>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">Loading PDF...</p>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="text-center py-8 bg-red-50 p-6 rounded">
            <p class="text-red-600 font-bold mb-2">Error loading PDF</p>
            <p class="text-red-500 text-sm">{{ error }}</p>
            <p class="text-gray-600 text-xs mt-4">Check browser console (F12) for details</p>
        </div>

        <!-- Success State - Canvas is always in DOM when this renders -->
        <div v-else-if="pdfLoaded" class="w-full">
            <canvas
                ref="canvas"
                class="w-full border border-gray-300 rounded mb-4"
            ></canvas>

            <!-- Navigation Controls -->
            <div class="flex items-center justify-between">
                <button
                    @click="previousPage"
                    :disabled="currentPage === 1"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 disabled:bg-gray-400"
                >
                    ← Previous
                </button>

                <span class="text-gray-700 font-semibold">
                    Page {{ currentPage }} of {{ totalPages }}
                </span>

                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 disabled:bg-gray-400"
                >
                    Next →
                </button>
            </div>
        </div>
    </div>
</template>
