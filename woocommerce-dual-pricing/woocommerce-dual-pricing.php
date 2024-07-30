<?php
/**
 * Plugin Name: WooCommerce Dual Pricing
 * Description: Ofrece un precio distinto al rol de usuario instalador. Por ejemplo para instaladores de lamparas, les mejoras el precio.
 * Version: 1.0
 * Author: Oscar Jesús Zúñiga Ruiz
 * URI: bozstudy.com
 * Text Domain: woocommerce-dual-pricing
 */

// Evita el acceso directo.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook para inicializar el plugin.
add_action( 'plugins_loaded', 'init_woocommerce_dual_pricing' );

function init_woocommerce_dual_pricing() {
    if ( class_exists( 'WooCommerce' ) ) {
        // Aquí irá nuestro código.
        add_action( 'woocommerce_product_options_pricing', 'add_custom_pricing_fields' );
        add_action( 'woocommerce_process_product_meta', 'save_custom_pricing_fields' );
        add_filter( 'woocommerce_get_price', 'apply_custom_pricing', 10, 2 );
    }
}

function add_custom_pricing_fields() {
    woocommerce_wp_text_input( array(
        'id' => '_installer_price',
        'label' => __( 'Installer Price', 'woocommerce-dual-pricing' ),
        'data_type' => 'price',
    ));
}

function save_custom_pricing_fields( $post_id ) {
    $installer_price = isset( $_POST['_installer_price'] ) ? sanitize_text_field( $_POST['_installer_price'] ) : '';
    update_post_meta( $post_id, '_installer_price', $installer_price );
}

function apply_custom_pricing( $price, $product ) {
    if ( current_user_can( 'installer' ) ) {
        $installer_price = get_post_meta( $product->get_id(), '_installer_price', true );
        if ( ! empty( $installer_price ) ) {
            $price = $installer_price;
        }
    }
    return $price;
}
?>
