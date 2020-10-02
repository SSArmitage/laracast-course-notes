<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Lesson</title>
</head>
<body>
    <form action="/contact" method="POST">
        @csrf
        <div>
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email">
        </div>

        @error('email')
            <div style="color:red">{{ $message }}</div>
        @enderror

        <button type="submit">Email Me</button>

        @if(session('message'))
            <div>{{ session('message') }}</div>
        @endif
    
        
    </form>
</body>
</html>