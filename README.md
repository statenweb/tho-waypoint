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

Final step is to go to the root directory and run:
`wp victoria publish`

This command copies the files of [statenweb / victoria-package](https://github.com/statenweb/victoria-package) from `vendor/statenweb/victoria/files` to `web/wp-content/themes/<theme_name>/Victoria` directory, ensuring the package is placed in the correct location within the theme structure.
For more details, please refer to the Git repository.

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

#### Blocks, Hooks, Sidebars... Classes
We have abstract classes to handle common logic, and specific implementations (e.g. `Hero_Block`) should extend these abstract classes. The abstract classes manage core logic, while specific classes define settings for that logic.

When creating a new class, make sure to register it in the corresponding provider’s `protected array $items` property.

#### Interfaces
Interfaces are used in conjunction with abstract classes. They allow handlers to manage the specific logic of abstract classes. For example, the `abstract class Enqueue` and `abstract class Hook` both implement the `Hookable` interface. Any new class extending these abstracts (e.g. `Icons_Enqueue` or `WC_Hooks`) should implement the `attach_hooks()` method to register hooks and callbacks.

#### ACF Fields for Gutenberg Blocks and `Has_Acf_Fields_Builder` Trait
You can create ACF fields programmatically using PHP. If you're using the `Has_Acf_Fields_Builder` trait in your class, the class must implement the `get_acf_fields()` method, which returns a `FieldsBuilder` instance. Alternatively, you can still use the ACF plugin's UI to build block fields - just skip including the trait in that case.
For more information on programmatically building ACF fields and blocks with PHP, refer to the [StoutLogic / acf-builder](https://github.com/StoutLogic/acf-builder) documentation.

#### Background Job Processing
Application uses [deliciousbrains / wp-background-processing](https://github.com/deliciousbrains/wp-background-processing) package to handle background jobs.
- Use the `Sw_Background_Job` class for handling background jobs.
- For async requests, utilize the `Sw_Async_Request` class.
For detailed usage, refer to the package's documentation.

If you need to create custom background jobs or asynchronous request classes, extend the `Background_Processing` class. Make sure to set the `protected ?string $async_request_class_name` and `protected ?string $background_job_class_name` properties accordingly.
Don’t forget to register your background processing class in the `Background_Processing_Provider` class.

#### Sw_Mail_Service Class
If you need to send emails, you can utilize the `Sw_Mail_Service` class. By default, this class will push the email-sending process to a background job. If you prefer to send emails synchronously (without using background processing), pass the `$sync` parameter as `true` when calling `send_mail()`, like so `send_mail( sync: true )`.

Note: Using `add_recipient_email( string $recipient_email )` or `add_user( int|\WP_User $user )` sends an individual email to each recipient separately. If you want to send a single email to multiple recipients at once, use `add_group_recipients_emails( array $recipients_emails )` or `add_group_users( array $users )` instead.

#### Mail_Template Class
The `Mail_Template` class is designed to help you define email templates. It uses the `Placeholders_Replacement` trait, which allows you to replace placeholders in the template.

Placeholders should be wrapped in curly brackets `{}` (e.g., `{placeholder}`). If you want to insert a link as a replacement, you should add a `text` attribute like `{login_link text='Click here to login'}`. Additional attributes, such as `class='some-class'`, can also be added.

Placeholders are defined as an array, where the keys represent the placeholder names, and the values are their corresponding replacements. The replacements can be either strings or callback functions. When using callback functions, a `WP_User` object will be injected as a parameter into the callback, allowing you to dynamically customize the replacement based on user-specific data.

Below is an example of how to build and send an email using the provided methods:
```
// Sending emails without mail templates and WP User
$mailer = new \Victoria\Utilities\Sw_Mail_Service();

$mailer->add_recipient_email( 'recipient.1@statenweb.com' )                                         // recipient.1@statenweb.com will get individual email
    ->add_recipient_email( 'recipient.2@statenweb.com', 'recipient.3@statenweb.com' )               // recipient.2@statenweb.com and recipient.3@statenweb.com will get individual emails
    ->add_group_recipients_emails( [ 'recipient.4@statenweb.com', 'recipient.5@statenweb.com' ] )   // recipient.4@statenweb.com and recipient.5@statenweb.com will get same email
    ->set_subject( 'Hello from StatenWeb' )
    ->set_body( 'Welcome to StatenWeb. This text can be HTML.' )
    ->set_from( [ 'name' => 'StetenWeb', 'email' => 'hello@statenweb.com' ] )
    ->set_reply_to( [ 'name' => 'StetenWeb', 'email' => 'hello@statenweb.com' ] )
    ->add_cc_email( [ 'name' => 'Operations', 'email' => 'operations@statenweb.com' ] )
    ->add_cc_email( [ 'name' => 'Marketing', 'email' => 'marketing@statenweb.com' ] )
    ->add_bcc_email( [ 'name' => 'developers', 'email' => 'developers@statenweb.com' ] )
    ->send_mail();



// Sending emails using mail templates and WP User
$mailer = new \Victoria\Utilities\Sw_Mail_Service();

$mail_template = new \Victoria\Mails\Sw_Mail_Template(
    subject: 'Hello {first_name}',
    body: 'Welcome to StatenWeb! Mr. {function_callback} you can login here {login text="Click here to login"}. You can pass additional attributes to link {pass_reset text="Click here to reset password" class="some-class"}',
    attachments: [ wp_get_upload_dir()['basedir'] . '/example_file_1.csv' ],
    placeholders: [
        '{first_name}' => 'Marko',
        '{function_callback}' => fn ( $user ) => $user?->display_name,
        '{login}' => get_login_link(),
        '{pass_reset}' => get_pass_reset_link()
    ]
);

$mailer->add_user( $user1 )                     // $user1 will get individual email
    ->add_user( $user2, $user3 )                // $user2 and $user3 will get individual emails
    ->add_group_users( [ $user4, $user5 ] )     // $user4 and $user5 will get same email
    ->set_mail_template( $mail_template )
    ->set_from( [ 'name' => 'StetenWeb', 'email' => 'hello@statenweb.com' ] )
    ->set_reply_to( [ 'name' => 'StetenWeb', 'email' => 'hello@statenweb.com' ] )
    ->add_cc_email( [ 'name' => 'Operations', 'email' => 'operations@statenweb.com' ] )
    ->add_cc_email( [ 'name' => 'Marketing', 'email' => 'marketing@statenweb.com' ] )
    ->add_bcc_email( [ 'name' => 'developers', 'email' => 'developers@statenweb.com' ] )
    ->send_mail();
```

#### Bringing It All Together
The main `App` class is responsible for registering and booting providers (e.g. `Blocks_Provider`). Each provider will then load the classes it has registered (e.g. the `Hero` block class). These classes are passed to handlers, which determine which methods to invoke by checking for the `Handler_Method` attribute on the methods of the instances.

## PHP code sniffer & coding standards
To ensure your code meets our standards, you can run `composer run lint` to check for issues, and `composer run lint-fix` to automatically fix errors. Note that your code must pass linting before committing, as all PRs will trigger a lint check on the committed code. PRs with linting errors will not be mergeable.

## Packages
1. [statenweb / victoria-package](https://github.com/statenweb/victoria-package)
   - Contains the main source files for the starter theme.

2. [statenweb / sw-generator](https://github.com/statenweb/sw-generator)
    - A WP-CLI script for generating StatenWeb starter theme assets (from Victoria package).

3. [statenweb / wp-block-generator](https://github.com/statenweb/wp-block-generator)
    - A WP-CLI script for generating WordPress blocks.

4. [statenweb / block-generator](https://github.com/statenweb/block-generator)
    - A Node.js script for generating WordPress blocks.