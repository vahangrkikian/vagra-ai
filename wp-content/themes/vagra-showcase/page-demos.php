<?php
/**
 * Template Name: Demos
 *
 * Live demo browser page — vagra.ai Showcase (React SPA).
 *
 * @package vagra-showcase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$assets = get_template_directory_uri() . '/assets';
?><!doctype html>
<html lang="en" data-mode="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Demos · vagra.ai</title>
  <meta name="description" content="Live previews of every vagra.ai WordPress theme — desktop, tablet, mobile." />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" />

  <link rel="stylesheet" href="<?php echo esc_url( $assets ); ?>/css/showcase.css" />
  <link rel="stylesheet" href="<?php echo esc_url( $assets ); ?>/css/demos.css" />
</head>
<body>
  <div id="root"></div>

  <script src="https://unpkg.com/react@18.3.1/umd/react.development.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/react-dom@18.3.1/umd/react-dom.development.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/@babel/standalone@7.29.0/babel.min.js" crossorigin="anonymous"></script>

  <script src="<?php echo esc_url( $assets ); ?>/js/data.js"></script>
  <script type="text/babel" src="<?php echo esc_url( $assets ); ?>/js/preview-art.jsx"></script>
  <script type="text/babel" src="<?php echo esc_url( $assets ); ?>/js/demo-mocks.jsx"></script>
  <script type="text/babel" src="<?php echo esc_url( $assets ); ?>/js/components.jsx"></script>
  <script type="text/babel" src="<?php echo esc_url( $assets ); ?>/js/sections.jsx"></script>
  <script type="text/babel" src="<?php echo esc_url( $assets ); ?>/js/demos-app.jsx"></script>
</body>
</html>
<?php exit; ?>
