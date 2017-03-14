# ChrisBryant - Genesis Custom Child Theme

Github project link: https://github.com/bryantweb/chrisbryant

## Summary
Mostly mobile-first (except for the responsive menu) Genesis Sample Child Theme 2.2.3. CSS styles have been split into SASS partials. Optimization functions have been added to improve speed.

## Installation Instructions

1. Click 'Download ZIP' to download the complete project to your computer.
2. Launch by double-clicking on the 'index.html' file - or - by drag-and-dropping the index.html file onto an open web browser.


## Stylesheets

* Directory Changes
 - added /src/sass sub-folder
 - added /src/scss/genesis sub-folder
 - Default CSS styles divided into SASS Partials (see /src/scss/genesis folder)
 - added /src/scss/style.scss (compiles to root style.css via CodeKit3)
 - Neat 2.0 added via CodeKit3

## Javascript
* No changes to default child theme JS

## Functions

Code and File changes related to php functions.

### Directory Changes
* custom-admin.php added to /lib folder (file with changes that affect the back end only)
* optimize.php added to /lib folder (file with changes that affect the front end only)

#### functions.PHP
 * Enqueued Google Roboto font 300, 400, 500, 700
 * Disabled Genesis WooCommerce default support

#### optimize.PHP

* Disable Emojis JS, CSS, and Feeds (default: active)
* Disable Comment Reply JS (default: active)
* FIX POOR Query Strings Reported by GT Metrix (default: active)
* Clean up WordPress Head (default: active)
* Remove WP Version Numbers (default: active)
* Remove Auto-Generated Markup (default: active)
* Add Browser to Body Class (default: active)

#### customize-admin.PHP
* Add ACF Options Menu and Page (default: active)
* Disable ACF on Frontend (default: inactive)
* Control Who Sees What (default: active)
* Remove Genesis menu link (default: inactive)
* Remove WP LOGO from Top Bar in the backend (default: active)
* Customize Footer Text in the Admin Area (default: active)
* Remove WP Admin Bar (default: active)
* Unregister default Genesis layouts. (default: inactive)
* Unregister default Genesis sidebars. (default: inactive)
* Unregister default Genesis widgets. (default: active)
* Remove Dashboard Meta
* Unregister Widgets
 - Akismet (default: active)
 - Welcome Panel (default: active)
 - Yoast Dashboard Widget (default: inactive)
* Unregister Default WP Widgets

## Sticky Footer
* added .vh-wrap to /src/scss/genesis/_structure-layout.scss
* added stickyfoot_wrap_begin and stickyfoot_wrap_end functions to functions.php

## Neat Grid 2.0 Usage
 * Neat 2.0 added and used on .wrap divs (include content-sidebar-wrap)
 * See the variables.scss partial for Grid settings
 * In this version I haven't quite committed to breakpoints / grid setup. So if things seem a little buggy - don't be surprised.

###### Syntax Notes

- [x] this is a complete item
- [ ] this is an incomplete item