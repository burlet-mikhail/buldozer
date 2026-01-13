<!DOCTYPE html>
<html>
<head>
    <title>Новая заявка</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background-color: #63666b;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header a {
            color: #ffffff;
            text-decoration: none;
            text-transform: uppercase;
        }

        .content {
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .content p {
            margin: 0;
            padding: 0;
        }

        .button {
            display: inline-block;
            background-color: #35424a;
            color: white;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Новая заявка</h1>
    </header>
    <div class="content">
        <p><strong>Имя:</strong> {{ $callback['name'] }}</p>
        <p><strong>Телефон:</strong> {{ $callback['phone'] }}</p>
        @isset($callback['product'])
            <p>Объект: <a href="{{$callback['product']['link']}}">{{$callback['product']['title']}}</a></p>
        @endisset
        <br>
        <p><a class="button" href="{{ config('app.url') }}/admin/resource/callback-resource">Посмотреть заявки</a>
        </p>
    </div>
</div>
</body>
</html>
