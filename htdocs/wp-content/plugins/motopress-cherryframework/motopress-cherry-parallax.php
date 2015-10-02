<?php

// add Cherry shortcodes to library
add_action('mp_library', 'motopress_cherry_parallax_mp_library_action', 10, 1);

// filter shortcode render
add_filter('cherry_plugin_shortcode_output', 'motopress_cherry_parallax_output_filter', 10, 3);

// include php files
add_action('motopress_render_shortcode', 'motopress_cherry_parallax_render_action', 10, 1);

// filter shortcode output
function motopress_cherry_parallax_output_filter($content, $atts, $shortcodename)
{
    if ( !empty($shortcodename) && $shortcodename == "cherry_parallax" ) {

        require_once 'motopress-cherry-shortcodes-utils.php';

        extract(shortcode_atts(addStyleAtts(), $atts));

        $classes = trim($mp_style_classes . getBasicClasses($shortcodename) . getMarginClasses($margin));

        return '<div' . ( empty($classes) ? '' : (' class="' . $classes . '" ') ) . '>' . $content . '</div>';
    } else {
        return $content;
    }
}


// add cherry_parallax to MP Library
function motopress_cherry_parallax_mp_library_action($motopressCELibrary)
{
    global $motopress_cherry_default_title, $motopress_cherry_default_text, $motopressCELang;
    
    $openInEditorText = empty($motopressCELang) ? 'Open in WordPress Editor' : $motopressCELang->CEOpenInWPEditor;

    $motopressCELibrary->addObject(
        new MPCEObject(
            'cherry_parallax',
            'Cherry Parallax',
            null,
            array(
                'shortcode_content' => array(
                    'type' => 'longtext-tinymce',
                    'label' => 'Content',
                    'text' => $openInEditorText,
                    'default' => '[spacer]<h1>' . $motopress_cherry_default_title . '</h1><h3>' . $motopress_cherry_default_text . '</h3>[spacer]',
                    'saveInContent' => 'true'
                ),
                'image' => array(
                    'type' => 'text',
                    'label' => "Image",
                    'default' => '//lorempixel.com/1920/600/abstract/9/',
                ),
                'width' => array(
                    'type' => 'text',
                    'label' => 'Width',
                    'default' => '1920',
                ),
                'speed' => array(
                    'type' => 'slider',
                    'label' => 'Speed',
                    'default' => 3,
                    'min' => 1,
                    'max' => 10
                ),
                'custom_class' => array(
                    'type' => 'text',
                    'label' => "Custom class",
                ),
            ),
            0,
            MPCEObject::ENCLOSED
        ),
        'other'
    );
}

// include cherry parallax class file
function motopress_cherry_parallax_render_action($shortcode)
{
    if ( file_exists(MOTOPRESS_CHERRYFRAMEWORK_PLUGIN_DIR . '../cherry-parallax/cherry-parallax.php') )
        include_once (MOTOPRESS_CHERRYFRAMEWORK_PLUGIN_DIR . '../cherry-parallax/cherry-parallax.php');
}
