<?php

class MPCherryShortcodeParser {

    private $info;

    private $defaultValues;

	public $parameters = array();

	public function __construct( $file, $info ) {

        $this->info = $info;
        $this->defaultValues = $info['defaultValues'];

        if (is_file($file))
        {
            $data = file_get_contents($file);

            $pattern = '/^(frameworkShortcodeAtts\s*=)(?P<data>(.*))(\};)/s';
            preg_match($pattern, $data, $matches);
            $data = $matches['data'] . "}";

            $data = str_replace("attributes:", '"attributes":', $data);
            $data = str_replace("label:", '"label":', $data);
            $data = str_replace("id:", '"id":', $data);
            $data = str_replace("help:", '"help":', $data);
            $data = str_replace("controlType:", '"controlType":', $data);
            $data = str_replace("selectValues:", '"selectValues":', $data);
            $data = str_replace("defaultValue:", '"defaultValue":', $data);
            $data = str_replace("defaultText:", '"defaultText":', $data);
            $data = str_replace("defaultContent:", '"defaultContent":', $data);
            $data = str_replace("shortcode:", '"shortcode":', $data);
            $data = str_replace("shortcodeType:", '"shortcodeType":', $data);
            $data = str_replace("item_class:", '"item_class":', $data);

            $your_array = explode("\n", $data);

            foreach ($your_array as $key => $value)
            {
                $val = explode(":", $value, 2);
                $valKey = trim($val[0]);
                $valValue = isset($val[1]) ? $val[1] : "";
                switch ($valKey) {
                    case '"help"':
                    case '"label"':
                    break;

                    default:
                        $valValue = preg_replace('/\'/', '"', $valValue);
                }
                if (strlen($valValue))
                    $your_array[$key] = $valKey . ":" . $valValue;
                else
                    $your_array[$key] = $valKey;
            }
            $data = implode('', $your_array);

            $values = json_decode($data);

            $attributes = isset( $values->attributes ) ? $values->attributes : null;

            $motoPressParameters = array();

            $cotrolsMap = array(
                'select-control' => 'select',
                'textarea-control' => 'longtext'
            );
            
            if (!empty($values->defaultContent)) {
                $motoPressParameters['shortcode_content'] = array(
                    'type' => 'longtext',
                    'label' => 'Content:',
                    'default' => $values->defaultContent,
                    'saveInContent' => 'true'
                );
            }

            if ($attributes) {
                foreach ($attributes as $attribute) {
                
                    /*if ($attribute->id == "custom_class")
                        continue;*/
                
                    $mpParams = array();
                    
                    $mpParams['label'] = $attribute->label;
                    $mpParams['description'] = $attribute->help;
                    
                    if (isset($attribute->defaultValue))
                        $mpParams['default'] = $attribute->defaultValue;
                    else
                    {
                        if (isset($this->defaultValues[$attribute->id]))
                            $mpParams['default'] = $this->defaultValues[$attribute->id];
                        else
                            $mpParams['default'] = '';
                    }
                    if (isset($attribute->controlType))
                        $mpParams['type'] = $cotrolsMap[$attribute->controlType];
                    else
                        $mpParams['type'] = 'text';
                    
                    if (isset($attribute->selectValues))
                    {
                        $mpParams['list'] = array();
                        foreach ($attribute->selectValues as $listItem)
                        {
                            $mpParams['list'][$listItem] = $listItem;
                        }
                    }

                    $motoPressParameters[$attribute->id] = $mpParams;
                }
            }

            $this->parameters = $motoPressParameters;
        }
    }

}