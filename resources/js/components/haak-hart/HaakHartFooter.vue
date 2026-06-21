<script setup lang="ts">
type NavigationItem = {
    key: string;
    label: string;
    href: string;
};

const navigation: NavigationItem[] = [
    { key: 'home-haak-hart', label: 'Home', href: '/home-haak-hart' },
    {
        key: 'producten-haak-hart',
        label: 'Producten',
        href: '/producten-haak-hart',
    },
    { key: 'donatie-haak-hart', label: 'Doneren', href: '/donatie-haak-hart' },
    { key: 'contact-haak-hart', label: 'Contact', href: '/contact-haak-hart' },
];
</script>

<template>
    <footer class="border-t border-borderstrokeline bg-backgroundfooter-pink">
        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-12 px-8 py-12 md:grid-cols-3"
        >
            <div class="mr-0 md:mr-10">
                <div class="flex items-center gap-4">
                    <img
                        src="/images/LogoHaakHart.svg"
                        alt="Haak & Hart"
                        class="h-14 w-14"
                    />
                    <div>
                        <h1
                            class="font-timesnewroman text-2xl font-semibold text-primarytext"
                        >
                            Haak & Hart
                        </h1>
                        <p class="text-sm text-secondarytext">
                            Met liefde gehaakt
                        </p>
                    </div>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-secondarytext">
                    Met liefde gehaakt voor mensen in nood. Samen maken we de
                    wereld warmer, steek voor steek.
                </p>
            </div>

            <div>
                <h3
                    class="font-timesnewroman mb-4 text-xl font-semibold text-primarytext"
                >
                    Snelle links
                </h3>

                <ul class="space-y-2 text-sm">
                    <li v-for="item in navigation" :key="item.key">
                        <ULink
                            :to="item.href"
                            class="text-secondarytext transition hover:text-primary-pink"
                        >
                            {{ item.label }}
                        </ULink>
                    </li>
                </ul>
            </div>

            <div>
                <h3
                    class="font-timesnewroman mb-4 text-xl font-semibold text-primarytext"
                >
                    Contact
                </h3>

                <div class="space-y-2 text-sm text-secondarytext">
                    <p>Haak & Hart</p>
                    <p>Warmtestraat 12</p>
                    <p>1234 AB Eindhoven</p>
                    <p>
                        <a
                            href="mailto:info@haakenhart.nl"
                            class="hover:text-primary-pink"
                        >
                            info@haakenhart.nl
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="mx-6 border-t border-borderstrokeline py-6">
            <div
                class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-8 text-center text-xs text-secondarytext md:flex-row"
            >
                <p>© 2026 Haak & Hart. Alle rechten voorbehouden.</p>
                <p>Gemaakt met ❤️ en garen</p>
            </div>
        </div>
    </footer>
</template>
