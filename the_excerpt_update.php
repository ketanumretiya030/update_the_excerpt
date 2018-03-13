<?php
/*
Plugin Name: Update the_excerpt
Text Domain: update_the_excerpt
Domain Path: /languages
Plugin URI: http://wordpresshtml.com/
Description: Plugin will allow html tag in the_exrpte and update word length , Readmore text.
Version: 1
Author: Ketan umretiya 
Author URI: https://profiles.wordpress.org/ketanumretiya030
*/

function ket_allowedtags_excerpt() {
    // Add custom tags to this string
        return '<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>'; 
    }

if ( ! function_exists( 'ket_update_the_excerpt' ) ) : 

    function ket_update_the_excerpt($ketex_excerpt) {
    $raw_excerpt = $ketex_excerpt;
        if ( '' == $ketex_excerpt ) {

            $ketex_excerpt = get_the_content('');
            $ketex_excerpt = strip_shortcodes( $ketex_excerpt );
            $ketex_excerpt = apply_filters('the_content', $ketex_excerpt);
            $ketex_excerpt = str_replace(']]>', ']]&gt;', $ketex_excerpt);
            $ketex_excerpt = strip_tags($ketex_excerpt, ket_allowedtags_excerpt()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            // word count and only break after sentence is complete.
                $excerpt_word_count = 30;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $ketex_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) { 
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $ketex_excerpt = trim(force_balance_tags($excerptOutput));

                $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '"> Read more </a>'; 
               // $excerpt_more = apply_filters('excerpt_more', $excerpt_end); 

                //$pos = strrpos($ketex_excerpt, '</');
                //if ($pos !== false)
                // Inside last HTML tag
                //$ketex_excerpt = substr_replace($ketex_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                //else
                // After the content
                $ketex_excerpt .= $excerpt_end; /*Add read more in new paragraph */

            return $ketex_excerpt;   

        }
        return apply_filters('ket_update_the_excerpt', $ketex_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'ket_update_the_excerpt'); 

// admin setup page  add in version 2

/*function ketexprt_options_page()
{
    add_submenu_page( 'options-general.php', 'Excerpt info ','Excerpt info ', 'manage_options', 'ketexrpt_option', 'ketexrpt_option_page_html' );
}
add_action('admin_menu', 'ketexprt_options_page');

//admin page code
function ketexrpt_option_page_html()
{
?>
    <h2>Select alert Post type </h2>
    <form name="ketexcerpt" id="ketexcerpt" method="post" action="options-general.php?page=ketexrpt_option">
		<?php
          $core_function = new AlertPosttypeSelect();
          $core_function->alt_list_posttype();
         ?>
        <h3>Alert Content </h3><textarea name="alert_text" id="alert_text"    class="large-text code"><?php echo get_option('alert_text');?></textarea>
        <p class="submit"><input name="submit" id="submit" class="button button-primary" value="Save Changes" type="submit"></p>
    </form>
 <?php
}*/
					
 
 
