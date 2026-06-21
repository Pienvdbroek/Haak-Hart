<script setup lang="ts">
import HaakHartFooter from '@/components/haak-hart/HaakHartFooter.vue';
import HaakHartHeaderBar from '@/components/haak-hart/HaakHartHeaderBar.vue';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-[#F9F1F3] to-[#FAF8F8]">
        <HaakHartHeaderBar />

        <main class="mx-auto max-w-7xl">
            <slot />
        </main>    
        </div>
        <HaakHartFooter />

</template>

