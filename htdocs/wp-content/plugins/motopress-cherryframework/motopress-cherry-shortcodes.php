<?php

global $motopress_cherry_shortcodes_map, $mpc_cherry_prefix;

$motopress_cherry_shortcodes_map = array();
$mpc_cherry_prefix = 'mpc_';

require_once 'motopress-cherry-shortcodes-utils.php';
require_once 'motopress-cherry-shortcodes-map.php';

// add Cherry scripts
if (isset($_GET['motopress-ce']) && $_GET['motopress-ce'] == 1) {
    add_action('wp_head', 'motopress_cherry_shortcodes_wphead');
}

// add Cherry shortcodes to library
add_action('mp_library', 'motopress_cherry_shortcodes_mp_library_action', 10, 1);

// include php files
add_action('motopress_render_shortcode', 'motopress_cherry_shortcodes_render_action', 10, 1);

// filter shortcode render
add_filter('cherry_plugin_shortcode_output', 'motopress_cherry_plugin_shortcode_output_filter', 10, 3);

// tinymce inline elements
add_action('mp_library', 'motopress_cherry_extend_tinymce_style_formats', 11, 1);


/* create new shortcode to render original one in div for margin and custom class name */
foreach ($motopress_cherry_shortcodes_map as $id => $cherryShortcode) {
    if ( isset($cherryShortcode['rewrite']) && $cherryShortcode['rewrite'] == TRUE) {
        add_shortcode($id, "motopress_cherry_common_shortcode_renderer");
    }
}

function motopress_cherry_shortcodes_wphead() {
    wp_enqueue_script('owl-carousel', CHERRY_PLUGIN_URL .'lib/js/owl-carousel/owl.carousel.min.js',
        array('jquery'), '1.31', true);
    wp_enqueue_script('cherry-plugin', CHERRY_PLUGIN_URL . 'includes/js/cherry-plugin.js',
        array('jquery'));
    wp_enqueue_script('roundabout_script', CHERRY_PLUGIN_URL . 'lib/js/roundabout/jquery.roundabout.min.js',
        array('jquery'));
    wp_enqueue_script('roundabout_shape', CHERRY_PLUGIN_URL . 'lib/js/roundabout/jquery.roundabout-shapes.min.js',
        array('jquery'));
    wp_enqueue_script('googlemapapis', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false',
        array('jquery'));
}

// add cherry shortcodes to MP Library
function motopress_cherry_shortcodes_mp_library_action($motopressCELibrary)
{
    global $motopress_cherry_shortcodes_map;
    require_once 'motopress-cherry-shortcodes-parser-class.php';

    $cherry_shortcodes_dir = CHERRY_PLUGIN_DIR . "admin/shortcodes/shortcodes/";

    foreach ($motopress_cherry_shortcodes_map as $id => $cherryShortcode)
    {
        $mpCherryShortcodeParser = new MPCherryShortcodeParser(
            $cherry_shortcodes_dir . $cherryShortcode['jsFile'], $cherryShortcode);
        $parameters = $mpCherryShortcodeParser->parameters;

        if ( ($id == 'content_box') || ($id == 'extra_wrap') ) {
        
            global $motopress_cherry_default_title, $motopress_cherry_default_text, $motopressCELang;
            $openInEditorText = empty($motopressCELang) ? 'Open in WordPress Editor' : $motopressCELang->CEOpenInWPEditor;
        
            $parameters['shortcode_content'] = array(
                'type' => 'longtext-tinymce',
                'label' => 'Content:',
                'text' => $openInEditorText,
                'default' => '[spacer]<h1>' . $motopress_cherry_default_title . '</h1><h3>' . $motopress_cherry_default_text . '</h3>[spacer]',
                'saveInContent' => 'true'
            );
        }

        $motopressCELibrary->addObject(
            // new MPCEObject( $id, $name, $icon, $attributes, $position, $closeType, $resize );
            new MPCEObject(
                $id,
                $cherryShortcode['label'],
                $cherryShortcode['icon'],
                $parameters,
                0,
                $cherryShortcode['closeType'], //MPCEObject::ENCLOSED
                $cherryShortcode['resize']
            ),
            $cherryShortcode['group']
        );
    }
    
    //$motopressCELibrary->removeObject('mp_button');
    $motopressCELibrary->getObject('mp_button')->setShow(false);
    $motopressCELibrary->removeObject('mp_gmap');
    $motopressCELibrary->removeObject('mp_posts_grid');
}

