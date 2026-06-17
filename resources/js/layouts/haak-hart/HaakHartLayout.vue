<script setup lang="ts">
import HaakHartHeaderBar from '@/components/haak-hart/HaakHartHeaderBar.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <HaakHartHeaderBar />

        <main class="container mx-auto px-4 py-6">
            <slot />
        </main>
    </div>
</template>
