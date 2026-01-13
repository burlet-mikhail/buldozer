@if($filter->values())
    @foreach($filter->values() as $option)
        <div class="item__filtres with_range_slider__filtres">
            <h6 class="title__item">{{$option['title']}}</h6>

            @if($option['option_values'])

                <div class="item__filtres with_range_slider__filtres">
                    <div class="range_slider__item">

                        <div class="values__range_slider" style="display: none;">
                            <input type="text" id="range_slider_1_min" class="inputbox" data-index="0" value="5">
                            <input type="text" id="range_slider_1_max" class="inputbox" data-index="1" value="35">
                        </div>
                    </div>
                    <div class="values__range_slider">
                        <input
                            name="{{$filter->name($option['id'])}}"
                            data-type="double"
                            type="text" id="single-range-{{$option['id']}}"/>
                    </div>
                </div>

                @section('script')
                    <script>

                        const custom_values = [
                            @foreach($option['option_values'] as $id => $label)
                            ({{(string)$label['title']}}).toString(),
                            @endforeach
                        ];


                        document.addEventListener('DOMContentLoaded', function () {
                            console.log(custom_values)
                            ionRangeSlider('#single-range-{{$option['id']}}', {
                                values: custom_values,
                                @isset($filter->requestValue()['from'])
                                from: custom_values.indexOf("{{$filter->requestValue()['from']}}"),
                                to: custom_values.indexOf("{{$filter->requestValue()['to']}}"),
                                @else
                                from: 0,
                                to: custom_values.length,
                                @endisset
                            });
                        })
                    </script>

                @endsection

            @endif

        </div>
    @endforeach

@endif

