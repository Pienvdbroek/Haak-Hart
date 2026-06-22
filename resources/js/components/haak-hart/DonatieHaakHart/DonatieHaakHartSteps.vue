<script setup lang="ts">
const steps = [
    {
        number: '1',
        title: 'Aanmelden of vul het donatie papier',
        description: 'Beschrijf wat u gaat doneren.',
    },
    {
        number: '2',
        title: 'Wacht op confirmatie',
        description: 'U zult een mail krijgen.',
    },
    {
        number: '3',
        title: 'Pak uw donatie in',
        description: 'Bijvoorbeeld in een kartonnen doos.',
    },
    {
        number: '4',
        title: 'Stuur uw donatie op',
        description: 'Kijk bij contacten voor adresgegevens.',
    },
    {
        number: '5',
        title: 'Terugkoppeling donatie',
        description: 'E-mail over succesvolle donatie.',
    },
];
</script>

<template>
    <section class="mx-auto w-full max-w-xl">
        <h2 class="font-timesnewroman text-4xl font-bold text-primarytext">
            Hoe werkt de Donatie?
        </h2>

        <UPageGrid class="mt-8 gap-5 sm:grid-cols-1 lg:grid-cols-1">
            <UPageCard
                v-for="step in steps"
                :key="step.number"
                variant="naked"
                class="rounded-2xl"
            >
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-menuhover-pink text-xl font-semibold text-primary-pink"
                    >
                        {{ step.number }}
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-primarytext">
                            {{ step.title }}
                        </h3>

                        <p class="text-sm text-secondarytext">
                            {{ step.description }}
                        </p>
                    </div>
                </div>
            </UPageCard>
        </UPageGrid>
    </section>
</template>
