<?php

function mapCherryShortcode($id, $label, $jsFile, $phpFile, $group = 'other', $position = null,
    $icon = '', $defaultValues = null, $rewrite = false, $customRenderFunction = '', $closeType = 'enclosed', $resize = 'horizontal')
{
    global $motopress_cherry_shortcodes_map, $mpc_cherry_prefix;

    $shortcodeName = $rewrite ? $mpc_cherry_prefix . $id : $id;

    $motopress_cherry_shortcodes_map[$shortcodeName] = array (
        'original_shortcode' => $id,
        'label' => $label,
        'jsFile' => $jsFile,
        'phpFile' => $phpFile,
        'defaultValues' => $defaultValues,
        'rewrite' => $rewrite,
        'render_function' => $customRenderFunction,
        'group' => $group,
        'icon' => $icon,
        'closeType' => $closeType,
        'resize' => $resize,
    );
}

/* code from MP */
function addStyleAtts($atts = array()) {
    $styles = array(
        'mp_style_classes' => '',
        'margin' => ''
    );
    $styles['classes'] = ''; //for support versions less than 1.4.6 where margin save in classes

    $intersect = array_intersect_key($atts, $styles);
    if (!empty($intersect)) {
        echo '<p>Shortcode attributes intersect with style attributes</p>';
        var_dump($intersect);
    }
    return array_merge($atts, $styles);
}

function getMarginClasses($margin, $space = true) {
    $result = '';
    if (is_string($margin)) {
        $margin = trim($margin);
        if (!empty($margin)) {
            $margin = explode(',', $margin, 4);
            $margin = array_map('trim', $margin);

            $marginClasses = array();
            if (count(array_unique($margin)) === 1 && $margin[0] !== 'none') {
                $marginClasses[] = 'motopress-margin-' . $margin[0];
            } else {
                $sides = array('top', 'bottom', 'left', 'right');
                foreach ($margin as $key => $value) {
                    if ($value !== 'none') {
                        $marginClasses[] = 'motopress-margin-' . $sides[$key] . '-' . $value;
                    }
                }
            }
            if (!empty($marginClasses)) $result = implode(' ', $marginClasses);
            if (!empty($result) && $space) $result = ' ' . $result;
        }
    }
    return $result;
}

/* end from MP */

function motopress_cherry_common_shortcode_renderer($atts, $content = null, $shortcode_name) {
    global $motopress_cherry_shortcodes_map;

    $shortCodeMap = $motopress_cherry_shortcodes_map[$shortcode_name];
    $originalShortcodeRenderFunction = $shortCodeMap['render_function'];

    if (strlen($originalShortcodeRenderFunction) == 0)
        $originalShortcodeRenderFunction = $shortCodeMap['original_shortcode'] . '_shortcode';

    if (is_callable($originalShortcodeRenderFunction))
        $result = call_user_func($originalShortcodeRenderFunction, $atts, $content);
    else
        $result = '"' . $originalShortcodeRenderFunction . '"' . ' is not callable';
    
    extract(shortcode_atts(addStyleAtts(), $atts));

    if (!empty($classes)) $classes = ' ' . $classes;
    if (!empty($custom_class)) $custom_class = ' ' . $custom_class;
    return '<div class="' . $shortcode_name . $classes . getMarginClasses($margin) . $custom_class . '">' . $result . '</div>';
}

function getBasicClasses($shortcodeName, $space = false) {
    global $motopressCELibrary;
    $result = '';
    if (isset($motopressCELibrary) && !empty($shortcodeName)) {
        $object = &$motopressCELibrary->getObject($shortcodeName);
        if ($object) {
            $styleClasses = &$object->getStyle('mp_style_classes');
            if (array_key_exists('basic', $styleClasses) && !empty($styleClasses['basic'])) {
                $classes = array();
                if (!array_key_exists('class', $styleClasses['basic'])) {
                    foreach ($styleClasses['basic'] as $value) {
                        $classes[] = $value['class'];
                    }
                } else {
                    $classes[] = $styleClasses['basic']['class'];
                }
                if (!empty($classes)) $result = implode(' ', $classes);
                if (!empty($result) && $space) $result = ' ' . $result;
            }
        }
    }
    return $result;
}