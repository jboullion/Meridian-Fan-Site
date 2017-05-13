<?php
    if(! empty($_REQUEST['s'])){
        global $wpdb;
        $searchable_posts = array("page","post","spells","creatures","npcs","reagents","locations","items","weapons","armor");

        $exact_query = 'SELECT ID FROM '.$wpdb->prefix.'posts
                        WHERE post_title = "'.$_REQUEST['s'].'"
                            AND post_type IN ("'.implode('","',$searchable_posts).'")
                            AND post_status = "publish"
                            LIMIT 1';

        $exact_match = $wpdb->get_row($exact_query);

        if(! empty($exact_match)){
            //m59_print($exact_match);
            wp_redirect( get_permalink($exact_match->ID) );
            //exit;
        }

        //using rank to make sure and order the posts that START with the search term first
        $get_query = 'SELECT DISTINCT(ID),post_title
                      FROM (SELECT 1 as Rank,ID,post_title FROM '.$wpdb->prefix.'posts
                            WHERE post_title LIKE "'.$_REQUEST['s'].'%"
                                AND post_type IN ("'.implode('","',$searchable_posts).'")
                                AND post_status = "publish"
                            UNION
                            SELECT 2 as Rank, ID,post_title FROM '.$wpdb->prefix.'posts
                            WHERE post_title LIKE "%'.$_REQUEST['s'].'%"
                                AND post_type IN ("'.implode('","',$searchable_posts).'")
                                AND post_status = "publish") a
                        ORDER BY Rank, post_title ASC';
        //echo $get_query;

        $page_rows = 4;

        if(! empty($_GET['pag'])){
            //pag is set
            $pagenum = $_GET['pag'];
        }else{
            $pagenum = 1;
        }

        $all_results = $wpdb->get_results($get_query);

        $num_rows = count($all_results);
        $last = ceil($num_rows/$page_rows);

        if ($pagenum < 1) {
            $pagenum = 1;
        } elseif ($pagenum > $last) {
            $pagenum = $last;
        }

        $max = ' LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

        $final_results = $wpdb->get_results($get_query.$max);

        $pagination_string = '';
        if($num_rows > $page_rows){

            $pagination_string .= '<br clear="both" /><div class="wp-pagenavi">';

            if($pagenum > 2 && $last > 5){
                $pagination_string .= '<a class="firstpostslink" rel="first" href="?pag=1&'.$query_string.'">&laquo;</a>';
            }

            if($pagenum > 1 ){
                //$pagination_string .= '<a class="prevpostslink" rel="prev" href="?pag='.($pagenum-1).'&'.$query_string.'">&lsaquo;</a>';
            }

            //$single_pagination = ($last > 5? 5:$last);
            $start_page = ($pagenum < 4? 1:$pagenum - 3);
            $max_pages = ($pagenum + 3 > $last? $last:$pagenum + 3);
            for($p = $start_page; $p <= $max_pages; $p++){
                if ($pagenum == $p) {
                    $pagination_string .= '<span class="current">'.$p.'</span>';
                }else{
                    $pagination_string .= '<a class="page larger" href="?pag='.$p.'&'.$query_string.'">'.$p.'</a>';
                }
            }

            if($pagenum < $last){
                //$pagination_string .= '<a class="nextpostslink" rel="next" href="?pag='.($pagenum+1).'&'.$query_string.'">&rsaquo;</a>';
            }

            if($pagenum < $last - 1 && $last > 5){
                $pagination_string .= '<a class="lastpostslink" rel="last" href="?pag='.$last.'&'.$query_string.'">&raquo;</a>';
            }

            $pagination_string .= '</div>';
        }
    }

    get_header();
    the_post();

    do_action('m59-begin-content');

        if(! empty($final_results)):

            foreach($final_results as $result):

                $search_post = get_post($result->ID);
                $post_options = get_fields($search_post->ID);
                $column_width = "12";
                echo '<div class="entry">';

                if (!empty($post_options['graphic']['url'])) {
                    $column_width = "9";
                echo '<div class="col-sm-3"><a href="' . get_permalink($search_post->ID) . '">
                    <img src ="' . $post_options['graphic']['sizes']['creature-thumb'] . '" alt="' . $search_post->post_title . '" />
                    </a></div>';
                }
                echo '<div class="col-sm-'.$column_width.'">
                        <h3><a href="' . get_permalink($search_post->ID) . '">' . $search_post->post_title . '</a></h3>
                        <p>'.m59_get_first_paragraph($search_post->post_content, true).'</p>
                        </div><br clear="both"/></div>';

            endforeach;

            //wp_pagenavi();
            echo $pagination_string;

        else:

            echo '<div class="entry"><p><strong>No results found.</strong></p></div>';

        endif;

do_action('m59-end-content');
get_footer(); ?>