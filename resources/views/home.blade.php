<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
        <button type="button" onclick="window.location='{{ action('PagesController@auth') }}'">login</button>
    </body>
</html>