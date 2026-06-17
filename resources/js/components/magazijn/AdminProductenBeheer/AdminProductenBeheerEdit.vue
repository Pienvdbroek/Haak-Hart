<script setup lang="ts">
import { computed, ref, watch } from 'vue';

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

const props = withDefaults(
    defineProps<{
        product: Product;
        isNew: boolean;
        errors?: FormErrors;
    }>(),
    {
        errors: () => ({}),
    },
);

const emit = defineEmits<{
    (
        e: 'gallery-change',
        payload: {
            entries: ProductImage[];
        },
    ): void;
    (e: 'save'): void;
}>();

const categories = [
    'Camera',
    'Audio',
    'Licht',
    'Stabilisatie',
    'Kits',
    'Filters',
    'Accu',
    'Rugzak',
    'Overig',
];

const quantities = Array.from({ length: 21 }, (_, i) => i);

const imageEntries = ref<ProductImage[]>([]);
const carousel = ref<any>(null);
const addInput = ref<HTMLInputElement | null>(null);
const replaceInput = ref<HTMLInputElement | null>(null);
const replaceTargetId = ref<string | null>(null);

const youtubeVideoModel = computed<string>({
    get: () => props.product.youtubeVideo ?? '',
    set: (value) => {
        props.product.youtubeVideo = value || '';
    },
});

const productImages = computed(() => imageEntries.value);
const hasImages = computed(() => productImages.value.length > 0);
const hasMultipleImages = computed(() => productImages.value.length > 1);
const mainImageId = computed(() => imageEntries.value[0]?.id || null);

const carouselKey = computed(() => {
    return imageEntries.value
        .map((entry) => `${entry.id}-${entry.previewUrl}-${entry.path}`)
        .join('|');
});

watch(
    () => props.product,
    (product) => {
        imageEntries.value = (product.imageEntries || []).map((entry) => ({
            ...entry,
        }));

        emitGalleryChange();
    },
    { immediate: true },
);

function errorText(...keys: string[]) {
    for (const key of keys) {
        const value = props.errors?.[key];

        if (Array.isArray(value)) {
            return value[0] || '';
        }

        if (typeof value === 'string') {
            return value;
        }
    }

    return '';
}

function emitGalleryChange() {
    emit('gallery-change', {
        entries: imageEntries.value,
    });
}

function scrollNext() {
    carousel.value?.emblaApi?.scrollNext();
}

function makeMainImage(id: string) {
    const index = imageEntries.value.findIndex((entry) => entry.id === id);

    if (index <= 0) {
        emitGalleryChange();
        return;
    }

    const [selectedEntry] = imageEntries.value.splice(index, 1);

    imageEntries.value.unshift(selectedEntry);

    requestAnimationFrame(() => {
        carousel.value?.emblaApi?.scrollTo?.(0);
    });

    emitGalleryChange();
}

function removeImage(id: string) {
    const index = imageEntries.value.findIndex((entry) => entry.id === id);

    if (index === -1) return;

    const [removedEntry] = imageEntries.value.splice(index, 1);

    if (removedEntry?.isNew && removedEntry.previewUrl) {
        URL.revokeObjectURL(removedEntry.previewUrl);
    }

    requestAnimationFrame(() => {
        carousel.value?.emblaApi?.scrollTo?.(0);
    });

    emitGalleryChange();
}

function openAddUpload() {
    addInput.value?.click();
}

function openReplaceUpload(id: string) {
    replaceTargetId.value = id;
    replaceInput.value?.click();
}

function addUploadedImages(event: Event) {
    const target = event.target as HTMLInputElement;
    const files = Array.from(target.files || []);

    if (!files.length) return;

    const newEntries: ProductImage[] = files.map((file, index) => ({
        id: `upload-${Date.now()}-${index}`,
        path: null,
        previewUrl: URL.createObjectURL(file),
        file,
        isNew: true,
    }));

    imageEntries.value.push(...newEntries);

    target.value = '';
    emitGalleryChange();
}

function replaceImage(event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0] || null;

    if (!file || !replaceTargetId.value) {
        target.value = '';
        return;
    }

    const entry = imageEntries.value.find(
        (image) => image.id === replaceTargetId.value,
    );

    if (!entry) {
        target.value = '';
        replaceTargetId.value = null;
        return;
    }

    if (entry.isNew && entry.previewUrl) {
        URL.revokeObjectURL(entry.previewUrl);
    }

    entry.path = null;
    entry.previewUrl = URL.createObjectURL(file);
    entry.file = file;
    entry.isNew = true;

    target.value = '';
    replaceTargetId.value = null;

    emitGalleryChange();
}
</script>

