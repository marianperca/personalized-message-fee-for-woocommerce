<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Personalized_Message_Fee_For_Woocommerce
 * @subpackage Personalized_Message_Fee_For_Woocommerce/public
 * @author     Marian Perca <marian.perca@gmail.com>
 */
class Personalized_Message_Fee_For_Woocommerce_Public
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
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/personalized-message-fee-for-woocommerce-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/personalized-message-fee-for-woocommerce-public.js', array('jquery'), $this->version, false);

        $char_limit = get_option('personalized_message_char_limit', 100);

        wp_localize_script($this->plugin_name, 'personalizedMessageSettings', [
            'charLimit' => $char_limit,
        ]);
    }

    function add_personalized_message_field()
    {
        $product = wc_get_product(get_the_ID());
        $allowed_categories = get_option('personalized_message_categories', []);
        $categories = wp_get_post_terms($product->get_id(), 'product_cat', ['fields' => 'ids']);
        $char_limit = get_option('personalized_message_char_limit', 100);
        $label = sprintf(
            __('Add a personalized message (extra %s %s):', 'personalized-message-fee-for-woocommerce'),
            esc_html(get_option('personalized_message_fee', 0)),
            get_woocommerce_currency()
        );
        $promo_text = get_option('personalized_message_promo_text', '');

        // Check if the product category is allowed
        if (array_intersect($allowed_categories, $categories)) {
            include 'partials/personalized-message-fee-for-woocommerce-public-display.php';
        }
    }

    function validate_personalized_message($passed, $product_id, $quantity)
    {
        $limit = get_option('personalized_message_char_limit', 100);

        if (isset($_POST['personalized_message'])) {
            // count the characters in the personalized message without spaces and new lines
            $message_length = strlen(preg_replace('/\s+/', '', $_POST['personalized_message']));

            if ($message_length > $limit) {
                wc_add_notice(
                    sprintf(
                        __('The personalized message must be less than %s characters.', 'personalized-message-fee-for-woocommerce'),
                        $limit
                    ),
                    'error'
                );
                return false;
            }
        }

        return $passed;
    }

    function add_fee_to_cart()
    {
        global $woocommerce;

        $extra_fee = get_option('personalized_message_fee', 5);
        $total_fee = 0;
        foreach ($woocommerce->cart->get_cart() as $cart_item) {
            if (!empty($cart_item['personalized_message'])) {
                $total_fee += $extra_fee * $cart_item['quantity'];
            }
        }

        if ($total_fee > 0) {
            $woocommerce->cart->add_fee(__('Personalized message', 'personalized-message-fee-for-woocommerce'), $total_fee);
        }
    }

    function save_personalized_message_field($cart_item_data, $product_id)
    {
        if (!empty($_POST['personalized_message'])) {
            $cart_item_data['personalized_message'] = sanitize_textarea_field($_POST['personalized_message']);
        }
        return $cart_item_data;
    }

    function display_personalized_message_cart($item_data, $cart_item)
    {
        if (!empty($cart_item['personalized_message'])) {
            $item_data[] = array(
                'name' => __('Personalized message', 'personalized-message-fee-for-woocommerce'),
                'value' => $cart_item['personalized_message']
            );
        }
        return $item_data;
    }

    function add_personalized_message_to_order_item($item, $cart_item_key, $values, $order)
    {
        if (isset($values['personalized_message'])) {
            $item->add_meta_data(__('Personalized Message', 'personalized-message-fee-for-woocommerce'), $values['personalized_message']);
        }
    }
}
