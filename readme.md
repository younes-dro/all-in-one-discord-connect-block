# All-in-One Discord Connect Block

**Contributors:** younes-dro
**Tags:** discord, gutenberg, connect, membership, lms, block, custom button
**Requires at least:** 5.8
**Tested up to:** 6.5
**Requires PHP:** 7.4
**Stable tag:** 1.0.0
**License:** GPLv3
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html

A Gutenberg block that displays a custom “Connect to Discord” button with flexible styling options. Seamlessly integrates with popular membership and LMS plugins to sync your users with Discord automatically.

---

## 🧩 Features

- Gutenberg block for WordPress block editor
- Customizable button text, background color, and text color
- Conditional display: show to logged-in or logged-out users
- Integrates with popular plugins:
  - Membership: Paid Memberships Pro, MemberPress, Ultimate Member
  - LMS: Tutor LMS, LearnDash, LifterLMS
- Clean, modern frontend style with minimal setup
- Extendable for developers

---

## 🚀 Installation

1. Upload the plugin files to the `/wp-content/plugins/all-in-one-discord-connect-block/` directory, or install it directly through the WordPress admin dashboard.
2. Activate the plugin through the “Plugins” menu in WordPress.
3. Go to any post or page in the Block Editor (Gutenberg).
4. Search for **“Discord Connect”** block and insert it.
5. Customize the appearance and logic from the block settings panel.

---

## ⚙️ Block Settings

- **Button Text** – Customize the label shown on the Discord button.
- **Background Color** – Choose a background color for the button.
- **Text Color** – Customize text color for better contrast and accessibility.
- **Visibility** – Show the button only to logged-in or logged-out users.

---

## 🔌 Compatibility

This plugin works out-of-the-box with the following:

- **Membership Plugins:**
  - Paid Memberships Pro
  - MemberPress
  - Ultimate Member
- **LMS Plugins:**
  - Tutor LMS
  - LearnDash
  - LifterLMS

> _Note: Some integrations may require additional configuration depending on how user roles or profile meta are managed._

---

## 🧑‍💻 Developers

Hooks and filters are provided to customize button behavior and integration logic.

```php
/**
 * Filter the Discord connect URL.
 */
apply_filters( 'aio_discord_connect_url', $url );
````

More hooks coming soon!

---

## 📄 Changelog

### 1.0.0

* Initial release
* Added Gutenberg block with style controls
* Membership + LMS plugin integration
* Conditional display logic

---

## 📃 License

This plugin is licensed under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.html).

---

## 🙌 Credits

Developed by [Younes DRO](https://github.com/younes-dro)
Icon and branding inspired by Discord®

---

## 📬 Support

Found a bug? Want to request a feature?
Open an issue or contribute via the [GitHub repository](https://github.com/younes-dro/all-in-one-discord-connect-block).
