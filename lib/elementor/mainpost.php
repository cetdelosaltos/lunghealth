<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class LHFT_main_post_list extends \Elementor\Widget_Base
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
        return 'lhft_main_post_list';
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
        return esc_html__('LHF Main Post List', 'lhft_main_post_list');
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
                'label' => esc_html__('Setup', 'lhft_main_post_list'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'lhft_main_post_url',
            [
                'label' => esc_html__('Main Post URL', 'lhft_main_post_list'),
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

        $lhft_grid_set = $this->get_settings_for_display();
        $catego = $lhft_grid_set['lhft_main_post_url'];
        $curl = curl_init();
        $url = $catego['url'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "x-rapidapi-host: climacell-microweather-v1.p.rapidapi.com",
                "x-rapidapi-key: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err):
            echo "No Posts Available";
        else:
            $postitos = json_decode($response);

?>

<div class="lhft-main-posts-list-widget">
    <div class="lhft-list-grid">
        <h5 class="azul">Latest News</h5>
        <ul class="lhft-main-post-list roboto">
            <?php foreach ($postitos as $postis): ?>
            <li>
                <a href="<?php echo $postis->link; ?>" target="_blank">
                    <?php echo $postis->title->rendered; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php
        endif;
    }

}
?>