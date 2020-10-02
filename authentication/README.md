# About this lesson (2 lessons)

## ***** AUTHENTICATION *****
### 1. Quickly Build a Registration System
Thanks to the first-party package, Laravel UI, you can easily scaffold a full registration system that includes sign ups, session handling, password resets, email confirmations, and more. And the best part is you can knock out this tedious and common requirement...in minutes.
NOTES:
- after creating new project, run "composer require laravel/ui --dev"
- use dev dependancy here => Dev dependencies are those things that are only used to build your application, but not to run it. Stuff like babel and webpack are only used to build, so they're not included at runtime, whereas you'd need lodash for the app to run.
- run "php artisan help ui" to see how this works => can be used with react, vue, or bootstrap
- run "php artisan ui vue --auth"
- install development dependancies and then compile down the associated assets, run "npm install && npm run dev"
- you can view all the registered routes for a project by runnning "php artisan route:list"
- set up database => MySQL
- change DB connection info in the .env file
- migrate the database to build up initial tables, run "php artisan migrate"

### 2. The Password Reset Flow
In this episode, we'll discuss the basic password reset flow. If a user forgets their password, a series of actions need to take place: they request a reset; we prepare a unique token and associate it with their account; we fire off an email to the user that contains a link back to our site; once clicked, we validate the token in the link against what is stored in the database; we allow the user to set a new password. Luckily, Laravel can handle this entire workflow for us automatically.
NOTES:
1. Click "Forgot Password" link
    - this is provided by laravel auth
    - the link goes to password/reset URI which loads the ForgotPasswordController (contains the SendsPasswordResetEmails trait)
    - the trait SendsPasswordResetEmails contains a method called showLinkRequestForm, which loads the view where a user fills out a form to recieve a password reset
2. Fill out a form with their email address
    - default settings for mail in .env file (smtp)
    - specifics in config/mail.php file (where the environment variables referenced from)
    - in .env change MAIL_MAILER=smtp to MAIL_MAILER=log (whenever you fire off an email, it will be logged to a file in /storage/logs)
3. After submit, prepare a unique token and associate it with the user's account (a hashed version of the token will be saved to the database along with the asssociated email)
    - the form submits a POST request to the password/email URI which loads the ForgotPasswordController (contains the SendsPasswordResetEmails trait)
    - the trait SendsPasswordResetEmails contains a method called the sendResetLinkEmail
        => sendResetLinkEmail first validates the users email address using $request->validate()
        => it then calls its own broker() method, which returns an instance of the PasswordBroker class (Password::broker())
        => the PasswordBroker instance has its sendResetLink() method called (the user's credentials passed in as an argument - just the email address passed in this case)
        => sendRestLink() grabs the $user instance (using the passed in email address), and calls the sendPasswordResetNotification() method directly on that user instance (passing in a new unique token)
            => this method sends the email to the user with a link to reset their password
    - Able to call sendPasswordResetNotification() directly on the $user becasue... 
    - laravel provides app/User.php out of the box
    - app/User extends Authenticatable, and Authenticatable === auth/User, which extends model
    - auth/User has a trait called CanResetPassword (and becasue app/User extends this class, it also has access to this trait)
        - trait => One of the problems of PHP as a programming language is the fact that you can only have single inheritance. This means a class can only inherit from one other class. For example, it might be desirable to inherit methods from a couple of different classes in order to prevent code duplication. In PHP 5.4 a new feature of the language was added known as Traits and are used extensively in the Laravel Framework
        => Traits are a mechanism for code reuse in single inheritance languages such as PHP. A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies
        => A Trait is similar to a class, but only intended to group functionality in a fine-grained and consistent way. It is not possible to instantiate a Trait on its own. It is an addition to traditional inheritance and enables horizontal composition of behavior
        =>A Trait is simply a group of methods that you want include within another class. A Trait, like an abstract class, cannot be instantiated on it’s own
        => i.e. trait SharePost {
                public function share($item)
                {
                    return 'share this post';
                }
            }
        => You could then include this Trait within other classes like this:
        => i.e. class Post {
                use SharePost;
            }
 
            class Comment {
                use SharePost;
            }
    - So, app/User has access to the CanResetPassword trait
    - CanResetPassword has a method on it called sendPasswordResetNotification()
    - sendPasswordResetNotification() creates a notification instance (blueprint for an email found in the ResetPassword.php class) using the unique token and passes that to the notify() funciton => this will send the email to the user
        => inside this email, there is a button that takes the user back to the site (URL), with route = password.reset (password/reset/{token})
4. Confirm that the person who requested the reset is also the person who owns that email address (the email contains a unique link back to your site that confirms email ownership)
5. Once the user clicks on the link, they are sent back to your site, the server then verifies the token in that link, and if it matches, the user can fill out the form to set a new password
    - when the user clicks the link they are requesting the password/reset/{token} route
    - the ResetPasswordController is loaded, it contains the trait ResetsPasswords, which has a showResetForm() method
    - showResetForm() is called on the ResetPasswordController 
    - the showResetForm method loads the view that contains the reset password form, passing in the token and user email (token is passed with the request when the user clicks the link in the email)
    - new password is submitted with the form
    - submition of form makes a request to the password/reset route (password.update route), which loads the ResetPasswordController and called the reset() method (found in the ResetsPasswords trait)
        => reset() validates the inputs in the request
        => it then calls its own broker() method, which returns an instance of the PasswordBroker class (Password::broker())
        => use the PasswordBroker to reset the email => the PasswordBroker instance has its reset() method called, taking in the users credentials (just the email in this case), and a closure (this updates the user) => the fxn takes in the $user and $credentials and saves them to the database (updates the password on a user model and persist it to the database) & then logs in the user => this reset() method on the PasswordBroker is assigned to $response, which will be succesful ($response === Password::PASSWORD_RESET), or not successful ($response !== Password::PASSWORD_RESET)
        => If the password was successfully reset, we will redirect the user back to the application's home authenticated view. If there is an error we can redirect them back to where they came from with their error message.





