<?php
/*
Plugin Name: Strava Activity Widget
Plugin URI: http://interdevel.es/wp-plugins/strava-activity-widget
Description: Strava Activity Widget displays a list of your recent rides/runs, or a summary of your last week of riding/running from your Strava profile
Author: Luis Molina
Version: 1.0
Author URI: http://interdevel.es/
*/


class StravaActivityWidget extends WP_Widget {

  function StravaActivityWidget() {
    $widget_ops = array('classname' => 'StravaActivityWidget', 'description' => __('Displays recent activity from your Strava profile') );
    $this->WP_Widget('StravaActivityWidget', 'Strava Activity', $widget_ops);
  }

  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
    $wstrava_display_type = $instance['wstrava_display_type'];
    $wstrava_width = $instance['wstrava_width'];
    $wstrava_height = $instance['wstrava_height'];
  ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
    <p><label for="<?php echo $this->get_field_id('wstrava_display_type'); ?>"><?php _e('Display Type'); ?></label>
    <select name="<?php echo $this->get_field_name('wstrava_display_type'); ?>" id="<?php echo $this->get_field_id('wstrava_display_type'); ?>" class="widefat">
      <?php
      $options = array('a' => 'Activity', 's' => 'Summary');
      foreach ($options as $option => $option_description) {
        echo '<option value="' . $option . '" id="' . $option . '"', $wstrava_display_type == $option ? ' selected="selected"' : '', '>', $option_description, '</option>';
      }
      ?>
    </select></p>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Width'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('wstrava_width'); ?>" name="<?php echo $this->get_field_name('wstrava_width'); ?>" type="text" value="<?php echo attribute_escape($wstrava_width); ?>" /></p>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Height'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('wstrava_height'); ?>" name="<?php echo $this->get_field_name('wstrava_height'); ?>" type="text" value="<?php echo attribute_escape($wstrava_height); ?>" /></p>
  <?php
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['wstrava_display_type'] = $new_instance['wstrava_display_type'];
    $instance['wstrava_width'] = strip_tags( $new_instance['wstrava_width'] );
    $instance['wstrava_height'] = strip_tags( $new_instance['wstrava_height'] );
    return $instance;
  }

  function widget( $args, $instance ) {
    extract($args, EXTR_SKIP);

    echo $before_widget;

    $title = empty( $instance['title'] ) ? ' ' : apply_filters( 'widget_title', $instance['title'] );
    if ( !empty( $title ) )
      echo $before_title . $title . $after_title;

    $wstrava_display_type = $instance['wstrava_display_type'];
    $wstrava_width = $instance['wstrava_width'];
    $wstrava_height = $instance['wstrava_height'];
    
    $url_strava_activity = 'PUBLIC URL OF YOUR STRAVA PROFILE ACTIVITY';
    $url_strava_summary  = 'PUBLIC URL OF YOUR STRAVA PROFILE SUMMARY';

    if ( $wstrava_display_type == 'a' )
      $iframe_url = $url_strava_activity;
    else if ( $wstrava_display_type == 's' )
      $iframe_url = $url_strava_summary;
    else 
      $iframe_url = '#';

    echo '<iframe width="', $wstrava_width, '" height="', $wstrava_height, '" frameborder="0" allowtransparency="true" scrolling="no" src="', $iframe_url, '"></iframe>';

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "StravaActivityWidget" );' ) );?>
