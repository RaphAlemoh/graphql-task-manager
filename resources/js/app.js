import './bootstrap';
import '../sass/app.scss';
import Router from '@/router'

import { createApp, provide, h } from 'vue';
import { DefaultApolloClient } from '@vue/apollo-composable'
import { ApolloClient, createHttpLink, InMemoryCache } from '@apollo/client/core'
import App from "./components/layouts/App.vue";

const httpLink = createHttpLink({
    uri: VITE_APP_URL,
})

const cache = new InMemoryCache()

const apolloClient = new ApolloClient({
    link: httpLink,
    cache,
})

const app = createApp({
    setup() {
        provide(DefaultApolloClient, apolloClient)
    },
    render: () => h(App)
})

app.use(Router)
app.mount('#app')