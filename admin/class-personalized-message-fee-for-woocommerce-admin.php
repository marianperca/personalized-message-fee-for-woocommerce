<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://marianperca.com
 * @since      1.0.0
 *
 * @package    Personalized_Message_Fee_For_Woocommerce
 * @subpackage Personalized_Message_Fee_For_Woocommerce/admin
 */

class Personalized_Message_Fee_For_Woocommerce_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/personalized-message-fee-for-woocommerce-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/personalized-message-fee-for-woocommerce-admin.js', array('jquery'), $this->version, false);
    }

    function add_submenu_page() {
        add_submenu_page(
            'woocommerce', // Parent slug to make it appear under WooCommerce menu
            __('Personalized message settings', 'personalized-message-fee-for-woocommerce'), // Page title
            __('Personalized message', 'personalized-message-fee-for-woocommerce'), // Menu title
            'manage_options', // Capability required to access this page
            'woocommerce-personalized-message-fee-settings', // Menu slug
            [$this, 'settings_page'] // Callback function to render the settings page
        );
    }

    function settings_init() {
        register_setting('personalized_message_fee_for_woocommerce_settings', 'personalized_message_fee');
        register_setting('personalized_message_fee_for_woocommerce_settings', 'personalized_message_categories');
        register_setting('personalized_message_fee_for_woocommerce_settings', 'personalized_message_char_limit');
        register_setting('personalized_message_fee_for_woocommerce_settings', 'personalized_message_promo_text');

        add_settings_section(
            'personalized_message_fee_section',
            __('Personalized message fee settings', 'personalized-message-fee-for-woocommerce'),
            [$this, 'section_description'],
            'personalized-message-fee'
        );

        add_settings_field(
            'personalized_message_fee',
            __('Message fee amount', 'personalized-message-fee-for-woocommerce'),
            [$this, 'message_fee_field'],
            'personalized-message-fee',
            'personalized_message_fee_section'
        );

        add_settings_field(
            'personalized_message_char_limit',
            __('Message characters limit', 'personalized-message-fee-for-woocommerce'),
            [$this, 'message_char_limit_field'],
            'personalized-message-fee',
            'personalized_message_fee_section'
        );

        add_settings_field(
            'personalized_message_promo_text',
            __('Description (promo text)', 'personalized-message-fee-for-woocommerce'),
            [$this, 'promo_text_field'],
            'personalized-message-fee',
            'personalized_message_fee_section'
        );

        add_settings_field(
            'personalized_message_categories',
            __('Applicable product categories', 'personalized-message-fee-for-woocommerce'),
            [$this, 'message_categories_field'],
            'personalized-message-fee',
            'personalized_message_fee_section'
        );
    }

    function section_description() {
        echo '<p>Set the fee amount and select categories for which the personalized message option will be available.</p>';
    }

    function message_fee_field() {
        $fee = get_option('personalized_message_fee', 0);
        echo '<input type="number" name="personalized_message_fee" value="' . esc_attr($fee) . '" step="0.01" min="0">';
    }

    function message_char_limit_field() {
        $limit = get_option('personalized_message_char_limit', 100);
        echo '<input type="number" name="personalized_message_char_limit" value="' . esc_attr($limit) . '" step="1" min="0">';
    }

    function promo_text_field() {
        $promo_text = get_option('personalized_message_promo_text', '');
        echo '<input type="text" name="personalized_message_promo_text" value="' . esc_attr($promo_text) . '">';
    }

    function message_categories_field() {
        $selected_categories = get_option('personalized_message_categories', []);
        $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);

        foreach ($categories as $category) {
            $checked = in_array($category->term_id, (array)$selected_categories) ? 'checked' : '';
            echo '<label><input type="checkbox" name="personalized_message_categories[]" value="' . esc_attr($category->term_id) . '" ' . $checked . '> ' . esc_html($category->name) . '</label><br>';
        }
    }

    function settings_page() {
        echo '<div class="wrap">';
        echo '<form action="options.php" method="post">';
        settings_fields('personalized_message_fee_for_woocommerce_settings');
        do_settings_sections('personalized-message-fee');
        submit_button();
        echo '</form>';
        echo '</div>';
    }

    function display_personalized_message($item_id, $item, $order) {
        $personalized_message = $item->get_meta('Personalized Message');

        if ($personalized_message) {
            echo '<p><strong>' . __('Personalized Message', 'personalized-message-fee-for-woocommerce') . ':</strong><br>' . nl2br(esc_html($personalized_message)) . '</p>';
        }
    }
}
