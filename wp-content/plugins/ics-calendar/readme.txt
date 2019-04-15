=== ICS Calendar ===
Contributors: room34
Donate link: http://room34.com/donation
Tags: calendar, iCal, iCalendar
Requires at least: 4.7
Tested up to: 5.1.0
Requires PHP: 5.6.0
Stable tag: 2.2.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embed a live updating iCal (ICS) feed in any page using a shortcode.

== Description ==

Using a simple shortcode, you can embed any iCalendar subscription feed (ending in .ics) into a page as a monthly calendar grid.

This plugin includes the PHP ICS Parser library by Jonathan Goode, John Grogg and Martin Thoma (MIT license).

== Installation ==

Once the plugin is installed and activated, use the shortcode below to insert a calendar into your pages. See FAQ for details.

== Frequently Asked Questions ==

__How do I insert a calendar into my page?__

Use this shortcode:

`[ics_calendar url="ICAL_SUBSCRIBE_URL"]`

Be sure you are using the _subscribe_ URL (i.e. for importing into a calendar program), not the URL for viewing a calendar in a web browser.

Additional customization options can be found in WordPress admin under __Settings > ICS Calendar__.

If you are using the Classic Editor, you can also use the __Add ICS Calendar__ button to build the customized shortcode automatically from a set of options.

__Why isn't my calendar loading?__

This may be due to your server's configuration. This plugin requires either the PHP cURL extensions, or the `allow_url_fopen` PHP setting to be turned on. Check your PHP configuration or your server administrator if you think this may be the issue.

__Why isn't my calendar updating?__

For performance, this plugin uses WordPress transients to limit the number of times the ICS feed is loaded from the source. If you have updated events that are not showing up in your page, you can force the plugin to reload the ICS feed every time by adding `reload="1"` to the shortcode. Be sure to remove this when you no longer need to force reload.

== Screenshots ==

== Changelog ==

= 2.2.1.1 =

* Added workaround to issue where an Outlook ICS URL might return a "Found" HTML link instead of an actual ICS feed.
* Added code for Block Editor (coming in version 3.0 -- not yet functional).

= 2.2.1 =

* Added `toggle` attribute to allow for event description/location display to be toggled on/off by clicking an event title.

= 2.2.0.1 =

* Removed `phone_only` class from location information in list view.

= 2.2.0 =

* Modified transients to store parsed data instead of raw data, to improve performance for feeds with a large number of events.

= 2.1.4 =

* Fixed grid layout issues in month view if site's Week Starts On value is set to a day other than Sunday.

= 2.1.3 =

* Fixed bug introduced in version 2.1.0 that prevented list view from displaying properly.

= 2.1.2 =

* Restructured logic for empty calendars so grid still displays when there are no events in a given period on month and current week views.

= 2.1.1 =

* Added "current week" as option in Add ICS Calendar editor button pop-up (Classic Editor only).
* Fixed ampersand entities and escape backslashes in readme file.
* Additional improvements to admin help page.

= 2.1.0 =

* Cleaned up FAQs.
* Added new URL retrieval function that tries cURL and then falls back on file\_get\_contents.
* Added full currentweek template with previous/this/next week selector. Deprecated __currentweek__ option in favor of `view="currentweek"`.
* Added admin notice if __allow\_url\_fopen__ is off and cURL is unavailable.
* Added error handling if no ICS data was retrieved.
* Improved layout of admin help page.
* Minor refactoring.

= 2.0.5 =

* Added __currentweek__ option to display just the current calendar week in the month grid style.

= 2.0.4 =

(No updates -- checked in new version number to correct issue with previous checkin.)

= 2.0.3 =

* Added object property for current plugin version.
* Added current plugin version variable to enqueue stylesheet.

= 2.0.2 =

* Updated ICS loading to allow URLs using the __webcal://__ protocol. (Plugin automatically converts to __https://__.) Also updated instructions page to make it clearer that ICS URLs may not always have the __.ics__ filename extension.
* Updated CSS to allow any element to use the __.phone_only__ class, not just <span> tags. (Mainly affects the display of event descriptions in month view.)
* Fixed issues with relative text sizes of various elements in month view.

__Note:__ If your site was relying on the previous functionality, you can override the hidden __.phone_only__ class by adding the following line of code in __Appearance > Customizer > Additional CSS__:

__.ics-calendar .phone_only { display: initial; }__

= 2.0.1 =

* Fixed issue where events would not appear in the calendar if the ICS feed entry does not contain a DTEND value.

= 2.0.0 =

