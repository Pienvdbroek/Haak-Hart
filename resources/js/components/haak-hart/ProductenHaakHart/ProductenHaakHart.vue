<script setup lang="ts">
import ProductenHaakHartContents from '@/components/haak-hart/ProductenHaakHart/ProductenHaakHartContents.vue';
import HaakHartLayout from '@/layouts/haak-hart/HaakHartLayout.vue';

defineOptions({
    layout: HaakHartLayout,
});
</script>

<template>
    <UContainer class="max-w-7xl -my-4">
        <ProductenHaakHartContents />
    </UContainer>
</template>
