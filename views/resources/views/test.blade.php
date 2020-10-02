<!-- blade is a templating engine for laravel -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Test Complete</h1>
    <!-- laravel uses {{}} to compile down and escape the variable -->
    <!-- instead of <?= htmlspecialchars($value, ENT_QUOTES) ?> -->
    <!-- htmlspecialchars() => convert special chars to html entities -->
    <!-- prevents users from injecting harmful code into the url queries -->
    <!-- i.e. if a user puts in 
        <script>alert('hello');</script>
        it will be read as html entities instead of JS
     -->
     <!-- to see what this file is compiled down into, go into: storage/framework/views/matching view -->
     <!-- if you do not want to escape the data (i.e. you are fetching html from a database), use the following instead {!! $value !!} -->
    <p>{{$value}}</p>
</body>
</html>