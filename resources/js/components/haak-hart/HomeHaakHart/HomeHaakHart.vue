<script setup lang="ts">
import { Hand, Shirt } from 'lucide-vue-next';

import HaakHartLayout from '@/layouts/haak-hart/HaakHartLayout.vue';

defineOptions({
    layout: HaakHartLayout,
});

const examples = [
    {
        title: 'Sjaals',
        image: '/images/sjaal.png',
    },
    {
        title: 'Mutsen',
        image: '/images/muts.png',
    },
    {
        title: 'Handschoenen',
        image: '/images/handschoen.png',
    },
    {
        title: 'Sokken',
        image: '/images/sokken.png',
    },
];

const accepted = [
    {
        title: 'Truien',
        icon: Shirt,
    },
    {
        title: 'Sjaals',
        icon: Shirt,
    },
    {
        title: 'Mutsen',
        icon: Shirt,
    },
    {
        title: 'Sokken',
        icon: Shirt,
    },
    {
        title: 'Handschoenen',
        icon: Hand,
    },
];
</script>

<template>
    <div class="mx-auto max-w-7xl pt-10">
        <div class="px-8 py-10">
            <section class="grid items-center gap-10 md:grid-cols-2">
                <div>
                    <span
                        class="text-sm font-semibold tracking-widest text-primary-pink uppercase"
                    >
                        Warmte voor iedereen
                    </span>

                    <h1
                        class="font-timesnewroman mt-2 text-4xl leading-tight font-bold text-primarytext sm:text-5xl md:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl"
                    >
                        Met liefde
                        <span class="text-primary-pink italic"> gehaakt </span>
                        <br />
                        voor mensen
                        <span class="text-primary-pink">in nood</span>
                    </h1>

                    <p class="mt-6 max-w-lg text-secondarytext">
                        Haak & Hart is een haakclub die met eigen productie en
                        donaties warmte brengt aan mensen die het nodig hebben.
                        Van truien tot sjaals, van mutsen tot sokken.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <ULink
                            to="/donatie-haak-hart"
                            class="flex items-center gap-2 rounded-md bg-primary-pink px-10 py-2 text-lg font-semibold text-white shadow-md hover:bg-primaryhover-pink"
                        >
                            <UIcon name="i-lucide-heart" class="h-5 w-5" />
                            <span>Doneer nu</span>
                        </ULink>

                        <ULink
                            to="/producten-haak-hart"
                            class="flex items-center gap-2 rounded-md border-2 border-borderstrokeline bg-backgroundfooter-pink px-10 py-2 text-lg font-semibold text-primarytext shadow-md hover:bg-menuhover-pink hover:text-primarytext"
                        >
                            <span>Bekijk producten</span>
                        </ULink>
                    </div>
                </div>

                <div class="flex justify-end">
                    <img
                        src="/images/homeimg.png"
                        alt=""
                        class="w-full rounded-xl object-cover shadow-lg lg:max-w-lg"
                    />
                </div>
            </section>

            <section class="mt-40 text-center">
                <p
                    class="text-sm font-semibold tracking-widest text-primary-pink uppercase"
                >
                    Onze creaties
                </p>

                <h2
                    class="font-timesnewroman mt-3 text-5xl font-bold text-primarytext"
                >
                    Haak voorbeelden
                </h2>

                <p class="mt-4 text-neutral-500">
                    Elk item is met zorg en liefde met de hand gehaakt. Bekijk
                    onze collectie en laat je inspireren.
                </p>

                <div
                    class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="item in examples"
                        :key="item.title"
                        class="group"
                    >
                        <img
                            :src="item.image"
                            :alt="item.title"
                            class="h-90 w-full rounded-xl object-cover shadow-md transition duration-300 group-hover:scale-105"
                        />

                        <h3
                            class="font-timesnewroman mt-4 text-center text-lg font-semibold text-primarytext"
                        >
                            {{ item.title }}
                        </h3>
                    </div>
                </div>
            </section>

            <section class="mt-28 text-center">
                <h2
                    class="font-timesnewroman text-5xl font-bold text-primarytext"
                >
                    Wat accepteren wij?
                </h2>

                <p class="mt-4 text-secondarytext">
                    We nemen de volgende handgemaakte items aan, nieuw of in
                    goede staat.
                </p>

                <div class="mt-10 flex flex-wrap justify-center gap-6">
                    <div
                        v-for="item in accepted"
                        :key="item.title"
                        class="flex h-38 w-32 flex-col items-center justify-center rounded-2xl border-2 border-borderstrokeline"
                    >
                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-menuhover-pink"
                        >
                            <component
                                :is="item.icon"
                                class="h-6 w-6 text-primary-pink"
                            />
                        </div>

                        <span
                            class="font-timesnewroman text-center text-lg font-medium text-primarytext"
                        >
                            {{ item.title }}
                        </span>
                    </div>
                </div>
            </section>
        </div>

        
    </div>
    <section class="mt-24 bg-backgroundsecondary-pink py-20">
            <div class="mx-auto grid max-w-7xl gap-12 px-6 lg:grid-cols-2">
                <img
                    src="/images/oma.png"
                    alt=""
                    class="h-auto w-full rounded-xl object-cover shadow-lg sm:h-160 lg:aspect-square lg:h-auto"
                />

                <div>
                    <span
                        class="text-sm font-semibold tracking-widest text-primary-pink uppercase"
                    >
                        Samen sterk
                    </span>

                    <h2
                        class="font-timesnewroman mt-3 text-4xl leading-tight font-bold"
                    >
                        Doneer warmte aan
                        <span class="text-primary-pink italic">
                            mensen in nood
                        </span>
                    </h2>

                    <p class="mt-4 text-secondarytext">
                        Help gehaakte kledingstukken verzamelen voor mensen die
                        warmte nodig hebben.
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div
                            class="rounded-xl border-2 border-borderstrokeline bg-white p-5"
                        >
                            <UIcon
                                name="i-lucide-heart"
                                class="h-5 w-5 text-primary-pink"
                            />
                            <p
                                class="font-timesnewroman mt-2 text-2xl font-bold text-primarytext"
                            >
                                500+
                            </p>
                            <p class="text-sm text-secondarytext">
                                Donaties ontvangen
                            </p>
                        </div>

                        <div
                            class="rounded-xl border-2 border-borderstrokeline bg-white p-5"
                        >
                            <UIcon
                                name="i-lucide-heart"
                                class="h-5 w-5 text-primary-pink"
                            />
                            <p
                                class="font-timesnewroman mt-2 text-2xl font-bold text-primarytext"
                            >
                                50+
                            </p>
                            <p class="text-sm text-secondarytext">
                                Vrijwilligers
                            </p>
                        </div>

                        <div
                            class="rounded-xl border-2 border-borderstrokeline bg-white p-5"
                        >
                            <UIcon
                                name="i-lucide-heart"
                                class="h-5 w-5 text-primary-pink"
                            />
                            <p
                                class="font-timesnewroman mt-2 text-2xl font-bold text-primarytext"
                            >
                                1200+
                            </p>
                            <p class="text-sm text-secondarytext">
                                Items uitgedeeld
                            </p>
                        </div>

                        <div
                            class="rounded-xl border-2 border-borderstrokeline bg-white p-5"
                        >
                            <UIcon
                                name="i-lucide-heart"
                                class="h-5 w-5 text-primary-pink"
                            />
                            <p
                                class="font-timesnewroman mt-2 text-2xl font-bold text-primarytext"
                            >
                                800+
                            </p>
                            <p class="text-sm text-secondarytext">
                                Mensen geholpen
                            </p>
                        </div>
                    </div>

                    <ULink
                        to="/donatie-haak-hart"
                        class="mt-8 flex w-50 items-center gap-2 rounded-md bg-primary-pink px-10 py-2 text-lg font-semibold text-white shadow-md hover:bg-primaryhover-pink"
                    >
                        <UIcon name="i-lucide-heart" class="h-5 w-5" />
                        <span>Doneer nu</span>
                    </ULink>
                </div>
            </div>
        </section>
</template>
