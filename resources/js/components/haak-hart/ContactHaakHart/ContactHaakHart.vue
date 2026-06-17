<script setup lang="ts">
import { ref } from 'vue';
import HaakHartLayout from '@/layouts/haak-hart/HaakHartLayout.vue';

defineOptions({
    layout: HaakHartLayout,
});

const page = {
    title: 'Contact',
    description: 'Neem contact op met Haak-Hart.',
};

const name = ref('');
const email = ref('');
const message = ref('');

function submitContact() {
    alert('Contactformulier is nog demo. Backend kan later gekoppeld worden.');
}
</script>

<template>
    <UContainer class="px-3 pb-14 pt-[clamp(28px,6vw,61px)] sm:px-5">
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
            class="mt-[clamp(34px,7vw,48px)] grid gap-6 lg:grid-cols-[0.9fr_1.1fr]"
        >
            <UCard
                class="bg-magazijn-white"
                :ui="{
                    root: 'rounded-[18px] ring-1 ring-magazijn-purple-soft shadow-sm',
                    body: 'p-0 sm:p-0',
                }"
            >
                <div class="p-[clamp(24px,4vw,34px)]">
                    <div
                        class="mb-6 grid size-14 place-items-center rounded-full bg-magazijn-purple text-magazijn-white"
                    >
                        <UIcon name="i-lucide-mail" class="size-7" />
                    </div>

                    <h1 class="text-3xl font-extrabold text-black">
                        Contactgegevens
                    </h1>

                    <div class="mt-7 space-y-5">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-wide text-magazijn-gray">
                                Email
                            </p>

                            <p class="mt-1 text-[17px] font-semibold text-black">
                                info@haak-hart.nl
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-bold uppercase tracking-wide text-magazijn-gray">
                                Locatie
                            </p>

                            <p class="mt-1 text-[17px] font-semibold text-black">
                                Nederland
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-bold uppercase tracking-wide text-magazijn-gray">
                                Pagina's
                            </p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <UButton
                                    to="/home-haak-hart"
                                    variant="ghost"
                                    class="rounded-[10px] bg-magazijn-purple-soft text-magazijn-purple hover:bg-magazijn-purple/10"
                                >
                                    Home
                                </UButton>

                                <UButton
                                    to="/producten-haak-hart"
                                    variant="ghost"
                                    class="rounded-[10px] bg-magazijn-purple-soft text-magazijn-purple hover:bg-magazijn-purple/10"
                                >
                                    Producten
                                </UButton>

                                <UButton
                                    to="/donatie-haak-hart"
                                    variant="ghost"
                                    class="rounded-[10px] bg-magazijn-purple-soft text-magazijn-purple hover:bg-magazijn-purple/10"
                                >
                                    Donatie
                                </UButton>
                            </div>
                        </div>
                    </div>
                </div>
            </UCard>

            <UCard
                class="bg-magazijn-white"
                :ui="{
                    root: 'rounded-[18px] ring-1 ring-magazijn-purple-soft shadow-sm',
                    body: 'p-0 sm:p-0',
                }"
            >
                <form
                    class="space-y-6 p-[clamp(24px,4vw,34px)]"
                    @submit.prevent="submitContact"
                >
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-black">
                            Naam
                        </label>

                        <UInput
                            v-model="name"
                            placeholder="Vul je naam in"
                            size="xl"
                            class="w-full"
                            :ui="{
                                base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-blue-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                            }"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-black">
                            Email
                        </label>

                        <UInput
                            v-model="email"
                            type="email"
                            placeholder="Vul je email in"
                            size="xl"
                            class="w-full"
                            :ui="{
                                base: 'h-[46px] rounded-[10px] bg-white text-black ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-blue-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                            }"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-black">
                            Bericht
                        </label>

                        <UTextarea
                            v-model="message"
                            placeholder="Typ je bericht..."
                            autoresize
                            :rows="6"
                            class="w-full"
                            :ui="{
                                base: 'min-h-[150px] resize-none rounded-[10px] bg-white px-[15px] py-[13px] text-[15px] text-black ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-blue-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                            }"
                        />
                    </div>

                    <UButton
                        type="submit"
                        icon="i-lucide-send"
                        size="xl"
                        block
                        class="h-[52px] rounded-[10px] bg-magazijn-purple text-[18px] font-bold text-magazijn-white hover:bg-magazijn-purple"
                    >
                        Versturen
                    </UButton>
                </form>
            </UCard>
        </section>
    </UContainer>
</template>
