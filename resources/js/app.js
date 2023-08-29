import './bootstrap';
import '../sass/app.scss';
import Router from '@/router'

import { createApp } from 'vue';
import ApolloClient from 'apollo-boost';
import VueApollo from 'vue-apollo';
import App from "./components/layouts/App.vue";

const app = createApp(App)

const apolloClient = new ApolloClient({
    uri: 'http://127.0.0.1:8000/graphql'
});

const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
});

app.use(Router)
app.use(apolloProvider)
app.mount('#app')