=== Content Hider ===
Contributors: khaxan
Tags: members-only, members-only content, private content, membership website, membership, hide posts, hide content, hider, sensitive content
Donate link: http://wpgurus.net/
Requires at least: 2.5
Tested up to: 3.8
Stable tag: 0.1
License: License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Restrict access to your content by wrapping it in a simple shortcode. You can grant access to certain roles or users who have a certain capability.

== Description ==
This light weight plugin can be used to hide posts and pages from specified user roles. All you have to do is wrap the target content in the shortcode [lock_content]. The plugin also adds a new button to the default WordPress editor so you can lock content quickly and effortlessly.

**Features:**

**Custom error messages:** You can specify the error message while hiding the content. Just add an error attribute to the shortcode. For instance: 


`[lock_content error="You need to log in first"]Some text[/lock_content]`

Also, you can add a default error message in the control panel that will be displayed in case the error attribute of the shortcode is absent.

**User levels:** By specifying a role in the shortcode you can decide which members see the hidden content. For instance:

`[lock_content role="author"]Text visible to authors, editors and admins[/lock_content]`

You can also set a default access level in the control panel.

**Capabilities:** You can also block access by specifying a capability instead of a role. This may come in handy if you have custom roles on your website. Here's an example of this feature:

`[lock_content capability="activate_plugins"]Text visible to admins[/lock_content]`

If you like this plugin please give it a good rating.

== Installation ==
1. Use WordPress' plugin installer to install the plugin.
2. Set default values in the control panel (optional).
3. In the WordPress editor select the content you want to hide and click the lock icon in the top panel. The selected text will automatically be wrapped in the shortcode.

== Changelog ==
= 1.0 =
* Initial release