<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

type NavigationItem = {
    key: string;
    label: string;
    icon: string;
    href: string;
};

type FakeUser = {
    name: string;
    email: string;
    initials: string;
};

const page = usePage();
const mobileOpen = ref(false);
const fakeLoggedIn = ref(false);

const fakeAuthKey = 'haakHartFakeLoggedIn';
const authChangedEvent = 'haak-hart-auth-changed';

const fakeUser: FakeUser = {
    name: 'Haak & Hart gebruiker',
    email: 'gebruiker@haakenhart.nl',
    initials: 'HH',
};

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

const isLoggedIn = computed(() => {
    return fakeLoggedIn.value || !!page.props.auth?.user;
});

const currentUser = computed(() => {
    if (!isLoggedIn.value) {
        return null;
    }

    return fakeUser;
});

const currentPath = computed(() => {
    return (page.url || '').split('?')[0].replace(/\/$/, '') || '/';
});

function isActive(item: NavigationItem) {
    return currentPath.value === item.href;
}

function syncFakeAuth() {
    fakeLoggedIn.value = window.localStorage.getItem(fakeAuthKey) === 'true';
}

function setFakeLoggedIn(value: boolean) {
    fakeLoggedIn.value = value;

    if (value) {
        window.localStorage.setItem(fakeAuthKey, 'true');
    } else {
        window.localStorage.removeItem(fakeAuthKey);
    }

    window.dispatchEvent(new Event(authChangedEvent));
}

function authAction() {
    mobileOpen.value = false;

    if (isLoggedIn.value) {
        setFakeLoggedIn(false);
        router.get('/home-haak-hart');

        return;
    }

    router.get('/login');
}

onMounted(() => {
    syncFakeAuth();

    window.addEventListener('storage', syncFakeAuth);
    window.addEventListener(authChangedEvent, syncFakeAuth);
});

onBeforeUnmount(() => {
    window.removeEventListener('storage', syncFakeAuth);
    window.removeEventListener(authChangedEvent, syncFakeAuth);
});
</script>

<template>
    <div class="font-calibri">
        <div
            class="h-2 bg-gradient-to-r from-[#D7425B] via-[#F3E1E7] to-[#D7425B]"
        ></div>

        <header class="relative border-b-1 border-borderstrokeline bg-white">
            <div class="mx-auto flex h-20 max-w-7xl items-center px-8">
                <ULink
                    to="/home-haak-hart"
                    class="flex shrink-0 items-center gap-4"
                >
                    <img
                        src="/images/LogoHaakHart.svg"
                        alt="Haak & Hart"
                        class="h-16 w-16 shrink-0"
                    />

                    <div class="shrink-0">
                        <h1
                            class="font-timesnewroman whitespace-nowrap text-2xl font-semibold text-primarytext"
                        >
                            Haak & Hart
                        </h1>

                        <p class="whitespace-nowrap text-sm text-secondarytext">
                            Met liefde gehaakt
                        </p>
                    </div>
                </ULink>

                <div class="relative mx-auto hidden xl:block">
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

                <div
                    v-if="currentUser"
                    class="mr-4 hidden items-center gap-3 xl:flex"
                >
                    <div
                        class="font-timesnewroman flex h-10 w-10 items-center justify-center rounded-md bg-menuhover-pink text-lg font-bold text-primarytext"
                    >
                        {{ currentUser.initials }}
                    </div>

                    <div class="leading-tight">
                        <p
                            class="font-timesnewroman whitespace-nowrap text-sm font-semibold text-primarytext"
                        >
                            {{ currentUser.name }}
                        </p>

                        <p class="whitespace-nowrap text-xs text-secondarytext">
                            {{ currentUser.email }}
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    class="hidden items-center gap-2 rounded-md bg-primary-pink px-6 py-2 text-lg font-semibold text-white shadow-md transition hover:bg-primaryhover-pink xl:flex"
                    @click="authAction"
                >
                    <UIcon
                        :name="
                            isLoggedIn
                                ? 'i-heroicons-heart-solid'
                                : 'i-lucide-heart'
                        "
                        class="h-5 w-5 text-white"
                    />

                    <span>{{ isLoggedIn ? 'Uitloggen' : 'Aanmelden' }}</span>
                </button>

                <button
                    type="button"
                    class="ml-auto flex items-center justify-center xl:hidden"
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
                class="border-t border-borderstrokeline bg-white shadow-sm xl:hidden"
            >
                <nav class="flex flex-col gap-2 p-4">
                    <ULink
                        v-for="item in navigation"
                        :key="item.key"
                        :to="item.href"
                        :class="[
                            'rounded-md px-4 py-3 font-semibold text-primarytext transition-all',
                            isActive(item)
                                ? 'bg-primary-pink text-white hover:text-white'
                                : 'hover:bg-menuhover-pink hover:text-primarytext',
                        ]"
                        @click="mobileOpen = false"
                    >
                        {{ item.label }}
                    </ULink>

                    <div
                        v-if="currentUser"
                        class="mt-2 flex items-center gap-3 rounded-xl bg-backgroundfooter-pink p-4"
                    >
                        <div
                            class="font-timesnewroman flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-menuhover-pink text-lg font-bold text-primarytext"
                        >
                            {{ currentUser.initials }}
                        </div>

                        <div class="min-w-0 leading-tight">
                            <p
                                class="font-timesnewroman font-semibold text-primarytext"
                            >
                                {{ currentUser.name }}
                            </p>

                            <p class="text-sm text-secondarytext">
                                {{ currentUser.email }}
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="mt-2 flex items-center justify-center gap-2 rounded-md bg-primary-pink px-4 py-3 font-semibold text-white transition hover:bg-primaryhover-pink"
                        @click="authAction"
                    >
                        <UIcon
                            :name="
                                isLoggedIn
                                    ? 'i-heroicons-heart-solid'
                                    : 'i-lucide-heart'
                            "
                            class="h-5 w-5 text-white"
                        />

                        <span>
                            {{ isLoggedIn ? 'Uitloggen' : 'Aanmelden' }}
                        </span>
                    </button>
                </nav>
            </div>
        </header>

        <slot />
    </div>
</template>
