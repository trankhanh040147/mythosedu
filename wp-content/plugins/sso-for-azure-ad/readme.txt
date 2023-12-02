=== SSO for Azure AD ===
Contributors: qlcvea
Tags: sso, oauth, azure-ad
Requires at least: 4.7.0
Tested up to: 6.1
Stable tag: trunk
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enable Single Sign On with Azure AD on your site.

== Description ==

This plugin allows users to authenticate to a site with an Azure AD account using OAuth.

This plugin requires an app registration in the Azure AD portal.

**Warning**: guest users and users created with a linked Microsoft account may lead to strange behavior. See the "How are AD users matched to site users?" FAQ for more information.

Not affiliated with or approved by Microsoft.

== Installation ==

After installing the plugin, an application must be created in Azure AD to allow for authentication.

1. In the plugin's settings (Settings -> SSO for Azure AD), make a note of the Redirect URL displayed in the "Endpoints" section.
2. In the Azure AD admin panel for your directory, select "New registration".
3. Enter a name. This will be visible to users.  
    Note: unless you know you need to change this option, leave "Supported account types" set to "Accounts in this organizational directory only".
4. Under "Redirect URI", select "Web" and enter the Redirect URL that you copied earlier.  
    If the "URL may not contain a query string" error appears, please see the dedicated FAQ entry for that error.
5. Select "Register".
6. Make a note of the "Application (client ID)" and the "Directory (tenant) ID".
7. Select "Certificates & secrets".
8. Select "New client secret"
9. Enter a description and select an expiration, then select "Add".
    Note: if you select any option other than "Never", do not forget to create a new client secret and change it in the plugin settings before the current one expires!
10. Make a note of the client secret.
11. In the plugin's settings, enter the values noted down earlier in the corresponding fields and save your changes.

== Frequently Asked Questions ==

= Why is the "Login with Azure AD" button not visible on my site's login page? =

The login button will not be displayed until the plugin has been fully configured.

Make sure that the following options are configured and valid inside the plugin's settings (Settings -> SSO for Azure AD):
1. Application (client) ID
2. Client secret
3. Directory (tenant) ID

= How are AD users matched to site users? =

The plugin will look for a user whose email address is the same as their email address on Azure AD.

For example, when the user who logs in to Azure AD by entering `user@example.com` logs in to the site, the plugin will look for a user with the email address `user@example.com`.

**Warning**: guest users and users created with a linked Microsoft account may have a different format. For example, `user@guestexample.com` may become `user_guestexample.com#EXT#@example.onmicrosoft.com`. (In some situations, the `#` characters may be removed.)

= What happens when an AD user who does not have an account on the site attempts to log in? =

The behavior for this case is configurable.

In the "Login options" section of the plugin's settings (Settings -> SSO for Azure AD), there is an option named "Create new users if they don't already exist".

If it is enabled, when a user logs in and the plugin cannot find the corresponding site user, a new one will be created with the same role as the site default for new signups.

The plugin can also automatically fill the user's name on the new account by enabling the "Generate user profiles automatically" option.

The plugin will set the user's username to be their email address.  
Alternatively, the email address can be removed (`user@example.com` -> `user`) by enabling the "Create usernames without domain name" option.  
**Warning**: if multiple users have the same name but different domain names (`user@1.example.com` and `user@2.example.com`) enabling this option may cause conflicts.

If it is disabled, when a user logs in and the plugin cannot find the corresponding site user, the following error message will be displayed: "Your account has not been registered on this site. Please contact your administrator."

= How can I add the site administration panel to the Azure application list? =

To add the site administration panel to the Azure application list, copy the "Homepage/Login URL" displayed in the "Endpoints" section of the plugin's settings (Settings -> SSO for Azure AD).

This URL must be pasted in the "Home page URL" field in the "Branding" section of your app registration on the Azure AD portal.

= Error while setting up on Azure AD: "URL may not contain a query string" =

In some cases, Azure may reject the callback URL provided by the plugin with the error "URL may not contain a query string".

In this case, URL rewrites are required. In the plugin settings page, enable "Use rewrites" and save.

The callback and login/homepage URLs listed in the plugin settings will change. These new URLs do not contain a query string and should therefore work.

**Warning**: if you had previously referenced the callback URL with a query string, those references must be changed to the new value displayed in the plugin settings.

== Changelog ==

= 1.0.0 =
First release

= 1.1.0 =
- Added support for URL rewrites
- The plugin now receives less data from Microsoft APIs (only the user's email address)
- The plugin source now contains internationalization comments

= 2.0.0 =
- **Breaking change**: The plugin now matches users based on email address and not UPN
- "Scope" setting has been removed (the plugin now uses the Microsoft Graph API exclusively)
- Account creation can now automatically fill the user's name from their Azure AD profile
- Account creation can now create usernames without the email domain
- Other minor changes

= 2.1.0 =
- The plugin will now automatically convert callback URLs to HTTPS regardless of the site's URL scheme, except if the hostname is "localhost" or "127.0.0.1".

== Upgrade Notice ==

= 1.0.0 =
First release

= 2.0.0 =
**Breaking change**: The plugin now matches users based on email address and not UPN