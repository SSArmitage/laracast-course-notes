@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="/payments" method="POST">
            @csrf
            <!-- when the user clicks the button, it will simulate a payment, and we will fire off a notification to the user to let them know the payment has been recieved -->
            <button type="submit" class="btn btn-primary">Make Payment</button>
        </form>
    </div>

@endsection