# Statenweb starter theme

## Local setup

1. Check out this repo
2. Map (no pun intended) a local domain, e.g. socialimpact.tst to `{REPO ROOT}/web`
3. Create a local DB
4. Copy .env.example to .env
5. Update the `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST`, `WP_ENV`, `WP_HOME`, `WP_SITEURL`, as applicable
6. Navigate to the mapped location (from above)
7. Install WordPress and plugins by running composer install
8. Navigate to the mapped domain
9. Walk through the default install of WordPress
10. The next, optional steps are, locally, to:
    - Activate WP Migrate DB Pro + the WP Migrate DB Pro Media Add On.

At this point you will have a live copy of a WordPress instance without the theme.

The next step is to go to the theme directory and run:
1. `composer install`
2. `npm install`
3. `npm run watch`

This will run webpack's watch functionality and will compile your JS/SCSS and run the webpack build process whenever any assets it is watching are changed.

That's all, you're set to get started.

## Autoloading
We use PSR-4 autoloading for class files.

### Classes
When creating new classes, follow the existing structure:
	- Class file path: `Victoria\Class_Name.php`
	- Class name: `Victoria\Class_Name.php`

### Method & Function Naming
Methods and functions should follow the snake_case convention (e.g. `class_method_or_function()`).

## Theme code structure

### Bootstrapping the Application
The application bootstraps from `application.php`. You’ll need to register your service providers in the main `App` class.

#### Service Providers
Each provider should be responsible for loading a specific set of classes. When creating a new provider, make sure it extends the `abstract Victoria\Abstracts\Provider` class. This abstract class will automatically load all classes defined in the provider’s `protected array $items` property. Additionally, it utilizes handlers to manage each class’s associated `Interfaces` and `Traits`.

#### Handlers
Each handler is responsible for managing specific logic (e.g. `Interface_Handler` handles logic related to interfaces). To determine which methods a handler should invoke, use the `Handler_Method` attribute in the method declaration.

### Blocks, Hooks, Sidebars... Classes
We have abstract classes to handle common logic, and specific implementations (e.g. `Hero_Block`) should extend these abstract classes. The abstract classes manage core logic, while specific classes define settings for that logic.

When creating a new class, make sure to register it in the corresponding provider’s `protected array $items` property.

### Interfaces
Interfaces are used in conjunction with abstract classes. They allow handlers to manage the specific logic of abstract classes. For example, the `abstract class Enqueue` and `abstract class Hook` both implement the `Hookable` interface. Any new class extending these abstracts (e.g. `Icons_Enqueue` or `WC_Hooks`) should implement the `attach_hooks()` method to register hooks and callbacks.

### ACF Fields for Gutenberg Blocks and `Has_Acf_Fields_Builder` Trait
You can create ACF fields programmatically using PHP. If you're using the `Has_Acf_Fields_Builder` trait in your class, the class must implement the `get_acf_fields()` method, which returns a `FieldsBuilder` instance. Alternatively, you can still use the ACF plugin's UI to build block fields - just skip including the trait in that case.

## PHP code sniffer & coding standards
To ensure your code meets our standards, you can run `composer run lint` to check for issues, and `composer run code-fixer` to automatically fix errors. Note that your code must pass linting before committing, as all PRs will trigger a lint check on the committed code. PRs with linting errors will not be mergeable.
