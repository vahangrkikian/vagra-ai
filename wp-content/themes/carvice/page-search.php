<?php
/**
 * Template Name: Search Providers
 * Search results page with filters — matches Carmaster /search reference.
 *
 * @package Carvice
 */

get_header();

// Read filter state from URL.
$query_text      = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$category_filter = isset( $_GET['category'] ) ? sanitize_text_field( wp_unslash( $_GET['category'] ) ) : '';
$service_filter  = isset( $_GET['service'] ) ? sanitize_text_field( wp_unslash( $_GET['service'] ) ) : '';
$brand_filter    = isset( $_GET['brand'] ) ? sanitize_text_field( wp_unslash( $_GET['brand'] ) ) : '';
$type_filter     = isset( $_GET['type'] ) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : '';
$sort_by         = isset( $_GET['sort'] ) ? sanitize_text_field( wp_unslash( $_GET['sort'] ) ) : 'rating';

$has_filters = $query_text || $category_filter || $service_filter || $brand_filter || $type_filter;

// Build WP_Query args.
$args = array(
    'post_type'      => 'carvice_provider',
    'posts_per_page' => 40,
    'post_status'    => 'publish',
);

// Meta query parts.
$meta_query = array();

// Provider type filter.
if ( $type_filter ) {
    $type_map = array(
        'company'    => array( 'center', 'company' ),
        'individual' => array( 'individual' ),
        'dealer'     => array( 'dealer' ),
    );
    $type_values = isset( $type_map[ $type_filter ] ) ? $type_map[ $type_filter ] : array( $type_filter );
    $meta_query[] = array(
        'key'     => '_carvice_provider_type',
        'value'   => $type_values,
        'compare' => 'IN',
    );
}

// Tax query parts.
$tax_query = array();

if ( $category_filter ) {
    $tax_query[] = array(
        'taxonomy' => 'carvice_service_cat',
        'field'    => 'slug',
        'terms'    => $category_filter,
    );
}

if ( $service_filter ) {
    $tax_query[] = array(
        'taxonomy' => 'carvice_service_type',
        'field'    => 'slug',
        'terms'    => $service_filter,
    );
}

if ( $brand_filter ) {
    $tax_query[] = array(
        'taxonomy' => 'carvice_brand',
        'field'    => 'slug',
        'terms'    => $brand_filter,
    );
}

if ( ! empty( $meta_query ) ) {
    $args['meta_query'] = $meta_query;
}
if ( ! empty( $tax_query ) ) {
    $args['tax_query'] = $tax_query;
}

// Text search.
if ( $query_text ) {
    $args['s'] = $query_text;
}

// Sort.
switch ( $sort_by ) {
    case 'reviews':
        $args['meta_key'] = '_carvice_review_count';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC';
        break;
    case 'name':
        $args['orderby'] = 'title';
        $args['order']   = 'ASC';
        break;
    default: // rating
        $args['meta_key'] = '_carvice_rating';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC';
        break;
}

$results = new WP_Query( $args );

// Get taxonomy terms for filter dropdowns.
$service_cats  = get_terms( array( 'taxonomy' => 'carvice_service_cat', 'hide_empty' => false ) );
$service_types = get_terms( array( 'taxonomy' => 'carvice_service_type', 'hide_empty' => false ) );
$brands        = get_terms( array( 'taxonomy' => 'carvice_brand', 'hide_empty' => false ) );

// Build current URL base for filter links.
$search_page_url = get_permalink();
?>

