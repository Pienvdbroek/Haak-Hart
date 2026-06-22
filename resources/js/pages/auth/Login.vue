<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { request } from '@/routes/password';


defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();

const processing = ref(false);

const fakeAuthKey = 'haakHartFakeLoggedIn';
const authChangedEvent = 'haak-hart-auth-changed';

function fakeLogin() {
    processing.value = true;

    window.localStorage.setItem(fakeAuthKey, 'true');
    window.dispatchEvent(new Event(authChangedEvent));

    router.get('/home-haak-hart');
}
</script>

<template>
    <Head title="Aanmelden" />

    <div class="font-calibri">
        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <form class="flex flex-col gap-6" @submit.prevent="fakeLogin">
            <section class="text-center">
                <p
                    class="text-sm font-semibold tracking-widest text-primary-pink uppercase"
                >
                    Welkom terug
                </p>

                <h1
                    class="font-timesnewroman mt-3 text-5xl font-bold text-primarytext"
                >
                    Aanmelden
                </h1>

                <p class="mx-auto mt-4 max-w-2xl text-secondarytext">
                    Vul je gegevens in om verder te gaan.
                </p>
            </section>

            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label
                        for="email"
                        class="font-medium text-primarytext"
                    >
                        E-mailadres
                    </Label>

                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="h-12 rounded-md border-borderstrokeline px-4 py-3 text-primarytext placeholder:text-secondarytext focus-visible:ring-2 focus-visible:ring-primary-pink"
                    />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label
                            for="password"
                            class="font-medium text-primarytext"
                        >
                            Wachtwoord
                        </Label>

                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm text-primary-pink"
                            :tabindex="5"
                        >
                            Wachtwoord vergeten?
                        </TextLink>
                    </div>

                    <PasswordInput
                        id="password"
                        name="password"
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Wachtwoord"
                        class="h-12 rounded-md border-borderstrokeline px-4 py-3 text-primarytext placeholder:text-secondarytext focus-visible:ring-2 focus-visible:ring-primary-pink"
                    />
                </div>

                <div class="flex items-center justify-between">
                    <Label
                        for="remember"
                        class="flex items-center space-x-3 font-medium text-primarytext"
                    >
                        <Checkbox id="remember" name="remember" :tabindex="3" />

                        <span>Ingelogd blijven</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full rounded-md bg-primary-pink px-6 py-3 font-semibold text-white shadow-md transition hover:bg-primaryhover-pink"
                    :tabindex="4"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <Spinner v-if="processing" />
                    Aanmelden
                </Button>
            </div>

            <div
                v-if="canRegister"
                class="text-center text-sm text-secondarytext"
            >
                Nog geen account?
                <TextLink
                    :href="register()"
                    :tabindex="5"
                    class="text-primary-pink"
                >
                    Registreren
                </TextLink>
            </div>
        </form>
    </div>
</template>
