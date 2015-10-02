<?php

// add Cherry shortcodes to library
add_action('mp_library', 'motopress_cherry_lazy_load_mp_library_action', 10, 1);

// filter shortcode render
add_filter('cherry_plugin_shortcode_output', 'motopress_cherry_lazy_load_output_filter', 10, 3);

// include php files
add_action('motopress_render_shortcode', 'motopress_cherry_lazy_load_render_action', 10, 1);

add_action('init', 'motopress_cherry_lazy_load_init');

function motopress_cherry_lazy_load_init()
{
    if ( isset($_GET['motopress-ce']) && $_GET['motopress-ce'] === '1' ) {
        global $cherry_lazy_load;
        remove_filter( 'cherry_plugin_shortcode_output', array( $cherry_lazy_load, 'add_lazy_load_wrap' ), 9);
    }
}

// filter shortcode output
function motopress_cherry_lazy_load_output_filter($content, $atts, $shortcodename)
{
    if ( !empty($shortcodename) && $shortcodename == "lazy_load_box" ) {

        require_once 'motopress-cherry-shortcodes-utils.php';

        extract(shortcode_atts(addStyleAtts(), $atts));

        $divId = '';
        $script = '';

        if (
            (isset($_GET['motopress-ce']) && $_GET['motopress-ce'] === '1') ||
            (isset($_POST['action']) && $_POST['action'] === 'motopress_ce_render_shortcode')
        ) {
            if ($shortcodename == 'lazy_load_box') {
                $uid = uniqid('lazy_load_');
                $divId = ' id="' . $uid . '" ';
                $script = '<script>jQuery("#' . $uid .' .lazy-load-box").removeClass("trigger").animate({"opacity":"1"}, 100);</script>';
            }
        }        

        $classes = trim($mp_style_classes . getBasicClasses($shortcodename) . getMarginClasses($margin));

        return '<div' . $divId . ( empty($classes) ? '' : (' class="' . $classes . '" ') ) . '>' . $content . '</div>' . $script;
    } else {
        return $content;
    }
}


// add cherry_lazy_load to MP Library
function motopress_cherry_lazy_load_mp_library_action($motopressCELibrary)
{
    global $motopress_cherry_default_title, $motopress_cherry_default_text, $motopressCELang;
    
    $openInEditorText = empty($motopressCELang) ? 'Open in WordPress Editor' : $motopressCELang->CEOpenInWPEditor;

    $motopressCELibrary->addObject(
        new MPCEObject(
            'lazy_load_box',
            'Lazy Load Boxes',
            null,
            array(
                'shortcode_content' => array(
                    'type' => 'longtext-tinymce',
                    'label' => 'Content',
                    'text' => $openInEditorText,
                    'default' => '[spacer]<h1>' . $motopress_cherry_default_title . '</h1><h3>' . $motopress_cherry_default_text . '</h3>[spacer]',
                    'saveInContent' => 'true'
                ),
                'effect' => array(
                    'type' => 'select',
                    'label' => "Effect",
                    'default' => 'fade',
                    'list' => array(
                        'fade' => 'Fade',
                        'slideup' => 'Slideup',
                        'slidefromleft' => 'Slide from left',
                        'slidefromright' => 'Slide from right',
                        'zoomin' => 'Zoom in',
                        'zoomout' => 'Zoom out',
                        'rotate' => 'Rotate',
                        'skew' => 'Skew',
                    ),
                ),
                'delay' => array(
                    'type' => 'slider',
                    'label' => 'Delay',
                    'default' => 0,
                    'min' => 0,
                    'max' => 1000
                ),
                'speed' => array(
                    'type' => 'slider',
                    'label' => 'Speed',
                    'default' => 600,
                    'min' => 100,
                    'max' => 1000
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

function motopress_cherry_lazy_load_render_action($shortcode)
{
    // include cherry lazy_load class file
    if ( file_exists(MOTOPRESS_CHERRYFRAMEWORK_PLUGIN_DIR . '../cherry-lazy-load/cherry-lazy-load.php') )
        include_once (MOTOPRESS_CHERRYFRAMEWORK_PLUGIN_DIR . '../cherry-lazy-load/cherry-lazy-load.php');

    global $cherry_lazy_load;
    remove_filter( 'cherry_plugin_shortcode_output', array( $cherry_lazy_load, 'add_lazy_load_wrap' ), 9);
}
