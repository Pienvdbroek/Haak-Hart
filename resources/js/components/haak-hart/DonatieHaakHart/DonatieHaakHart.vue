<script setup lang="ts">
import DonatieHaakHartContents from '@/components/haak-hart/DonatieHaakHart/DonatieHaakHartContents.vue';
import HaakHartLayout from '@/layouts/haak-hart/HaakHartLayout.vue';

defineOptions({
    layout: HaakHartLayout,
});
</script>

<template>
    <UContainer class="max-w-7xl py-8">
        <DonatieHaakHartContents />
    </UContainer>
</template>
