<template>

    <form @submit.prevent="store()" method="POST" id="modal_form_callback" name="modal_form_callback">

        <div class="top_box_form">
            <label for="name_modal_callback">
                <input class="inputbox" id="name_modal_callback" v-model="form.name" name="name" type="text"
                       placeholder="Ваше имя" required>
            </label>
            <label for="phone_modal_callback">
                <input class="inputbox mask_phone" id="phone" v-mask="'+7 (###) ### ## ##'" v-model="form.phone"
                       name="phone_modal_callback"
                       type="text" placeholder="Ваш телефон" required>
            </label>
            <input type="hidden" v-model="form.product_id" name="product_id">
            <input type="hidden" v-model="form.user_id" name="user_id">
        </div>
        <div class="bot_box_form">
            <button class="button btn__modal" type="submit">
                <span>Отправить</span>
            </button>
            <div class="first_text_item">
                Нажимая на кнопку Отправить, <br>вы соглашаетесь с
                <a href="/privacy-policy">условиями обработки данных</a>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios"
import {ref} from "vue";
import {Fancybox} from "@fancyapps/ui";
import {mask} from "vue-the-mask";

let token = document.head.querySelector('meta[name="csrf-token"]');

export default {
    directives: {mask},
    setup(props) {
        const form = ref({
            name: '',
            phone: '',
            product_id: props.product,
            user_id: props.user,
        })

        function store() {
            axios.post('/api/callback', {
                    name: form.value.name,
                    phone: form.value.phone,
                    product_id: form.value.product_id,
                    user_id: form.value.user_id,
                }, {
                    headers: {'X-CSRF-TOKEN': token.content},
                }
            ).then(response => {
                Fancybox.close();
                const fancybox = new Fancybox([{
                    src: '#thanks',
                    type: 'inline',
                },]);
                form.value.name = '';
                form.value.phone = '';
            }).catch(error => console.log(error));
        }

        return {form, store}
    },
    props: {
        product: '',
        user: '',
    },
}
</script>


<style>

</style>
