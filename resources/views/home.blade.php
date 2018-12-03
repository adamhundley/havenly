<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <form action="/" method="POST" enctype="multipart/form-data">
                @csrf
                Upload CSV:
                <br />
                <input type="file" name="csv" />
                <br /><br />
                <input type="submit" value=" Upload " />
            </form>
        </div>
    </body>
</html>
