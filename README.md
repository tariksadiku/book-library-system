# Library Book

## Prerequisites

Ensure you have the following installed on your system before you start:

-   **PHP**: Version 8.2
-   **Node.js**: Version 20.14.1

## Architecture

### Services

For business logic, we create service classes, which are classes with one public method that encapsulate actions a user would take. All the dependencies inside the class are what it needs, so we keep it nice and doing only one thing. If it needs to do something else, it delegates that action to another service class (e.g., `GetBookImageService`).

### Validation

For validation, I rely heavily on `Form Requests` provided by Laravel. I don't think any endpoint should exist without some sort of validation. I prefer to do validations in a class instead of the controllers.

### Design Patterns

In our architecture, we use design patterns to keep the code organized and maintainable:

-   **Facades**: For example, `GetBookImageService` is a `Facade` design pattern where it encapsulates a whole library (OpenLibrary) to only be used to get a simple cover URL.
-   **Dependency Injection**: We leverage dependency injection to provide all the required dependencies to services. This makes services easier to test and maintain, as we can easily swap out dependencies for mock objects or different implementations. For example, we use `GetBookImageService` in production code but `MockGetBookImageService` for testing.

### Inertia

We are using **Inertia** to build modern, single-page applications (SPAs) while maintaining the simplicity of traditional server-side routing.

#### Benefits of Inertia:

-   **Full-Stack Simplicity**: The simplicity comes from continuing to use server-side routing (so no need for a client-side router), better SEO (not returning a simple empty HTML page but a complete HTML page), no need to use libraries such as React-Query to fetch data from the database (shared props from the server-side Inertia client are all we need).
-   **Seamless React Integration**: It works effortlessly with React, providing the ability to build powerful client-side interactivity while keeping the server-side logic and routes intact.
-   **No API Layer**: With Inertia, we avoid the complexity of an API layer. This even extends to using a very safe but very simple to implement session-based authentication if we desire.
-   **Improved Development Speed**: It's simply React (or Vue) replacing Blade, not much more.

### Cache

The way we implement caching on this app is based on `updated_at` on `Eloquent Models`:

1. We save data in the cache with keys such as: `model->id` + `model->updated_at`
2. We also retrieve keys based on this format.
3. If `updated_at` changes, that cache will be invalidated and evicted (based on our eviction strategy). Meanwhile, any time a user gets a new model, it will save again to the cache with a new key (since `updated_at` is changed again).
4. When we update a model which has a relationship with another model, we bust the related cache using static model functions such as `saved`. An example can be seen in the `Author.php` model where we bust the cache for the `Books` model based on the `Book` `cacheKey`.

### Traits

Since we already mentioned `cacheKey` in the `Cache` section, I make use of `Traits` when I want to attach shared behavior to multiple classes (in our case, Models) without wanting to add another inheritance chain. I believe the traits used here create a simpler design to get your head around (`UseSort`, `UseSearch`, and `UseCacheKey`). In this case, composition feels better over inheritance.

### Testing

Testing is pretty straightforward. I generally prefer `Feature` tests over `Unit` tests. Using Inertia's testing helper, we do mocked HTTP requests on our endpoints.

### Tailwind for CSS

Tailwind is also pretty industry standard now. I feel it gives us as engineers a very quick way (but not dirty) to write nice and clean CSS in rapid speed.

### Database

Our database schema is minimal but flexible enough for a library/book relationship.

#### Tables and Columns

##### Authors

This table stores all authors and has the following columns:

| Column       | Type    | Notes                       |
| ------------ | ------- | --------------------------- |
| `id`         | integer | Primary key, auto-increment |
| `name`       | string  | Required                    |
| `birth_date` | date    | Required                    |
| `biography`  | text    | Required                    |

##### Books

Each book belongs to an author. This table has the following columns:

| Column      | Type    | Notes                         |
| ----------- | ------- | ----------------------------- |
| `id`        | integer | Primary key, auto-increment   |
| `title`     | string  | Required                      |
| `isbn`      | string  | Required                      |
| `cover_url` | string  | Optional – filled via service |
| `author_id` | integer | Foreign key to `authors`      |

#### Relationships

-   **Author has many Books**
-   **Book belongs to an Author**

### Filtering, Sorting, Pagination

For filtering and sorting, we are using two other traits to attach this behavior on respective models, `HasSort` and `HasSearch`, which by themselves are `scopes` offered by Laravel to make querying on Models much easier to read. These scopes are used on `Service` classes to compose the necessary queries, additionally we are using another Laravel feature `pagination` to paginate results in chunks of 10.
