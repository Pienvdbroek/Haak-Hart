<script setup lang="ts">
import HaakHartLayout from '@/layouts/haak-hart/HaakHartLayout.vue';

defineOptions({
    layout: HaakHartLayout,
});

const page = {
    title: 'Donatie',
    description: 'Steun Haak-Hart met een donatie.',
};

const donationOptions = [
    {
        amount: '€5',
        title: 'Kleine steun',
        description: 'Een kleine bijdrage die al helpt.',
    },
    {
        amount: '€10',
        title: 'Mooie bijdrage',
        description: 'Een fijne donatie om Haak-Hart verder te helpen.',
    },
    {
        amount: '€25',
        title: 'Grote steun',
        description: 'Een sterke bijdrage voor meer impact.',
    },
];
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

        <section class="mt-[clamp(34px,7vw,48px)]">
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
                        <UIcon
                            name="i-lucide-heart-handshake"
                            class="size-7"
                        />
                    </div>

                    <h1
                        class="text-[clamp(30px,5vw,42px)] font-extrabold leading-tight tracking-[-0.04em] text-black"
                    >
                        Help Haak-Hart verder groeien.
                    </h1>

                    <p
                        class="mt-5 max-w-[760px] text-[18px] leading-8 text-magazijn-gray"
                    >
                        Hier kun je later een echte donatieknop, QR-code,
                        betaalprovider of uitleg plaatsen. Voor nu staat de
                        pagina klaar als werkende Haak-Hart donatiepagina.
                    </p>
                </div>
            </UCard>

            <div
                class="mt-8 grid grid-cols-[repeat(auto-fit,minmax(min(100%,260px),1fr))] gap-6"
            >
                <UCard
                    v-for="option in donationOptions"
                    :key="option.amount"
                    class="bg-magazijn-white"
                    :ui="{
                        root: 'rounded-[18px] ring-1 ring-magazijn-purple-soft shadow-sm transition hover:-translate-y-[2px] hover:shadow-md',
                        body: 'p-0 sm:p-0',
                    }"
                >
                    <div class="p-6">
                        <div
                            class="grid size-14 place-items-center rounded-full bg-magazijn-purple text-[20px] font-extrabold text-magazijn-white"
                        >
                            {{ option.amount }}
                        </div>

                        <h2 class="mt-5 text-2xl font-bold text-black">
                            {{ option.title }}
                        </h2>

                        <p class="mt-3 text-[16px] leading-7 text-magazijn-gray">
                            {{ option.description }}
                        </p>

                        <UButton
                            icon="i-lucide-heart"
                            size="xl"
                            block
                            class="mt-6 h-[48px] rounded-[10px] bg-magazijn-purple text-[17px] font-bold text-magazijn-white hover:bg-magazijn-purple"
                        >
                            Kies {{ option.amount }}
                        </UButton>
                    </div>
                </UCard>
            </div>
        </section>
    </UContainer>
</template>
