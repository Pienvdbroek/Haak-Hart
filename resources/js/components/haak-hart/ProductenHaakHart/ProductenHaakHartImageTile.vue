<script setup lang="ts">
defineProps<{
    image: string;
    alt: string;
}>();
</script>

<template>
    <div class="relative overflow-hidden rounded-2xl bg-backgroundfooter-pink">
        <img
            :src="image"
            :alt="alt"
            class="h-full w-full object-cover object-center"
        />

        <slot />
    </div>
</template>
