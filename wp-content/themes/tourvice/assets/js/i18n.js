/**
 * TourVice — Internationalisation (i18n)
 *
 * Translation dictionary (EN / HY) and language-switching logic.
 * Persists the chosen language in localStorage key `tv_lang`.
 *
 * @package TourVice
 * @since   1.0.0
 */

'use strict';

var TourviceI18n = ( function () {

  var T = {
    en: {
      /* -- Navigation -- */
      nav_home:          'Home',
      nav_tours:         'Tours',
      nav_contact:       'Contact',

      /* -- Buttons -- */
      btn_book_tour:     'Book Tour',
      btn_browse_tours:  'Browse Tours',
      btn_view_tour:     'View Tour',
      btn_back:          'Back',
      btn_confirm:       'Confirm Booking',
      btn_done:          'Done',
      btn_subscribe:     'Subscribe',
      btn_send_message:  'Send Message',
      btn_join:          'Join',

      /* -- Hero -- */
      hero_title:        'Discover Armenia',
      hero_subtitle:     'Unforgettable luxury experiences in the heart of the Caucasus',

      /* -- Stats -- */
      stat_destinations: 'Destinations',
      stat_travelers:    'Happy Travelers',
      stat_rating:       'Rating',

      /* -- Featured Tours -- */
      section_featured:       'Featured Tours',
      section_featured_label: 'Curated for you',
      section_featured_desc:  'Handpicked destinations for unforgettable experiences',

      /* -- Group Discounts -- */
      section_discounts:       'Group Discounts',
      section_discounts_label: 'Save more together',
      section_discounts_desc:  'Exclusive pricing for group bookings',
      discount_best_value:     'Best Value',

      /* -- Testimonials -- */
      section_testimonials:       'Guest Testimonials',
      section_testimonials_label: 'Real stories',
      section_testimonials_desc:  'Stories from happy travelers',

      /* -- Newsletter -- */
      section_newsletter:       'Stay Updated',
      section_newsletter_desc:  'Get exclusive deals and travel inspiration delivered to your inbox',
      newsletter_placeholder:   'Your email address',
      newsletter_success:       'Thank you! Check your email for exclusive offers.',

      /* -- Tour details -- */
      tour_duration:     'Duration',
      tour_group:        'Group Size',
      tour_rating:       'Rating',
      tour_price:        'Base Price',
      tour_overview:     'Overview',
      tour_highlights:   'Highlights',
      tour_itinerary:    'Itinerary',

      /* -- Booking -- */
      booking_title:     'Book Now',
      booking_name:      'Full Name',
      booking_email:     'Email',
      booking_phone:     'Phone',
      booking_date:      'Travel Date',
      booking_requests:  'Special Requests (optional)',
      booking_for:       'Booking for',
      booking_success:   'Booking Requested!',
      booking_success_msg: 'We\'ll reach out within 24 hours to confirm your trip.',
      booking_per_person: 'Price per person',
      booking_total:     'Total',

      /* -- Archive -- */
      archive_title:     'Explore Tours',
      archive_search:    'Search tours...',
      archive_search_placeholder: 'Search tours...',
      archive_filter:    'Location:',
      archive_filter_location: 'Location:',
      archive_all:       'All',
      archive_filter_all: 'All',
      archive_empty:     'No tours found. Try different filters.',
      tour_singular:     'tour',
      tour_plural:       'tours',
      found:             'found',

      /* -- Contact -- */
      contact_title:     'Get In Touch',
      contact_desc:      'We\'d love to hear from you',
      contact_form_title:'Send us a Message',
      contact_name:      'Name',
      contact_email:     'Email',
      contact_subject:   'Subject',
      contact_message:   'Message',
      contact_success:   'Message sent successfully! We\'ll reply soon.',

      /* -- Footer -- */
      footer_brand_desc: 'Luxury tourism experiences in the heart of the Caucasus.',
      footer_links:      'Quick Links',
      footer_contact:    'Contact',
      footer_newsletter: 'Newsletter',
      footer_newsletter_desc: 'Subscribe for exclusive deals',
      footer_copy:       '\u00a9 2024 Discover Luxury Tours. All rights reserved.',

      /* -- Chat -- */
      chat_title:        'Tour Assistant',
      chat_subtitle:     'Ask us anything',
      chat_placeholder:  'Type a message...',
      chat_chip_tours:   'Popular tours',
      chat_chip_pricing: 'Pricing info',
      chat_chip_custom:  'Custom itinerary',

      /* -- Misc -- */
      people:            'people',
      per_person:        '/person',
      sending:           'Sending...',
    },

    hy: {
      /* -- Navigation -- */
      nav_home:          '\u0533\u056c\u056d\u0561\u057e\u0578\u0580',
      nav_tours:         '\u054f\u0578\u0582\u0580\u0565\u0580',
      nav_contact:       '\u053f\u0561\u057a',

      /* -- Buttons -- */
      btn_book_tour:     '\u0531\u0574\u0580\u0561\u0563\u0580\u0565\u056c \u054f\u0578\u0582\u0580',
      btn_browse_tours:  '\u0534\u056b\u057f\u0565\u056c \u054f\u0578\u0582\u0580\u0565\u0580\u0568',
      btn_view_tour:     '\u0534\u056b\u057f\u0565\u056c \u054f\u0578\u0582\u0580\u0568',
      btn_back:          '\u0540\u0565\u057f',
      btn_confirm:       '\u0540\u0561\u057d\u057f\u0561\u057f\u0565\u056c',
      btn_done:          '\u054a\u0561\u057f\u0580\u0561\u057d\u057f',
      btn_subscribe:     '\u0532\u0561\u056a\u0561\u0576\u0578\u0580\u0564\u0561\u0563\u0580\u057e\u0565\u056c',
      btn_send_message:  '\u054a\u0578\u0582\u0572\u0561\u0580\u056f\u0565\u056c',
      btn_join:          '\u0544\u056b\u0561\u0576\u0561\u056c',

      /* -- Hero -- */
      hero_title:        '\u0532\u0561\u0581\u0561\u0570\u0561\u0575\u057f\u0565\u0584 \u0540\u0561\u0575\u0561\u057d\u057f\u0561\u0576\u0568',
      hero_subtitle:     '\u0531\u0576\u0574\u0578\u057c\u0561\u0576\u0561\u056c\u056b \u056c\u0575\u0578\u0582\u0584\u057d \u0583\u0578\u0580\u0571\u0561\u057c\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580 \u053f\u0578\u057e\u056f\u0561\u057d\u056b \u057d\u0580\u057f\u0578\u0582\u0574',

      /* -- Stats -- */
      stat_destinations: '\u0546\u057a\u0561\u057f\u0561\u056f\u0561\u056f\u0565\u057f\u0565\u0580',
      stat_travelers:    '\u0533\u0578\u0570 \u0543\u0561\u0574\u0583\u0578\u0580\u0564\u0576\u0565\u0580',
      stat_rating:       '\u0533\u0576\u0561\u0570\u0561\u057f\u0561\u056f\u0561\u0576',

      /* -- Featured Tours -- */
      section_featured:       '\u0538\u0576\u057f\u0580\u0561\u0576\u056b \u054f\u0578\u0582\u0580\u0565\u0580',
      section_featured_label: '\u0538\u0576\u057f\u0580\u057e\u0561\u056e \u0571\u0565\u0566 \u0570\u0561\u0574\u0561\u0580',
      section_featured_desc:  '\u0541\u0565\u057c\u0584\u0578\u057e \u0568\u0576\u057f\u0580\u057e\u0561\u056e \u0578\u0582\u0572\u0572\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580',

      /* -- Group Discounts -- */
      section_discounts:       '\u053d\u0574\u0562\u0561\u0575\u056b\u0576 \u0536\u0565\u0572\u0579\u0565\u0580',
      section_discounts_label: '\u053d\u0576\u0561\u0575\u0565\u0584 \u0561\u057e\u0565\u056c\u056b\u0576 \u0574\u056b\u0561\u057d\u056b\u0576',
      section_discounts_desc:  '\u0532\u0561\u0581\u0561\u057c\u056b\u056f \u0563\u0576\u0561\u0563\u0578\u0575\u0561\u0581\u0578\u0582\u0574 \u056d\u0574\u0562\u0561\u0575\u056b\u0576 \u0561\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574\u0576\u0565\u0580\u056b \u0570\u0561\u0574\u0561\u0580',
      discount_best_value:     '\u053c\u0561\u057e\u0561\u0563\u0578\u0582\u0575\u0576 \u0531\u0580\u056a\u0565\u0584',

      /* -- Testimonials -- */
      section_testimonials:       '\u0540\u0575\u0578\u0582\u0580\u0565\u0580\u056b \u053f\u0561\u0580\u056e\u056b\u0584\u0576\u0565\u0580',
      section_testimonials_label: '\u053b\u0580\u0561\u056f\u0561\u0576 \u057a\u0561\u057f\u0574\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580',
      section_testimonials_desc:  '\u054a\u0561\u057f\u0574\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580 \u0563\u0578\u0570 \u0573\u0561\u0574\u0583\u0578\u0580\u0564\u0576\u0565\u0580\u056b\u0581',

      /* -- Newsletter -- */
      section_newsletter:       '\u054f\u0565\u0572\u0565\u056f\u0561\u0581\u0565\u0584',
      section_newsletter_desc:  '\u054d\u057f\u0561\u0581\u0565\u0584 \u0562\u0561\u0581\u0561\u057c\u056b\u056f \u0561\u057c\u0561\u057b\u0561\u0580\u056f\u0576\u0565\u0580 \u0587 \u0573\u0561\u0574\u0583\u0578\u0580\u0564\u0561\u056f\u0561\u0576 \u0578\u0563\u0565\u0577\u0576\u0579\u0578\u0582\u0574',
      newsletter_placeholder:   '\u0541\u0565\u0580 \u0567\u056c. \u0570\u0561\u057d\u0581\u0565\u0568',
      newsletter_success:       '\u0547\u0576\u0578\u0580\u0570\u0561\u056f\u0561\u056c\u0578\u0582\u0569\u0575\u0578\u0582\u0576! \u054d\u057f\u0578\u0582\u0563\u0565\u0584 \u0571\u0565\u0580 \u0567\u056c. \u0583\u0578\u057d\u057f\u0568:',

      /* -- Tour details -- */
      tour_duration:     '\u054f\u0587\u0578\u0572\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
      tour_group:        '\u053d\u0574\u0562\u056b \u0549\u0561\u0583',
      tour_rating:       '\u0533\u0576\u0561\u0570\u0561\u057f\u0561\u056f\u0561\u0576',
      tour_price:        '\u0544\u0565\u056f\u0576\u0561\u0580\u056f\u0561\u0575\u056b\u0576 \u0533\u056b\u0576',
      tour_overview:     '\u0536\u0576\u0576\u0561\u0580\u056f\u0578\u0582\u0574',
      tour_highlights:   '\u053f\u0561\u0580\u0587\u0578\u0580 \u053f\u0565\u057f\u0565\u0580',
      tour_itinerary:    '\u0535\u0580\u0569\u0578\u0582\u0572\u056b',

      /* -- Booking -- */
      booking_title:     '\u0531\u0574\u0580\u0561\u0563\u0580\u0565\u056c \u0540\u056b\u0574\u0561',
      booking_name:      '\u0531\u0576\u0578\u0582\u0576 \u0531\u0566\u0563\u0561\u0576\u0578\u0582\u0576',
      booking_email:     '\u0537\u056c. \u0570\u0561\u057d\u0581\u0565',
      booking_phone:     '\u0540\u0565\u057c\u0561\u056d\u0578\u057d',
      booking_date:      '\u0543\u0561\u0574\u0583\u0578\u0580\u0564\u056b \u0531\u0574\u057d\u0561\u0569\u056b\u057e',
      booking_requests:  '\u0540\u0561\u057f\u0578\u0582\u056f \u053d\u0576\u0564\u0580\u0561\u0576\u0584\u0576\u0565\u0580 (\u056f\u0561\u0574\u0561\u057e\u0578\u0580)',
      booking_for:       '\u0531\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574',
      booking_success:   '\u0531\u0574\u0580\u0561\u0563\u0580\u0578\u0582\u0574\u0568 \u054a\u0561\u0570\u0561\u0576\u057b\u057e\u0565\u056c \u0537!',
      booking_success_msg: '\u0544\u0565\u0576\u0584 \u056f\u056f\u0561\u057a\u057e\u0565\u0576\u0584 \u0571\u0565\u0566 \u0570\u0565\u057f 24 \u056a\u0561\u0574\u057e\u0561 \u0568\u0576\u0569\u0561\u0581\u0584\u0578\u0582\u0574:',
      booking_per_person: '\u0533\u056b\u0576\u0568 \u0574\u0565\u056f \u0561\u0576\u0571\u056b \u0570\u0561\u0574\u0561\u0580',
      booking_total:     '\u0538\u0576\u0564\u0561\u0574\u0565\u0576\u0568',

      /* -- Archive -- */
      archive_title:     '\u0534\u056b\u057f\u0565\u0584 \u054f\u0578\u0582\u0580\u0565\u0580\u0568',
      archive_search:    '\u0555\u0580\u0578\u0576\u0565\u056c \u057f\u0578\u0582\u0580\u0565\u0580...',
      archive_search_placeholder: '\u0555\u0580\u0578\u0576\u0565\u056c \u057f\u0578\u0582\u0580\u0565\u0580...',
      archive_filter:    '\u054f\u0565\u0572\u0561\u0564\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u055d',
      archive_filter_location: '\u054f\u0565\u0572\u0561\u0564\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u055d',
      archive_all:       '\u0532\u0578\u056c\u0578\u0580',
      archive_filter_all: '\u0532\u0578\u056c\u0578\u0580',
      archive_empty:     '\u054f\u0578\u0582\u0580\u0565\u0580 \u0579\u0565\u0576 \u0563\u057f\u0576\u057e\u0565\u056c: \u0553\u0578\u0580\u0571\u0565\u0584 \u0561\u0575\u056c \u0586\u056b\u056c\u057f\u0580\u0565\u0580:',
      tour_singular:     '\u057f\u0578\u0582\u0580',
      tour_plural:       '\u057f\u0578\u0582\u0580',
      found:             '\u0563\u057f\u0576\u057e\u0565\u056c',

      /* -- Contact -- */
      contact_title:     '\u053f\u0561\u057a\u057e\u0565\u0584 \u0544\u0565\u0566 \u0540\u0565\u057f',
      contact_desc:      '\u0544\u0565\u0576\u0584 \u0578\u0582\u0580\u0561\u056d \u056f\u056c\u056b\u0576\u0565\u0576\u0584 \u0571\u0565\u0566\u0576\u056b\u0581 \u056c\u057d\u0565\u056c',
      contact_form_title:'\u0533\u0580\u0565\u0584 \u0544\u0565\u0566 \u0540\u0561\u0572\u0578\u0580\u0564\u0561\u0563\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
      contact_name:      '\u0531\u0576\u0578\u0582\u0576',
      contact_email:     '\u0537\u056c. \u0570\u0561\u057d\u0581\u0565',
      contact_subject:   '\u054e\u0565\u0580\u0576\u0561\u0563\u056b\u0580',
      contact_message:   '\u0540\u0561\u0572\u0578\u0580\u0564\u0561\u0563\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
      contact_success:   '\u0540\u0561\u0572\u0578\u0580\u0564\u0561\u0563\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0568 \u0570\u0561\u057b\u0578\u0572\u057e\u0565\u0581! \u0544\u0565\u0576\u0584 \u0577\u0578\u0582\u057f\u0578\u057e \\u056f\u057a\u0561\u057f\u0561\u057d\u056d\u0561\u0576\u0565\u0576\u0584:',

      /* -- Footer -- */
      footer_brand_desc: '\u053c\u0575\u0578\u0582\u0584\u057d \u057f\u0578\u0582\u0580\u056b\u057d\u057f\u0561\u056f\u0561\u0576 \u0583\u0578\u0580\u0571\u0561\u057c\u0578\u0582\u0569\u0575\u0578\u0582\u0576\u0576\u0565\u0580 \u053f\u0578\u057e\u056f\u0561\u057d\u056b \u057d\u0580\u057f\u0578\u0582\u0574:',
      footer_links:      '\u0531\u0580\u0561\u0563 \u0540\u0572\u0578\u0582\u0574\u0576\u0565\u0580',
      footer_contact:    '\u053f\u0561\u057a',
      footer_newsletter: '\u054f\u0565\u0572\u0565\u056f\u0561\u057f\u057e\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
      footer_newsletter_desc: '\u0532\u0561\u056a\u0561\u0576\u0578\u0580\u0564\u0561\u0563\u0580\u057e\u0565\u0584 \u0562\u0561\u0581\u0561\u057c\u056b\u056f \u0561\u057c\u0561\u057b\u0561\u0580\u056f\u0576\u0565\u0580\u056b \u0570\u0561\u0574\u0561\u0580',
      footer_copy:       '\u00a9 2024 Discover Luxury Tours. \u0532\u0578\u056c\u0578\u0580 \u056b\u0580\u0561\u057e\u0578\u0582\u0576\u0584\u0576\u0565\u0580\u0568 \u057a\u0561\u0577\u057f\u057a\u0561\u0576\u057e\u0561\u056e \u0565\u0576:',

      /* -- Chat -- */
      chat_title:        '\u054f\u0578\u0582\u0580\u056b\u057d\u057f\u0561\u056f\u0561\u0576 \u0555\u0563\u0576\u0561\u056f\u0561\u0576',
      chat_subtitle:     '\u0540\u0561\u0580\u0581\u0580\u0565\u0584 \u0574\u0565\u0566',
      chat_placeholder:  '\u0533\u0580\u0565\u0584 \u0570\u0561\u0572\u0578\u0580\u0564\u0561\u0563\u0580\u0578\u0582\u0569\u0575\u0578\u0582\u0576...',
      chat_chip_tours:   '\u0540\u0561\u0575\u057f\u0576\u056b \u057f\u0578\u0582\u0580\u0565\u0580',
      chat_chip_pricing: '\u0533\u0576\u0561\u0575\u056b\u0576 \u057f\u0565\u0572\u0565\u056f\u0578\u0582\u0569\u0575\u0578\u0582\u0576',
      chat_chip_custom:  '\u0540\u0561\u057f\u0578\u0582\u056f \u0565\u0580\u0569\u0578\u0582\u0572\u056b',

      /* -- Misc -- */
      people:            '\u0574\u0561\u0580\u0564',
      per_person:        '/\u0574\u0561\u0580\u0564',
      sending:           '\u054a\u0578\u0582\u0572\u0561\u0580\u056f\u057e\u0578\u0582\u0574 \u0567...',
    },

    ru: {
      nav_home:          '\u0413\u043b\u0430\u0432\u043d\u0430\u044f',
      nav_tours:         '\u0422\u0443\u0440\u044b',
      nav_contact:       '\u041a\u043e\u043d\u0442\u0430\u043a\u0442\u044b',
      nav_about:         '\u041e \u043d\u0430\u0441',
      nav_blog:          '\u0411\u043b\u043e\u0433',
      hero_title:        '\u041e\u0442\u043a\u0440\u043e\u0439\u0442\u0435 \u0410\u0440\u043c\u0435\u043d\u0438\u044e',
      hero_subtitle:     '\u041d\u0435\u0437\u0430\u0431\u044b\u0432\u0430\u0435\u043c\u044b\u0435 \u043f\u0443\u0442\u0435\u0448\u0435\u0441\u0442\u0432\u0438\u044f \u0432 \u0441\u0435\u0440\u0434\u0446\u0435 \u041a\u0430\u0432\u043a\u0430\u0437\u0430',
      hero_cta:          '\u041f\u043e\u0441\u043c\u043e\u0442\u0440\u0435\u0442\u044c \u0442\u0443\u0440\u044b',
      stat_destinations: '\u041d\u0430\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u0438\u044f',
      stat_travelers:    '\u0422\u0443\u0440\u0438\u0441\u0442\u043e\u0432',
      stat_rating:       '\u0420\u0435\u0439\u0442\u0438\u043d\u0433',
      featured_eyebrow:  '\u041f\u043e\u0434\u043e\u0431\u0440\u0430\u043d\u043e \u0434\u043b\u044f \u0432\u0430\u0441',
      featured_title:    '\u041f\u043e\u043f\u0443\u043b\u044f\u0440\u043d\u044b\u0435 \u0442\u0443\u0440\u044b',
      featured_desc:     '\u041b\u0443\u0447\u0448\u0438\u0435 \u043d\u0430\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u0438\u044f \u0434\u043b\u044f \u043d\u0435\u0437\u0430\u0431\u044b\u0432\u0430\u0435\u043c\u044b\u0445 \u0432\u043f\u0435\u0447\u0430\u0442\u043b\u0435\u043d\u0438\u0439',
      featured_browse:   '\u0412\u0441\u0435 \u0442\u0443\u0440\u044b',
      discount_eyebrow:  '\u042d\u043a\u043e\u043d\u043e\u043c\u044c\u0442\u0435 \u0432\u043c\u0435\u0441\u0442\u0435',
      discount_title:    '\u0413\u0440\u0443\u043f\u043f\u043e\u0432\u044b\u0435 \u0441\u043a\u0438\u0434\u043a\u0438',
      discount_desc:     '\u042d\u043a\u0441\u043a\u043b\u044e\u0437\u0438\u0432\u043d\u044b\u0435 \u0446\u0435\u043d\u044b \u0434\u043b\u044f \u0433\u0440\u0443\u043f\u043f',
      testimonials_eyebrow: '\u041e\u0442\u0437\u044b\u0432\u044b',
      testimonials_title:   '\u041e\u0442\u0437\u044b\u0432\u044b \u0433\u043e\u0441\u0442\u0435\u0439',
      testimonials_desc:    '\u0418\u0441\u0442\u043e\u0440\u0438\u0438 \u0441\u0447\u0430\u0441\u0442\u043b\u0438\u0432\u044b\u0445 \u043f\u0443\u0442\u0435\u0448\u0435\u0441\u0442\u0432\u0435\u043d\u043d\u0438\u043a\u043e\u0432',
      newsletter_title:  '\u0411\u0443\u0434\u044c\u0442\u0435 \u0432 \u043a\u0443\u0440\u0441\u0435',
      newsletter_desc:   '\u041f\u043e\u043b\u0443\u0447\u0430\u0439\u0442\u0435 \u043b\u0443\u0447\u0448\u0438\u0435 \u043f\u0440\u0435\u0434\u043b\u043e\u0436\u0435\u043d\u0438\u044f \u043d\u0430 \u043f\u043e\u0447\u0442\u0443',
      newsletter_btn:    '\u041f\u043e\u0434\u043f\u0438\u0441\u0430\u0442\u044c\u0441\u044f',
      single_book_tour:  '\u0417\u0430\u0431\u0440\u043e\u043d\u0438\u0440\u043e\u0432\u0430\u0442\u044c',
      single_book_now:   '\u0417\u0430\u0431\u0440\u043e\u043d\u0438\u0440\u043e\u0432\u0430\u0442\u044c',
      single_group_size: '\u0420\u0430\u0437\u043c\u0435\u0440 \u0433\u0440\u0443\u043f\u043f\u044b',
      single_overview:   '\u041e\u0431\u0437\u043e\u0440',
      single_highlights: '\u041e\u0441\u043e\u0431\u0435\u043d\u043d\u043e\u0441\u0442\u0438',
      single_itinerary:  '\u041c\u0430\u0440\u0448\u0440\u0443\u0442',
      archive_title:     '\u041d\u0430\u0448\u0438 \u0442\u0443\u0440\u044b',
      archive_search:    '\u041f\u043e\u0438\u0441\u043a \u0442\u0443\u0440\u043e\u0432...',
      archive_search_placeholder: '\u041f\u043e\u0438\u0441\u043a \u0442\u0443\u0440\u043e\u0432...',
      archive_filter_location: '\u041c\u0435\u0441\u0442\u043e\u043f\u043e\u043b\u043e\u0436\u0435\u043d\u0438\u0435:',
      archive_filter_all: '\u0412\u0441\u0435',
      archive_empty:     '\u0422\u0443\u0440\u044b \u043d\u0435 \u043d\u0430\u0439\u0434\u0435\u043d\u044b. \u041f\u043e\u043f\u0440\u043e\u0431\u0443\u0439\u0442\u0435 \u0434\u0440\u0443\u0433\u0438\u0435 \u0444\u0438\u043b\u044c\u0442\u0440\u044b.',
      tour_singular:     '\u0442\u0443\u0440',
      tour_plural:       '\u0442\u0443\u0440\u043e\u0432',
      found:             '\u043d\u0430\u0439\u0434\u0435\u043d\u043e',
      contact_title:     '\u0421\u0432\u044f\u0436\u0438\u0442\u0435\u0441\u044c \u0441 \u043d\u0430\u043c\u0438',
      contact_subtitle:  '\u041c\u044b \u0440\u0430\u0434\u044b \u0432\u0430\u0448\u0435\u043c\u0443 \u043e\u0431\u0440\u0430\u0449\u0435\u043d\u0438\u044e',
      contact_send:      '\u041e\u0442\u043f\u0440\u0430\u0432\u0438\u0442\u044c',
      chat_title:        '\u0422\u0443\u0440\u0438\u0441\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u0439 \u043f\u043e\u043c\u043e\u0449\u043d\u0438\u043a',
      chat_subtitle:     '\u0421\u043f\u0440\u043e\u0441\u0438\u0442\u0435 \u043d\u0430\u0441',
      chat_placeholder:  '\u041d\u0430\u043f\u0438\u0448\u0438\u0442\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u0435...',
      chat_chip_tours:   '\u041b\u0443\u0447\u0448\u0438\u0435 \u0442\u0443\u0440\u044b',
      chat_chip_pricing: '\u0418\u043d\u0444\u043e \u043e \u0446\u0435\u043d\u0430\u0445',
      chat_chip_custom:  '\u0421\u043f\u043b\u0430\u043d\u0438\u0440\u043e\u0432\u0430\u0442\u044c \u043f\u043e\u0435\u0437\u0434\u043a\u0443',
      people:            '\u0447\u0435\u043b.',
      per_person:        '/\u0447\u0435\u043b.',
      sending:           '\u041e\u0442\u043f\u0440\u0430\u0432\u043a\u0430...',
    },
  };

  var lang = localStorage.getItem( 'tv_lang' ) || 'en';

  function dict( l ) {
    return T[ l || lang ] || T.en;
  }

  function t( key, l ) {
    var d = dict( l );
    return d[ key ] !== undefined ? d[ key ] : key;
  }

  function setLang( l ) {
    lang = l;
    localStorage.setItem( 'tv_lang', l );

    /* Update text content */
    document.querySelectorAll( '[data-i18n]' ).forEach( function ( el ) {
      var k = el.dataset.i18n;
      if ( T[ l ] && T[ l ][ k ] !== undefined ) {
        if ( el.tagName === 'INPUT' || el.tagName === 'TEXTAREA' ) {
          el.placeholder = T[ l ][ k ];
        } else {
          el.innerHTML = T[ l ][ k ];
        }
      }
    } );

    /* Update placeholder attributes */
    document.querySelectorAll( '[data-i18n-placeholder]' ).forEach( function ( el ) {
      var k = el.dataset.i18nPlaceholder;
      if ( T[ l ] && T[ l ][ k ] !== undefined ) {
        el.placeholder = T[ l ][ k ];
      }
    } );

    /* Update language buttons */
    document.querySelectorAll( '.tourvice-header__lang-btn, [data-lang]' ).forEach( function ( btn ) {
      btn.classList.toggle( 'active', btn.dataset.lang === l );
    } );

    /* Update dynamic text (tour count, people, etc.) */
    document.querySelectorAll( '[data-i18n-template]' ).forEach( function ( el ) {
      var k = el.dataset.i18nTemplate;
      var val = el.dataset.value || '';
      if ( T[ l ] && T[ l ][ k ] !== undefined ) {
        el.textContent = val + ' ' + T[ l ][ k ];
      }
    } );

    if ( typeof window.TourviceCurrency !== 'undefined' && typeof window.TourviceCurrency.setCurrency === 'function' ) {
      /* Trigger currency update to refresh per_person suffix. */
      window.TourviceCurrency.setCurrency( window.TourviceCurrency.getCurrency() );
    }
  }

  function getLang() {
    return lang;
  }

  function updatePageI18n() {
    setLang( lang );
  }

  window.setLang = setLang;

  return {
    T:             T,
    dict:          dict,
    t:             t,
    setLang:       setLang,
    getLang:       getLang,
    updatePageI18n: updatePageI18n,
  };

} )();
