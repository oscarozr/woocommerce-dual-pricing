<?php
/**
 * Plugin Name: Rol Instalador
 * Description: Adds a custom "Installer" role to WordPress.
 * Version: 1.0
 * Author: Oscar Zúñiga + AI
 * Text Domain: installer-role
 */

// Evita el acceso directo.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook para la activación del plugin.
register_activation_hook( __FILE__, 'installer_role_add' );

// Hook para la desactivación del plugin.
register_deactivation_hook( __FILE__, 'installer_role_remove' );

/**
 * Función para añadir el rol de "Instalador".
 */
function installer_role_add() {
    add_role(
        'installer',
        __( 'Installer', 'installer-role' ),
        array(
            'read' => true,
            'installer' => true,
        )
    );
}

/**
 * Función para eliminar el rol de "Instalador".
 */
function installer_role_remove() {
    remove_role( 'installer' );
}
?>