// include cherry shortcodes
function motopress_cherry_shortcodes_render_action($shortcode)
{
    /*global $motopress_cherry_shortcodes_map;
    $cherry_shortcodes_dir = CHERRY_PLUGIN_DIR . "includes/shortcodes/";

    if (!empty($shortcode) && !empty($motopress_cherry_shortcodes_map[$shortcode]))
    {
        $phpFile = $cherry_shortcodes_dir . $motopress_cherry_shortcodes_map[$shortcode]['phpFile'];
        // include one shortcode
        if ( is_file($phpFile) )
                include_once ($phpFile);
    } else {
        // include all shortcodes
        foreach ($motopress_cherry_shortcodes_map as $id => $cherryShortcode)
        {
            $phpFile = $cherry_shortcodes_dir . $cherryShortcode['phpFile'];
            if ( is_file($phpFile) )
                include_once ($phpFile);
        }
    }
    
    $shortCodeFiles = array(
        'pricing-tables.php', 'html.php', 'shortcodes.php', 'misc.php',
    );
    
    switch ($shortcode) {
        case 'mp_code' :
        case 'content_box' :
        case 'extra_wrap' :
        {
            foreach ($shortCodeFiles as $shortcodeFile)
            {
                if ( is_file($cherry_shortcodes_dir . $shortcodeFile) )
                    include_once ($cherry_shortcodes_dir . $shortcodeFile);
            }
            break;
        }
    }*/
    if ( is_file(CHERRY_PLUGIN_DIR . 'includes/plugin-includes.php') )
        include_once (CHERRY_PLUGIN_DIR . 'includes/plugin-includes.php');
}

// filter shortcode output
function motopress_cherry_plugin_shortcode_output_filter($content, $atts, $shortcodename)
{
    global $motopress_cherry_shortcodes_map;

    if ( !empty($shortcodename) && array_key_exists($shortcodename,$motopress_cherry_shortcodes_map) ) {
        extract(shortcode_atts(addStyleAtts(), $atts));

        $classes = trim($mp_style_classes . getBasicClasses($shortcodename) . getMarginClasses($margin));
        
        $output = '<div' . ( empty($classes) ? '' : (' class="' . $classes . '" ') ) . '>' . $content . '</div>';
        
        if ((isset($_POST['action']) && $_POST['action'] == 'motopress_ce_render_shortcode')) {
            if ($shortcodename == 'carousel_owl') {
                $output .= '<script>cherryPluginCarouselInit();</script>';
            }
        }

        return $output;
    } else {
        return $content;
    }
}


function motopress_cherry_extend_tinymce_style_formats($motopressCELibrary) {
    $motopressCELibrary->tinyMCEStyleFormats[] = array(
        'title' =>'Text highlight',
        'inline' => 'span',
        'classes' => 'text-highlight'
    );
    $motopressCELibrary->tinyMCEStyleFormats[] = array(
        'title' =>'Dropcap',
        'inline' => 'span',
        'classes' => 'dropcap'
    );
    $motopressCELibrary->tinyMCEStyleFormats[] = array(
        'title' =>'Label',
        'inline' => 'span',
        'classes' => 'label'
    );
    $motopressCELibrary->tinyMCEStyleFormats[] = array(
        'title' =>'Well',
        'inline' => 'span',
        'classes' => 'well'
    );
    $motopressCELibrary->tinyMCEStyleFormats[] = array(
        'title' =>'Small',
        'inline' => 'span',
        'classes' => 'small'
    );
}