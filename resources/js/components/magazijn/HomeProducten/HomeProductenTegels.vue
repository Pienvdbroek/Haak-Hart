<script setup>
import HomeProductenTegelCarouselViewer from './HomeProductenTegelCarouselViewer.vue';

defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['select', 'play-video']);
</script>

<template>
    <article
        class="cursor-pointer overflow-hidden rounded-[15px] border border-magazijn-purple-soft bg-magazijn-white transition hover:-translate-y-[2px] hover:shadow-md"
        tabindex="0"
        role="region"
        @click="emit('select', product)"
        @keydown.enter="emit('select', product)"
        @keydown.space.prevent="emit('select', product)"
    >
        <div
            class="relative h-[clamp(210px,45vw,214px)] overflow-hidden bg-magazijn-purple"
        >
            <HomeProductenTegelCarouselViewer
                :product="product"
                autoplay-on-hover
            />

            <div class="absolute left-3 top-3 flex items-center gap-[6px]">
                <UBadge
                    label="Beschikbaar"
                    class="h-[19px] rounded-[6px] bg-magazijn-green px-[11px] text-[11px] text-magazijn-white ring-0"
                />

                <UBadge
                    :label="product.available"
                    class="grid size-5 place-items-center rounded-full bg-magazijn-green p-0 text-[11px] text-magazijn-white ring-0"
                />
            </div>
        </div>

        <div class="relative h-[134px] bg-magazijn-white px-3 pt-4">
            <h2
                class="max-w-[calc(100%-48px)] truncate text-[22px] font-bold leading-7 tracking-[-0.02em] text-black"
            >
                {{ product.name }}
            </h2>

            <p class="mt-1 truncate text-[16px] leading-5 text-magazijn-gray">
                {{ product.type }}
            </p>

            <p
                class="mt-[14px] truncate text-[16px] leading-5 text-magazijn-gray"
            >
                {{ product.info }}
            </p>

            <UButton
                v-if="product.youtubeVideo"
                type="button"
                icon="i-lucide-play"
                aria-label="Bekijk video"
                variant="solid"
                class="absolute right-[22px] top-[21px] !grid size-9 !place-items-center rounded-full bg-magazijn-purple !p-0 text-magazijn-white shadow-md transition hover:scale-110 hover:bg-magazijn-purple hover:shadow-lg active:scale-95"
                @click.stop="emit('play-video', product)"
            />
        </div>
    </article>
</template>
