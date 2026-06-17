<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { register } from '@/routes';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
    >
        <header class="mb-6 w-full max-w-4xl text-sm">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    href="/home-producten"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>

                <template v-else>
                    <Link
                        href="/login"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>

        <main
            class="flex w-full max-w-4xl flex-col overflow-hidden rounded-lg bg-white shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:flex-row dark:bg-[#161615] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
        >
            <section class="flex-1 p-6 pb-12 text-[13px] leading-[20px] lg:p-20">
                <h1 class="mb-1 text-lg font-medium">
                    Welcome to your Laravel project
                </h1>

                <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                    This root page uses your normal Laravel + Inertia setup.
                    You can log in, register, or open the dashboard when you are
                    already authenticated.
                </p>

                <div class="flex flex-wrap gap-3 text-sm leading-normal">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="inline-block rounded-sm border border-black bg-[#1b1b18] px-5 py-1.5 text-sm leading-normal text-white hover:border-black hover:bg-black dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
                    >
                        Go to dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="login()"
                            class="inline-block rounded-sm border border-black bg-[#1b1b18] px-5 py-1.5 text-sm leading-normal text-white hover:border-black hover:bg-black dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
                        >
                            Log in
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="register()"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                        >
                            Register
                        </Link>
                    </template>
                </div>
            </section>

            <section
                class="flex min-h-[280px] flex-1 items-center justify-center bg-[#fff2f2] p-8 dark:bg-[#1D0002]"
            >
                <div class="text-center">
                    <div class="text-6xl font-bold text-[#F53003] dark:text-[#FF4433]">
                        Laravel
                    </div>

                    <p class="mt-3 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Inertia root page loaded through home.blade.php
                    </p>
                </div>
            </section>
        </main>

        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