<template>
    <div class="space-y-7">
        <input
            ref="addInput"
            type="file"
            accept="image/*"
            multiple
            class="hidden"
            @change="addUploadedImages"
        />

        <input
            ref="replaceInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="replaceImage"
        />

        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Naam product
            </label>

            <UInput
                v-model="product.name"
                placeholder="Bijv. Canon EOS R50"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-blue-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
                class="w-full"
            />

            <p
                v-if="errorText('name', 'item_name')"
                class="mt-1 text-sm text-magazijn-red"
            >
                {{ errorText('name', 'item_name') }}
            </p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Categorie
            </label>

            <USelect
                v-model="product.category"
                :items="categories"
                placeholder="Selecteer categorie"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-blue-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    content: 'z-[9999]',
                }"
                :portal="'body'"
                class="w-full"
            />

            <p
                v-if="errorText('category')"
                class="mt-1 text-sm text-magazijn-red"
            >
                {{ errorText('category') }}
            </p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Beschrijving
            </label>

            <UTextarea
                v-model="product.info"
                placeholder="Voeg een beschrijving toe..."
                autoresize
                :rows="4"
                :ui="{
                    base: 'rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-blue-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
                class="w-full"
            />

            <p
                v-if="errorText('info', 'description')"
                class="mt-1 text-sm text-magazijn-red"
            >
                {{ errorText('info', 'description') }}
            </p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Product foto
            </label>

            <div
                v-if="hasImages"
                class="relative h-[170px] overflow-hidden rounded-[14px] border-2 border-dashed border-magazijn-purple bg-magazijn-purple"
            >
                <UCarousel
                    :key="carouselKey"
                    ref="carousel"
                    v-slot="{ item }"
                    loop
                    align="start"
                    :items="productImages"
                    class="h-full w-full"
                    :ui="{
                        root: 'h-full w-full overflow-hidden',
                        viewport: 'h-full w-full overflow-hidden',
                        container: 'h-full !-ms-0',
                        item: 'h-full basis-full !ps-0',
                    }"
                >
                    <div class="relative h-full w-full">
                        <button
                            type="button"
                            class="relative block h-full w-full"
                            @click="openReplaceUpload(item.id)"
                        >
                            <img
                                v-if="item.previewUrl"
                                :src="item.previewUrl ?? undefined"
                                :alt="product.name"
                                class="block h-full w-full object-cover object-center"
                                draggable="false"
                            />

                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center text-center text-[18px] font-bold text-magazijn-white"
                            >
                                {{ product.name }}
                            </div>

                            <div
                                class="pointer-events-none absolute inset-0 bg-black/10"
                            />

                            <span
                                class="absolute bottom-3 left-3 rounded-full bg-magazijn-purple px-3 py-1 text-xs font-semibold text-magazijn-white"
                            >
                                Klik om te vervangen
                            </span>
                        </button>

                        <div
                            class="absolute right-4 top-4 z-[60] flex items-center gap-2"
                        >
                            <UButton
                                type="button"
                                icon="i-lucide-heart"
                                aria-label="Maak hoofdafbeelding"
                                color="neutral"
                                variant="solid"
                                class="!grid size-10 !place-items-center rounded-full !p-0 shadow-lg transition hover:scale-110 active:scale-95"
                                :class="
                                    mainImageId === item.id
                                        ? 'bg-magazijn-red text-magazijn-white hover:bg-magazijn-red'
                                        : 'bg-magazijn-purple text-magazijn-white hover:bg-magazijn-purple'
                                "
                                :ui="{
                                    base: '!gap-0 !p-0',
                                    leadingIcon:
                                        mainImageId === item.id
                                            ? 'size-5 fill-current'
                                            : 'size-5',
                                }"
                                @click.stop="makeMainImage(item.id)"
                            />

                            <UButton
                                type="button"
                                icon="i-lucide-trash"
                                aria-label="Verwijder afbeelding"
                                color="neutral"
                                variant="solid"
                                class="!grid size-10 !place-items-center rounded-full bg-magazijn-red !p-0 text-magazijn-white shadow-lg transition hover:scale-110 hover:bg-magazijn-red active:scale-95"
                                :ui="{
                                    base: '!gap-0 !p-0',
                                    leadingIcon: 'size-5',
                                }"
                                @click.stop="removeImage(item.id)"
                            />
                        </div>
                    </div>
                </UCarousel>

                <UButton
                    v-if="hasMultipleImages"
                    type="button"
                    icon="i-lucide-chevron-right"
                    aria-label="Volgende afbeelding"
                    color="neutral"
                    variant="solid"
                    class="absolute right-4 top-1/2 z-20 !grid size-11 -translate-y-1/2 !place-items-center rounded-full bg-magazijn-purple !p-0 text-magazijn-white shadow-md transition hover:scale-110 hover:bg-magazijn-purple active:scale-95"
                    :ui="{
                        base: '!gap-0 !p-0',
                        leadingIcon: 'size-6 shrink-0',
                    }"
                    @click.stop="scrollNext"
                />
            </div>

            <button
                v-else
                type="button"
                class="flex h-[170px] w-full items-center justify-center rounded-[14px] border-2 border-dashed border-magazijn-purple bg-magazijn-purple"
                @click="openAddUpload"
            >
                <div class="text-center">
                    <div
                        class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-magazijn-white"
                    >
                        <UIcon
                            name="i-lucide-image-plus"
                            class="h-6 w-6 text-magazijn-purple"
                        />
                    </div>

                    <p class="text-sm font-semibold text-magazijn-white">
                        Upload een afbeelding
                    </p>
                </div>
            </button>

            <button
                v-if="hasImages"
                type="button"
                class="mt-4 flex h-[110px] w-full items-center justify-center rounded-[14px] border-2 border-dashed border-magazijn-purple-soft bg-magazijn-purple-soft transition hover:border-magazijn-purple hover:bg-magazijn-purple/10"
                @click="openAddUpload"
            >
                <div class="text-center">
                    <div
                        class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-magazijn-purple"
                    >
                        <UIcon
                            name="i-lucide-image-plus"
                            class="h-5 w-5 text-magazijn-white"
                        />
                    </div>

                    <p class="text-sm font-semibold text-magazijn-purple">
                        Nog een afbeelding toevoegen
                    </p>
                </div>
            </button>

            <p
                v-if="errorText('image')"
                class="mt-1 text-sm text-magazijn-red"
            >
                {{ errorText('image') }}
            </p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                Aantal eenheden
            </label>

            <USelect
                v-model="product.available"
                :items="quantities"
                size="xl"
                :ui="{
                    base: 'h-[46px] w-full rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                    content: 'z-[9999]',
                }"
                :portal="'body'"
                
            />

            <p
                v-if="errorText('available', 'quantity_available')"
                class="mt-1 text-sm text-magazijn-red"
            >
                {{ errorText('available', 'quantity_available') }}
            </p>
        </div>

        <div
            class="flex items-center justify-between rounded-[12px] border border-magazijn-purple-soft bg-magazijn-white px-4 py-3"
        >
            <div>
                <h3 class="text-sm font-semibold text-black">
                    Beschikbaar
                </h3>

                <p class="text-sm text-magazijn-gray">
                    Product zichtbaar voor reserveringen
                </p>
            </div>

            <USwitch
                v-model="product.enabled"
                :ui="{
                    base: 'data-[state=checked]:bg-magazijn-purple data-[state=unchecked]:bg-magazijn-red',
                    thumb: 'bg-magazijn-white',
                }"
            />
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-black">
                YouTube video
            </label>

            <UInput
                v-model="youtubeVideoModel"
                placeholder="Bijv. https://www.youtube.com/watch?v=oWJ1YAkF9yU"
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-blue-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                }"
                class="w-full"
            />

            <p
                v-if="errorText('video_link', 'youtubeVideo')"
                class="mt-1 text-sm text-magazijn-red"
            >
                {{ errorText('video_link', 'youtubeVideo') }}
            </p>
        </div>

        <UButton
            size="xl"
            color="neutral"
            block
            class="h-[60px] rounded-[10px] bg-magazijn-purple text-xl font-bold text-magazijn-white hover:bg-magazijn-purple"
            @click="emit('save')"
        >
            Opslaan
        </UButton>
    </div>
</template>
