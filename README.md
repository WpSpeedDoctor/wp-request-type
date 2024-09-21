# WP_REQUEST_TYPE Whitepaper

## What is WP_REQUEST_TYPE?

WP_REQUEST_TYPE is a runtime-defined constant that represents the entry point into WordPress. Its goal is to facilitate the execution of only the branch of code relevant to a given request.

## What problems does implementing this solve in plugin and theme codebases?

Implementing WP_REQUEST_TYPE reduces the amount of unnecessary code required and executed. As a result, overall WordPress speed increases, server load decreases, and a significant amount of energy is saved.

## Why do we need the WP_REQUEST_TYPE constant?

**Short answer:**

To provide developers with a resource for code branching.

**Longer answer:**

There are arguably 10 different types of requests: `cron`, `ajax`, `admin`, `login`, `xmlrpc`, `empty`, `rest`, `sitemap`, `404`, and `frontend`.

WordPress developers often overlook that code running in one request type is usually useless in another. This leads to many unnecessary files being loaded, numerous unused hooks and filters being declared, and an overall slower WordPress site. The common belief within the WordPress community is that more plugins automatically mean slower speed.

If this concept is implemented and actively used, even websites with 100 plugins can run very fast and use minimal resources.

## Is adding it to the WP core enough?

No. By itself, it won't solve anything. Only by adopting it can developers and everyday users incorporate their code into `functions.php` to achieve the desired effect. Additionally, there should be a system of feedback for developers who don't use it and incentives for those who do.

## How could these incentives work?

WordPress should offer advantages for implementing and, in general, for creating good performance plugins. A few ideas for incentives include:

1. **Priority plugin approval:** Plugins implementing WP_REQUEST_TYPE could jump the queue for approval in the WordPress repository.
2. **Enhanced visibility:** Better listing positions when the plugin or theme is searched.
3. **Performance badge:** A "Written for performance" badge on the WordPress plugin page.

## Why am I convinced that this works?

I run a busy WooCommerce e-shop with many blog posts, subscriptions, memberships, multiple marketing plugins, and overall 80+ active plugins. By applying this logic with my own custom plugin, the Time To First Byte (TTFB) on the product page, without full-page cache or Redis, is 550ms. This is an average time throughout the day. Without this implementation, it would be over 2.5 seconds if all 80+ plugins ran as they wish because they don't have an internal mechanism to execute their code only when necessary.

## Some request types are obvious from their names, but some are not. can you describe all of them?

Sure, here is what they represent:

- **`cron`**:  
  The entry point is `/wp-cron.php`. The function `wp_doing_cron()` is used to determine it.

- **`ajax`**:  
  The entry point is `/wp-admin/admin-ajax.php`. The function `wp_doing_ajax()` is used to determine it.
  Another entry point that qualifies as `ajax` is when the query string key `wc-ajax` is set, which is used by WooCommerce.

- **`admin`**:  
  Usually, requests start with `/wp-admin/`. The function `is_admin()` is used to determine it.

- **`login`**:  
  The entry point is `/wp-login.php`. A custom URL set by a plugin won't be detected.

- **`xmlrpc`**:  
  Handles XML-RPC requests. Typically accessed via `/xmlrpc.php`.

- **`empty`**:  
  When `$_SERVER['REQUEST_URI']` is not set or is an empty string, usually when WP is run directly via PHP or CLI.

- **`rest`**:  
  REST API requests, identified by `/wp-json/` in the URI path.

- **`sitemap`**:  
  Sitemap requests, for example, `/wp-sitemap.xml`.

- **`404`**:  
  Most likely a request for a missing file.

- **`frontend`**:  
  Declared as the default type since there is no universal identification method. When all other request types don't qualify, it's most likely a request for the front-end.
