<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import AdminProductenBeheerTegels from './AdminProductenBeheerTegels.vue';
import AdminProductenBeheerEdit from './AdminProductenBeheerEdit.vue';

type ProductImage = {
    id: string;
    path: string | null;
    previewUrl?: string | null;
    file?: File | null;
    isNew?: boolean;
};

type Product = {
    id?: number;
    name: string;
    type: string;
    info: string;
    category: string;
    available: number;
    enabled: boolean;

    image?: string | null;
    imageUrl?: string | null;

    images?: string[];
    imageUrls?: string[];

    imageEntries?: ProductImage[];

    youtubeVideo?: string | null;
};

type FormErrors = Record<string, string | string[]>;

const products = ref<Product[]>([]);
const search = ref('');
const loading = ref(false);
const saving = ref(false);
const error = ref('');
const errors = ref<FormErrors>({});

const isModalOpen = ref(false);
const editingProduct = ref<Product | null>(null);
const isCreating = ref(false);

const visibleProducts = computed(() => {
    const query = search.value.trim().toLowerCase();

    return products.value.filter((product) => {
        if (!query) return true;

        return [
            product.name,
            product.type,
            product.info,
            product.category,
            product.youtubeVideo,
        ].some((value) => String(value || '').toLowerCase().includes(query));
    });
});

function getCsrfToken() {
    return (
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') || ''
    );
}

