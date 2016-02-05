<?php
require_once('shortcode.base.php');

/**
 * Sociala länkar
 */
class SocialShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    public function processData($atts)
    {
        $share_links = (self::Exists($atts['share_links'], '') === '1') ? true : false;
        $social_links = self::Exists($atts['social_links'], '');
        $social_links = explode(',', $social_links);

        $links = array();
        $app_id = null;
        $url = get_permalink();
        $url_encoded = urlencode($url);

        if (count($social_links) > 0) {
            foreach ($social_links as $link) {
                $item = array();

                if ($link === 'facebook') {
                    if ($share_links) {
                        $app_id = get_field('settings-fb-app-id', 'options');
                        $the_link = 'https://www.facebook.com/dialog/share?app_id=' . $app_id . '&display=' . $url_encoded;
                    } else {
                        $fb = get_field('settings-fb', 'options');
                        $the_link = 'http://www.facebook.com/' . $fb;
                    }
                    $item['icon'] = 'ion ion-social-facebook';
                    $item['link'] = $the_link;
                } elseif ($link === 'instagram') {

                } elseif ($link === 'twitter') {
                    if ($share_links) {
                        $app_id = get_field('settings-twitter-app-id', 'options');
                        $the_link = 'https://www.twitter.com/intent/tweet?url=' . $url_encoded;
                    } else {
                        $twitter = get_field('settings-twitter', 'options');
                        $the_link = 'http://www.twitter.com/' . $twitter;
                    }
                    $item['icon'] = 'ion ion-social-twitter';
                    $item['link'] = $the_link;
                }

                if (!empty($item)) {
                    array_push($links, $item);
                }
            }
        }

        if (!empty($links)) {
            $atts['social_links'] = $links;
        }

        return $atts;
    }
}

function bb_init_social_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Sociala länkar',
        'base' => 'social',
        'description' => 'Lägg till länkar till sociala medier',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'checkbox',
                'heading' => 'Delningslänkar',
                'param_name' => 'share_links',
                'description' => 'Kryssa i om du vill använda som delningslänkar.',
                'value' => array(
                    'Ja' => '1'
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Välj länkar',
                'param_name' => 'social_links',
                'value' => array(
                    'Facebook' => 'facebook',
                    'Instagram' => 'instagram',
                    'Twitter' => 'twitter'
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_social_params', $map['params']);

    $vcSocial = new SocialShortcode($map);
}
add_action('after_setup_theme', 'bb_init_social_shortcode');

?>