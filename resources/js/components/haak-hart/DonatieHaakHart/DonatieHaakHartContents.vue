<script setup lang="ts">
import DonatieHaakHartForm from '@/components/haak-hart/DonatieHaakHart/DonatieHaakHartForm.vue';
import DonatieHaakHartSteps from '@/components/haak-hart/DonatieHaakHart/DonatieHaakHartSteps.vue';
</script>

<template>
    <section class="py-10">
        <UPageGrid
            class="items-center gap-14 sm:grid-cols-1 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)]"
        >
            <DonatieHaakHartSteps class="order-1 lg:order-2" />

            <DonatieHaakHartForm class="order-2 lg:order-1" />
        </UPageGrid>
    </section>
</template>
