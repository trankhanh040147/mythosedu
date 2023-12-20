=== Rename Plugins Folder ===
Contributors: giuse
Donate link: buymeacoffee.com/josem
Tags: security, rename plugins folder
Requires at least: 4.6
Tested up to: 6.4
Stable tag: 0.0.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

With Rename Plugins Folder you can rename the plugins folder.

This is an underestimated way to increase the security of your installation.



== Description ==


Usually, for security reasons, people rename any kind of folder, but they don't rename the plugins folder.

Renaming the plugins folder makes the protection of your website stronger.

Bad robots scan the net to find websites that have vulnerable plugins.

Most of the time they detect the plugins by checking the path wp-content/plugins in the page HTML.

If instead of wp-content/plugins the path is for example wp-content/extensions, probably the bad robot will not detect any plugin.

This plugin just renames the plugins folder and updates the wp-config.php file to make work your website with the new folder name.

It doesn't save anything in the database.

It's for the users who don't know how to modify the wp-config.php file, if you know it, of course you don't really need this plugin.

We recommend making a backup before renaming the plugins folder, especially of the file wp-config.php, so you can easily go back in case you have issues.

Issues may occur if your theme or one of your plugins doesn't follow the best practices to refer to the plugins folder.

Normally, the authors of themes and plugins know that they must refer to the plugins folder by adopting best practices.

If one of your plugins or the theme gives issues, we suggest restoring the original folder name but writing the author of the plugin that was giving the issue.


You will find the options in Plugins => Rename Plugins Folder



== How to rename the plugins folder ==

1. Install and activate the plugin Rename Plugins Folder
2. To be very sure, make a backup of the file wp-config.php that is included in the main directory
3. Go to Plugins => Rename Plugins Folder
4. Assign a new name for the plugins folder
5. Click on "Rename"



== Demo ==

If you want to have a look at the backend before installing the plugin, you can see the demo on <a href="https://wpdemo.net/demos/plugins/rename-plugins-folder">https://wpdemo.net/</a>


== Installation ==

1. Upload the entire `rename-plugins-folder` folder to the `/wp-content/plugins/` directory or install it using the usual installation button in the Plugins administration page.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. After successful activation you will be automatically redirected to the plugin global settings page.
4. All done. Good job!



== Screenshots ==

1. Inspecting elements you should see the new plugins folder name
2. Plugins settings in Plugins => Rename Plugins Folder


== Changelog ==

= 0.0.1 =
* First release
