<script setup lang="ts">
import { computed } from 'vue';

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
    imageEntries?: ProductImage[];
    youtubeVideo?: string | null;
};

const props = defineProps<{
    product: Product;
}>();

const emit = defineEmits<{
    (e: 'edit', product: Product): void;
    (e: 'delete', product: Product): void;
}>();

const isAvailable = computed(() => {
    return props.product.enabled && props.product.available > 0;
});
</script>

<template>
    <UCard
        variant="outline"
        :ui="{
            root: 'overflow-hidden rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft',
            body: 'p-0 sm:p-0',
        }"
    >
        <div
            class="flex min-h-[96px] items-center justify-between gap-5 px-5 py-4"
        >
            <div class="flex min-w-0 items-center gap-5">
                <div
                    class="h-16 w-16 shrink-0 rounded-[18px] bg-magazijn-purple"
                />

                <div class="min-w-0">
                    <h2 class="truncate text-[17px] font-bold leading-6 text-black">
                        {{ product.name }}
                    </h2>

                    <p class="truncate text-[14px] leading-5 text-magazijn-gray">
                        {{
                            product.type ||
                            product.category ||
                            'Geen categorie'
                        }}
                    </p>
                </div>
            </div>

            <div class="flex shrink-0 items-center gap-5">
                <span
                    class="inline-flex h-[30px] min-w-[145px] items-center justify-center gap-2 rounded-full border px-4 text-sm font-semibold"
                    :class="
                        isAvailable
                            ? 'border-magazijn-green bg-magazijn-green-soft text-magazijn-green'
                            : 'border-magazijn-red bg-magazijn-red-soft text-magazijn-red'
                    "
                >
                    <UIcon
                        :name="
                            isAvailable
                                ? 'i-lucide-check'
                                : 'i-lucide-x'
                        "
                        class="h-4 w-4"
                    />

                    {{ isAvailable ? 'Beschikbaar' : 'Uitgeleend' }}
                </span>

                <UButton
                    icon="i-lucide-pencil"
                    color="neutral"
                    variant="ghost"
                    class="text-magazijn-purple hover:bg-magazijn-purple-soft hover:text-magazijn-purple"
                    @click="emit('edit', product)"
                />

                <UButton
                    icon="i-lucide-trash"
                    color="neutral"
                    variant="ghost"
                    class="text-magazijn-purple hover:bg-magazijn-red-soft hover:text-magazijn-red"
                    @click="emit('delete', product)"
                />
            </div>
        </div>
    </UCard>
</template>
