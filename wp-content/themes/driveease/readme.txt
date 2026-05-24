=== DriveEase ===

Contributors: vagra
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A car rental booking theme with multi-language and multi-currency support, featuring a 3-step booking wizard, fleet showcase, and branch locator.

== Description ==

DriveEase is a modern WordPress theme designed for car rental businesses. It provides everything needed to showcase a vehicle fleet, accept bookings, and manage rental operations.

**Features:**

* 3-step booking wizard modal (vehicle selection, customer details, confirmation)
* Fleet archive with category filtering and grid layout
* Single vehicle detail page with image gallery and specifications
* Multi-language support (English and Armenian) with client-side i18n
* Multi-currency support (USD, EUR, AMD) with live price conversion
* Branch locator with dedicated CPT
* Email notification system for booking confirmations
* One-click demo content import
* Responsive design optimized for all devices
* Custom post types for cars, bookings, and branches

== Installation ==

1. In your WordPress admin panel, go to Appearance > Themes and click "Add New".
2. Click "Upload Theme" and choose the driveease.zip file.
3. Click "Install Now" and then "Activate".
4. Navigate to Appearance > Menus to set up your Primary and Footer menus.
5. Use the DriveEase > Import Demo tool to load sample cars, branches, and menus.
6. Configure your site title and logo under Appearance > Customize.

== Frequently Asked Questions ==

= How do I add new vehicles? =

Go to DriveEase > Cars > Add New in your WordPress admin. Fill in the title, description, featured image, and use the Car Details meta box to set price, seats, doors, transmission, fuel type, and engine specifications.

= How does the booking system work? =

Customers use the "Book Now" button to open a 3-step wizard: select dates and locations, enter personal details, then confirm. Bookings are saved as a custom post type and email notifications are sent to both the admin and customer.

= Can I change the available currencies? =

The theme supports USD, EUR, and AMD out of the box. Currency conversion rates and display are managed in `assets/js/currency.js`.

= Is this theme translation-ready? =

Yes. All user-facing strings use WordPress i18n functions with the 'driveease' text domain. A POT file is included in the languages directory for creating translations.

= How do I set up branches? =

Go to DriveEase > Branches > Add New. Each branch appears in the footer "Our Branches" section and can serve as a pickup/drop-off location in the booking form.

== Changelog ==

= 1.0.0 =
* Initial release
* 3-step booking wizard with AJAX form submission
* Fleet archive and single car detail templates
* Multi-language support (EN/HY)
* Multi-currency support (USD/EUR/AMD)
* Branch management custom post type
* Email notification system for bookings
* One-click demo content import
* Responsive dark navbar with backdrop blur
* Admin dashboard with car and booking management

== Credits ==

* Theme developed by vagra.ai (https://vagra.ai)
* Built on WordPress theme development best practices

== Resources ==

* Inter font - Copyright 2020 The Inter Project Authors (https://github.com/rsms/inter) - Licensed under SIL Open Font License 1.1
* Font Awesome Free 6.5.0 - Copyright Fonticons, Inc. - Licensed under Font Awesome Free License (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT)
* Car placeholder image - Created by theme author, GPLv2 compatible
