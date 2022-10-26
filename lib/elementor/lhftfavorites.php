<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class LHFT_favorites_bar extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        wp_register_script('lhft_favorites_jquery', LHF_URL . '/lib/elementor/lhft_custom.min.js', ['elementor-frontend'], '1.0.5', true);
    }
    public function get_name()
    {
        return 'lhft_favorites_bar';
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
        return esc_html__('LHF Favorites', 'lhft_favorites_bar');
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
     */
    public function get_script_depends()
    {
        return ['lhft_favorites_jquery'];
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Setup', 'lhft_favorites_bar'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $todascats = get_categories(array('taxonomy' => 'lhf_tools_categories', 'hide_empty' => false));
        $miscats = array();
        foreach ($todascats as $lascats) {
            $miscats[$lascats->term_id] = $lascats->name;
        }
        $this->add_control(
            'lhft_favorites_list_url',
            [
                'label' => esc_html__('Favorites List URL', 'lhft_favorites_bar'),
                'type' => \Elementor\Controls_Manager::URL
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
        $lhft_favorites_set = $this->get_settings_for_display();

?>
<div class="lhft_favorites_bar">
    <?php
        $allfavoritesURL = $lhft_favorites_set['lhft_favorites_list_url'];
        $cuantos = get_total_favorites_count();
        if ($cuantos > 0):
            if ($allfavoritesURL):
                $favoritos_link = '<a href="' . $allfavoritesURL['url'] . '">' . $cuantos . ' Tools Added</a>';
    else:
    $favoritos_link = $cuantos;
    endif;
    echo $favoritos_link;
    else: ?>
    <?="No Tools added"; ?>
    <?php endif;
?>
</div>
<?php }

}
?>