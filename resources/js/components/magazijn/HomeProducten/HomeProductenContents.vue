<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import HomeProductenTegels from './HomeProductenTegels.vue';
import HomeProductenTegelsBinnenIn from './HomeProductenTegelsBinnenIn.vue';
import HomeProductenVideoEmbed from './HomeProductenVideoEmbed.vue';

const page = {
    title: 'Producten',
    description: 'Bekijk en reserveer beschikbare apparatuur',
};

const categories = ref(['Alle']);
const allItems = ref([]);
const loading = ref(true);
const error = ref('');

const search = ref('');
const category = ref('Alle');
const selectedProduct = ref(null);
const selectedVideoProduct = ref(null);
const videoModalOpen = ref(false);

const visibleProducts = computed(() => {
    const query = search.value.trim().toLowerCase();

    return allItems.value.filter((product) => {
        const fields = [
            product.name,
            product.type,
            product.info,
            product.category,
        ];

        return (
            (category.value === 'Alle' || product.category === category.value) &&
            (!query ||
                fields.some((field) =>
                    String(field || '').toLowerCase().includes(query),
                ))
        );
    });
});

function getCsrfToken() {
    return (
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') || ''
    );
}

function normalizeImageUrl(path) {
    if (!path) return null;

    if (path.startsWith('http://') || path.startsWith('https://')) {
        return path;
    }

    if (path.startsWith('/')) {
        return path;
    }

    if (path.startsWith('images/')) {
        return `/${path}`;
    }

    return `/storage/${path}`;
}

function mapBackendItem(item) {
    const mainImage = item.image_url || normalizeImageUrl(item.image);

    const extraImages = Array.isArray(item.images_urls)
        ? item.images_urls
        : Array.isArray(item.images)
            ? item.images.map((image) => normalizeImageUrl(image))
            : [];

    const cleanExtraImages = [...new Set(extraImages)]
        .filter(Boolean)
        .filter((image) => image !== mainImage);

    return {
        id: item.id,
        name: item.item_name || '',
        type: item.type || item.category || 'Overig',
        info: item.description || '',
        category: item.category || 'Overig',
        available: Number(item.quantity_available ?? 0),
        enabled: item.status === 'available',
        image: mainImage,
        images: cleanExtraImages,
        youtubeVideo: item.video_link || null,
    };
}

async function fetchProducts() {
    loading.value = true;
    error.value = '';

    try {
        const response = await fetch('/api/items', {
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
        });

        if (!response.ok) {
            throw new Error('Producten ophalen mislukt');
        }

        const data = await response.json();

        const availableItems = data.filter((item) => {
            return (
                Number(item.quantity_available ?? 0) > 0 &&
                (item.status || 'available') === 'available'
            );
        });

        allItems.value = availableItems.map(mapBackendItem);

        const uniqueCategories = [
            ...new Set(allItems.value.map((product) => product.category)),
        ].filter(Boolean);

        categories.value = ['Alle', ...uniqueCategories];
    } catch (err) {
        console.error('Fout bij laden producten:', err);
        error.value = 'Kon producten niet laden.';
        allItems.value = [];
        categories.value = ['Alle'];
    } finally {
        loading.value = false;
    }
}

function scrollTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function openProduct(product) {
    selectedProduct.value = product;
    scrollTop();
}

function closeProduct() {
    selectedProduct.value = null;
    scrollTop();
}

function openVideo(product) {
    selectedVideoProduct.value = product;
    videoModalOpen.value = true;
}

function closeVideo() {
    videoModalOpen.value = false;
}

onMounted(() => {
    fetchProducts();
});
</script>

<template>
    <HomeProductenVideoEmbed
        v-model:open="videoModalOpen"
        :product="selectedVideoProduct"
        @close="closeVideo"
    />

    <HomeProductenTegelsBinnenIn
        v-if="selectedProduct"
        :product="selectedProduct"
        @back="closeProduct"
        @play-video="openVideo"
    />

    <UContainer
        v-else
        class="px-3 pb-14 pt-[clamp(28px,6vw,61px)] sm:px-5"
    >
        <UPageHeader
            v-bind="page"
            :ui="{
                root: 'border-0 py-0',
                container: 'px-0',
                title: 'text-[clamp(38px,7vw,40px)] font-bold leading-tight tracking-[-0.03em] text-black',
                description: 'mt-2 text-[clamp(18px,4vw,20px)] font-normal leading-snug tracking-wide text-magazijn-gray',
            }"
        />

        <section
            class="mt-[clamp(26px,6vw,39px)] flex flex-wrap items-center gap-[10px]"
        >
            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Zoek producten..."
                variant="outline"
                size="xl"
                class="min-w-[min(100%,360px)] flex-[999_1_360px]"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    leadingIcon: 'text-magazijn-gray',
                }"
            />

            <UButton
                v-for="item in categories"
                :key="item"
                variant="ghost"
                size="xl"
                :class="[
                    'h-[46px] rounded-[10px] px-[clamp(18px,5vw,23px)] text-[16px] font-semibold shadow-sm ring-1 ring-magazijn-purple-soft',
                    category === item
                        ? 'bg-magazijn-purple text-magazijn-white hover:bg-magazijn-purple'
                        : 'bg-magazijn-white text-magazijn-gray hover:bg-magazijn-white',
                ]"
                :ui="{
                    base: 'focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
                @click="category = item"
            >
                {{ item }}
            </UButton>
        </section>

        <div v-if="loading" class="py-14 text-center">
            <UIcon
                name="i-lucide-loader-circle"
                class="mx-auto h-7 w-7 animate-spin text-magazijn-purple"
            />

            <p class="mt-3 text-sm text-magazijn-gray">
                Producten laden...
            </p>
        </div>

        <UCard
            v-else-if="error"
            class="mt-[48px] bg-magazijn-white"
            :ui="{
                root: 'rounded-[10px] ring-1 ring-red-200',
                body: 'p-0 sm:p-0',
            }"
        >
            <div class="py-10 text-center">
                <p class="text-lg font-semibold text-red-500">
                    {{ error }}
                </p>
            </div>
        </UCard>

        <div
            v-else-if="visibleProducts.length"
            class="mt-[clamp(34px,7vw,48px)] grid grid-cols-[repeat(auto-fit,minmax(min(100%,280px),1fr))] gap-x-[41px] gap-y-[37px]"
        >
            <HomeProductenTegels
                v-for="product in visibleProducts"
                :key="product.id"
                :product="product"
                @select="openProduct"
                @play-video="openVideo"
            />
        </div>

        <UCard
            v-else
            class="mt-[48px] bg-magazijn-white"
            :ui="{
                root: 'rounded-[10px] ring-1 ring-magazijn-purple-soft',
                body: 'p-0 sm:p-0',
            }"
        >
            <div class="py-10 text-center">
                <p class="text-lg font-semibold text-magazijn-purple">
                    Geen producten gevonden
                </p>

                <p class="mt-1 text-sm text-magazijn-gray">
                    Pas je zoekterm of categorie aan.
                </p>
            </div>
        </UCard>
    </UContainer>
</template>
