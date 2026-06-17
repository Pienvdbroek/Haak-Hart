<script setup lang="ts">
import HaakHartLayout from '@/layouts/haak-hart/HaakHartLayout.vue';

defineOptions({
    layout: HaakHartLayout,
});

const page = {
    title: 'Haak-Hart',
    description: 'Welkom op de Haak-Hart homepagina.',
};
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
            class="mt-[clamp(34px,7vw,48px)] grid gap-6 lg:grid-cols-[1.2fr_0.8fr]"
        >
            <UCard
                class="bg-magazijn-white"
                :ui="{
                    root: 'rounded-[18px] ring-1 ring-magazijn-purple-soft shadow-sm',
                    body: 'p-0 sm:p-0',
                }"
            >
                <div class="p-[clamp(24px,4vw,38px)]">
                    <div
                        class="mb-6 grid size-14 place-items-center rounded-full bg-magazijn-purple text-magazijn-white"
                    >
                        <UIcon name="i-lucide-heart" class="size-7" />
                    </div>

                    <h1
                        class="text-[clamp(30px,5vw,46px)] font-extrabold leading-tight tracking-[-0.04em] text-black"
                    >
                        Samen maken we verschil met Haak-Hart.
                    </h1>

                    <p
                        class="mt-5 max-w-[760px] text-[18px] leading-8 text-magazijn-gray"
                    >
                        Dit is de centrale plek voor informatie, producten,
                        donaties en contact rondom Haak-Hart.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <UButton
                            to="/producten-haak-hart"
                            icon="i-lucide-camera"
                            size="xl"
                            class="h-[48px] rounded-[10px] bg-magazijn-purple px-6 text-[17px] font-bold text-magazijn-white hover:bg-magazijn-purple"
                        >
                            Producten bekijken
                        </UButton>

                        <UButton
                            to="/donatie-haak-hart"
                            icon="i-lucide-heart-handshake"
                            size="xl"
                            variant="ghost"
                            class="h-[48px] rounded-[10px] bg-magazijn-white px-6 text-[17px] font-bold text-magazijn-purple ring-1 ring-magazijn-purple-soft hover:bg-magazijn-purple/10"
                        >
                            Doneren
                        </UButton>
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
                <div class="p-[clamp(24px,4vw,34px)]">
                    <h2 class="text-2xl font-bold text-black">
                        Snel naar
                    </h2>

                    <div class="mt-6 space-y-3">
                        <UButton
                            to="/home-haak-hart"
                            icon="i-lucide-home"
                            block
                            variant="ghost"
                            class="h-[54px] justify-start rounded-[12px] bg-magazijn-purple-soft px-4 text-[16px] font-bold text-magazijn-purple hover:bg-magazijn-purple/10"
                        >
                            Home
                        </UButton>

                        <UButton
                            to="/producten-haak-hart"
                            icon="i-lucide-camera"
                            block
                            variant="ghost"
                            class="h-[54px] justify-start rounded-[12px] bg-magazijn-purple-soft px-4 text-[16px] font-bold text-magazijn-purple hover:bg-magazijn-purple/10"
                        >
                            Producten
                        </UButton>

                        <UButton
                            to="/donatie-haak-hart"
                            icon="i-lucide-heart-handshake"
                            block
                            variant="ghost"
                            class="h-[54px] justify-start rounded-[12px] bg-magazijn-purple-soft px-4 text-[16px] font-bold text-magazijn-purple hover:bg-magazijn-purple/10"
                        >
                            Donatie
                        </UButton>

                        <UButton
                            to="/contact-haak-hart"
                            icon="i-lucide-mail"
                            block
                            variant="ghost"
                            class="h-[54px] justify-start rounded-[12px] bg-magazijn-purple-soft px-4 text-[16px] font-bold text-magazijn-purple hover:bg-magazijn-purple/10"
                        >
                            Contact
                        </UButton>
                    </div>
                </div>
            </UCard>
        </section>
    </UContainer>
</template>
