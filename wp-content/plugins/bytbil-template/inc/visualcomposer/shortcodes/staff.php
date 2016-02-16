<?php
require_once('shortcode.base.php');

/**
 * Personal
 */
class StaffShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    private function append_employee(&$employees, $i, $id, $facilities = false, $dep_dropdown = false)
    {
        if ($facilities) {
            $facility = get_field('employee-facility', $id);

            if (!$facility) {
                return false;
            } else {
                if (!in_array($facility->ID, $facilities)) {
                    return false;
                }
            }
        }

        if ($dep_dropdown) {
            $departments = array();
            $post_terms = wp_get_post_terms($id, 'department');

            foreach ($post_terms as $term) {
                array_push($departments, $term->name);
            }

            $employees[$i]['departments'] = $departments;
        }

        $employees[$i]['name'] = get_the_title($id);
        $image = get_field('employee-image', $id);
        $employees[$i]['image'] = $image['url'];
        $employees[$i]['work_title'] = get_field('employee-jobtitle', $id);
        $employees[$i]['email'] = get_field('employee-email', $id);
        $employees[$i]['hide-email'] = get_field('employee-email-hide', $id);
        $employees[$i]['text'] = get_field('employee-textarea', $id);
        $phonenumbers = get_field('employee-phonenumbers', $id);
        if (!empty($phonenumbers)) {
            $employees[$i]['phone'] = $phonenumbers[0]['employee-phonenumber-number'];
        }
    }

    public function processData($atts)
    {
        $dep_dropdown = (self::Exists($atts['dep_dropdown']) == '1') ? true : false;
        $atts['dep_dropdown'] = $dep_dropdown;
        $employees = array();
        $type = self::Exists($atts['employee_type'], false);
        $row_amount = self::Exists($atts['row_amount'], '3');

        if ($type) {
            if ($type === 'generated') {
                $facilities = self::Exists($atts['facility'], false);
                $departments = self::Exists($atts['department_terms'], false);
                $brands = self::Exists($atts['brand_terms'], false);
                $facilities_terms = false;
                $tax_query = array();

                if ($facilities) {
                    $facilities_terms = explode(',', $facilities);
                }

                if ($departments) {
                    $departments_terms = explode(',', $departments);
                    $query = array(
                        'taxonomy' => 'department',
                        'field' => 'id',
                        'terms' => $departments_terms
                    );

                    array_push($tax_query, $query);
                }

                if ($brands) {
                    $brands_terms = explode(',', $brands);
                    $query = array(
                        'taxonomy' => 'brand',
                        'field' => 'id',
                        'terms' => $brands_terms
                    );

                    array_push($tax_query, $query);
                }

                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'employee',
                    'post_status' => 'publish',
                    'tax_query' => $tax_query
                );

                $posts = get_posts($args);

                if (count($posts) > 0) {
                    foreach ($posts as $i => $post) {
                        self::append_employee($employees, $i, $post->ID, $facilities_terms, $dep_dropdown);
                    }
                }
            } elseif ($type === 'employee') {
                $ids = false;

                if (isset($atts['employees']))
                    $ids = $atts['employees'];

                if ($ids) {
                    $expl = explode(',', $ids);

                    foreach ($expl as $i => $id) {
                        self::append_employee($employees, $i, $id, false, $dep_dropdown);
                    }
                }

            } elseif ($type === 'employee_list') {
                $id = self::Exists($atts['employee_list'], false);

                if ($id) {
                    $ids = get_field('employee_list', $id);

                    if ($ids) {
                        foreach ($ids as $i => $id) {
                            self::append_employee($employees, $i, $id, false, $dep_dropdown);
                        }
                    }
                }
            }
        }

        $atts['employees'] = $employees;
        $atts['row_amount'] = $row_amount;

        if ($dep_dropdown) {
            // Register and enqueue jQuery shuffle and BBShuffle
            wp_register_script('jquery-shuffle', VCADMINURL . 'assets/js/vendor/jquery.shuffle.min.js', array(), '1.0.0', true);
            wp_register_script('BBShuffle', VCADMINURL . 'assets/js/BBShuffle.js', array(), '1.0.0', true);
            wp_enqueue_script('jquery-shuffle');
            wp_enqueue_script('BBShuffle');

            $departments = array();
            foreach ($employees as $employee) {
                foreach ($employee['departments'] as $department) {
                    array_push($departments, $department);
                }
            }
            $departments = array_unique($departments);
            $atts['departments'] = $departments;
        }

        return $atts;
    }
}

function bb_init_staff_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Personal',
        'base' => 'staff',
        'description' => 'Visa personal',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => 'Välj visningssätt',
                'param_name' => 'employee_type',
                'value' => array(
                    'Välj personal' => 'employee',
                    'Automatisk lista' => 'generated',
                    'Personallista' => 'employee_list'
                ),
                'description' => 'Välj om du vill visa personal från en lista eller välja själv.'
            ),
            array(
                'type' => 'cptlist',
                'post_type' => 'employee',
                'heading' => 'Välj personal',
                'param_name' => 'employees',
                'value' => '',
                'description' => 'Välj ur en lista av personal',
                'dependency' => array(
                    'element' => 'employee_type',
                    'value' => 'employee'
                )
            ),
            array(
                'type' => 'multiselect',
                'post_type' => 'facility',
                'heading' => 'Filtrera på anläggning',
                'param_name' => 'facility',
                'description' => 'Ctrl-klicka (⌘ om du har Mac) för att välja flera.',
                'dependency' => array(
                    'element' => 'employee_type',
                    'value' => 'generated'
                )
            ),
            array(
                'type' => 'multiselect',
                'heading' => 'Filtrera på avdelning',
                'term_tax' => true,
                'term' => 'department',
                'param_name' => 'department_terms',
                'value' => '',
                'description' => 'Ctrl-klicka (⌘ om du har Mac) för att välja flera.',
                'dependency' => array(
                    'element' => 'employee_type',
                    'value' => 'generated'
                )
            ),
            array(
                'type' => 'multiselect',
                'heading' => 'Filtrera på märke',
                'term_tax' => true,
                'term' => 'brand',
                'param_name' => 'brand_terms',
                'value' => '',
                'description' => 'Ctrl-klicka (⌘ om du har Mac) för att välja flera.',
                'dependency' => array(
                    'element' => 'employee_type',
                    'value' => 'generated'
                )
            ),
            array(
                'type' => 'cpt',
                'post_type' => 'employee_list',
                'heading' => 'Personallista',
                'param_name' => 'employee_list',
                'placeholder' => 'Välj personallista',
                'value' => '',
                'description' => 'Välj en existerande personallista.',
                'dependency' => array(
                    'element' => 'employee_type',
                    'value' => 'employee_list'
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Antal per rad',
                'param_name' => 'row_amount',
                'description' => 'Välj antalet som ska synas per rad',
                'value' => array(
                    'En' => 12,
                    'Två' => 6,
                    'Tre' => 4,
                    'Fyra' => 3,
                    'Sex' => 2
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Visa avdelnings-dropdown',
                'param_name' => 'dep_dropdown',
                'description' => 'Bocka i om du vill kunna välja avdelningar i vyn.',
                'value' => array(
                    'Ja' => '1'
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_staff_params', $map['params']);

    $vcStaff = new StaffShortcode($map);
}
add_action('after_setup_theme', 'bb_init_staff_shortcode');

?>