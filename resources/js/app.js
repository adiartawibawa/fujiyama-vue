require('./bootstrap');

// Import modules...
import Vue from 'vue';
import {
    App as InertiaApp,
    plugin as InertiaPlugin
} from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import Multiselect from 'vue-multiselect'

// register globally
Vue.use(require('vue-moment'));
Vue.component('multiselect', Multiselect)

Vue.mixin({
    methods: {
        route
    }
});
Vue.use(InertiaPlugin);
Vue.use(PortalVue);

const app = document.getElementById('app');

new Vue({
    mounted() {
        window.addEventListener('popstate', () => {
            this.$page.props.popstate = true;
        })
    },
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
