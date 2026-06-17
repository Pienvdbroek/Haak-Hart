<script setup>
import { computed, ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const page = usePage();
const menuOpen = ref(false);

// Gebruiker uit de Inertia auth props halen
const user = computed(() => page.props.auth.user);

const navigation = [
    {
        key: 'producten',
        label: 'Producten',
        icon: 'i-lucide-camera',
        href: '/home-producten',
    },
    {
        key: 'mijn-reserveringen',
        label: 'Mijn Reserveringen',
        icon: 'i-lucide-shopping-cart',
        href: '/mijn-reserveringen',
    },
    {
        key: 'producten-beheer',
        label: 'Producten Beheer',
        icon: 'i-lucide-package',
        href: '/admin-producten-beheer',
    },
    {
        key: 'admin-reserveringen',
        label: 'Alle Reserveringen',
        icon: 'i-lucide-calendar-check',
        href: '/admin-reserveringen',
    },
];

const currentPath = computed(() => {
    return (page.url || '').split('?')[0].replace(/\/$/, '') || '/';
});

function isActive(item) {
    return currentPath.value === item.href;
}

function logout() {
    router.post('/logout');
}
</script>

<template>
    <header class="sticky top-0 z-40 bg-magazijn-purple text-magazijn-white">
        <div class="flex h-[80px] items-center px-4 sm:px-8">
            <UButton
                to="/home-producten"
                variant="unstyled"
                class="flex min-w-0 shrink-0 items-center gap-4 rounded-none p-0 sm:gap-5 lg:w-auto"
            >
                <div
                    class="grid size-12 shrink-0 place-items-center rounded-full bg-magazijn-white text-magazijn-purple"
                >
                    <span class="text-[16px] font-extrabold tracking-[-0.18em]"
                        >MM</span
                    >
                </div>
                <div
                    class="text-[26px] font-bold tracking-[0.08em] text-magazijn-white"
                >
                    SUMMA
                </div>
            </UButton>

            <nav class="ml-20 hidden h-full items-center gap-6 lg:flex">
                <UButton
                    v-for="item in navigation"
                    :key="item.key"
                    :to="item.href"
                    :icon="item.icon"
                    variant="unstyled"
                    size="md"
                    :class="[
                        'h-full rounded-none px-2 text-[16px] font-semibold tracking-wide hover:text-white',
                        isActive(item)
                            ? 'text-magazijn-white'
                            : 'text-magazijn-blue-gray',
                    ]"
                >
                    <span class="whitespace-nowrap">{{ item.label }}</span>
                </UButton>
            </nav>

            <div class="ml-auto hidden items-center gap-8 text-right lg:flex">
                <div>
                    <div
                        class="text-[17px] leading-5 font-bold tracking-wide text-magazijn-white"
                    >
                        {{ user.name }}
                    </div>
                    <div
                        class="mt-[2px] text-[14px] font-semibold text-magazijn-blue-gray"
                    >
                        {{ user.email }}
                    </div>
                </div>
                <UButton
                    icon="i-lucide-log-out"
                    variant="ghost"
                    size="xl"
                    aria-label="Uitloggen"
                    class="text-magazijn-blue-gray hover:bg-magazijn-blue-gray/15 hover:text-magazijn-white"
                    @click="logout"
                />
            </div>

            <UButton
                :icon="menuOpen ? 'i-lucide-x' : 'i-lucide-menu'"
                variant="ghost"
                size="xl"
                aria-label="Menu openen"
                class="ml-auto text-magazijn-white hover:bg-magazijn-blue-gray/15 lg:hidden"
                @click="menuOpen = !menuOpen"
            />
        </div>

        <div
            v-if="menuOpen"
            class="border-t border-magazijn-blue-gray/40 bg-magazijn-purple lg:hidden"
        >
            <nav class="flex flex-col gap-1 px-6 py-4">
                <UButton
                    v-for="item in navigation"
                    :key="item.key"
                    :to="item.href"
                    :icon="item.icon"
                    variant="ghost"
                    size="xl"
                    :class="[
                        'h-[48px] justify-start rounded-none px-2 text-[17px] font-semibold tracking-wide hover:bg-magazijn-blue-gray/15',
                        isActive(item)
                            ? 'text-magazijn-white'
                            : 'text-magazijn-blue-gray',
                    ]"
                    @click="menuOpen = false"
                >
                    <span>{{ item.label }}</span>
                </UButton>
                <UButton
                    icon="i-lucide-log-out"
                    variant="ghost"
                    size="xl"
                    class="h-[48px] justify-start rounded-none px-2 text-[17px] font-semibold tracking-wide text-magazijn-blue-gray hover:bg-magazijn-blue-gray/15 hover:text-magazijn-white"
                    @click="logout"
                >
                    <span>Uitloggen</span>
                </UButton>
            </nav>
            <div class="border-t border-magazijn-blue-gray/40 px-7 py-4">
                <div
                    class="text-[17px] leading-5 font-bold tracking-wide text-magazijn-white"
                >
                    {{ user.name }}
                </div>
                <div
                    class="mt-[2px] text-[14px] font-semibold text-magazijn-blue-gray"
                >
                    {{ user.email }}
                </div>
            </div>
        </div>
    </header>
</template>
