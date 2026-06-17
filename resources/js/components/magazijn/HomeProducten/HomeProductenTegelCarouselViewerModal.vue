<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    open: {
        type: Boolean,
        default: false,
    },
    product: {
        type: Object,
        required: true,
    },
    images: {
        type: Array,
        default: () => [],
    },
    startIndex: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits(['update:open']);

const carousel = ref(null);

const modalOpen = computed({
    get: () => props.open,
    set: (value) => emit('update:open', value),
});

const modalImages = computed(() => {
    if (!props.images.length) {
        return [];
    }

    const index = Math.max(
        0,
        Math.min(props.startIndex, props.images.length - 1),
    );

    return [
        ...props.images.slice(index),
        ...props.images.slice(0, index),
    ];
});

const hasMultipleImages = computed(() => modalImages.value.length > 1);

const carouselKey = computed(() => {
    return `${props.product.id}-${props.startIndex}`;
});

function nextImage() {
    carousel.value?.emblaApi?.scrollNext();
}
</script>

<template>
    <UModal
        v-model:open="modalOpen"
        :title="product.name"
        close-icon="i-lucide-x"
        :close="{
            color: 'primary',
            variant: 'ghost',
            class: 'rounded-full !text-magazijn-purple hover:!bg-magazijn-purple/10',
        }"
        :ui="{
            content: 'max-w-[min(94vw,1100px)] overflow-hidden rounded-[18px] bg-magazijn-white ring-1 ring-magazijn-purple-soft',
            header: 'px-5 py-4',
            title: 'text-[22px] font-bold leading-tight text-black',
            body: 'p-0 sm:p-0',
        }"
    >
        <template #body>
            <div
                class="group relative h-[min(78vh,760px)] w-full overflow-hidden bg-magazijn-white"
            >
                <UCarousel
                    v-if="modalImages.length"
                    :key="carouselKey"
                    ref="carousel"
                    v-slot="{ item }"
                    loop
                    align="start"
                    :items="modalImages"
                    class="h-full w-full"
                    :ui="{
                        root: 'h-full w-full overflow-hidden',
                        viewport: 'h-full w-full overflow-hidden',
                        container: 'h-full !-ms-0',
                        item: 'h-full basis-full !ps-0',
                    }"
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
                    class="flex h-full w-full items-center justify-center px-6 text-center text-[18px] font-bold text-magazijn-purple"
                >
                    Geen afbeelding beschikbaar
                </div>

                <UButton
                    v-if="hasMultipleImages"
                    type="button"
                    icon="i-lucide-chevron-right"
                    aria-label="Volgende afbeelding"
                    class="absolute right-5 top-1/2 z-20 !grid size-12 -translate-y-1/2 !place-items-center rounded-full bg-magazijn-purple !p-0 text-magazijn-white opacity-0 shadow-md transition hover:scale-110 hover:bg-magazijn-purple hover:shadow-lg active:scale-95 group-hover:opacity-100"
                    :ui="{
                        base: '!gap-0 !p-0',
                        leadingIcon: 'size-7 shrink-0',
                    }"
                    @click.stop="nextImage"
                />
            </div>
        </template>
    </UModal>
</template>
