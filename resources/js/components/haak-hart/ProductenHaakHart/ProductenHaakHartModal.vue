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
    content: 'w-[min(94vw,520px)] max-w-none bg-transparent p-0 shadow-none ring-0',
};

const fieldUi = {
    label: 'mb-2 block font-medium text-primarytext dark:text-primarytext',
};

const inputUi = {
    base: 'h-12 rounded-md bg-white px-4 py-3 text-base text-primarytext ring-1 ring-borderstrokeline placeholder:text-secondarytext outline-none transition focus-visible:ring-2 focus-visible:ring-primary-pink dark:bg-white dark:text-primarytext dark:ring-borderstrokeline dark:placeholder:text-secondarytext',
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
                class="relative rounded-2xl border border-borderstrokeline bg-white p-8 shadow-xl"
            >
                <UButton
                    icon="i-lucide-x"
                    color="neutral"
                    variant="ghost"
                    aria-label="Sluiten"
                    class="absolute top-5 right-5 z-10 h-9 w-9 justify-center rounded-full bg-primary-pink p-0 text-white transition-all duration-200 hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink"
                    @click="modalOpen = false"
                />

                <UForm :state="state" class="space-y-5" @submit="onSubmit">
                    <div class="grid gap-5 sm:grid-cols-[1fr_150px]">
                        <div class="space-y-5">
                            <section>
                                <p
                                    class="text-sm font-semibold tracking-widest text-primary-pink uppercase"
                                >
                                    Bestel product
                                </p>

                                <h3
                                    class="font-timesnewroman mt-3 text-3xl font-bold text-primarytext"
                                >
                                    {{ props.product.title }}
                                </h3>

                                <p class="mt-4 text-secondarytext">
                                    {{ props.product.price }}
                                </p>
                            </section>

                            <UFormField
                                label="E-mail"
                                name="email"
                                required
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
                            class=" w-full rounded-2xl shadow-md"
                        />
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <UFormField
                            label="Postcode"
                            name="postcode"
                            required
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
                    </div>

                    <UFormField
                        label="Telefoonnummer"
                        name="phone"
                        required
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

                    <UButton
                        type="submit"
                        label="Bestellen"
                        icon="i-lucide-shopping-cart"
                        color="neutral"
                        variant="ghost"
                        class="mt-1 w-full justify-center gap-2 rounded-md bg-primary-pink px-6 py-3 font-semibold text-white shadow-md transition-all duration-200 hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink"
                    />
                </UForm>
            </div>
        </template>
    </UModal>
</template>
