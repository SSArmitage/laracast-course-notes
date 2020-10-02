# About this lesson (3 lessons)

## ***** CONTROLLER TECHNIQUES *****
### 1. Leverage Route Model Binding
So far. we've been manually fetching a record from the database using a wildcard from the URI. However, Laravel can perform this query for us automatically, thanks to route model binding.
NOTES:
- refactoring => improve the structure and clarity/organization of your code without changing the outcome.
- route model binding => Laravel route model binding provides a convenient way to automatically inject the model instances directly into your routes. For example, instead of injecting a user's ID, you can inject the entire User model instance that matches the given ID.

### 2. Reduce Duplication
Your next technique is to reduce duplication. If you review our previous ArticlesController, we reference request keys in multiple places. Now as it turns out, there's a useful way to reduce this repetition considerably.
- pattern => validate the request, build up an article, assign the attributes, and then persist it

### 3. Named Routes
Named routes allow you to translate a URI into a variable. This way, if a route changes at some point down the road, all of your links will automatically update, due to the fact that they're referencing the named version of the route rather than the hardcoded path.



