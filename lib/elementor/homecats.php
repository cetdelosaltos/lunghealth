<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class LHFT_cats_grid extends \Elementor\Widget_Base
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
        return 'lhft_cats_grid';
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
        return esc_html__('LHF Toolkit Home Grid', 'lhft_cats_grid');
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
                'label' => esc_html__('Setup', 'lhft_cats_grid'),
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
                'label' => esc_html__('LHF Tool Category', 'lhft_cats_grid'),
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
        $lhft_grid_set = $this->get_settings_for_display();
        $catego = $lhft_grid_set['lhft_category'];
        $cati = get_category($catego);
        $catidos = get_term($catego, 'lhf_tools_categories');
        if ($cati):
            $ttermitas = get_term_meta($cati->term_id);
            $thumbitas = wp_get_attachment_url($ttermitas['jupiterx_taxonomy_thumbnail_id'][0]);
            $lhft_page_link = get_field('related_page', $cati) ? get_field('related_page', $cati) : get_term_link($cati);
            $descripcion = $cati->description;
            $nombre = $cati->name;
            $vinculo = get_category_link($cati->term_id);
        endif;
        if ($catidos):
            $campitos = get_fields($catidos);
            $thumbitas = $campitos['category_thumbnail'];
            $lhft_page_link = $campitos['related_page'];
            $descripcion = $catidos->description;
            $nombre = $catidos->name;
            $vinculo = get_category_link($cati->term_id);
        endif;

?>

<div class="lhft-home-widget">
    <div class="lhft-home-grid">
        <div class="lhft-fondo-cat">
            <a href="<?= $lhft_page_link; ?>" class="lhft-cat-link">
                <img src="<?= $thumbitas; ?>" alt="<?= $nombre; ?>" class="lhft-cat-image">
                <div href="<?= $lhft_page_link; ?>" class="lhft-cat-btn lhft-btn-color elementor-button ">
                    <?= $nombre; ?>
                </div>
            </a>
        </div>
        <!--
        <div class="lhft-cat-description">
            <?php /* $descripcion;*/?>
        </div>
    -->
    </div>
</div>
<?php

    }

}