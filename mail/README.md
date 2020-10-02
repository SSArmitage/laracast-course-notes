# About this lesson (7 lessons)

## ***** MAIL *****
### 1. Send Raw Mail
The easiest way to send an email in Laravel is with the Mail::raw() method. In this lesson, we'll learn how to submit a form, read a provided email address from the request, and then fire off an email to the person.
FILES WORKED WITH:
- contact.blade.php
- web.php
- ContactController.php
- .env 
NOTES:
- SMTP => the Simple Mail Transfer Protocol is a communication protocol for electronic mail transmission
- set up routes for '/contact'
- set up controller to render view
- conifg form in view to make a 'POST' request to '/contact'
- need validation on the front end & back end
    => back end => in the controller store() method, validate request with request()->validate(), passing in rules that the user inputs must follow. If the validation fails, it will automatically re-direct back to the previous page (without any error info). To include error feedback for the user, in the view add a:
        1. @error directive => gives you access to the $message variable, message for the error
        <!-- @error('email')
            <div style="color:red">{{ $message }}</div>
        @enderror -->
        2. error object & message method
        <!-- <div style="color:red">{{ $errors->message }}</div> -->
    => front end => add "required" attribute for the form inputs
- how to read the email:
    => in the .env file
        => if the MAIL_DRIVER=log, the "logged" email will be in the  storage/logs directory, there will be a log file with the email contents
- your global "From" email address
    => default found in config/mail.php
    => can change in .env file, add a variable MAIL_FROM_ADDRESS=newFromAddress
    => can also define it explicitly in the raw() method on the $message object
- sending a flash message
    => flash message => data that is put in the session for exactly ONE request, indcates to the user that the email was sent
    => display the message in the view
    => look in the session, if there is a "message", if so display
        i.e. #1
        <!-- @if(session('message'))
            <div>{{ session('message') }}</div>
        @endif -->
        i.e. #2
        <!-- <?php
        $sessionMessage = session('message');
        if ($sessionMessage) {
            echo "<div>$sessionMessage</div>";
        }
        ?> -->

### 2. Simulate a Mailbox Using Mailtrap
It's useful to view a log of any mail that is sent while in development mode, but let's switch over to using Mailtrap. This will allow us to simulate a real-life email inbox, which will be especially useful once we begin sending HTML email.
FILES WORKED WITH:
- .env

### 3. Send HTML Emails Using Mailable Classes
So far, we've only managed to send a basic plain-text email. Let's upgrade to a full HTML-driven email by leveraging Laravel's mailable classes.
FILES WORKED WITH:
- ContactController.php
- ContactMe.php
NOTES:
- a form to provide your email address, and the site sends you a dummy letter
- sending a rich-text html-driven email
- often when you're sending an email, you will need to reference data that needs to be passed to the view i.e. data about the current user

### 4. Sending Email Using Markdown Templates
We can alternatively write emails using Markdown! In this lesson, you'll learn how to send nicely formatted emails constructed by the framework. For the cases when you need to tweak the underlying HTML structure, we'll also publish the mailable assets and review how to create custom themes.
FILES WORKED WITH:
- ContactMe.php
- ContactMe.blade.php
- config/app.php
- vendor/larval/framework/src/Illuminate/Mail/resources/views/html/button.blade.php
- resources/views/vendor/mail/html/button.blade.php
- config/mail.php
NOTES:
- laravel takes the markdown and provides a nicely formatted HTML email
- you don't have to worry about designing and formatting an email, done for you
- don't indent anything if youre using markdown
- creating a Mailer via php artisan
    => php artisan make:mail Contact --markdown=emails.contact
    => --markdown flag creates a markdown file for you with a starter boilerplate
    => specificy a path where you want the markdown file to be placed 
- customizing emails 
    => i.e. if you want the colours and layout to match your branding
    => publish the assets to your own local project so that you can modify and tweak them 
    => php artisan vendor:publish
    => allows you to publish assets from a vendor package into your main project directory (into your reasources directory)
    => php artisan vendor:publish --tag=laravel-mail
    => it physically copies the view to your own resources (now its loacted in resources/views/vendor/mail)
    => so now whenever you send an email, it will read from your local template
    => the themes directory contains all the default css that will be inlined into your email, but you can add your own css file
        => you can tell laravel that you want to use our own custom css file/theme
        => go into config/mail.php, into the markdown settings, and change the default theme (value is the css file name)
    => https://laravel.com/docs/7.x/mail#customizing-the-components

