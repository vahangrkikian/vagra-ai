<?php
/**
 * The template for displaying comments.
 *
 * @package Vagra_MSP
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="vagra-comments">

    <?php if ( have_comments() ) : ?>
        <h2 class="vagra-comments__title">
            <?php
            $vagra_comment_count = get_comments_number();
            if ( '1' === $vagra_comment_count ) {
                printf(
                    /* translators: 1: title. */
                    esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'vagra-msp' ),
                    '<span>' . wp_kses_post( get_the_title() ) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $vagra_comment_count, 'comments title', 'vagra-msp' ) ),
                    number_format_i18n( $vagra_comment_count ),
                    '<span>' . wp_kses_post( get_the_title() ) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="vagra-comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 48,
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if ( ! comments_open() ) :
            ?>
            <p class="vagra-no-comments"><?php esc_html_e( 'Comments are closed.', 'vagra-msp' ); ?></p>
            <?php
        endif;

    endif;

    comment_form();
    ?>

</div>
