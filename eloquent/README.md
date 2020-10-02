# About this lesson (5 lessons)

## ***** ELOQUENT *****
### 1. Basic Eloquent Relationships
Let's now switch back to Eloquent and begin discussing relationships. For example, if I have a $user instance, how might I fetch all projects that were created by that user? Or if I instead have a $project instance, how would I fetch the user who manages that project?
NOTES:
- connection between User & Article => a user has articles (relationship) & an article has a user who created it (inverse of the relationship)
- access one model from another
- Database tables are often related to one another. For example, a blog post may have many comments, or an order could be related to the user who placed it. Eloquent makes managing and working with these relationships easy
- Eloquent relationships are defined as methods on your Eloquent model classes
- like Eloquent models themselves, relationships also serve as powerful query builders
- the different relationships & their Eloquent Models:
    - One to One => hasOne() & belongsTo() ** most common **
    - One to Many => hasMany() & belongsTo() ** most common **
    - Polymorphic One to Many => morphMany() & morphTo()
    - Many to Many => belongsToMany()
    - Polymorphic Many to Many => morphToMany() & morphedByMany()

hasOne() => one model has one of another model (inverse is belongsTo)
hasMany() => one model can have many of another model (inverse is belongsTo)
belongsTo() => one model belongs to another model

### 2. Understanding Foreign Keys and Database Factories
Let's put our learning from the previous episode to the test. If an article is associated with a user, then we need to add the necessary foreign key and relationship methods. As part of this, though, we'll also quickly review database factories and how useful they can be during the development and testing phase.

### 3. Many to Many Relationships With Linking Tables
Next up, we have the slightly more confusing "many to many" relationship type. To illustrate this, we'll use the common example of articles and tags. As we'll quickly realize, a third table is necessary in order to associate one article with many tags, and one tag with many articles.

### 4. Display all tags under each article
Now that we've learned how to construct many-to-many relationships, we can finally display all tags for each article on the page. Additionally, we can now filter all articles by tag.

### 5. Attach and validate Many-to-Many inserts
We now understand how to fetch and display records from a linking table. Let's next learn how to perform inserts. We can leverage the attach() and detach() methods to insert one or many records at once. However, we should also perform the necessary validation to ensure that a malicious user doesn't sneak an invalid id.



