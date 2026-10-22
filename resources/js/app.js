import './bootstrap';

// Import modules...
import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';

createInertiaApp({
    resolve: (name) => import.meta.glob('./Pages/**/*.vue')[`./Pages/${name}.vue`](),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .mixin({ methods: { route } })
            .use(plugin)
            .use(PrimeVue, { theme: { preset: Aura } })
            .component('Link', Link)
            .mount(el);
    },
    progress: { color: '#4B5563' },
});
