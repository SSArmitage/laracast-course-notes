<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    public function show() {
        // query the DB and pass in the notifications to the view (here we communitcate with the DB twice)

        // $auth-user() grabs the currently signed in user
        // $notifications = auth()->user()->notifications;

        // only grab the unread notifications from the database (returns a collection - the DatabaseNotificationCollection class which extends the Collection class. DatabaseNotificationCollection has additional methods such as markAsRead() method)
        $notifications = auth()->user()->unreadNotifications;
        // then mark each notifcation rendered here as "read" and update the database (the markAsRead() method belongs to the DatabaseNotificationCollection)
        // on the next page load, when you fetch the notifications, it wont show any until a new notification comes in
        $notifications->markAsRead();
        // dd($notifications[0]->data['amount']);
        return view('notifications.show', [
            'notifications' => $notifications
        ]);
    }
}
