@if($filter->values())
    @foreach($filter->values() as $option)
        <div class="item__filtres with_range_slider__filtres">
            <h6 class="title__item">{{$option['title']}}</h6>

            @if($option['option_values'])

                <div class="item__filtres with_range_slider__filtres">

                    <div class="values__range_slider">
                        <input
                            name="{{$filter->name($option['id'])}}"
                            data-type="single"

                            type="text" id="single-range-{{$option['id']}}"/>
                    </div>
                </div>

                @push('scripts')
                    <script>

                        const custom_values_{{$option['id']}} = [
                            @foreach($option['option_values'] as $id => $label)
                                "{{$label['title']}}",
                            @endforeach
                        ];


                        document.addEventListener('DOMContentLoaded', function () {
                            ionRangeSlider('#single-range-{{$option['id']}}', {
                                values: custom_values_{{$option['id']}},
                                from: custom_values_{{$option['id']}}.indexOf("{{$filter->requestValue($option['id'])}}"),
                            });
                        })

                    </script>

                @endpush

            @endif

        </div>
    @endforeach

@endif

