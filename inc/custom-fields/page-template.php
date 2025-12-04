<?php

acf_add_local_field_group([
    'key' => 'wtvr_page_template_group',
    'title' => 'Custom page template',
    'fields' => [
        [
            'key' => 'wtvr_page_template',
            'label' => 'Select template',
            'name' => '_wp_page_template',
            'type' => 'select',
            'choices' => [
                'default' => 'Default template'
            ],
            'default_value' => 'default',
            'return_format' => 'value'
        ]
    ],
    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ],
            [
                'param' => 'post_type',
                'operator' => '!=',
                'value' => 'post',
            ]
        ]
    ],
    'position' => 'side',
    'style' => 'default',
    'menu_order' => 0,
    'active' => true
]);

add_filter('acf/load_field/key=wtvr_page_template', function($field) {
    global $post;
    if ($post && $post->post_type === 'page') {
        $templates = get_page_templates();
        foreach($templates as $template_name => $template_filename) {
            $field['choices'][$template_filename] = $template_name;
        }
    }
    return $field;
}); 