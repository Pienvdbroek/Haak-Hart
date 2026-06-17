<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    open: {
        type: Boolean,
        default: false,
    },
    product: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['update:open', 'close']);

const cachedProduct = ref(null);

watch(
    () => [props.open, props.product],
    ([, product]) => {
        if (product) {
            cachedProduct.value = product;
        }
    },
    { immediate: true },
);

const modalOpen = computed({
    get: () => props.open,
    set(value) {
        emit('update:open', value);

        if (!value) {
            emit('close');
        }
    },
});

const modalTitle = computed(() => cachedProduct.value?.name || '');

const youtubeEmbedUrl = computed(() => {
    const url = cachedProduct.value?.youtubeVideo || '';

    if (url.includes('youtube.com/embed/')) {
        return url;
    }

    const videoId =
        url.match(/[?&]v=([^&]+)/)?.[1] ||
        url.match(/youtu\.be\/([^?&]+)/)?.[1] ||
        url.match(/youtube\.com\/shorts\/([^?&]+)/)?.[1];

    return videoId ? `https://www.youtube.com/embed/${videoId}?autoplay=1` : '';
});
</script>

<template>
    <UModal
        v-model:open="modalOpen"
        :title="modalTitle"
        close-icon="i-lucide-x"
        :close="{
            color: 'primary',
            variant: 'ghost',
            class: 'rounded-full !text-magazijn-purple hover:!bg-magazijn-purple/10',
        }"
        :ui="{
            content: 'max-w-[min(92vw,920px)] overflow-hidden rounded-[18px] bg-magazijn-white ring-1 ring-magazijn-purple-soft',
            header: 'px-5 py-4',
            title: 'text-[22px] font-bold leading-tight text-black',
            body: 'p-0 sm:p-0',
        }"
    >
        <template #body>
            <div class="aspect-video bg-black">
                <iframe
                    v-if="youtubeEmbedUrl"
                    class="h-full w-full"
                    :src="youtubeEmbedUrl"
                    :title="modalTitle"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                />
            </div>
        </template>
    </UModal>
</template>
