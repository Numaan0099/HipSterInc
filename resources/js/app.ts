import '../css/app.css';

import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';

/* -----------------------------------------------------------------
 | Axios setup (REQUIRED for broadcasting auth)
 |----------------------------------------------------------------- */
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const csrfToken =
    document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content') ?? '';

if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

/* -----------------------------------------------------------------
 | Determine which broadcasting auth endpoint to use
 |----------------------------------------------------------------- */
const isAdmin = window.location.pathname.startsWith('/admin');

const authEndpoint = isAdmin
    ? '/broadcasting/auth/admin'
    : '/broadcasting/auth/customer';

/* -----------------------------------------------------------------
 | Echo (Pusher) setup
 |----------------------------------------------------------------- */
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'ap2',
    forceTLS: true,

    authEndpoint,
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
    },
    withCredentials: true,
});

/* -----------------------------------------------------------------
 | Inertia app bootstrap
 |----------------------------------------------------------------- */
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),

    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});

initializeTheme();
