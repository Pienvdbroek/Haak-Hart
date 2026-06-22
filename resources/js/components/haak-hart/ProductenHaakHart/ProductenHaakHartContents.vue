<script setup lang="ts">
import { computed, ref } from 'vue';

import ProductenHaakHartImageTile from '@/components/haak-hart/ProductenHaakHart/ProductenHaakHartImageTile.vue';
import ProductenHaakHartModal from '@/components/haak-hart/ProductenHaakHart/ProductenHaakHartModal.vue';

type Product = {
    title: string;
    category: string;
    image: string;
    price: string;
};

const activeCategory = ref('Alle');
const modalOpen = ref(false);
const selectedProduct = ref<Product | null>(null);

const categories = [
    'Alle',
    'Truien',
    'Sjaals',
    'Sokken',
    'Handschoenen',
    'Mutsen',
    'Overig',
];

const products: Product[] = [
    {
        title: 'Roze gehaakte trui',
        category: 'Truien',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
    {
        title: 'Warme winter sjaal',
        category: 'Sjaals',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
    {
        title: 'Zachte sokken',
        category: 'Sokken',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
    {
        title: 'Roze handschoenen',
        category: 'Handschoenen',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
    {
        title: 'Gehaakte muts',
        category: 'Mutsen',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
    {
        title: 'Bloemen sjaal',
        category: 'Sjaals',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
    {
        title: 'Warme trui',
        category: 'Truien',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
    {
        title: 'Overig haakwerk',
        category: 'Overig',
        image: '/images/exampleimage.png',
        price: '€ 67,00',
    },
];

const filteredProducts = computed(() => {
    if (activeCategory.value === 'Alle') {
        return products;
    }

    return products.filter((product) => {
        return product.category === activeCategory.value;
    });
});

function openProductModal(product: Product) {
    selectedProduct.value = product;
    modalOpen.value = true;
}
</script>

<template>
    <div class="mx-auto max-w-7xl py-16">
        <section class="text-center">
            <p
                class="text-sm font-semibold tracking-widest text-primary-pink uppercase"
            >
                Eigen productie
            </p>

            <h1
                class="font-timesnewroman mt-3 text-5xl font-bold text-primarytext"
            >
                Onze Producten
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-secondarytext">
                Elk product is met de hand gehaakt door onze vrijwilligers. De
                opbrengst gaat naar het helpen van mensen in nood.
            </p>
        </section>

        <div class="mx-auto mt-10 flex max-w-4xl flex-wrap justify-center gap-4">
            <UButton
                v-for="category in categories"
                :key="category"
                :label="category"
                size="lg"
                color="neutral"
                variant="ghost"
                class="min-w-36 justify-center rounded-xl font-medium shadow-none transition-all duration-200"
                :class="
                    category === activeCategory
                        ? 'border border-primary-pink bg-primary-pink text-white hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink'
                        : 'border border-borderstrokeline bg-white text-primarytext hover:bg-menuhover-pink hover:text-primarytext active:bg-menuhover-pink'
                "
                @click="activeCategory = category"
            />
        </div>

        <UPageGrid class="mt-10 lg:grid-cols-4">
            <UPageCard
                v-for="product in filteredProducts"
                :key="product.title"
                variant="naked"
            >
                <ProductenHaakHartImageTile
                    :image="product.image"
                    :alt="product.title"
                    class="aspect-[4/5] shadow-md"
                >
                    <UButton
                        icon="i-lucide-shopping-cart"
                        color="neutral"
                        variant="ghost"
                        :aria-label="`${product.title} toevoegen aan winkelwagen`"
                        class="absolute top-5 right-5 h-9 w-20 justify-center rounded-xl bg-primary-pink p-0 text-white transition-all duration-200 hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink"
                        @click.stop="openProductModal(product)"
                    />

                    <UBadge
                        :label="product.title"
                        class="font-timesnewroman absolute bottom-16 left-5 h-9 w-fit max-w-[calc(100%-2.5rem)] justify-start rounded-full bg-white px-4 text-left text-base font-bold text-primarytext shadow-sm"
                    />

                    <UBadge
                        :label="product.price"
                        class="font-timesnewroman absolute right-5 bottom-5 h-9 w-20 justify-center rounded-xl bg-primary-pink px-0 text-sm font-semibold text-white"
                    />
                </ProductenHaakHartImageTile>
            </UPageCard>
        </UPageGrid>

        <ProductenHaakHartModal
            v-model:open="modalOpen"
            :product="selectedProduct"
        />
    </div>
</template>
