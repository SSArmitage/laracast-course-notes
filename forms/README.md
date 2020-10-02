# About this lesson (5 lessons)

## ***** FORMS *****
### 1. The Seven Restful Controller Actions 
There are seven restful controller actions that you should become familiar with. In this episode, we'll review their names and when you would reach for them.

### 2. Restful Routing
Now that you're familiar with resourceful controllers, let's switch back to the routing layer and review a RESTful approach for constructing URIs and communicating intent.
NOTES:
- REST => Representational state transfer
- it is a software architectural style/set of rules that developers follow when they create their API
- A RESTful API is an API that uses HTTP requests to GET, PUT, POST and DELETE data.
- everything you need to know is included as part of the request
- everything is stateless?

### 3. Form Handling
Now that you understand resourceful controllers and HTTP verbs, let's build a form to persist a new article.

### 4. Forms that submit PUT requests
Browsers, at the time of this writing, only recognize GET and POST request types. No problem, though; we can get around this limitation by passing a hidden input along with our request that signals to Laravel which HTTP verb we actually want. Let's review the basic workflow in this episode.

### 5. Form Validation Essentials
Before we move on to cleaning up the controller, let's first take a moment to review form validation. At the moment, our controller doesn't care what the user types into each input. We assign each provided value to a property and attempt to throw it in the database. You should never do this. Remember: when dealing with user-provided data, assume that they're being malicious.