# All-in-One Discord Connect Block

**Contributors:** younes-dro
**Tags:** discord, gutenberg, connect, membership, lms, block, custom button
**Requires at least:** 5.8
**Tested up to:** 6.5
**Requires PHP:** 7.4
**Stable tag:** 1.0.0
**License:** GPLv3
**License URI:** https://www.gnu.org/licenses/gpl-3.0.html

A powerful Gutenberg block that displays a fully customizable “Connect to Discord” button. Seamlessly integrates with leading membership and LMS plugins to automatically sync users and assign Discord roles. Perfect for communities, e-learning platforms, and membership-based websites.

---

## 🧩 Features

- Gutenberg block for the WordPress block editor
- Full styling control:
  - Button text customization
  - Button background and text color (connect/disconnect states)
- Dynamic messaging based on connection state
- Role assignment messaging
- Connected account display
- Conditional visibility based on login status
- Seamless integration with popular plugins:
  - **Membership:** Paid Memberships Pro, MemberPress, Ultimate Member
  - **LMS:** Tutor LMS, LearnDash, LifterLMS
- Developer-friendly: Easily extensible with hooks and filters

---

## 🚀 Installation

1. Upload the plugin files to the `/wp-content/plugins/all-in-one-discord-connect-block/` directory, or install it directly through the WordPress admin dashboard.
2. Activate the plugin through the “Plugins” menu in WordPress.
3. Edit a post or page using the Gutenberg Block Editor.
4. Search for **“Discord Connect”** block and insert it.
5. Use the block settings panel to customize appearance, behavior, and messages.

---

## ⚙️ Block Settings

Each block instance allows you to customize:

- **Button Appearance**

  - `connectButtonTextColor`: Color of the “Connect” button text
  - `connectButtonBgColor`: Background color for the “Connect” button
  - `disconnectButtonTextColor`: Color of the “Disconnect” button text
  - `disconnectButtonBgColor`: Background color for the “Disconnect” button

- **Text & Messaging**

  - `loggedInText`: Text shown when user is logged in but not connected
  - `loggedOutText`: Text shown when user is connected to Discord
  - `roleWillAssignText`: Message before assigning roles
  - `roleAssignedText`: Message after assigning roles
  - `discordConnectedAccountText`: Label for the connected Discord account

- **Visibility Options**
  - Conditional display based on login status

---

## 🔌 Compatibility

This plugin supports out-of-the-box integrations with:

- **Membership Plugins:**

  - Paid Memberships Pro
  - MemberPress
  - Ultimate Member

- **LMS Plugins:**
  - Tutor LMS

---
