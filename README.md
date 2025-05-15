# WP_REQUEST_TYPE

A lightweight and efficient WordPress helper to determine the current request type (AJAX, admin, cron, etc.) and improve plugin/theme performance by conditional execution of its code.

---

## 🔍 What is WP_REQUEST_TYPE?

`WP_REQUEST_TYPE` is a runtime-defined constant that identifies the current type of request in a WordPress environment. It enables developers to conditionally load code only when needed—reducing memory use, execution time, and server strain.

---

## ✅ Benefits

- 🧠 Smarter branching: Load logic only when necessary  
- 🚀 Faster execution: Reduce unnecessary code  
- 🔌 Plugin-friendly: Helps prevent bloated plugin behavior  
- 🌱 Green computing: Save energy by optimizing load paths
- ✅ Unit tests and diligent testing on production, high-traffic websites
- 🚀 Code optimized for maximum performance
---

## ⚙️ Installation

1. Download `wp-request-type.php`.
2. Include it as early as possible in your plugin or theme, ideally before any heavy logic runs:

```php
require_once __DIR__ . '/wp-request-type.php';
```

3. Use the `WP_REQUEST_TYPE` constant in your code:

```php
if( WP_REQUEST_TYPE === REQUEST_AJAX ){
	// AJAX-specific code here
}
```

or using SWITCH

```php

switch(WPSD_REQUEST_TYPE){

	case REQUEST_FRONTEND:

		//your code for front-end
		break;

	case REQUEST_ADMIN:

		//your code for the admin area
		break;

	case REQUEST_AJAX:

		//your code for AJAX
		break;
}
```
---

## 🧠 Why This Exists

WordPress lacks a native global way to detect request type early in execution. Without this, plugins and themes frequently load all hooks and files regardless of relevance. With `WP_REQUEST_TYPE`, you can limit execution to relevant branches.

---

## 🔎 Request Type Overview

| Constant         | Description                                 | Detection Method                            |
|------------------|---------------------------------------------|---------------------------------------------|
| `REQUEST_CRON`   | Cron job (`wp-cron.php`)                    | `wp_doing_cron()`                           |
| `REQUEST_AJAX`   | Admin AJAX or WooCommerce `wc-ajax`         | `wp_doing_ajax()` or `$_GET['wc-ajax']`     |
| `REQUEST_ADMIN`  | WordPress admin area                        | `is_admin()`                                |
| `REQUEST_LOGIN`  | Login screen (`wp-login.php`)               | URI path match                              |
| `REQUEST_XMLRPC` | XML-RPC API (`xmlrpc.php`)                  | URI path match                              |
| `REQUEST_EMPTY`  | Blank/undefined request URI                 | `empty($_SERVER['REQUEST_URI'])`            |
| `REQUEST_REST`   | REST API requests (`/wp-json/`)             | URI path match                              |
| `REQUEST_SITEMAP`| Sitemap requests (`/wp-sitemap.xml`)        | URI path match                              |
| `REQUEST_404`    | Missing file, invalid request               | `!file_exists()` + status                   |
| `REQUEST_FRONTEND`| Fallback to front-end                      | When no other type matches                  |

---

## 🛠 Example Use Case

In your plugin's main file:

```php
if( !defined('WP_REQUEST_TYPE') ){
	require_once __DIR__ . '/wp-request-type.php';
}

switch( WP_REQUEST_TYPE ){

	case REQUEST_REST:
		// Setup REST endpoints
		break;

	case REQUEST_ADMIN:
		// Load admin-specific hooks
		break;

	case REQUEST_FRONTEND:
		// Enqueue scripts/styles
		break;

	default:
		// Exit early or skip processing
		return;
}
```

---

## 🔒 Why Core Adoption Isn't Enough

Even if `WP_REQUEST_TYPE` were added to WordPress core, its true power lies in **developer adoption**. Without usage in themes/plugins, its benefits are lost. Community-wide participation is essential.

---

## 💡 Incentive Ideas for Widespread Use

- **Priority plugin approval**
- **"Performance-Optimized" badge**
- **Higher visibility in plugin directory**

---

## ⚡ Proven Results

On a production WooCommerce site with **80+ active plugins**, this optimization strategy reduced average TTFB on product pages to **550ms** (without full-page cache). Without it, the TTFB was **2.5+ seconds**.

---

## 📢 Contributing

PRs, improvements, and feedback are welcome. Help make the WordPress ecosystem leaner and faster.
