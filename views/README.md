# About this lesson (6 lessons)

## ***** VIEWS *****
### 1. Integrating a site template
Using the techniques you've learned in the last several episodes, let's integrate a free site template into our Laravel project, called SimpleWork.

### 2. Set an active menu link
In this episode, you'll learn how to detect and highlight the current page in your navigation bar. We can use the Request facade for this.

### 3. Asset compilation
Laravel provides a useful tool called Mix - a wrapper around webpack - to assist with asset bundling and compilation. In this episode, I'll show you the basic workflow you'll follow when working on your frontend.

* where you put your js and css depends on if you are using a build process such as webpack or gulp (i.e. does your css or js need to be compiled?)
- can either go in public OR resources
- vanilla css and js can go in public folder
- css pre-processor like SASS, using npm, importing modules => go in the resources folder => need an intermediate step, something that compiles those files down to raw css or vanilla js
- the files you store in resources will ultimately be compiled down to the public directory, and those files are served to the browser

### 4. Render Dynamic Data
Let's next learn how to render dynamic data. The "about" page of the site template we're using contains a list of articles. Let's create a model for these, store some records in the database, and then render them dynamically on the page.

### 5. Render Dynamic Data II
Let's finish up this exercise by creating a dedicated page for viewing a full article.

### 6. Homework
Let's review the solution to the homework from the end of the previous episode. To display a list of articles, you'll need to create a matching route, a corresponding controller action, and the view to iterate over the articles and render them on the page.