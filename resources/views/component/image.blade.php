@isset($url)
    <img src="{{$url}}" class="{{$class}}" style="" alt="">
@else
    <div class="no-image img-thumbnail bg-gray d-flex align-items-center justify-content-center"
         style="min-height: 200px;background: #ccc;">Нет изображения
    </div>
@endisset
