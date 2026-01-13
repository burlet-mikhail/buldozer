<template>
    <form id="form__add" @submit.prevent="store" name="form__add" style="position: relative;">

        <loader v-if="loading"></loader>

        <div v-if="success" class="item__form wrc_item__form">
            <div class="left__item">
                Спасибо, ваше объявление появится на сайте после проверки.
            </div>
        </div>
        <div v-else>
            <div class="item__form wrc_item__form">
                <div class="left__item">
                    <h3 class="h3_title__site h3_black__site"><span>1. Данные объявления</span></h3>
                    <div class="input__item">
                        <label class="labelbox" for="name_technic">Наименование техники</label>
                        <input class="inputbox" id="name_technic" name="title" type="text"
                               placeholder="" required>
                    </div>
                    <div class="select__item">
                        <label class="labelbox" for="select_category">Выбор категории</label>
                        <select name="select_category" id="select_category"
                                @change="getOptions()" v-model="selectedCategory">
                            <option value="0">Выберите категорию</option>
                            <option :value="category.id" v-for="category in categories">
                                {{ category.name }}
                            </option>

                        </select>
                    </div>


                    <div v-for="option in options" class="checkboxes__item">
                        <div class="labelbox">{{ option.title }}</div>
                        <div class="catalog__checkboxes">
                            <div class="item__catalog" v-for="value in option.option_values ">
                                <div class="btn__item">
                                    <label class="label-check option">
                                        <input :value="value.id" :name="'selectedOptions[]'"
                                               v-model="optionsChecked[value.id]" type="checkbox"
                                               class="label-check__input">
                                        <span class="label-check__new-input"></span>
                                    </label>
                                </div>
                                <div class="text__item on_click_checked_neighbour">{{ value.title }}</div>
                            </div>
                        </div>
                    </div>


                    <!--                <div class="input__item" style="display: none;">-->
                    <!--                    <label class="labelbox" for="name_var1">Длина стрелы</label>-->
                    <!--                    <input class="inputbox" id="name_var1" name="name_var1" type="text"-->
                    <!--                           placeholder="" required>-->
                    <!--                </div>-->
                    <!--                <div class="input__item" style="display: none;">-->
                    <!--                    <label class="labelbox" for="name_var2">Длина стрелы</label>-->
                    <!--                    <input class="inputbox" id="name_var2" name="name_var2" type="text"-->
                    <!--                           placeholder="" required>-->
                    <!--                </div>-->

                    <!--                <div class="radios__item" style="display: none;">-->
                    <!--                    <div class="labelbox">Дополнительные параметры</div>-->
                    <!--                    <div class="catalog__radios">-->
                    <!--                        <div class="item__catalog">-->
                    <!--                            <div class="btn__item">-->
                    <!--                                <label class="label-check option">-->
                    <!--                                    <input name="radio_params1" type="radio"-->
                    <!--                                           class="label-check__input">-->
                    <!--                                    <span class="label-check__new-input"></span>-->
                    <!--                                </label>-->
                    <!--                            </div>-->
                    <!--                            <div class="text__item on_click_checked_neighbour">Лебедка</div>-->
                    <!--                        </div>-->
                    <!--                        <div class="item__catalog">-->
                    <!--                            <div class="btn__item">-->
                    <!--                                <label class="label-check option">-->
                    <!--                                    <input name="radio_params1" type="radio"-->
                    <!--                                           class="label-check__input">-->
                    <!--                                    <span class="label-check__new-input"></span>-->
                    <!--                                </label>-->
                    <!--                            </div>-->
                    <!--                            <div class="text__item on_click_checked_neighbour">Проблесковый маячок-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                        <div class="item__catalog">-->
                    <!--                            <div class="btn__item">-->
                    <!--                                <label class="label-check option">-->
                    <!--                                    <input name="radio_params1" type="radio"-->
                    <!--                                           class="label-check__input">-->
                    <!--                                    <span class="label-check__new-input"></span>-->
                    <!--                                </label>-->
                    <!--                            </div>-->
                    <!--                            <div class="text__item on_click_checked_neighbour">Видеорегистратор-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                        <div class="item__catalog">-->
                    <!--                            <div class="btn__item">-->
                    <!--                                <label class="label-check option">-->
                    <!--                                    <input name="radio_params1" type="radio"-->
                    <!--                                           class="label-check__input">-->
                    <!--                                    <span class="label-check__new-input"></span>-->
                    <!--                                </label>-->
                    <!--                            </div>-->
                    <!--                            <div class="text__item on_click_checked_neighbour">Фарпкоп</div>-->
                    <!--                        </div>-->
                    <!--                        <div class="item__catalog">-->
                    <!--                            <div class="btn__item">-->
                    <!--                                <label class="label-check option">-->
                    <!--                                    <input name="radio_params1" type="radio"-->
                    <!--                                           class="label-check__input">-->
                    <!--                                    <span class="label-check__new-input"></span>-->
                    <!--                                </label>-->
                    <!--                            </div>-->
                    <!--                            <div class="text__item on_click_checked_neighbour">Видеорегистратор-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                        <div class="item__catalog">-->
                    <!--                            <div class="btn__item">-->
                    <!--                                <label class="label-check option">-->
                    <!--                                    <input name="radio_params1" type="radio"-->
                    <!--                                           class="label-check__input">-->
                    <!--                                    <span class="label-check__new-input"></span>-->
                    <!--                                </label>-->
                    <!--                            </div>-->
                    <!--                            <div class="text__item on_click_checked_neighbour">Фарпкоп</div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                </div>-->


                    <div class="textarea__item">
                        <label class="labelbox" for="textarea_description">Описание</label>
                        <textarea class="textarea" name="text" id="textarea_description"
                                  placeholder=""></textarea>
                    </div>
                </div>
                <div class="right__item content_box_site">
                    <p>Здесь вы можете добавить ваш объект к нам на сайт. Можете быть уверены, все
                        данные пройдут коррекцию и будут опубликованы в лучшем виде!</p>
                    <p>Постарайтесь заполнить все поля формы и присоединить фотографии. Если вдруг не
                        получилось закачать все фотографии, можете прислать нам их на электронный адрес
                        info@saunagoroda.ru</p>
                    <p>После того как ваш объект будет опубликован, наш менеджер свяжется с вами и
                        расскажет о том, как мы можем помочь вам получить поток заказов с нашего
                        сайта.</p>
                    <p>Если у вас остались вопросы, мы с удовольствием на них ответим с 9:00 до 18:00 по
                        мск: 8-800-200-14-04 (звонок из любого региона РФ бесплатный).</p>
                </div>
            </div>
            <div class="item__form">
                <div class="photos__item">
                    <div class="labelbox">Добавить фото</div>
                    <div class="loaded__photos">
                        <div class="item__loaded" v-for="(image, index) in images" :key="index">
                            <img :src="image" alt="">
                        </div>
                        <div class="wrap__input_file">
                            <input name="input_file[]" type="file" @change="handleFileChange" id="input_file"
                                   class="inputbox input_file" multiple>
                            <label for="input_file" class="btn__input_file">
                                                <span class="img__btn">
                                                    <svg class="icon-svg">
                                                        <use xlink:href="#plus_ico"></use>
                                                    </svg>
                                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item__form">
                <div class="input__item">
                    <label class="labelbox" for="price_hour">Цена</label>
                    <input class="inputbox" id="price_hour" name="price" type="number" placeholder=""
                           required>
                </div>
                <div class="input__item">
                    <label class="labelbox" for="price_min">Минимальный заказ</label>
                    <input class="inputbox" id="price_min" name="min" type="text" placeholder=""
                           required>
                </div>
            </div>
            <div class="item__form">
                <div class="input__item">
                    <label class="labelbox" for="name">ФИО</label>
                    <label class="labelbox" style="font-weight: normal;font-size: 13px;" for="name">Для объявления можно
                        указать другие
                        данные </label>
                    <input class="inputbox" :value="name" id="name" name="name" type="text" placeholder=""
                           required>


                </div>
                <div class="input__item">
                    <label class="labelbox" for="name_phone">Телефон</label>
                    <input class="inputbox mask_phone" :value="phone" id="phone" name="contact" type="text"
                           placeholder="" required>
                </div>
                <div class="mess__item">
                    <div class="labelbox">Мессенджеры на номере:</div>
                    <div class="catalog__mess">
                        <div class="item__catalog">
                            <div class="btn__item">
                                <label class="label-check option">
                                    <input name="whatsapp" :checked="whatsapp === '1'" type="checkbox"
                                           class="label-check__input">
                                    <span class="label-check__new-input"></span>
                                </label>
                            </div>
                            <div class="img__item on_click_checked_neighbour">
                                <img src="../images/icons/whatsapp.png" alt="">
                            </div>
                        </div>
                        <div class="item__catalog">
                            <div class="btn__item">
                                <label class="label-check option">
                                    <input name="viber" :checked="viber === '1'" type="checkbox"
                                           class="label-check__input">
                                    <span class="label-check__new-input"></span>
                                </label>
                            </div>
                            <div class="img__item on_click_checked_neighbour">
                                <img src="../images/icons/viber.png" alt="">
                            </div>
                        </div>
                        <div class="item__catalog">
                            <div class="btn__item">
                                <label class="label-check option">
                                    <input :checked="telegram === '1'" name="telegram" type="checkbox"
                                           class="label-check__input">
                                    <span class="label-check__new-input"></span>
                                </label>
                            </div>
                            <div class="img__item on_click_checked_neighbour">
                                <img src="../images/icons/telegram.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input__item">
                    <label class="labelbox" for="city">Город</label>
                    <input @keyup="cities_block = true" v-model="city" class="inputbox" id="city" name="city"
                           type="text"
                           placeholder=""
                           required>

                    <ul class="cities" v-if="cities.length && cities_block">
                        <li @click="city = item.name; cities_block = false" v-for="item in cities">{{ item.name }}</li>
                    </ul>
                </div>
            </div>
            <div class="item__form">
                <button class="button btn__site" type="submit"><span>Отправить</span></button>
                <div class="text_pol__item">Нажимая кнопку «Отправить», я соглашаюсь с <a href="#">условиями
                    обработки данных</a></div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios"
