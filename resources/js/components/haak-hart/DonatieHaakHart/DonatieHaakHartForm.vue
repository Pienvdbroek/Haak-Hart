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
    label: 'text-xs text-primarytext dark:text-primarytext sm:text-sm',
};

const inputUi = {
    base: 'h-7 rounded-md bg-white text-xs text-primarytext ring-1 ring-borderstrokeline placeholder:text-secondarytext focus-visible:ring-2 focus-visible:ring-primary-pink dark:bg-white dark:text-primarytext dark:ring-borderstrokeline dark:placeholder:text-secondarytext sm:h-8 sm:text-sm',
};

const textareaUi = {
    base: 'min-h-24 rounded-md bg-white text-xs text-primarytext ring-1 ring-borderstrokeline placeholder:text-secondarytext focus-visible:ring-2 focus-visible:ring-primary-pink dark:bg-white dark:text-primarytext dark:ring-borderstrokeline dark:placeholder:text-secondarytext sm:min-h-28 sm:text-sm',
};

function onSubmit() {
    console.log({ ...state });
}
</script>

<template>
    <DonatieHaakHartDonationBox>
        <UForm :state="state" class="space-y-3 sm:space-y-4" @submit="onSubmit">
            <h1 class="font-timesnewroman text-2xl font-bold text-primarytext sm:text-3xl">
                Stuur ons een bericht
            </h1>

            <div class="grid grid-cols-2 gap-3 sm:gap-4">
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

            <UFormField label="Postcode" name="postcode" required :ui="fieldUi">
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
                color="neutral"
                variant="ghost"
                class="mt-4 w-full justify-center rounded-xl bg-primary-pink py-2 text-sm font-semibold text-white transition-all duration-200 hover:bg-primaryhover-pink hover:text-white active:bg-primary-pink sm:mt-5 sm:py-3"
            />
        </UForm>
    </DonatieHaakHartDonationBox>
</template>
