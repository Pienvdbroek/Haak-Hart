import '../css/app.css';

import type { DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import ui from '@nuxt/ui/vue-plugin';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';

import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import MagazijnLayout from '@/layouts/magazijn/MagazijnLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const pageModules = import.meta.glob<DefineComponent>('./pages/**/*.vue');

const magazijnModules = import.meta.glob<DefineComponent>(
    './components/magazijn/**/*.vue',
);

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),

    resolve: (name) => {
        if (name.startsWith('components/magazijn/')) {
            return resolvePageComponent(
                `./${name}.vue`,
                magazijnModules,
            );
        }

        return resolvePageComponent(
            `./pages/${name}.vue`,
            pageModules,
        );
    },

    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
                return null;

            case name.startsWith('components/magazijn/'):
                return MagazijnLayout;

            case name.startsWith('auth/'):
                return AuthLayout;

            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];

            default:
                return AppLayout;
        }
    },

    progress: {
        color: '#24126E',
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ui)
            .mount(el);
    },
});

initializeTheme();
initializeFlashToast();
