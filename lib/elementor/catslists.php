<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class LHFT_cats_list extends \Elementor\Widget_Base
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
        return 'lhft_cats_list';
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
        return esc_html__('LHF Toolkit Category List', 'lhft_cats_list');
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
                'label' => esc_html__('Setup', 'lhft_cats_list'),
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
                'label' => esc_html__('LHF Tool Category', 'lhft_cats_list'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => $miscats
            ]
        );
        /* $this->add_control(
         'lhft_button_color',
         [
         'label' => esc_html__('Button Color', 'textdomain'),
         'type' => \Elementor\Controls_Manager::COLOR,
         'selectors' => [
         '{{WRAPPER}} .lhft-btn-color' => 'background-color: {{VALUE}}',
         ],
         ]
         ); */


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
        $cati = get_term($catego, 'lhf_tools_categories');
        $arqcats = array(
            'numberposts' => -1,
            'post_type' => 'lhftools',
            'tax_query' => array(
                    array(
                    'taxonomy' => 'lhf_tools_categories',
                    'field' => 'slug',
                    'terms' => $cati->slug,
                ),
            ),
            'order' => 'ASC'
        );
        $listaquery = get_posts($arqcats);
        $l = 1;
?>

<div class="lhft-list-widget">
    <div class="lhft-list-grid">
        <div class="accordion" id="accordiontlhfools">
            <?php foreach ($listaquery as $cadatool): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="lhftoolaccheading<?= $l; ?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="<?='#lhftoolitem' . $l; ?>" aria-expanded="true"
                        aria-controls="<?='lhftoolitem' . $l; ?>">
                        <?= $cadatool->post_title; ?>
                    </button>
                </h2>
                <div id="<?='lhftoolitem' . $l; ?>" class="accordion-collapse collapse <?=($l == 1) ? ' show ' : '' ?>"
                    aria-labelledby="lhftoolaccheading<?= $l; ?>" data-bs-parent="#accordiontlhfools">
                    <div class="accordion-body">
                        <div>
                            <?= $cadatool->post_content; ?>
                        </div>
                        <div class="text-end">
                            <a href="<?= get_permalink($cadatool->ID); ?>" class="btn lhft-red-button">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $l++;
        endforeach; ?>
        </div>
    </div>
</div>
<?php
    }

}