@if($filter->values())
    @foreach($filter->values() as $option)
        <div class="item__filtres with_range_slider__filtres">
            <h6 class="title__item">{{$option['title']}}</h6>

            @if($option['option_values'])
                @if($option['template'] === 'checkbox')
                    <div class="checkboxes__item">
                        @foreach($option['option_values'] as $id => $label)
                            <div class="position__checkboxes">
                                <div class="btn__position">
                                    <label class="label-check option">
                                        <input name="{{$filter->name($label['id'])}}"
                                               value="{{$label['id']}}"
                                               @checked($filter->requestValue($label['id']))
                                               id="filters-characteristic-{{$label['id']}}" type="checkbox"
                                               class="label-check__input">
                                        <span class="label-check__new-input"></span>
                                        <span
                                            class="text__position on_click_checked_neighbour">{{$label['title']}}</span>
                                    </label>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
                @if($option['template'] === 'radio')
                    <div class="radios__item">
                        @foreach($option['option_values'] as $id => $label_value)
                            <div class="position__radios">
                                <div class="btn__position">

                                    <label class="label-check option" s>
                                        <input name="{{$filter->name($option['id'])}}"
                                               value="{{$label_value['id']}}"
                                               @checked($filter->requestValue($option['id']) == $label_value['id'])
                                               id="filters-characteristic-{{$label_value['id']}}" type="radio"
                                               class="label-check__input">
                                        <span class="label-check__new-input"></span>
                                        <span
                                            class="text__position on_click_checked_neighbour">{{$label_value['title']}}</span>
                                    </label>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
                @if($option['template'] === 'select')
                    <div class="radios__item">
                        <select
                            name="{{$filter->name($option['id'])}}">
                            <option value="">{{$option['title']}}</option>
                            @foreach($option['option_values'] as $id => $value_label)
                                <option
                                    @selected($filter->requestValue($option['id']) == $value_label['id'])  value="{{$value_label['id']}}">{{$value_label['title']}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endif

        </div>
    @endforeach

@endif