### 5. Notifications vs Mailables (standard Mail class)
So far in this chapter, we've exclusively reached for Mailable classes to send emails; however, there's an alternative approach that you might consider as well. A Notification class can be used to notify a user in response to some action they took on your website (i.e. they made a payment, they closed their account, they liked something, etc). The difference is in how the user is notified. Sure, we can send them an email, but we could also notify them via a text message, or Slack notification, or even as a physical post card!
FILES WORKED WITH:
- web.php
- PaymentsController.php
- views/payments/create.blade.php
- app\Notifications\PaymentRecieved.php
NOTES:
- * using Notification facade to send an email
- all types of Notifications use the same notification API
- set up authentication & DB (refer to the authentication lesson)
- set up view payment form view create.blade.php
- set up payment route - GET request to 'payments/create' endpoint
- set up controller and action PaymentsController@create
- set up submit payment route - POST request to 'payments' endpoint
- create Notification instance, run "php artisan make:notification PaymentRecieved"
- the PaymentRecieved class has the following:
    => notification's delivery channels
        => you can have one notification that is distrobuted to the user in multiple ways i.e. mail, sms message, etc
        => all of them can be represented here in the delivery channels
    => representation of the notification
        => for every different channel you need some way to translate the notification into the proper format for the channel
        i.e. if you are sending an email, you need to know how is should appear. If you were to translate the notification to an email, you would use the toMail API to build it up.
        => instead of loading a view where you manually write the html, here it is using the fluent API to add the email contents

## ***** NOTIFICATIONS *****

### 1. Database Notifications
A notification may be dispatched through any number of "channels." Perhaps a particular notification should alert the user via email and through the website. Sure, no problem! Let's learn how in this episode.
FILES WORKED WITH:
- app\Notifications\PaymentRecieved.php
- CreateNotificationsTable migration
- PaymentsController.php
- PaymentRecieved.php
- UserNotificationsController.php
- User.php
- vendor/laravel/framework/src/Illuminate/Notifications/Notifiable.php
- HasDatabaseNotifications.php
- DatabaseNotification.php (model)
NOTES:
- when something takes place in your system that should generate notification for the user, option#1 is to email them, optio#2 is to store it in the DB and then display it to them when they return to your website i.e. the Facebook notification alarm.
- https://laravel.com/docs/7.x/notifications#database-notifications
- create a migration (table) to store notifications, run "php artisan notifications:table"
- migrate, run "php artisan migrate"
- want to send the notification as an email & store it in the DB
    => add a 'database' parameter to the via() function in the PaymentRecieved.php file
- test it out! hit the "Make Payment" button
    => should send an email and also have a new item in the notifications table in the DB
    => in the DB for each notification: 
        => the type = class path i.e. App\Notifications\PaymentRecieved (what kind of notification is it)
        => the polymorphic notifiable section (notifiable_type & notifiable_id) will correspond to the thing that you are notifying i.e. usually a user (App\User) - here notifiable_id = 2, meaning this notification corresponds to a user with id=2
        => the JSON data => corresponds to the array returned by the toArray() merthod in the PaymentRecieved class
- create enpoint to view notifications
    => add route for GET request to 'notifications'
    => add controller, run "php artisan make:controller UserNotificationsController" + show() method
- display the user's notifications
    => create a view (notifications.show)
    => grab the notifications from the DB
        => do this in the UserNotificationsController.php show() method, and pass the retrieved notifications into the view. In the view, iterate over the notifications and put them in li's
        => in the User.php class, there is "use Notifiable;" - every default User uses the "Notifiable" trait (vendor/laravel/framework/src/Illuminate/Notifications/Notifiable.php)
        => the "Notifiable" trait uses a "HasDatabaseNotifications" trait
        => the "HasDatabaseNotifications" trait has a notifications() method that gets the notifications (it queries the DB using Eloquent relationships i.e. behind the scene the morphMany() relationship is running an SQL query)
        => so you can call notifications() method on the currently signed in user
            i.e. auth()->user()->notifications
        => CHECK: In php artisan tinker => App\User::find(2)->notifications(), this grabs a user with id=2 and gets their notifications
            => each returned item (notification) is an instance of the DatabaseNotification class (model)
            => DatabaseNotification has a method called notifiable() that gets the notifiable entity that the notification belongs to (gets the user who is notifiable - the user who was notified about a specific notification) => useful if you have a notification and want to grab the corresponding user who recieved the notification
- when the notification is read by the user, mark it as read
    => when a user loads the notifications page, it will be assumed that the user has "read" the notifications

### 2. SMS Notifications
Here's a fun exercise. For this next notification channel, we'll choose one that I've personally never used: SMS messaging. As you'll see, even with no prior experience, it's still laughably simple to conditionally fire off text messages to the users of your application.
FILES WORKED WITH:
- .env
- config/services.php
- PaymentRecieved.php
- User.php
NOTES:
- Sending SMS notifications in Laravel is powered by Nexmo. Before you can send notifications via Nexmo, you need to install the laravel/nexmo-notification-channel Composer package, run "composer require laravel/nexmo-notification-channel"
- This will also install the nexmo/laravel package. This package includes its own configuration file. You can use the NEXMO_KEY and NEXMO_SECRET environment variables to set your Nexmo public and secret key
- Next, you will need to add a configuration option to your config/services.php configuration file (defines the phone number that your SMS messages will be sent from)
- Next, in PaymentRecieved class, add a channel for 'nexmo' in the via() method, and then define a toNexmo() method (this method will receive a $notifiable entity and should return a Illuminate\Notifications\Messages\NexmoMessage instance)
- To route Nexmo notifications to the proper phone number, define a routeNotificationForNexmo method on your notifiable entity (User.php)
    => user would have to have a phone number associated with their account