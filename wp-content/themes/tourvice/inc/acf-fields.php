<?php
/**
 * ACF Field Groups for Home Page ACF Blocks.
 *
 * Each group targets a specific ACF block (location: block == acf/tourvice-*).
 * Fields appear in the block sidebar when the block is selected in Gutenberg.
 *
 * @package TourVice
 * @since 0.2.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) { return; }

    /* ================================================================
       HERO SLIDER BLOCK
       ================================================================ */
    acf_add_local_field_group( [
        'key'      => 'group_block_hero_slider',
        'title'    => 'Hero Slider',
        'fields'   => [
            [
                'key'           => 'field_blk_hero_title',
                'label'         => 'Hero Title',
                'name'          => 'hero_title',
                'type'          => 'text',
                'default_value' => 'Discover Armenia',
                'required'      => 1,
            ],
            [
                'key'           => 'field_blk_hero_subtitle',
                'label'         => 'Hero Subtitle',
                'name'          => 'hero_subtitle',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Unforgettable luxury experiences in the heart of the Caucasus',
            ],
            [
                'key'           => 'field_blk_hero_cta_text',
                'label'         => 'CTA Button Text',
                'name'          => 'hero_cta_text',
                'type'          => 'text',
                'default_value' => 'Browse Tours',
            ],
            [
                'key'          => 'field_blk_hero_cta_url',
                'label'        => 'CTA Button URL',
                'name'         => 'hero_cta_url',
                'type'         => 'url',
                'instructions' => 'Leave empty to auto-link to Tours archive.',
            ],
            [
                'key'          => 'field_blk_hero_slides',
                'label'        => 'Slides',
                'name'         => 'hero_slides',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Slide',
                'min'          => 1,
                'max'          => 10,
                'sub_fields'   => [
                    [
                        'key'           => 'field_blk_hero_slide_image',
                        'label'         => 'Background Image',
                        'name'          => 'image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'medium',
                        'required'      => 1,
                    ],
                    [
                        'key'           => 'field_blk_hero_slide_alt',
                        'label'         => 'Alt Text',
                        'name'          => 'alt_text',
                        'type'          => 'text',
                        'default_value' => 'Armenia landscape',
                    ],
                ],
            ],
            [
                'key'          => 'field_blk_hero_stats',
                'label'        => 'Stat Cards',
                'name'         => 'hero_stats',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Stat',
                'min'          => 0,
                'max'          => 4,
                'sub_fields'   => [
                    [
                        'key'   => 'field_blk_hero_stat_value',
                        'label' => 'Value',
                        'name'  => 'value',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_blk_hero_stat_label',
                        'label' => 'Label',
                        'name'  => 'label',
                        'type'  => 'text',
                    ],
                ],
            ],
        ],
        'location' => [
            [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/tourvice-hero-slider' ] ],
        ],
    ] );

    /* ================================================================
       FEATURED TOURS BLOCK
       ================================================================ */
    acf_add_local_field_group( [
        'key'      => 'group_block_featured_tours',
        'title'    => 'Featured Tours',
        'fields'   => [
            [
                'key'           => 'field_blk_ftours_eyebrow',
                'label'         => 'Eyebrow Text',
                'name'          => 'ftours_eyebrow',
                'type'          => 'text',
                'default_value' => 'Curated for you',
            ],
            [
                'key'           => 'field_blk_ftours_title',
                'label'         => 'Section Title',
                'name'          => 'ftours_title',
                'type'          => 'text',
                'default_value' => 'Featured Tours',
                'required'      => 1,
            ],
            [
                'key'           => 'field_blk_ftours_desc',
                'label'         => 'Description',
                'name'          => 'ftours_desc',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Handpicked destinations for unforgettable experiences',
            ],
            [
                'key'           => 'field_blk_ftours_count',
                'label'         => 'Number of Tours to Show',
                'name'          => 'ftours_count',
                'type'          => 'number',
                'default_value' => 3,
                'min'           => 1,
                'max'           => 12,
            ],
            [
                'key'           => 'field_blk_ftours_cta_text',
                'label'         => 'Browse All Button Text',
                'name'          => 'ftours_cta_text',
                'type'          => 'text',
                'default_value' => 'Browse All Tours',
            ],
        ],
        'location' => [
            [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/tourvice-featured-tours' ] ],
        ],
    ] );

    /* ================================================================
       GROUP DISCOUNTS BLOCK
       ================================================================ */
    acf_add_local_field_group( [
        'key'      => 'group_block_group_discounts',
        'title'    => 'Group Discounts',
        'fields'   => [
            [
                'key'           => 'field_blk_disc_eyebrow',
                'label'         => 'Eyebrow Text',
                'name'          => 'disc_eyebrow',
                'type'          => 'text',
                'default_value' => 'Save more together',
            ],
            [
                'key'           => 'field_blk_disc_title',
                'label'         => 'Section Title',
                'name'          => 'disc_title',
                'type'          => 'text',
                'default_value' => 'Group Discounts',
                'required'      => 1,
            ],
            [
                'key'           => 'field_blk_disc_desc',
                'label'         => 'Description',
                'name'          => 'disc_desc',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Exclusive pricing for group bookings',
            ],
            [
                'key'          => 'field_blk_disc_tiers',
                'label'        => 'Discount Tiers',
                'name'         => 'disc_tiers',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Tier',
                'min'          => 1,
                'max'          => 6,
                'sub_fields'   => [
                    [
                        'key'      => 'field_blk_disc_tier_size',
                        'label'    => 'Group Size',
                        'name'     => 'size',
                        'type'     => 'text',
                        'required' => 1,
                    ],
                    [
                        'key'      => 'field_blk_disc_tier_discount',
                        'label'    => 'Discount %',
                        'name'     => 'discount',
                        'type'     => 'text',
                        'required' => 1,
                    ],
                    [
                        'key'           => 'field_blk_disc_tier_style',
                        'label'         => 'Card Style',
                        'name'          => 'style',
                        'type'          => 'select',
                        'choices'       => [
                            'earth'      => 'Earth (Light)',
                            'sage-light' => 'Sage (Light)',
                            'sage-mid'   => 'Sage (Medium)',
                            'dark'       => 'Dark (Featured)',
                        ],
                        'default_value' => 'earth',
                    ],
                    [
                        'key'   => 'field_blk_disc_tier_badge',
                        'label' => 'Badge Text (optional)',
                        'name'  => 'badge',
                        'type'  => 'text',
                    ],
                ],
            ],
        ],
        'location' => [
            [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/tourvice-group-discounts' ] ],
        ],
    ] );

    /* ================================================================
       TESTIMONIALS BLOCK
       ================================================================ */
    acf_add_local_field_group( [
        'key'      => 'group_block_testimonials',
        'title'    => 'Testimonials',
        'fields'   => [
            [
                'key'           => 'field_blk_test_eyebrow',
                'label'         => 'Eyebrow Text',
                'name'          => 'test_eyebrow',
                'type'          => 'text',
                'default_value' => 'Real stories',
            ],
            [
                'key'           => 'field_blk_test_title',
                'label'         => 'Section Title',
                'name'          => 'test_title',
                'type'          => 'text',
                'default_value' => 'Guest Testimonials',
                'required'      => 1,
            ],
            [
                'key'           => 'field_blk_test_desc',
                'label'         => 'Description',
                'name'          => 'test_desc',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Stories from happy travelers',
            ],
            [
                'key'           => 'field_blk_test_bg_image',
                'label'         => 'Background Image',
                'name'          => 'test_bg_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
                'instructions'  => 'Parallax background behind testimonials.',
            ],
            [
                'key'          => 'field_blk_test_items',
                'label'        => 'Testimonials',
                'name'         => 'test_items',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Testimonial',
                'min'          => 1,
                'max'          => 8,
                'sub_fields'   => [
                    [
                        'key'      => 'field_blk_test_item_name',
                        'label'    => 'Name',
                        'name'     => 'name',
                        'type'     => 'text',
                        'required' => 1,
                    ],
                    [
                        'key'   => 'field_blk_test_item_role',
                        'label' => 'Role / Title',
                        'name'  => 'role',
                        'type'  => 'text',
                    ],
                    [
                        'key'      => 'field_blk_test_item_text',
                        'label'    => 'Quote',
                        'name'     => 'text',
                        'type'     => 'textarea',
                        'rows'     => 3,
                        'required' => 1,
                    ],
                    [
                        'key'           => 'field_blk_test_item_rating',
                        'label'         => 'Rating (1-5)',
                        'name'          => 'rating',
                        'type'          => 'number',
                        'min'           => 1,
                        'max'           => 5,
                        'default_value' => 5,
                    ],
                ],
            ],
        ],
        'location' => [
            [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/tourvice-testimonials' ] ],
        ],
    ] );

    /* ================================================================
       NEWSLETTER BLOCK
       ================================================================ */
    acf_add_local_field_group( [
        'key'      => 'group_block_newsletter',
        'title'    => 'Newsletter',
        'fields'   => [
            [
                'key'           => 'field_blk_nl_title',
                'label'         => 'Title',
                'name'          => 'nl_title',
                'type'          => 'text',
                'default_value' => 'Stay Updated',
                'required'      => 1,
            ],
            [
                'key'           => 'field_blk_nl_desc',
                'label'         => 'Description',
                'name'          => 'nl_desc',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Get exclusive deals and travel inspiration delivered to your inbox',
            ],
            [
                'key'           => 'field_blk_nl_placeholder',
                'label'         => 'Input Placeholder',
                'name'          => 'nl_placeholder',
                'type'          => 'text',
                'default_value' => 'Your email address',
            ],
            [
                'key'           => 'field_blk_nl_button',
                'label'         => 'Button Text',
                'name'          => 'nl_button',
                'type'          => 'text',
                'default_value' => 'Subscribe',
            ],
        ],
        'location' => [
            [ [ 'param' => 'block', 'operator' => '==', 'value' => 'acf/tourvice-newsletter' ] ],
        ],
    ] );
} );
