@extends('layouts.app')

@section('content')

    <div class="container">
        <!-- here we want to show all notifications for the user -  need to query the DB -->
        <!-- each $notifications is an instance of the DatabaseNotification class, so the methods that you can use are on that object -->
        <!-- "type" here refers to a DB column name -->
        <!-- all the DB columns are "attributes" of the DatabaseNotification object, and are accessable as properties on an objecet i.e. $notification->type -->
        <!-- to display an item within the DB data column of the $notification, you can either use: $notification->data['amount'] -->
            <!-- this occurs b/c DatabaseNotification has a $casts property that casts the data column to an array, which allows you to access things within the data array with a key -->
        <!-- also convert from cents to dollars -->
        <ul>
            @forelse($notifications as $notification)
                <li>
                    @if($notification->type === "App\Notifications\PaymentRecieved")
                        We have recieved a payment of ${{ $notification->data['amount']/100}} from you, thaks!
                    @endif
                </li>
            @empty
                <li>No new notifications!</li>
            @endforelse
        </ul>

    </div>

@endsection