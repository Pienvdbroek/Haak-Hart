<script setup lang="ts">
import HaakHartLayout from '@/layouts/haak-hart/HaakHartLayout.vue';

defineOptions({
    layout: HaakHartLayout,
});
</script>

<template>
    <div class="mx-auto max-w-7xl py-16">
        <section class="text-center">
            <p
                class="text-sm font-semibold tracking-widest text-primary-pink uppercase"
            >
                Neem contact op
            </p>

            <h1
                class="font-timesnewroman mt-3 text-5xl font-bold text-primarytext"
            >
                Contact
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-secondarytext">
                Heb je vragen, wil je meedoen als vrijwilliger, of wil je iets
                doneren? Neem gerust contact met ons op!
            </p>
        </section>

        <section class="mt-16 grid gap-12 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <h2
                    class="font-timesnewroman mb-8 text-3xl font-bold text-primarytext"
                >
                    Onze gegevens
                </h2>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-1">
                    <div class="flex gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-menuhover-pink"
                        >
                            <UIcon
                                name="i-lucide-map-pin"
                                class="h-5 w-5 text-primary-pink"
                            />
                        </div>

                        <div>
                            <h3 class="font-semibold text-primarytext">
                                Opstuuradres
                            </h3>

                            <p class="text-sm text-secondarytext">
                                Haak & Hart
                                <br />
                                Warmtestraat 12
                                <br />
                                1234 AB Amsterdam
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-menuhover-pink"
                        >
                            <UIcon
                                name="i-lucide-mail"
                                class="h-5 w-5 text-primary-pink"
                            />
                        </div>

                        <div>
                            <h3 class="font-semibold text-primarytext">
                                E-mail
                            </h3>

                            <a
                                href="mailto:info@haakenhart.nl"
                                class="text-sm text-primary-pink underline"
                            >
                                info@haakenhart.nl
                            </a>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-menuhover-pink"
                        >
                            <UIcon
                                name="i-lucide-phone"
                                class="h-5 w-5 text-primary-pink"
                            />
                        </div>

                        <div>
                            <h3 class="font-semibold text-primarytext">
                                Telefoon
                            </h3>

                            <p class="text-sm text-secondarytext">
                                020 - 123 4567
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-2xl bg-backgroundfooter-pink p-6">
                    <div class="flex items-center gap-3">
                        <UIcon
                            name="i-lucide-clock-3"
                            class="h-5 w-5 text-primary-pink"
                        />

                        <h3
                            class="font-timesnewroman text-xl font-semibold text-primarytext"
                        >
                            Openingstijden
                        </h3>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-secondarytext">
                        <p>Maandag - vrijdag: 9:00 - 17:00</p>
                        <p>Zaterdag: 10:00 - 14:00</p>
                        <p>Zondag: Gesloten</p>
                    </div>
                </div>
            </div>

            <div
                class="rounded-2xl border border-borderstrokeline bg-white p-8 shadow-sm"
            >
                <h2
                    class="font-timesnewroman mb-8 text-3xl font-bold text-primarytext"
                >
                    Stuur ons een bericht
                </h2>

                <form class="space-y-5">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-2 block font-medium text-primarytext"
                            >
                                Naam *
                            </label>

                            <input
                                type="text"
                                placeholder="Je naam"
                                class="w-full rounded-md border border-borderstrokeline px-4 py-3 outline-none focus:border-primary-pink"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-2 block font-medium text-primarytext"
                            >
                                E-mail *
                            </label>

                            <input
                                type="email"
                                placeholder="Je@email.nl"
                                class="w-full rounded-md border border-borderstrokeline px-4 py-3 outline-none focus:border-primary-pink"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block font-medium text-primarytext">
                            Onderwerp
                        </label>

                        <input
                            type="text"
                            placeholder="Waar gaat je bericht over?"
                            class="w-full rounded-md border border-borderstrokeline px-4 py-3 outline-none focus:border-primary-pink"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block font-medium text-primarytext">
                            Bericht *
                        </label>

                        <textarea
                            rows="6"
                            placeholder="Schrijf je bericht hier..."
                            class="w-full rounded-md border border-borderstrokeline px-4 py-3 outline-none focus:border-primary-pink"
                        />
                    </div>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-md bg-primary-pink px-6 py-3 font-semibold text-white shadow-md transition hover:bg-primaryhover-pink"
                    >
                        <UIcon name="i-lucide-send" class="h-5 w-5" />
                        Verstuur bericht
                    </button>
                </form>
            </div>
        </section>
    </div>
</template>