import {ref, watch} from "vue";
import {mask} from "vue-the-mask";
import loader from "./components/loader.vue";

let token = document.head.querySelector('meta[name="csrf-token"]');

export default {
    directives: {mask},
    components: {loader},
    setup(props) {
        const loading = ref(true);
        const cities_block = ref(false);
        const success = ref(false);
        const city = ref('');
        const categories = ref([]);
        const options = ref([]);
        const optionsChecked = ref([]);
        const cities = ref([]);
        const selectedCategory = ref(0);
        getCategories()

        function store() {
            loading.value = true;
            const formData = new FormData(event.target);
            console.log(formData.getAll('input_file'))
            axios.post('/api/add_item/product/' + props.user, formData, {
                    headers: {'X-CSRF-TOKEN': token.content},
                    "Content-Type": "multipart/form-data",
                }
            ).then(response => {
                console.log(response.data)
                loading.value = false;
                success.value = true;
            }).catch(error => {
                loading.value = false;
                console.log(error)
            });
        }

        function getCategories() {
            axios.post('/api/add_item/categories', {
                    headers: {'X-CSRF-TOKEN': token.content},
                }
            ).then(response => {
                categories.value = response.data;
                loading.value = false;
            }).catch(error => console.log(error));
        }

        watch(city, async (newQuestion, oldQuestion) => {
            if (city.value.length > 2 && cities_block.value) {
                getCity()
            }
        })

        function getCity() {
            axios.post('/api/add_item/city/' + city.value, {
                    headers: {'X-CSRF-TOKEN': token.content},
                }
            ).then(response => {
                cities.value = response.data;
                cities_block.value = true
            }).catch(error => console.log(error));
        }

        const images = ref([]);

        const handleFileChange = (event) => {
            images.value = [];
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = (e) => {
                    images.value.push(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        };

        function getOptions() {
            if (selectedCategory.value === '0') {
                options.value = [];
                return;
            }
            loading.value = true;
            axios.post('/api/add_item/categories/options/' + selectedCategory.value, {
                    headers: {'X-CSRF-TOKEN': token.content},
                }
            ).then(response => {

                options.value = response.data.options
                loading.value = false;
            }).catch(error => console.log(error));
        }

        console.log(props.telegram)
        console.log(props.viber)
        console.log(props.whatsapp)
        return {
            categories,
            selectedCategory,
            options,
            optionsChecked,
            loading,
            cities,
            city,
            cities_block,
            images,
            success,
            handleFileChange,
            getCity,
            store,
            getOptions,
        }
    },
    props: {
        product: '',
        user: '',
        name: '',
        phone: '',
        telegram: false,
        whatsapp: false,
        viber: false,
    },
}
</script>



