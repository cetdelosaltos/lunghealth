<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class LHFT_cats_menu extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */public function get_name()
    {
        return 'lhft_cats_menu';
    }
    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */public function get_title()
    {
        return esc_html__('LHF Toolkit SideMenu', 'lhft_cats_menu');
    }
    /**
     * Get widget icon.
     *
     * Retrieve oEmbed widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */public function get_icon()
    {
        return 'fa fa-lungs';
    }
    /**
     * Get custom help URL.
     *
     * Retrieve a URL where the user can get more information about the widget.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget help URL.
     */public function get_custom_help_url()
    {
        return 'https://developers.elementor.com/docs/widgets/';
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */public function get_categories()
    {
        return array('lhf');
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */public function get_keywords()
    {
        return ['post', 'post_grid', 'url', 'link'];
    }
    /**
     * Register oEmbed widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Setup', 'lhft_cats_menu'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $todascats = get_categories(array('taxonomy' => 'lhf_tools_categories', 'hide_empty' => false));
        $miscats = array();
        foreach ($todascats as $lascats) {
            $miscats[$lascats->term_id] = $lascats->name;
        }
        $this->add_control(
            'lhft_category',
            [
                'label' => esc_html__('LHF Tool Category', 'lhft_cats_menu'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => $miscats
            ]
        );
        $this->add_control(
            'lhft_button_color',
            [
                'label' => esc_html__('Button Color', 'textdomain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lhft-btn-color' => 'background-color: {{VALUE}}',
                ],
            ]

        );


        $this->end_controls_section();
    }
    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */protected function render()
    {
        global $post;
        $lhft_grid_set = $this->get_settings_for_display();
        $termino = get_the_terms($post->ID, 'lhf_tools_categories', 'string');
        $term_ids = wp_list_pluck($termino, 'term_id');
        $lalista = get_posts(array(
            'post_type' => 'lhftools',
            'numberposts' => -1,
            'tax_query' => array(
                    array(
                    'taxonomy' => 'lhf_tools_categories',
                    'field' => 'id',
                    'terms' => $term_ids,
                    'operator' => 'IN' //Or 'AND' or 'NOT IN'
                )
            ),
            'order' => 'ASC'
        ));
?>

<div class="lhft-catlist-sidebar-widget">
    <ul class="list-group list-group-flush">
        <?php foreach ($lalista as $postito): ?>
        <a href="<?= get_the_permalink($postito->ID); ?>"
            class="list-group-item list-group-item-action <?=($postito->ID == $post->ID) ? 'active fw-bold' : '' ?>">

            <?= $postito->post_title; ?>
        </a>
        <?php
        endforeach; ?>
    </ul>
</div>
<?php

    }

}