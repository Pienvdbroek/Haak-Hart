<script setup lang="ts">
import { computed, ref } from 'vue';
import HomeProductenTegelCarouselViewerModal from './HomeProductenTegelCarouselViewerModal.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    autoplayOnHover: {
        type: Boolean,
        default: false,
    },
    arrows: {
        type: Boolean,
        default: false,
    },
    expandable: {
        type: Boolean,
        default: false,
    },
});

const carousel = ref(null);
const hovering = ref(false);
const modalOpen = ref(false);
const activeIndex = ref(0);

const productImages = computed(() => {
    return [
        ...new Set([props.product.image, ...(props.product.images || [])]),
    ].filter(Boolean);
});

const mainImage = computed(() => productImages.value[0] || null);
const hasImage = computed(() => productImages.value.length > 0);
const hasMultipleImages = computed(() => productImages.value.length > 1);

const carouselAutoplay = computed(() => {
    return props.autoplayOnHover && hovering.value && hasMultipleImages.value
        ? { delay: 1200 }
        : false;
});

const controlsVisible = computed(() => hovering.value && !modalOpen.value);

const showExpandButton = computed(() => {
    return props.expandable && hasImage.value && controlsVisible.value;
});

const showNextButton = computed(() => {
    return props.arrows && hasMultipleImages.value && controlsVisible.value;
});

function nextImage() {
    carousel.value?.emblaApi?.scrollNext();
}

function openModal() {
    activeIndex.value = carousel.value?.emblaApi?.selectedScrollSnap() || 0;
    modalOpen.value = true;
    hovering.value = false;
}
</script>

<template>
    <div
        class="relative h-full w-full overflow-hidden bg-magazijn-purple"
        @mouseenter="hovering = true"
        @mouseleave="hovering = false"
    >
        <img
            v-if="!hasMultipleImages && mainImage"
            :src="mainImage"
            :alt="product.name"
            class="block h-full w-full object-cover object-center"
            loading="lazy"
            draggable="false"
        />

        <UCarousel
            v-else-if="hasMultipleImages"
            ref="carousel"
            v-slot="{ item }"
            loop
            align="start"
            :items="productImages"
            :autoplay="carouselAutoplay"
            class="h-full w-full"
            :ui="{
                root: 'h-full w-full overflow-hidden',
                viewport: 'h-full w-full overflow-hidden',
                container: 'h-full !-ms-0',
                item: 'h-full basis-full !ps-0',
            }"
            @select="activeIndex = $event"
        >
            <img
                :src="item"
                :alt="product.name"
                class="block h-full w-full object-cover object-center"
                loading="lazy"
                draggable="false"
            />
        </UCarousel>

        <div
            v-else
            class="flex h-full w-full items-center justify-center px-6 text-center text-[18px] font-bold text-magazijn-white"
        >
            {{ product.name }}
        </div>

        <div class="pointer-events-none absolute inset-0 bg-black/10" />

        <UButton
            v-if="showExpandButton"
            type="button"
            icon="i-lucide-maximize-2"
            aria-label="Vergroot afbeelding"
            variant="solid"
            class="absolute right-4 top-4 z-20 !grid size-10 !place-items-center rounded-full bg-magazijn-purple !p-0 text-magazijn-white shadow-md transition hover:scale-110 hover:bg-magazijn-purple hover:shadow-lg active:scale-95"
            :ui="{
                base: '!gap-0 !p-0',
                leadingIcon: 'size-5 shrink-0',
            }"
            @click.stop="openModal"
        />

        <UButton
            v-if="showNextButton"
            type="button"
            icon="i-lucide-chevron-right"
            aria-label="Volgende afbeelding"
            variant="solid"
            class="absolute right-4 top-1/2 z-20 !grid size-11 -translate-y-1/2 !place-items-center rounded-full bg-magazijn-purple !p-0 text-magazijn-white shadow-md transition hover:scale-110 hover:bg-magazijn-purple hover:shadow-lg active:scale-95"
            :ui="{
                base: '!gap-0 !p-0',
                leadingIcon: 'size-6 shrink-0',
            }"
            @click.stop="nextImage"
        />

        <HomeProductenTegelCarouselViewerModal
            v-if="expandable"
            v-model:open="modalOpen"
            :product="product"
            :images="productImages"
            :start-index="activeIndex"
        />
    </div>
</template>
