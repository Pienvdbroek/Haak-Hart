<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

type NavigationItem = {
    key: string;
    label: string;
    icon: string;
    href: string;
};

const page = usePage();
const mobileOpen = ref(false);

const isLoggedIn = computed(() => {
    return !!page.props.auth?.user;
});

const navigation: NavigationItem[] = [
    {
        key: 'home-haak-hart',
        label: 'Home',
        icon: 'i-lucide-home',
        href: '/home-haak-hart',
    },
    {
        key: 'producten-haak-hart',
        label: 'Producten',
        icon: 'i-lucide-camera',
        href: '/producten-haak-hart',
    },
    {
        key: 'donatie-haak-hart',
        label: 'Donatie',
        icon: 'i-lucide-heart-handshake',
        href: '/donatie-haak-hart',
    },
    {
        key: 'contact-haak-hart',
        label: 'Contact',
        icon: 'i-lucide-mail',
        href: '/contact-haak-hart',
    },
];

const currentPath = computed(() => {
    return (page.url || '').split('?')[0].replace(/\/$/, '') || '/';
});

function isActive(item: NavigationItem) {
    return currentPath.value === item.href;
}

function authAction() {
    mobileOpen.value = false;

    if (isLoggedIn.value) {
        router.post('/logout');

        return;
    }

    router.get('/login');
}
</script>

<template>
    <div class="font-calibri">
        <div
            class="h-2 bg-gradient-to-r from-[#D7425B] via-[#F3E1E7] to-[#D7425B]"
        ></div>

        <header class="relative border-b-1 border-borderstrokeline bg-white">
            <div class="mx-auto flex h-20 max-w-7xl items-center px-8">
                <ULink to="/home-haak-hart" class="flex items-center gap-4">
                    <img
                        src="/images/LogoHaakHart.svg"
                        alt="Haak & Hart"
                        class="h-16 w-16"
                    />

                    <div>
                        <h1 class="text-2xl font-semibold text-primarytext font-timesnewroman">
                            Haak & Hart
                        </h1>
                        <p class="text-sm text-secondarytext">
                            Met liefde gehaakt
                        </p>
                    </div>
                </ULink>

                <div class="relative mx-auto hidden lg:block">
                    <nav class="relative flex items-center">
                        <div class="relative flex items-center gap-2">
                            <ULink
                                v-for="item in navigation"
                                :key="item.key"
                                :to="item.href"
                                :class="[
                                    'rounded-md px-6 py-3 text-lg font-medium tracking-wide transition-all duration-200',
                                    isActive(item)
                                        ? 'bg-primary-pink text-white shadow-md hover:text-white'
                                        : 'text-primarytext hover:bg-menuhover-pink hover:text-primarytext',
                                ]"
                            >
                                {{ item.label }}
                            </ULink>
                        </div>
                    </nav>
                </div>

                <button
                    type="button"
                    class="hidden items-center gap-2 rounded-md bg-primary-pink px-6 py-2 text-lg font-semibold text-white shadow-md hover:bg-primaryhover-pink lg:flex"
                    @click="authAction"
                >
                    <UIcon name="i-lucide-heart" class="h-5 w-5" />
                    <span>{{ isLoggedIn ? 'Uitloggen' : 'Aanmelden' }}</span>
                </button>

                <!-- Mobile-->
                <button
                    type="button"
                    class="ml-auto flex items-center justify-center lg:hidden"
                    @click="mobileOpen = !mobileOpen"
                >
                    <UIcon
                        :name="mobileOpen ? 'i-lucide-x' : 'i-lucide-menu'"
                        class="h-7 w-7 text-primarytext"
                    />
                </button>
            </div>

            <div
                v-if="mobileOpen"
                class="border-t border-borderstrokeline bg-white shadow-sm lg:hidden"
            >
                <nav class="flex flex-col gap-2 p-4">
                    <ULink
                        v-for="item in navigation"
                        :key="item.key"
                        :to="item.href"
                        @click="mobileOpen = false"
                        :class="[
                            'rounded-md px-4 py-3 font-semibold text-primarytext transition-all',
                            isActive(item)
                                ? 'bg-primary-pink text-white hover:text-white'
                                : 'hover:bg-menuhover-pink hover:text-primarytext',
                        ]"
                    >
                        {{ item.label }}
                    </ULink>

                    <button
                        type="button"
                        class="mt-2 flex items-center justify-center gap-2 rounded-md bg-primary-pink px-4 py-3 font-semibold text-white hover:bg-primaryhover-pink"
                        @click="authAction"
                    >
                        <UIcon name="i-lucide-heart" class="h-5 w-5" />
                        <span>{{
                            isLoggedIn ? 'Uitloggen' : 'Aanmelden'
                        }}</span>
                    </button>
                </nav>
            </div>
        </header>
    </div>
</template>
