<script setup lang="ts">
import HaakHartHeaderBar from '@/components/haak-hart/HaakHartHeaderBar.vue';
</script>

<template>
    <div class="min-h-screen bg-backgroundprimary">
        <HaakHartHeaderBar />

    <div class="h-[120vh] bg-gradient-to-b from-[#F9F1F3] to-[#FAF8F8]">

        <main class=" ">
            <slot />
        </main>
        </div>
    </div>
</template>