function normalizeImageUrl(path?: string | null): string | undefined {
    if (!path) return undefined;

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

function buildImageEntries(item: any): ProductImage[] {
    const entries: ProductImage[] = [];

    const mainPath = item.image || null;
    const mainUrl = item.image_url || normalizeImageUrl(mainPath);

    if (mainPath || mainUrl) {
        entries.push({
            id: `main-${item.id}`,
            path: mainPath,
            previewUrl: mainUrl,
            file: null,
            isNew: false,
        });
    }

    const rawExtraImages = Array.isArray(item.images) ? item.images : [];
    const urlExtraImages = Array.isArray(item.images_urls)
        ? item.images_urls
        : [];

    rawExtraImages.forEach((path: string, index: number) => {
        entries.push({
            id: `extra-${item.id}-${index}`,
            path,
            previewUrl: urlExtraImages[index] || normalizeImageUrl(path),
            file: null,
            isNew: false,
        });
    });

    return entries;
}

function mapBackendProduct(item: any): Product {
    const imageEntries = buildImageEntries(item);
    const mainImage = imageEntries[0] || null;

    return {
        id: item.id,
        name: item.item_name || '',
        type: item.type || item.category || '',
        info: item.description || '',
        category: item.category || '',
        available: Number(item.quantity_available ?? 0),
        enabled: item.status
            ? item.status === 'available'
            : Number(item.quantity_available ?? 0) > 0,

        image: mainImage?.path || item.image || null,
        imageUrl:
            mainImage?.previewUrl ||
            item.image_url ||
            normalizeImageUrl(item.image),

        images: Array.isArray(item.images) ? item.images : [],
        imageUrls: Array.isArray(item.images_urls) ? item.images_urls : [],

        imageEntries,

        youtubeVideo: item.video_link || '',
    };
}

function normalizeErrors(serverErrors: FormErrors): FormErrors {
    const keyMap: Record<string, string> = {
        item_name: 'name',
        description: 'info',
        quantity_available: 'available',
        video_link: 'youtubeVideo',
    };

    const mapped: FormErrors = {};

    Object.entries(serverErrors).forEach(([key, value]) => {
        mapped[keyMap[key] || key] = value;
    });

    return mapped;
}

async function fetchProducts() {
    loading.value = true;
    error.value = '';

    try {
        const response = await fetch('/api/items', {
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            throw new Error('Producten ophalen mislukt');
        }

        const data = await response.json();
        const list = Array.isArray(data) ? data : data.data || [];

        products.value = list.map(mapBackendProduct);
    } catch (err) {
        console.error(err);
        error.value = 'Kon producten niet laden';
    } finally {
        loading.value = false;
    }
}

function validateProduct(product: Product) {
    const newErrors: FormErrors = {};

    if (!product.name.trim()) {
        newErrors.name = 'Naam product is verplicht';
    }

    if (!product.category) {
        newErrors.category = 'Categorie is verplicht';
    }

    if (Number(product.available) < 0) {
        newErrors.available = 'Aantal mag niet lager zijn dan 0';
    }

    errors.value = newErrors;

    return Object.keys(newErrors).length === 0;
}

function openEdit(product: Product) {
    editingProduct.value = {
        ...product,
        imageEntries: (product.imageEntries || []).map((entry) => ({ ...entry })),
    };

    errors.value = {};
    isCreating.value = false;
    isModalOpen.value = true;
}

function openCreate() {
    editingProduct.value = {
        name: '',
        type: '',
        info: '',
        category: '',
        available: 0,
        enabled: true,

        image: null,
        imageUrl: null,

        images: [],
        imageUrls: [],

        imageEntries: [],

        youtubeVideo: '',
    };

    errors.value = {};
    isCreating.value = true;
    isModalOpen.value = true;
}

function closeModal() {
    isModalOpen.value = false;
    editingProduct.value = null;
    errors.value = {};
    isCreating.value = false;
}

function handleModalOpen(value: boolean) {
    if (value) {
        isModalOpen.value = true;
        return;
    }

    closeModal();
}

function handleGalleryChange(payload: { entries: ProductImage[] }) {
    if (!editingProduct.value) return;

    const mainEntry = payload.entries[0] || null;

    editingProduct.value.imageEntries = payload.entries;
    editingProduct.value.image = mainEntry?.path || null;
    editingProduct.value.imageUrl = mainEntry?.previewUrl || null;
    editingProduct.value.images = payload.entries
        .slice(1)
        .map((entry) => entry.path)
        .filter(Boolean) as string[];
}

async function saveProduct() {
    if (!editingProduct.value) return;
    if (saving.value) return;
    if (!validateProduct(editingProduct.value)) return;

    saving.value = true;
    errors.value = {};

    const product = editingProduct.value;
    const entries = product.imageEntries || [];
    const mainEntry = entries[0] || null;
    const extraEntries = entries.slice(1);

    const formData = new FormData();

    formData.append('item_name', product.name.trim());
    formData.append('type', product.type || product.category || '');
    formData.append('category', product.category);
    formData.append('description', product.info || '');
    formData.append('quantity_available', String(Number(product.available)));
    formData.append('status', product.enabled ? 'available' : 'unavailable');
    formData.append('video_link', product.youtubeVideo || '');
    formData.append('gallery_submitted', '1');

    if (mainEntry?.file) {
        formData.append('image', mainEntry.file);
    } else if (mainEntry?.path) {
        formData.append('image_path', mainEntry.path);
    }

    extraEntries.forEach((entry) => {
        if (entry.file) {
            formData.append('image_files[]', entry.file);
            return;
        }

        if (entry.path) {
            formData.append('images[]', entry.path);
        }
    });

    const url = isCreating.value
        ? '/products/store'
        : `/products/${product.id}`;

    if (!isCreating.value) {
        formData.append('_method', 'PUT');
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => null);

            if (errorData?.errors) {
                errors.value = normalizeErrors(errorData.errors);
                return;
            }

            throw new Error('Opslaan mislukt');
        }

        await fetchProducts();
        closeModal();
    } catch (err) {
        console.error(err);
        alert('Fout bij opslaan van product');
    } finally {
        saving.value = false;
    }
}

