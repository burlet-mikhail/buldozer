<div>
    @if($success)
        <div class="item__form wrc_item__form">
            <div class="left__item">
                Спасибо, ваше объявление появится на сайте после проверки.
            </div>
        </div>

    @else
        <form id="form__add" wire:submit="save" enctype="multipart/form-data" name="form__add"
              style="position: relative;">

            <div>
                <div class="item__form wrc_item__form">
                    <div class="left__item">
                        <h3 class="h3_title__site h3_black__site"><span>1. Данные объявления</span></h3>
                        <div class="input__item">
                            <label class="labelbox" for="name_technic">Наименование техники</label>
                            <input class="inputbox" wire:model="title" id="name_technic" name="title" type="text"
                                   required>
                            @error('title')
                            <div class="error">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="select__item">
                            <label class="labelbox" for="select_category">Выбор региона</label>
                            <select wire:model="region_id" wire:change="getCities" name="select_region">
                                <option value="0">Выберите регион</option>

                                @foreach($regions as $region)
                                    <option value="{{$region['id']}}">{{$region['name']}}</option>
                                @endforeach

                            </select>
                            @error('region_id')
                            <div class="error">{{ $message }}</div>
                            @enderror

                        </div>
                        @if(count($cities))
                            <div class="select__item">
                                <label class="labelbox" for="select_category">Выбор города</label>
                                <select wire:change="changeCity()" name="select_city" wire:model="city_id">
                                    <option value="0">Выберите город</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city['id']}}">{{$city['name']}}</option>
                                    @endforeach
                                    <option value="manualCity">Нужного города нет в списке</option>
                                </select>

                                @error('city_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif


                        @if($manualCity)
                            <div class="input__item">
                                <label class="labelbox" for="city">Город</label>
                                <input class="inputbox" wire:model="manualCityName" id="city" name="city"
                                       type="text"
                                       placeholder=""
                                       required>
                            </div>
                        @endif


                        <div wire:loading>
                            <div class="loader-container">
                                <div class="loader"></div>
                            </div>
                        </div>

                        <div class="select__item">
                            <label class="labelbox" for="select_category">Выбор категории</label>
                            <select name="select_category" wire:model="category_id" wire:change="getValues"
                                    id="select_category">
                                <option value="0">Выберите категорию</option>

                                @foreach($categories as $category)

                                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                                @endforeach

                            </select>

                            @error('category_id')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>


                        @isset($options->options)

                            @foreach($options->options    as $option)
                                <div class="checkboxes__item">

                                    <div class="labelbox">{{$option->title}}</div>
                                    <div class="catalog__checkboxes">

                                        @foreach($option->optionValues as $value)

                                            <div class="item__catalog">
                                                <div class="btn__item">
                                                    <label class="label-check option">
                                                        <input wire:model="selectedOptions" name="selectedOptions[]"
                                                               type="checkbox"
                                                               value="{{$value['id']}}"
                                                               class="label-check__input">
                                                        <span class="label-check__new-input"></span>
                                                    </label>
                                                </div>
                                                <div
                                                    class="text__item on_click_checked_neighbour"> {{$value['title']}}</div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach
                        @endisset

                        <div class="textarea__item">
                            <label class="labelbox" for="textarea_description">Описание</label>
                            <textarea class="textarea" wire:model="text" name="text" id="textarea_description"
                                      placeholder=""></textarea>

                            @error('text')
                            <div class="error">{{ $message }}</div>
                            @enderror
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
                            <div id="photoContainer" style="display: flex;">
                                @if($images)
                                    @foreach($images as $image)
                                        <div class="item__loaded">
                                            <img src="{{$image->temporaryUrl()}}" alt="">
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <div class="wrap__input_file">
                                <input name="images[]" wire:model="images" type="file"
                                       id="input_file"
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

                        @error('images.*')

                        <div class="error">{{ $message }}</div>

                        @enderror

                    </div>
                </div>
                <div class="item__form">
                    <div class="input__item">
                        <label class="labelbox" for="price_hour">Цена</label>
                        <input class="inputbox" id="price_hour" wire:model="price" name="price" type="number"
                               placeholder=""
                               required>
                    </div>
                    <div class="input__item">
                        <label class="labelbox" for="price_min">Минимальный заказ</label>
                        <input class="inputbox" wire:model="minimumOrder" id="price_min" name="min" type="text"
                               placeholder=""
                               required>
                    </div>
                </div>
                <div class="item__form">
                    <div class="input__item">
                        <label class="labelbox" for="name">ФИО</label>
                        <label class="labelbox" style="font-weight: normal;font-size: 13px;" for="name">Для объявления
                            можно
                            указать другие
                            данные </label>
                        <input class="inputbox" id="name" wire:model="name" name="name" type="text" placeholder=""
                               required>
                        @error('name')
                        <div class="error">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="input__item">
                        <label class="labelbox" for="name_phone">Телефон</label>
                        <input class="inputbox mask_phone" wire:model="phone" id="phone" name="contact" type="text"
                               placeholder="" required>

                        @error('phone')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mess__item">
                        <div class="labelbox">Мессенджеры на номере:</div>
                        <div class="catalog__mess">
                            <div class="item__catalog">
                                <div class="btn__item">
                                    <label class="label-check option">
                                        <input wire:model="messenger.whatsapp" name="messenger[]" value="whatsapp"
                                               type="checkbox"
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
                                        <input wire:model="messenger.viber" name="messenger[]" value="viber"
                                               type="checkbox"
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
                                        <input wire:model="messenger.telegram" name="messenger[]" value="telegram"
                                               type="checkbox"
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

                </div>
                <div class="item__form">
                    <button class="button btn__site" type="submit"><span>Отправить</span></button>
                    <div class="text_pol__item">Нажимая кнопку «Отправить», я соглашаюсь с <a href="#">условиями
                            обработки данных</a></div>
                </div>
            </div>
        </form>
    @endif


</div>

