import {createApp} from 'vue/dist/vue.esm-bundler';
import Callback from "../vue/callback.vue";
import Add from "../vue/add.vue";


const app = createApp({});

app.component('callback', Callback)
app.component('add', Add)


app.mount('#wrapper')