<main id="primary" class="carvice-main">
    <div class="carvice-container carvice-search-page">

        <!-- Page title -->
        <h1 class="carvice-search-page__title"><?php esc_html_e( 'Search Results', 'carvice' ); ?></h1>
        <?php if ( $query_text ) : ?>
            <p class="carvice-search-page__subtitle">
                <?php printf( esc_html__( 'Showing results for "%s"', 'carvice' ), esc_html( $query_text ) ); ?>
            </p>
        <?php endif; ?>

        <!-- Filters bar -->
        <form method="get" action="<?php echo esc_url( $search_page_url ); ?>" class="carvice-search-filters">
            <?php if ( $query_text ) : ?>
                <input type="hidden" name="q" value="<?php echo esc_attr( $query_text ); ?>" />
            <?php endif; ?>

            <!-- Category -->
            <select name="category" class="carvice-search-select" onchange="this.form.submit()">
                <option value=""><?php esc_html_e( 'All Categories', 'carvice' ); ?></option>
                <?php if ( ! empty( $service_cats ) && ! is_wp_error( $service_cats ) ) : ?>
                    <?php foreach ( $service_cats as $cat ) : ?>
                        <option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( $category_filter, $cat->slug ); ?>>
                            <?php echo esc_html( $cat->name ); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <!-- Service type -->
            <select name="service" class="carvice-search-select" onchange="this.form.submit()">
                <option value=""><?php esc_html_e( 'All Services', 'carvice' ); ?></option>
                <?php if ( ! empty( $service_types ) && ! is_wp_error( $service_types ) ) : ?>
                    <?php foreach ( $service_types as $type ) : ?>
                        <option value="<?php echo esc_attr( $type->slug ); ?>" <?php selected( $service_filter, $type->slug ); ?>>
                            <?php echo esc_html( $type->name ); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <!-- Brand -->
            <select name="brand" class="carvice-search-select" onchange="this.form.submit()">
                <option value=""><?php esc_html_e( 'All Brands', 'carvice' ); ?></option>
                <?php if ( ! empty( $brands ) && ! is_wp_error( $brands ) ) : ?>
                    <?php foreach ( $brands as $brand ) : ?>
                        <option value="<?php echo esc_attr( $brand->slug ); ?>" <?php selected( $brand_filter, $brand->slug ); ?>>
                            <?php echo esc_html( $brand->name ); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <!-- Provider type -->
            <select name="type" class="carvice-search-select" onchange="this.form.submit()">
                <option value=""><?php esc_html_e( 'All Types', 'carvice' ); ?></option>
                <option value="company" <?php selected( $type_filter, 'company' ); ?>><?php esc_html_e( 'Service Centers', 'carvice' ); ?></option>
                <option value="individual" <?php selected( $type_filter, 'individual' ); ?>><?php esc_html_e( 'Individual Specialists', 'carvice' ); ?></option>
                <option value="dealer" <?php selected( $type_filter, 'dealer' ); ?>><?php esc_html_e( 'Official Dealers', 'carvice' ); ?></option>
            </select>

            <!-- Sort -->
            <select name="sort" class="carvice-search-select" onchange="this.form.submit()">
                <option value="rating" <?php selected( $sort_by, 'rating' ); ?>><?php esc_html_e( 'Sort: Rating', 'carvice' ); ?></option>
                <option value="reviews" <?php selected( $sort_by, 'reviews' ); ?>><?php esc_html_e( 'Sort: Reviews', 'carvice' ); ?></option>
                <option value="name" <?php selected( $sort_by, 'name' ); ?>><?php esc_html_e( 'Sort: Name', 'carvice' ); ?></option>
            </select>

            <?php if ( $has_filters ) : ?>
                <a href="<?php echo esc_url( $search_page_url ); ?>" class="carvice-search-clear">
                    <?php esc_html_e( 'Clear filters', 'carvice' ); ?>
                </a>
            <?php endif; ?>
        </form>

        <!-- Active filter pills -->
        <?php if ( $has_filters ) : ?>
            <div class="carvice-search-active-filters">
                <?php
                $current_params = array();
                if ( $query_text )       $current_params['q']        = $query_text;
                if ( $category_filter )  $current_params['category'] = $category_filter;
                if ( $service_filter )   $current_params['service']  = $service_filter;
                if ( $brand_filter )     $current_params['brand']    = $brand_filter;
                if ( $type_filter )      $current_params['type']     = $type_filter;
                if ( $sort_by !== 'rating' ) $current_params['sort'] = $sort_by;
                ?>

                <?php if ( $category_filter ) :
                    $remove_params = $current_params;
                    unset( $remove_params['category'] );
                    $cat_term = get_term_by( 'slug', $category_filter, 'carvice_service_cat' );
                ?>
                    <a href="<?php echo esc_url( add_query_arg( $remove_params, $search_page_url ) ); ?>" class="carvice-filter-pill-active">
                        <?php echo esc_html( $cat_term ? $cat_term->name : $category_filter ); ?>
                        <svg class="carvice-icon-xs" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                <?php endif; ?>

                <?php if ( $service_filter ) :
                    $remove_params = $current_params;
                    unset( $remove_params['service'] );
                    $svc_term = get_term_by( 'slug', $service_filter, 'carvice_service_type' );
                ?>
                    <a href="<?php echo esc_url( add_query_arg( $remove_params, $search_page_url ) ); ?>" class="carvice-filter-pill-active">
                        <?php echo esc_html( $svc_term ? $svc_term->name : $service_filter ); ?>
                        <svg class="carvice-icon-xs" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                <?php endif; ?>

                <?php if ( $brand_filter ) :
                    $remove_params = $current_params;
                    unset( $remove_params['brand'] );
                    $brand_term = get_term_by( 'slug', $brand_filter, 'carvice_brand' );
                ?>
                    <a href="<?php echo esc_url( add_query_arg( $remove_params, $search_page_url ) ); ?>" class="carvice-filter-pill-active">
                        <?php echo esc_html( $brand_term ? $brand_term->name : $brand_filter ); ?>
                        <svg class="carvice-icon-xs" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                <?php endif; ?>

                <?php if ( $type_filter ) :
                    $remove_params = $current_params;
                    unset( $remove_params['type'] );
                    $type_labels = array( 'company' => 'Service Centers', 'individual' => 'Individual Specialists', 'dealer' => 'Official Dealers' );
                ?>
                    <a href="<?php echo esc_url( add_query_arg( $remove_params, $search_page_url ) ); ?>" class="carvice-filter-pill-active">
                        <?php echo esc_html( isset( $type_labels[ $type_filter ] ) ? $type_labels[ $type_filter ] : $type_filter ); ?>
                        <svg class="carvice-icon-xs" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Results count -->
        <p class="carvice-search-count">
            <?php printf( esc_html( _n( '%d result found', '%d results found', $results->found_posts, 'carvice' ) ), $results->found_posts ); ?>
        </p>

        <!-- Results grid -->
        <?php if ( $results->have_posts() ) : ?>
            <div class="carvice-providers-grid">
                <?php
                while ( $results->have_posts() ) :
                    $results->the_post();
                    get_template_part( 'template-parts/provider-card' );
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <div class="carvice-search-empty">
                <p class="carvice-search-empty__title"><?php esc_html_e( 'No results found', 'carvice' ); ?></p>
                <p class="carvice-search-empty__text"><?php esc_html_e( 'Try adjusting your filters or search query.', 'carvice' ); ?></p>
                <a href="<?php echo esc_url( $search_page_url ); ?>" class="carvice-btn carvice-btn--primary">
                    <?php esc_html_e( 'Clear all filters', 'carvice' ); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
