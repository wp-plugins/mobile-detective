=== Plugin Name ===
Contributors: mln141
Donate link: http://wpplugins.ml
Tags: access, cms, permission, restrictions, user, protection, mobile, tablet, desktop, information
Requires at least: 4.2
Tested up to: 4.3
Stable tag: trunk

This plugin is used to detect information about the device used by the user.

== Description ==
"Mobile Detective" plugin was to help webmasters determine types of visitors' devices.
And according to the device type show actual information or redirect to a proper url.

The plugin not only detects more than 150 different device types. Not only PC/tablet/phone or OS but also a
wide range of vendors.

This plugin allows to combine different types using logical operations (OR, AND, NOT)

More info at http://wpplugins.ml/mobile-detective

== Installation ==
1. Upload `Mobile Detective` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In plugin settings (Admins menu “Settings”->”Mobile Detective”) you can edit groups:
	Groups allow to join several filters using logical OR operations. E.g. you can create a group
	"mobile_devices" as isMobile (is a phone) OR isTablet. Later you can use this group to determine
	PC using wit NOT operator (!mobile_devices).
4. Place plugin short code on the pages you want to protect.
	You can insert plugin’s short code in any place of you page. You can place:
	•	[MobDetective params]
	•	[MobDetective params] Text to display on success[/MobDetective]
	
	Possible params:
	* Filters' names: isMobile, isTablet ... - filters Full list of possible filters http://wpplugins.ml/wp-content/plugins/MobileDetective/filters.txt
    * Groups' names: Group_name1, Group_name2... 
    * Fail message: output="Text to display on fail" - optional parameter. By default "Failed "+filter/group name will be printed
    * Redirect: redirect="http://..." - optional parameter to redirect on fail

	
== Screenshots ==
1. Screen shot of plugin options (menu “Settings”->”Mobile Detective”) screenshot-1.jpg
2. Page content with different filters combinations (edit mode)
3. Page content with different filters combinations (presentation)
