<script setup lang="ts">
import { computed, reactive, watch } from 'vue';

import ProductenHaakHartImageTile from '@/components/haak-hart/ProductenHaakHart/ProductenHaakHartImageTile.vue';

type Product = {
    title: string;
    category: string;
    image: string;
    price: string;
};

type CheckoutForm = {
    email: string;
    name: string;
    postcode: string;
    houseNumber: string;
    phone: string;
};

const props = defineProps<{
    open: boolean;
    product: Product | null;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
    submit: [data: { product: Product; form: CheckoutForm }];
}>();

const modalOpen = computed({
    get() {
        return props.open;
    },
    set(value: boolean) {
        emit('update:open', value);
    },
});

const state = reactive<CheckoutForm>({
    email: '',
    name: '',
    postcode: '',
    houseNumber: '',
    phone: '',
});

const modalUi = {
    content:
        'w-[min(94vw,460px)] max-w-none bg-transparent p-0 shadow-none ring-0',
};

const fieldUi = {
    root: 'min-h-[76px]',
    label: 'text-primarytext dark:text-primarytext',
};

const inputUi = {
    base: 'h-8 rounded-md bg-white text-primarytext ring-1 ring-borderstrokeline placeholder:text-secondarytext focus-visible:ring-2 focus-visible:ring-primary-pink dark:bg-white dark:text-primarytext dark:ring-borderstrokeline dark:placeholder:text-secondarytext',
};

watch(
    () => props.product,
    () => {
        state.email = '';
        state.name = '';
        state.postcode = '';
        state.houseNumber = '';
        state.phone = '';
    },
);

function onSubmit() {
    if (!props.product) {
        return;
    }

    emit('submit', {
        product: props.product,
        form: { ...state },
    });

    modalOpen.value = false;
}
</script>

<template>
    <UModal v-model:open="modalOpen" :ui="modalUi">
        <template #content>
            <div
                v-if="props.product"
                class="relative min-h-[590px] rounded-2xl bg-white px-8 pt-8 pb-12 shadow-xl"
            >
                <UForm :state="state" class="space-y-8" @submit="onSubmit">
                    <div class="grid grid-cols-[150px_1fr] gap-x-5 gap-y-4">
                        <div class="space-y-4 self-end">
                            <UFormField
                                label="E-mail"
                                name="email"
                                required
                                size="sm"
                                :ui="fieldUi"
                            >
                                <UInput
                                    v-model="state.email"
                                    type="email"
                                    placeholder="Je@email.nl"
                                    color="neutral"
                                    variant="outline"
                                    class="w-full"
                                    :ui="inputUi"
                                />
                            </UFormField>

                            <UFormField
                                label="Naam"
                                name="name"
                                required
                                size="sm"
                                :ui="fieldUi"
                            >
                                <UInput
                                    v-model="state.name"
                                    placeholder="Je naam"
                                    color="neutral"
                                    variant="outline"
                                    class="w-full"
                                    :ui="inputUi"
                                />
                            </UFormField>
                        </div>

                        <ProductenHaakHartImageTile
                            :image="props.product.image"
                            :alt="props.product.title"
                            class="h-72 w-full"
                        >
                            <UButton
                                icon="i-lucide-x"
                                color="neutral"
                                variant="ghost"
                                aria-label="Sluiten"
                                class="absolute top-5 right-5 h-9 w-9 justify-center rounded-full bg-primary-pink p-0 text-white transition-all duration-200 hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink"
                                @click="modalOpen = false"
                            />
                        </ProductenHaakHartImageTile>

                        <div class="col-span-2 space-y-4">
                            <UFormField
                                label="Postcode"
                                name="postcode"
                                required
                                size="sm"
                                :ui="fieldUi"
                            >
                                <UInput
                                    v-model="state.postcode"
                                    placeholder="1111 AA.."
                                    color="neutral"
                                    variant="outline"
                                    class="w-full"
                                    :ui="inputUi"
                                />
                            </UFormField>

                            <UFormField
                                label="Huisnummer"
                                name="houseNumber"
                                required
                                size="sm"
                                :ui="fieldUi"
                            >
                                <UInput
                                    v-model="state.houseNumber"
                                    placeholder="11"
                                    color="neutral"
                                    variant="outline"
                                    class="w-full"
                                    :ui="inputUi"
                                />
                            </UFormField>

                            <UFormField
                                label="Telefoonnummer"
                                name="phone"
                                required
                                size="sm"
                                :ui="fieldUi"
                            >
                                <UInput
                                    v-model="state.phone"
                                    type="tel"
                                    placeholder="062993456"
                                    color="neutral"
                                    variant="outline"
                                    class="w-full"
                                    :ui="inputUi"
                                />
                            </UFormField>
                        </div>
                    </div>

                    <div class="flex justify-center pt-1">
                        <UButton
                            type="submit"
                            label="Bestellen"
                            size="lg"
                            color="neutral"
                            variant="ghost"
                            class="rounded-xl bg-primary-pink px-7 font-semibold text-white shadow-none transition-all duration-200 hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink"
                        />
                    </div>
                </UForm>
            </div>
        </template>
    </UModal>
</template>
