/**
 * DriveEase — Internationalisation (i18n)
 *
 * Translation dictionary (EN / HY) and language-switching logic.
 * Persists the chosen language in localStorage key `de_lang`.
 *
 * @package DriveEase
 * @since   1.0.0
 */

'use strict';

/* global DriveEase */

/**
 * Translation dictionary — 150+ keys, English and Armenian.
 *
 * @type {Object.<string, Object.<string, string>>}
 */
const DriveEaseI18n = ( function () {

	const T = {
		en: {
			/* ── Navigation ── */
			nav_home:       'Home',
			nav_fleet:      'Fleet',
			nav_services:   'Services',
			nav_how:        'How It Works',
			nav_reviews:    'Reviews',
			nav_contact:    'Contact',

			/* ── Buttons ── */
			btn_book:       'Book Now',
			btn_reserve:    'Reserve',
			btn_search:     'Search',
			btn_continue:   'Continue',
			btn_confirm:    'Confirm Booking',
			btn_done:       'Done',
			btn_reserve_car:'Reserve This Car',

			/* ── Hero ── */
			hero_badge:     '#1 Rated Car Rental Service',
			hero_title:     'Find Your Perfect <span>Ride</span> for Any Journey',
			hero_sub:       'Premium vehicles, unbeatable rates, and seamless booking \u2014 wherever your destination takes you.',

			/* ── Search widget ── */
			widget_title:   'Search Available Cars',
			label_pickup:   'Pick-Up Location',
			label_dropoff:  'Drop-Off Location',
			label_pickdate: 'Pick-Up Date',
			label_dropdate: 'Drop-Off Date',

			/* ── Fleet filters ── */
			filter_all:     'All',
			filter_economy: 'Economy',
			filter_sedan:   'Sedan',
			filter_suv:     'SUV',
			filter_luxury:  'Luxury',
			filter_compact: 'Compact',
			filter_minivan: 'Minivan',

			/* ── Fleet section ── */
			fleet_label:    'Our Vehicles',
			fleet_title:    'Choose Your Vehicle',

			/* ── Why DriveEase ── */
			why_label:      'Why DriveEase',
			why_title:      'Everything You Need,<br>Nothing You Don\'t',
			why1_title:     'Free Cancellation',
			why1_desc:      'Plans change. Cancel up to 24 hours before pick-up at no cost, no questions asked.',
			why2_title:     '24/7 Support',
			why2_desc:      'Our team is available around the clock via phone, chat, or email whenever you need us.',
			why3_title:     'GPS Included',
			why3_desc:      'Every vehicle comes equipped with a built-in GPS navigation system at no extra charge.',
			why4_title:     'Full Insurance',
			why4_desc:      'Comprehensive insurance coverage included with every rental \u2014 drive with complete peace of mind.',

			/* ── How it works ── */
			how_label:      'Simple Process',
			how_title:      'On the Road in 3 Steps',
			how1_title:     'Search',
			how1_desc:      'Enter your pick-up location, dates, and preferred vehicle class to browse availability.',
			how2_title:     'Book',
			how2_desc:      'Select your car, add any extras, and confirm your booking in under two minutes.',
			how3_title:     'Drive',
			how3_desc:      'Pick up the keys at your chosen branch and hit the road \u2014 it\'s that simple.',

			/* ── Reviews ── */
			rev_label:      'Customer Reviews',
			rev_title:      'What Our Customers Say',

			/* ── Footer ── */
			footer_about:   'Premium car rental services for every journey. Quality vehicles, transparent pricing, and exceptional support.',
			footer_links:   'Quick Links',
			footer_branches:'Branches',
			footer_contact: 'Contact Us',
			footer_copy:    '\u00a9 2024 DriveEase. All rights reserved.',

			/* ── Booking modal ── */
			modal_title:    'Reserve Your Car',
			modal_step1:    '1. Rental Details',
			modal_step2:    '2. Your Info',
			modal_step3:    '3. Extras & Pay',
			extras_label:   'Optional Extras',
			sum_vehicle:    'Vehicle',
			sum_duration:   'Duration',
			sum_base:       'Vehicle cost',
			sum_extras:     'Extras',
			sum_total:      'Total',
			success_title:  'Booking Confirmed!',
			success_msg:    'Thank you for choosing DriveEase. A summary has been sent to your email.',
			success_note:   'Please bring this reference and your driver\'s licence on pick-up day.',

			/* ── Car detail page ── */
			det_view:       'View Car',
			det_specs:      'Vehicle Specifications',
			det_features:   'Included Features',
			spec_make:      'Make',
			spec_class:     'Class',
			spec_year:      'Year',
			spec_seats:     'Seats',
			spec_trans:     'Transmission',
			spec_fuel:      'Fuel Type',
			spec_boot:      'Boot Space',
			spec_speed:     'Max Speed',
			spec_engine:    'Engine',
			spec_doors:     'Doors',
			feat_bt:        'Bluetooth Audio',
			feat_cam:       'Rear Camera',
			feat_heat:      'Heated Seats',
			feat_cruise:    'Cruise Control',
			feat_climate:   'Climate Control',
			feat_usb:       'USB Charging',
			sidebar_incl:   'GPS & basic insurance included',
			sidebar_cancel: 'Free cancellation up to 24h before pick-up',
			similar_label:  'Similar Vehicles',
			similar_title:  'You Might Also Like',

			/* ── Fleet Archive ── */
			fleet_hero_label: 'Our Fleet',
			fleet_hero_title: 'Find Your Perfect Ride',
			fleet_hero_sub:   'Browse our collection of premium vehicles for every occasion.',

			/* ── My Bookings ── */
			mybookings_label: 'Dashboard',
			mybookings_title: 'My Bookings',
			mybookings_sub:   'View and manage your reservations.',

			/* ── Reviews ── */
			reviews_title:      'Customer Reviews',
			review_form_title:  'Write a Review',

			/* ── Branches ── */
			branch_cta_sub: 'Get directions to our branch.',

			/* ── Contact Form ── */
			sending:      'Sending...',
			send_message: 'Send Message',

			/* ── Misc ── */
			seats:          'Seats',
			auto:           'Automatic',
			manual:         'Manual',
			per_day:        '/day',
		},

		hy: {
			/* ── Navigation ── */
			nav_home:       '\u0533\u056c\u056d\u0561\u057e\u0578\u0580',
			nav_fleet:      '\u0531\u057e\u057f\u0578\u057a\u0561\u0580\u056f',
			nav_services:   '\u053e\u0561\u057c\u0561\u0575\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580',
			nav_how:        '\u053b\u0576\u0579\u057a\u0565\u057d \u0531\u0577\u056d\u0561\u057f\u0578\u0582\u0574',
			nav_reviews:    '\u053f\u0561\u0580\u056e\u056b\u0584\u0576\u0565\u0580',
			nav_contact:    '\u053f\u0561\u057a',

			/* ── Buttons ── */
			btn_book:       '\u0531\u0574\u0580\u0561\u0563\u0580\u0565\u056c',
			btn_reserve:    '\u0531\u0574\u0580\u0561\u0563\u0580\u0565\u056c',
			btn_search:     '\u0555\u0580\u0578\u0576\u0565\u056c',
			btn_continue:   '\u0547\u0561\u0580\u0578\u0582\u0576\u0561\u056f\u0565\u056c',
			btn_confirm:    '\u0540\u0561\u057d\u057f\u0561\u057f\u0565\u056c \u0531\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574\u0568',
			btn_done:       '\u054a\u0561\u057f\u0580\u0561\u057d\u057f',
			btn_reserve_car:'\u0531\u0574\u0580\u0561\u0563\u0580\u0565\u056c \u0544\u0565\u0584\u0565\u0576\u0561\u0576',

			/* ── Hero ── */
			hero_badge:     '#1 \u0531\u057e\u057f\u0578\u056f\u0561\u0575\u0561\u0576 \u053e\u0561\u057c\u0561\u0575\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
			hero_title:     '\u0533\u057f\u0565\u0584 \u0571\u0565\u0580 \u056f\u0561\u057f\u0561\u0580\u0575\u0561\u056c <span>\u0544\u0565\u0584\u0565\u0576\u0561\u0576</span> \u0581\u0561\u0576\u056f\u0561\u0581\u0561\u056e \u0573\u0561\u0574\u0583\u0578\u0580\u0564\u0578\u0582\u0569\u0575\u0561\u0576 \u0570\u0561\u0574\u0561\u0580',
			hero_sub:       '\u054a\u0580\u0565\u0574\u056b\u0578\u0582\u0574 \u0574\u0565\u0584\u0565\u0576\u0561\u0576\u0565\u0580, \u0561\u0576\u0570\u0561\u0572\u0569\u0565\u056c\u056b \u0563\u0576\u0565\u0580 \u0587 \u0570\u0561\u0580\u0569 \u0561\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574 \u2014 \u0578\u0582\u0580 \u0567\u056c \u0571\u0565\u0580 \u0573\u0561\u0574\u0583\u0561\u0576 \u057f\u0561\u0576\u056b:',

			/* ── Search widget ── */
			widget_title:   '\u0555\u0580\u0578\u0576\u0565\u056c \u0540\u0561\u057d\u0561\u0576\u0565\u056c\u056b \u0544\u0565\u0584\u0565\u0576\u0561\u0576\u0565\u0580',
			label_pickup:   '\u054e\u0565\u0580\u0581\u0576\u0565\u056c\u0578\u0582 \u054e\u0561\u0575\u0580',
			label_dropoff:  '\u054e\u0565\u0580\u0561\u0564\u0561\u0580\u0571\u056b \u054e\u0561\u0575\u0580',
			label_pickdate: '\u054e\u0565\u0580\u0581\u0576\u0565\u056c\u0578\u0582 \u0531\u0574\u057d\u0561\u0569\u056b\u057e',
			label_dropdate: '\u054e\u0565\u0580\u0561\u0564\u0561\u0580\u0571\u056b \u0531\u0574\u057d\u0561\u0569\u056b\u057e',

			/* ── Fleet filters ── */
			filter_all:     '\u0532\u0578\u056c\u0578\u0580',
			filter_economy: '\u0537\u056f\u0578\u0576\u0578\u0574',
			filter_sedan:   '\u054d\u0565\u0564\u0561\u0576',
			filter_suv:     '\u054b\u056b\u057a',
			filter_luxury:  '\u053c\u0575\u0578\u0582\u0584\u057d',
			filter_compact: '\u053f\u0578\u0574\u057a\u0561\u056f\u057f',
			filter_minivan: '\u0544\u056b\u0576\u056b\u057e\u0565\u0576',

			/* ── Fleet section ── */
			fleet_label:    '\u0544\u0565\u0580 \u0544\u0565\u0584\u0565\u0576\u0561\u0576\u0565\u0580\u0568',
			fleet_title:    '\u0538\u0576\u057f\u0580\u0565\u0584 \u0541\u0565\u0580 \u0544\u0565\u0584\u0565\u0576\u0561\u0576',

			/* ── Why DriveEase ── */
			why_label:      '\u053b\u0576\u0579\u0578\u0582 DriveEase',
			why_title:      '\u0531\u0574\u0565\u0576 \u056b\u0576\u0579, \u056b\u0576\u0579 \u0571\u0565\u0566 \u0570\u0561\u0580\u056f\u0561\u057e\u0578\u0580 \u0567',
			why1_title:     '\u0531\u0576\u057e\u0573\u0561\u0580 \u0549\u0565\u0572\u0561\u0580\u056f\u0578\u0582\u0574',
			why1_desc:      '\u054a\u056c\u0561\u0576\u0576\u0565\u0580\u0576 \u0565\u0576 \u0583\u0578\u056d\u057e\u0578\u0582\u0574: \u0549\u0565\u0572\u0561\u0580\u056f\u0565\u0584 \u0574\u056b\u0576\u0579\u0587 24 \u056a\u0561\u0574 \u0561\u057c\u0561\u057b \u0561\u0576\u057e\u0573\u0561\u0580, \u0561\u057c\u0561\u0576\u0581 \u0570\u0561\u0580\u0581\u0565\u0580\u056b:',
			why2_title:     '24/7 \u0531\u057b\u0561\u056f\u0581\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
			why2_desc:      '\u0544\u0565\u0580 \u0569\u056b\u0574\u0568 \u0570\u0561\u057d\u0561\u0576\u0565\u056c\u056b \u0567 \u0577\u0578\u0582\u0580\u057b\u0585\u0580\u0575\u0561\u055d \u0570\u0565\u057c\u0561\u056d\u0578\u057d\u0578\u057e, \u0579\u0561\u0569\u0578\u057e \u056f\u0561\u0574 \u0567\u056c. \u0583\u0578\u057d\u057f\u0578\u057e:',
			why3_title:     'GPS \u0546\u0565\u0580\u0561\u057c\u057e\u0561\u056e',
			why3_desc:      '\u0545\u0578\u0582\u0580\u0561\u0584\u0561\u0576\u0579\u0575\u0578\u0582\u0580 \u0574\u0565\u0584\u0565\u0576\u0561 \u0570\u0561\u0563\u0565\u0581\u057e\u0561\u056e \u0567 GPS-\u0578\u057e\u055d \u0561\u057c\u0561\u0576\u0581 \u056c\u0580\u0561\u0581\u0578\u0582\u0581\u056b\u0579 \u057e\u0573\u0561\u0580\u056b:',
			why4_title:     '\u0531\u0574\u0562\u0578\u0572\u057b \u0531\u057a\u0561\u0570\u0578\u057e\u0561\u0563\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
			why4_desc:      '\u0531\u0574\u0562\u0578\u0572\u057b\u0561\u056f\u0561\u0576 \u0561\u057a\u0561\u0570\u0578\u057e\u0561\u0563\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576 \u0576\u0565\u0580\u0561\u057c\u057e\u0561\u056e \u0567 \u0575\u0578\u0582\u0580\u0561\u0584\u0561\u0576\u0579\u0575\u0578\u0582\u0580 \u057e\u0561\u0580\u0571\u0578\u0582\u0575\u0569\u056b \u0570\u0565\u057f:',

			/* ── How it works ── */
			how_label:      '\u054a\u0561\u0580\u0566 \u0533\u0578\u0580\u056e\u0568\u0576\u0569\u0561\u0581',
			how_title:      '\u0543\u0561\u0574\u0583\u0561 3 \u0554\u0561\u0575\u056c\u0578\u057e',
			how1_title:     '\u0555\u0580\u0578\u0576\u0565\u056c',
			how1_desc:      '\u0544\u0578\u0582\u057f\u0584\u0561\u0563\u0580\u0565\u0584 \u057e\u0561\u0575\u0580\u0568, \u0561\u0574\u057d\u0561\u0569\u057e\u0565\u0580\u0568 \u0587 \u0568\u0576\u057f\u0580\u0565\u0584 \u0574\u0565\u0584\u0565\u0576\u0561\u0575\u056b \u0564\u0561\u057d\u0568:',
			how2_title:     '\u0531\u0574\u0580\u0561\u0563\u0580\u0565\u056c',
			how2_desc:      '\u0538\u0576\u057f\u0580\u0565\u0584 \u0574\u0565\u0584\u0565\u0576\u0561\u0576, \u0561\u057e\u0565\u056c\u0561\u0581\u0580\u0565\u0584 \u056e\u0561\u057c\u0561\u0575\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580 \u0587 \u0570\u0561\u057d\u057f\u0561\u057f\u0565\u0584 \u0561\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574\u0568:',
			how3_title:     '\u054e\u0561\u0580\u0565\u056c',
			how3_desc:      '\u054e\u0565\u0580\u0581\u0580\u0565\u0584 \u0562\u0561\u0576\u0561\u056c\u056b\u0576\u0565\u0580\u0568 \u0574\u0561\u057d\u0576\u0561\u0573\u0575\u0578\u0582\u0572\u0578\u0582\u0574 \u0587 \u0573\u0561\u0574\u0583\u0561 \u0568\u0576\u056f\u0565\u0584:',

			/* ── Reviews ── */
			rev_label:      '\u0540\u0561\u0573\u0561\u056d\u0578\u0580\u0564\u0576\u0565\u0580\u056b \u053f\u0561\u0580\u056e\u056b\u0584\u0576\u0565\u0580',
			rev_title:      '\u053b\u0576\u0579 \u0535\u0576 \u0531\u057d\u0578\u0582\u0574 \u0544\u0565\u0580 \u0540\u0561\u0573\u0561\u056d\u0578\u0580\u0564\u0576\u0565\u0580\u0568',

			/* ── Footer ── */
			footer_about:   '\u054a\u0580\u0565\u0574\u056b\u0578\u0582\u0574 \u0561\u057e\u057f\u0578\u057e\u0561\u0580\u0571\u0578\u0582\u0575\u0569 \u0561\u0574\u0565\u0576 \u0573\u0561\u0574\u0583\u0578\u0580\u0564\u0578\u0582\u0569\u0575\u0561\u0576 \u0570\u0561\u0574\u0561\u0580: \u0548\u0580\u0561\u056f\u0575\u0561\u056c \u0574\u0565\u0584\u0565\u0576\u0561\u0576\u0565\u0580, \u0569\u0561\u0583\u0561\u0576\u0581\u056b\u056f \u0563\u0576\u0565\u0580:',
			footer_links:   '\u0531\u0580\u0561\u0563 \u0540\u0572\u0578\u0582\u0574\u0576\u0565\u0580',
			footer_branches:'\u0544\u0561\u057d\u0576\u0561\u0573\u0575\u0578\u0582\u0572\u0565\u0580',
			footer_contact: '\u053f\u0561\u057a \u0574\u0565\u0566 \u0570\u0565\u057f',
			footer_copy:    '\u00a9 2024 DriveEase: \u0532\u0578\u056c\u0578\u0580 \u056b\u0580\u0561\u057e\u0578\u0582\u0576\u0584\u0576\u0565\u0580\u0568 \u057a\u0561\u0577\u057f\u057a\u0561\u0576\u057e\u0561\u056e \u0565\u0576:',

			/* ── Booking modal ── */
			modal_title:    '\u0531\u0574\u0580\u0561\u0563\u0580\u0565\u056c \u0544\u0565\u0584\u0565\u0576\u0561',
			modal_step1:    '1. \u054e\u0561\u0580\u0571\u0578\u0582\u0575\u0569\u056b \u0544\u0561\u0576\u0580\u0561\u0574\u0561\u057d\u0576\u0565\u0580',
			modal_step2:    '2. \u0541\u0565\u0580 \u054f\u057e\u0575\u0561\u056c\u0576\u0565\u0580\u0568',
			modal_step3:    '3. \u0540\u0561\u057e\u0565\u056c\u0575\u0561\u056c & \u054e\u0573\u0561\u0580',
			extras_label:   '\u0540\u0561\u057e\u0565\u056c\u0575\u0561\u056c \u053e\u0561\u057c\u0561\u0575\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580',
			sum_vehicle:    '\u0544\u0565\u0584\u0565\u0576\u0561',
			sum_duration:   '\u054f\u0587\u0578\u0572\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
			sum_base:       '\u0544\u0565\u0584\u0565\u0576\u0561\u0575\u056b \u0561\u0580\u056a\u0565\u0584',
			sum_extras:     '\u0540\u0561\u057e\u0565\u056c\u0575\u0561\u056c',
			sum_total:      '\u0538\u0576\u0564\u0561\u0574\u0565\u0576\u0568',
			success_title:  '\u0531\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574\u0568 \u0540\u0561\u057d\u057f\u0561\u057f\u057e\u0561\u056e \u0567!',
			success_msg:    '\u0547\u0576\u0578\u0580\u0570\u0561\u056f\u0561\u056c\u0578\u0582\u0569\u0575\u0578\u0582\u0576 DriveEase \u0568\u0576\u057f\u0580\u0565\u056c\u0578\u0582 \u0570\u0561\u0574\u0561\u0580: \u0531\u0574\u0583\u0578\u0583\u0578\u0582\u0574\u0576 \u0578\u0582\u0572\u0561\u0580\u056f\u057e\u0565\u056c \u0567 \u0571\u0565\u0580 \u0567\u056c. \u0583\u0578\u057d\u057f\u056b\u0576:',
			success_note:   '\u053d\u0576\u0564\u0580\u0578\u0582\u0574 \u0565\u0576\u0584 \u0571\u0565\u0566 \u0570\u0565\u057f \u0562\u0565\u0580\u0565\u056c \u0561\u0575\u057d \u056f\u0578\u0564\u0568 \u0587 \u057e\u0561\u0580\u0578\u0580\u0564\u0561\u056f\u0561\u0576 \u056b\u0580\u0561\u057e\u0578\u0582\u0576\u0584\u0568:',

			/* ── Car detail page ── */
			det_view:       '\u0534\u056b\u057f\u0565\u056c',
			det_specs:      '\u0532\u0576\u0578\u0582\u0569\u0561\u0563\u0580\u0565\u0580',
			det_features:   '\u0546\u0565\u0580\u0561\u057c\u057e\u0561\u056e \u0540\u0561\u057f\u056f\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580',
			spec_make:      '\u0531\u0580\u057f\u0561\u0564\u0580\u0578\u0572',
			spec_class:     '\u053f\u0561\u0580\u0563',
			spec_year:      '\u054f\u0561\u0580\u056b',
			spec_seats:     '\u0546\u057d\u057f\u0561\u057f\u0565\u0572',
			spec_trans:     '\u0553\u0578\u056d\u0561\u0576\u0581\u0561\u057f\u0578\u0582\u0583',
			spec_fuel:      '\u054e\u0561\u057c\u0565\u056c\u056b\u0584',
			spec_boot:      '\u0532\u0565\u057c\u0576\u0561\u056d\u0578\u0582\u0581',
			spec_speed:     '\u0531\u0580\u0561\u0563. \u0531\u0580\u0561\u0563.',
			spec_engine:    '\u0547\u0561\u0580\u056a\u056b\u0579',
			spec_doors:     '\u0534\u057c\u0576\u0565\u0580',
			feat_bt:        'Bluetooth',
			feat_cam:       '\u0540\u0565\u057f\u0587\u056b \u054f\u0565\u057d\u0561\u056d\u0581\u056b\u056f',
			feat_heat:      '\u054f\u0561\u0584\u0561\u0581\u057e\u0578\u0572 \u0546\u057d\u057f.',
			feat_cruise:    '\u053f\u0561\u0575\u0578\u0582\u0576 \u0531\u0580\u0561\u0563.',
			feat_climate:   '\u053f\u056c\u056b\u0574\u0561\u0575. \u053f\u0561\u057c.',
			feat_usb:       'USB \u053c\u056b\u0581\u0584\u0561\u0582.',
			sidebar_incl:   'GPS-\u0576 \u0578\u0582 \u0570\u056b\u0574. \u0561\u057a. \u0576\u0565\u0580\u0561\u057c.',
			sidebar_cancel: '\u0531\u0576\u057e\u0573\u0561\u0580 \u0579\u0565\u0572. \u0574\u056b\u0576\u0579 24\u056a',
			similar_label:  '\u0546\u0574\u0561\u0576 \u0544\u0565\u0584\u0565\u0576\u0561\u0576\u0565\u0580',
			similar_title:  '\u053f\u0561\u0580\u0578\u0572 \u0535\u0584 \u0546\u0561\u0587 \u0538\u0576\u057f\u0580\u0565\u056c',

			/* ── Fleet Archive ── */
			fleet_hero_label: '\u0544\u0565\u0580 \u0531\u057e\u057f\u0578\u057a\u0561\u0580\u056f\u0568',
			fleet_hero_title: '\u0533\u057f\u0565\u0584 \u0541\u0565\u0580 \u053f\u0561\u057f\u0561\u0580\u0575\u0561\u056c \u0544\u0565\u0584\u0565\u0576\u0561\u0576',
			fleet_hero_sub:   '\u0536\u0576\u0576\u0565\u0584 \u0574\u0565\u0580 \u057a\u0580\u0565\u0574\u056b\u0578\u0582\u0574 \u0574\u0565\u0584\u0565\u0576\u0561\u0576\u0565\u0580\u056b \u0570\u0561\u057e\u0561\u0584\u0561\u056e\u0578\u0582\u0576:',

			/* ── My Bookings ── */
			mybookings_label: '\u053f\u0561\u057c\u0561\u057e\u0561\u0580\u0574\u0561\u0576 \u057e\u0561\u0570\u0561\u0576\u0561\u056f',
			mybookings_title: '\u053b\u0574 \u0531\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574\u0576\u0565\u0580\u0568',
			mybookings_sub:   '\u0534\u056b\u057f\u0565\u0584 \u0587 \u056f\u0561\u057c\u0561\u057e\u0561\u0580\u0565\u0584 \u0571\u0565\u0580 \u0561\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574\u0576\u0565\u0580\u0568:',

			/* ── Reviews ── */
			reviews_title:      '\u0540\u0561\u0573\u0561\u056d\u0578\u0580\u0564\u0576\u0565\u0580\u056b \u053f\u0561\u0580\u056e\u056b\u0584\u0576\u0565\u0580',
			review_form_title:  '\u0533\u0580\u0565\u0584 \u053f\u0561\u0580\u056e\u056b\u0584',

			/* ── Branches ── */
			branch_cta_sub: '\u054d\u057f\u0561\u0581\u0565\u0584 \u0578\u0582\u0572\u0572\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580 \u0574\u0565\u0580 \u0574\u0561\u057d\u0576\u0561\u0573\u0575\u0578\u0582\u0572:',

			/* ── Contact Form ── */
			sending:      '\u054a\u0578\u0582\u0572\u0561\u0580\u056f\u057e\u0578\u0582\u0574 \u0567...',
			send_message: '\u054a\u0578\u0582\u0572\u0561\u0580\u056f\u0565\u056c \u0540\u0561\u0572\u0578\u0580\u0564\u0561\u0563\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576',

			/* ── Misc ── */
			seats:          '\u0546\u057d\u057f\u0561\u057f\u0565\u0572',
			auto:           '\u0531\u057e\u057f\u0578\u0574\u0561\u057f',
			manual:         '\u0544\u0565\u056d\u0561\u0576\u056b\u056f\u0561\u056f\u0561\u0576',
			per_day:        '/\u0585\u0580',
		},
	};

	/** Currently active language code. */
	let lang = localStorage.getItem( 'de_lang' ) || 'en';

	/**
	 * Return the full dictionary for a given language.
	 *
	 * @param {string} [l] Language code (defaults to current).
	 * @return {Object.<string, string>}
	 */
	function dict( l ) {
		return T[ l || lang ] || T.en;
	}

	/**
	 * Look up a single translation key.
	 *
	 * @param {string} key  Translation key.
	 * @param {string} [l]  Language code (defaults to current).
	 * @return {string}
	 */
	function t( key, l ) {
		const d = dict( l );
		return d[ key ] !== undefined ? d[ key ] : key;
	}

	/**
	 * Switch the active language, persist to localStorage,
	 * and update every element carrying a `data-i18n` attribute.
	 *
	 * @param {string} l Language code ('en' | 'hy').
	 */
	function setLang( l ) {
		lang = l;
		localStorage.setItem( 'de_lang', l );

		document.querySelectorAll( '[data-i18n]' ).forEach( function ( el ) {
			var k = el.dataset.i18n;
			if ( T[ l ] && T[ l ][ k ] !== undefined ) {
				el.innerHTML = T[ l ][ k ];
			}
		} );

		document.querySelectorAll( '.lang-btn, [data-lang]' ).forEach( function ( btn ) {
			btn.classList.toggle( 'active', btn.dataset.lang === l );
		} );

		/* Let other modules react (e.g. booking summary refresh). */
		if ( typeof window.updateSummary === 'function' ) {
			window.updateSummary();
		}
		if ( typeof window.updateSidebar === 'function' ) {
			window.updateSidebar();
		}
	}

	/**
	 * Return the current language code.
	 *
	 * @return {string}
	 */
	function getLang() {
		return lang;
	}

	/* ── Public API ── */
	window.setLang = setLang;

	return {
		T:       T,
		dict:    dict,
		t:       t,
		setLang: setLang,
		getLang: getLang,
	};

} )();