async function deleteProduct(product: Product) {
    if (!product.id) return;

    if (!confirm(`Weet je zeker dat je "${product.name}" wilt verwijderen?`)) {
        return;
    }

    try {
        const response = await fetch(`/products/${product.id}`, {
            method: 'DELETE',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            throw new Error('Verwijderen mislukt');
        }

        products.value = products.value.filter((item) => item.id !== product.id);
    } catch (err) {
        console.error(err);
        alert('Fout bij verwijderen');
    }
}

onMounted(() => {
    fetchProducts();
});
</script>

<template>
    <UContainer class="px-3 pb-14 pt-[clamp(28px,6vw,32px)] sm:px-5">
        <div class="max-w-[1180px]">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1
                        class="text-[clamp(34px,5vw,38px)] font-bold leading-tight tracking-[-0.03em] text-black"
                    >
                        Producten Beheer
                    </h1>

                    <p
                        class="mt-2 text-[clamp(18px,3vw,20px)] font-normal leading-snug tracking-wide text-magazijn-gray"
                    >
                        Producten aanmaken, wijzigen en verwijderen
                    </p>
                </div>

                <UButton
                    size="xl"
                    color="neutral"
                    class="rounded-[10px] bg-magazijn-purple px-5 text-magazijn-white hover:bg-magazijn-purple"
                    @click="openCreate"
                >
                    + Nieuw Product
                </UButton>
            </div>

            <section class="mt-9">
                <UInput
                    v-model="search"
                    icon="i-lucide-search"
                    placeholder="Zoek op product..."
                    size="xl"
                    class="w-full"
                    :ui="{
                        base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                        leadingIcon: 'text-magazijn-gray',
                    }"
                />
            </section>

            <div v-if="loading" class="py-12 text-center">
                <UIcon
                    name="i-lucide-loader-circle"
                    class="mx-auto h-7 w-7 animate-spin text-magazijn-purple"
                />

                <p class="mt-2 text-magazijn-gray">
                    Producten laden...
                </p>
            </div>

            <div v-else-if="error" class="py-12 text-center text-magazijn-red">
                {{ error }}
            </div>

            <div v-else class="mt-10 space-y-5">
                <div
                    v-if="visibleProducts.length === 0"
                    class="rounded-[18px] border border-magazijn-purple-soft bg-magazijn-white py-10 text-center text-magazijn-gray"
                >
                    Geen producten gevonden.
                </div>

                <AdminProductenBeheerTegels
                    v-for="product in visibleProducts"
                    :key="product.id"
                    :product="product"
                    @edit="openEdit"
                    @delete="deleteProduct"
                />
            </div>
        </div>

        <UModal
            :open="isModalOpen"
            :ui="{
                overlay: 'z-[1000]',
                content: 'z-[1001] w-full max-w-[640px] max-h-[92dvh] overflow-hidden rounded-[18px] bg-magazijn-white',
            }"
            @update:open="handleModalOpen"
        >
            <template #content>
                <UCard
                    class="w-full bg-magazijn-white"
                    :ui="{
                        root: 'max-h-[92dvh] overflow-hidden flex flex-col rounded-[18px] bg-magazijn-white ring-1 ring-magazijn-purple-soft',
                        header: 'shrink-0 border-b border-magazijn-purple-soft bg-magazijn-white px-8 py-6',
                        body: 'overflow-y-auto bg-magazijn-white px-8 py-7 sm:px-8 sm:py-7',
                        footer: 'hidden',
                    }"
                >
                    <template #header>
                        <h2 class="text-2xl font-bold text-magazijn-purple">
                            {{
                                isCreating
                                    ? 'Nieuw product'
                                    : 'Product bewerken'
                            }}
                        </h2>
                    </template>

                    <AdminProductenBeheerEdit
                        v-if="editingProduct"
                        :product="editingProduct"
                        :is-new="isCreating"
                        :errors="errors"
                        @gallery-change="handleGalleryChange"
                        @save="saveProduct"
                    />
                </UCard>
            </template>
        </UModal>
    </UContainer>
</template>