* Added __Add ICS Calendar__ button to editor with visual tools for inserting shortcode into page. Notes: 1) Currently works only with Classic Editor plugin or in WordPress versions before 5.0. 2) Admin interface not yet translated for internationalization, although the output on the page will be translated as usual.

= 1.5.8 =

* Fixed an issue with some recurring all-day events not displaying as all-day after the initial instance.

= 1.5.7 =

* Added location display option.
* Refactored some variables.
* Added support for additional field display on all-day events.

= 1.5.6 =

* Added user\_agent string before retrieving the ICS calendar feed, to address an issue where some sites such as Airbnb might return a 403 Forbidden error.

= 1.5.5 =

* i18n: Added Finnish, Italian, Norwegian and Swedish translations. (Machine translations; may need some work. Please contact us with suggestions for improvement.)

= 1.5.4 =

* Added description display to month view on phone breakpoint.
* CSS text formatting adjustments (improved text scaling on phones; removed letter-spacing).

= 1.5.3 =

* i18n: Fixed bug that caused day/date in list view to always display in English.
* Added __showendtimes__ option to always display the end time instead of only displaying on hover.
* Added __eventdesc__ option to show event descriptions, with an optional word count limit.

= 1.5.2 =

* i18n: Added Chinese (Simplified), Dutch, Greek, Hungarian and Japanese translations.

= 1.5.1 =

* Modified list view to only show events on or after the current date. (Previously showed all events for the current month, including past dates.)

= 1.5.0 =

* Added list view with related options.
* Added option to hide times.
* Modified display of non-"all day" events that span across multiple days for clarity.
* Fixed issue with times displaying in GMT if ICS file is missing time zone offset information.
* Fixed bug with title="none" and description="none" options.
* Added a workaround for an unresolved issue that may cause All-Day events to appear between 9 AM and 10 AM instead of at beginning of day.
* Updated transient to cache raw ICS file data instead of processed data; allowing modification of output without needing to force a reload of the ICS file from the server.

= 1.4.1 =

* Fixed translations that were not appearing properly.
* Fixed bug in translation string format for multi-day events with start and end times.

= 1.4.0 =

* Refactored calendar loop to include months between the first and last month in the feed that do not have any events.
* Replaced all calls to default PHP date() function with WordPress date\_i18n() function to ensure proper formatting.
* Added WordPress current\_time() function to determination of today's date to avoid time zone issues around midnight.
* Fixed missing HTML tag when a feed returns no events.
* Added ability to hide title and/or description with __title="none"__ or __description="none"__ in shortcode.
* Added plugin icon.

= 1.3.0 =

* Added full i18n support.
* Added these translations: German, English (Australia), English (United States), Spanish (Mexico), French, Portuguese (Brazil). (Note: All languages are machine-translated. Please contact us if you would like to assist in our translation efforts!)

= 1.2.1 =

* Added support for multi-day events. (Thanks to Henry Brink for identifying this issue and proposing a solution.)

= 1.2.0.1 =

* Updated readme file for clarity.

= 1.2.0 =

* Fixed time zone error that was overcompensating for site's offset from GMT. (The included third-party ICS Parser library apparently double-applies the time zone offset when time zone data is present in individual events.)
* Added support for WordPress "Week Starts On" setting.
* Moved events' end time from direct display into tooltip on hover over start time, for cleaner appearance.
* Inserted <wbr> tag after any slashes in event label output, to prevent run-on lines overflowing table cells.
* Added date limit to avoid memory issues with very large calendars. Currently hardcoded to 365 days, but will be a configurable option in version 2.0.
* Added partial support for translations. Full language support coming in version 2.0.

= 1.1.4 =

* Added missing CSS class to display day of week in grid on phone layout only.

= 1.1.3 =

* Added support for localized time format.
* Removed debugging code that would display for administrators in version 1.1.2.

= 1.1.2 =

* Ran composer update to fix missing dependencies in ics-parser library.
* Removed recurrence handling code that was no longer needed with ics-parser library updates.

= 1.1.1 =

* Added handling for all-day events.
* Added handling of multiple events with same start date/time.
* Fixed start/end time bug affecting feeds that don't include the time zone in every event.
* CSS improvements.
* Updated ics-parser library to version 2.1.4.

= 1.1.0 =

* Added explicit cell widths to CSS.
* Added donation option to admin page.
* * Fixed bug that would cause all event end times to be 12:00am.
* Removed unnecessary use of .siblings() jQuery method on month select dropdown.

= 1.0.1 =

* Added handling for empty calendars.
* Updated "Tested up to" version.

= 1.0.0 =

* Initial release version.
