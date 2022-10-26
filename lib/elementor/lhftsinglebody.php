<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class LHFT_single_card extends \Elementor\Widget_Base
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
        return 'lhft_single_card';
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
        return esc_html__('LHF Toolkit Single Card', 'lhft_single_card');
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
                'label' => esc_html__('Setup', 'lhft_single_card'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
        $termino = get_the_terms($post->ID, 'lhf_tools_categories', 'string');
        $term_ids = wp_list_pluck($termino, 'term_id');
        $lalista = get_posts(array(
            'post_type' => 'lhftools',
            'tax_query' => array(
                    array(
                    'taxonomy' => 'lhf_tools_categories',
                    'field' => 'id',
                    'terms' => $term_ids,
                    'operator' => 'IN' //Or 'AND' or 'NOT IN'
                )
            ),
        ));
?>

<div class="lhft-single-card">
    <h3 class="roboto azul fw-bold">
        <?= $post->post_title; ?>
    </h3>
    <div class="card mb-3">
        <div class="row g-0">

            <div class="col-md-12 lhft-single-card-data">

                <div class="card-body roboto">
                    <?php if ($post->post_content): ?>
                    <div class="lhft_tool_single_field">
                        <p><span class="gris fw-bold">Description:</span>
                            <?= wp_filter_nohtml_kses($post->post_content); ?>
                        </p>
                    </div>
                    <?php
        endif;
        if (get_field('ownerauthor', $post->ID)):
            $autorurl = get_search_link(get_field('ownerauthor', $post->ID));
                    ?>
                    <div class="lhft_tool_single_field">
                        <p>
                            <span class="gris fw-bold">Owner/Author: </span>
                            <?php /*
                             <a href="<?= $autorurl; ?>">
                             <?= get_field('ownerauthor', $post->ID); ?>
                             </a>*/?>
                        </p>
                    </div>
                    <?php
        endif;
        if (get_field('year', $post->ID)): ?>
                    <div class="lhft_tool_single_field">
                        <p>
                            <span class="gris fw-bold">Year: </span>
                            <?= get_field('year', $post->ID); ?>
                        </p>
                    </div>
                    <?php
        endif;
        if (get_field('patient_population', $post->ID)): ?>
                    <div class="lhft_tool_single_field">

                        <p>
                            <span class="gris fw-bold">Patient Population: </span>

                            <?php $pacientes = get_field('patient_population', $post->ID);
            $cuantospacientes = count($pacientes);
            $f = 1;
            foreach ($pacientes as $formato):
                $formatico = get_term($formato, 'lhft_format');
                $linkformato = get_term_link($formatico);
                $vinculoformato = '';
                //$vinculoformato = '<a href="' . $linkformato . '">';
                $vinculoformato .= $formato;
                // $vinculoformato .= '</a>';
                echo $vinculoformato;
                $f++;
                echo ($f <= $cuantospacientes) ? ', ' : '';
            endforeach; ?>
                        </p>
                    </div>
                    <?php
        endif;
        if (get_field('supporting_evidence', $post->ID)): ?>
                    <div class="lhft_tool_single_field">

                        <p>
                            <span class="gris fw-bold">Supporting Evidence: </span>
                            <?php
            $soportes = get_field('supporting_evidence', $post->ID);
            $cuantossoportes = count($soportes);
            $so = 0;
            foreach ($soportes as $soporte):
                $vinculoformato = '<a href="' . $soporte['link']['url'] . '" target="' . $soporte['link']['target'] . '">';
                $vinculoformato .= $soporte['link']['title'];
                $vinculoformato .= '</a>';
                echo $vinculoformato;
                $so++;
                echo ($so < $cuantossoportes) ? ', ' : '';
                $so++;
            endforeach; ?>
                        </p>
                    </div>
                    <?php
        endif;
        if (get_field('format', $post->ID)): ?>
                    <div class="lhft_tool_single_field">

                        <p>
                            <span class="gris fw-bold">Format: </span>
                            <?php $formatos = get_field('format', $post->ID);
            $cuantosformatos = count($formatos);
            $f = 1;
            foreach ($formatos as $formato):
                $formatico = get_term($formato, 'lhft_format');
                $linkformato = get_term_link($formatico);
                $vinculoformato = '';
                //$vinculoformato = '<a href="' . $linkformato . '">';
                $vinculoformato .= $formatico->name;
                // $vinculoformato .= '</a>';
                echo $vinculoformato;
                $f++;
                echo ($f <= $cuantosformatos) ? ', ' : '';
            endforeach; ?>
                        </p>
                    </div>
                    <?php
        endif;
        if (get_field('access_instructions', $post->ID)): ?>
                    <div class="lhft_tool_single_field">
                        <p>
                            <span class="gris fw-bold">Access Instructions:&nbsp;</span>
                            <?= get_field('access_instructions', $post->ID, false); ?>
                        </p>
                    </div>
                    <?php
        endif;
        if (get_the_tag_list('', ', ', '', $post->ID)): ?>
                    <div class="lhft_tool_single_field">
                        <p>
                            <span class="gris fw-bold">Tags: </span>
                            <?php print_r(get_the_tag_list('', ', ', '', $post->ID)); ?>
                        </p>
                    </div>
                    <?php
        endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

    }

}