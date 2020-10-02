<!-- 1. view -->
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>It works again!!!</h1>
    <p>You need to hear more about {{ $topic }}!!!</p>
    <img src="https://www.prestigeanimalhospital.com/sites/default/files/styles/large/adaptive-image/public/golden-retriever-dog-breed-info.jpg?itok=scGfz-nI" alt="">
</body>
</html> -->

<!-- 2. markdown -->
@component('mail::message')
# A Heading

fsdjfjsdkjfksldjfksdjf

- list
- item
- here

<!-- in "mail::button," the "::" indicates that the view (in this case, the button component) is going to be in the vendor directory (i.e. vendor/larval/framework/src/Illuminate/Mail/resources/views/html/button.blade.php) -  the view is coming from a vendor dependancy -->
@component('mail::button', ['url' => 'http://www.saraharmitage.com/'])
    Visit Us!
@endcomponent

@endcomponent