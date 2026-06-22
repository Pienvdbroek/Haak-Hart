<script setup lang="ts">
import { reactive } from 'vue';

import DonatieHaakHartDonationBox from '@/components/haak-hart/DonatieHaakHart/DonatieHaakHartDonationBox.vue';

type DonationForm = {
    name: string;
    email: string;
    postcode: string;
    houseNumber: string;
    phone: string;
    donation: string;
};

const state = reactive<DonationForm>({
    name: '',
    email: '',
    postcode: '',
    houseNumber: '',
    phone: '',
    donation: '',
});

const fieldUi = {
    label: 'mb-2 block font-medium text-primarytext dark:text-primarytext',
};

const inputUi = {
    base: 'h-12 rounded-md bg-white px-4 py-3 text-base text-primarytext ring-1 ring-borderstrokeline placeholder:text-secondarytext outline-none transition focus-visible:ring-2 focus-visible:ring-primary-pink dark:bg-white dark:text-primarytext dark:ring-borderstrokeline dark:placeholder:text-secondarytext',
};

const textareaUi = {
    base: 'min-h-36 rounded-md bg-white px-4 py-3 text-base text-primarytext ring-1 ring-borderstrokeline placeholder:text-secondarytext outline-none transition focus-visible:ring-2 focus-visible:ring-primary-pink dark:bg-white dark:text-primarytext dark:ring-borderstrokeline dark:placeholder:text-secondarytext',
};

function onSubmit() {
    console.log({ ...state });
}
</script>

<template>
    <DonatieHaakHartDonationBox>
        <UForm :state="state" class="space-y-5" @submit="onSubmit">
            <h1
                class="font-timesnewroman mb-8 text-3xl font-bold text-primarytext"
            >
                Stuur ons een bericht
            </h1>

            <div class="grid gap-4 md:grid-cols-2">
                <UFormField label="Naam" name="name" required :ui="fieldUi">
                    <UInput
                        v-model="state.name"
                        placeholder="Je naam"
                        color="neutral"
                        variant="outline"
                        class="w-full"
                        :ui="inputUi"
                    />
                </UFormField>

                <UFormField label="E-mail" name="email" required :ui="fieldUi">
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

            <UFormField label="Donatie" name="donation" :ui="fieldUi">
                <UTextarea
                    v-model="state.donation"
                    placeholder="Wat gaat u doneren..."
                    color="neutral"
                    variant="outline"
                    class="w-full"
                    :ui="textareaUi"
                />
            </UFormField>

            <UButton
                type="submit"
                label="Verstuur bericht"
                icon="i-lucide-send"
                color="neutral"
                variant="ghost"
                class="mt-1 w-full justify-center gap-2 rounded-md bg-primary-pink px-6 py-3 font-semibold text-white shadow-md transition-all duration-200 hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink"
            />
        </UForm>
    </DonatieHaakHartDonationBox>
</template>
