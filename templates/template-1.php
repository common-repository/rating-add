<style type="text/css">
    #rating_wrapper > *{
}
    #rating_wrapper{
        background: <?php echo get_post_meta($id,'wsrp_rating_container_color',true ); ?>;
        width:<?php echo get_post_meta($id,'wsrp_rating_container_width',true ); ?>%;
        border:2px solid <?php echo get_post_meta($id,'wsrp_rating_container_border',true ); ?>;
        border-radius: <?php echo get_post_meta($id,'wsrp_rating_container_border_radius',true ); ?>px;
        padding: 15px;
    }
    #rating_content{
        margin: 0 auto;
    }
    #rating_tooltip{
        display: inline-block;
        padding: 15px;
        font-size: 2.5rem;
        color: #fff;
        border-radius: 100px;
        background: #e3e3e3;
        text-align: center;
    }
    #rate<?php echo $post_id; ?>{
        display: inline-block;
        float: left;
        margin: 0 auto;
        font-size: 4.4rem;
    }
     .rate-base-layer{
        color: <?php echo get_post_meta($id,'wsrp_rating_bg_color',true ); ?>;
    }
     .rate-hover-layer,.rate-select-layer{
            color: <?php echo get_post_meta($id,'wsrp_rating_hover_color',true ); ?>;
            
    }
    #rate<?php echo $post_id; ?> .rate-base-layer span, #rate<?php echo $post_id; ?> .rate-base-layer span{
        opacity: 0.8;
    }

    .fa{
        margin-left: 10px;
    }
</style>

<?php

$current_post_id = get_the_id();
$all_ratings = get_post_meta($id,'rating', true);

if (!empty($all_ratings)) {
    if (!empty($all_ratings[$id])) {
        if (!empty($all_ratings[$id][$current_post_id])) {
            $ratings_for_current_post = $all_ratings[$id][$current_post_id];  
        }
    }
}
$prev_value_avg = 0;
$current_value_avg = 0;
$counter_avg = 0;
if (!empty($ratings_for_current_post)) {
    foreach ($ratings_for_current_post as $v1) {
        foreach ($v1 as $n) {
                $prev_value_avg =  $n;
                $current_value_avg = $prev_value_avg + $current_value_avg;
                $counter_avg++;
        }
            
    }

    $rating_average = round($current_value_avg/$counter_avg,1,PHP_ROUND_HALF_DOWN);
}else{
    $rating_average = 0;
}



$all_ratings = get_post_meta($id,'rating', true);
if(!empty($all_ratings[$id][$current_post_id][$user_ip])){
    $set_prev_value = $all_ratings[$id][$current_post_id][$user_ip]['rate_value'];
}
if (empty($set_prev_value)) {
    $prev_value = "0";
}else{
    $prev_value = $set_prev_value;
}


$change_once = get_post_meta($id,'wsrp_rating_changeable', true);
    if (!empty($change_once)) {
        $change_once_value = "false";
    }
    else{
        $change_once_value = "true";
    }

    $selected_symbol_type =  get_post_meta($id,'wsrp_rating_type', true);
    $rating_max_value = get_post_meta($id,'wsrp_rating_max_value', true);
    if (strpos($selected_symbol_type, 'fontawesome') !== false) {
        if ($rating_max_value <= 5) {
            $rating_width = "min-width: 260px;";
        } elseif($rating_max_value > 5){
            $rating_width = "min-width:520px;";
        }
        
    }else{
        $rating_width = " ";
    }

?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
<div id='rating_wrapper'>
    <div id="rating_content">
        <div id='rate<?php echo $post_id; ?>' style='<?php echo $rating_width; ?>' ></div>
        <div id="rating_tooltip"><?php echo $rating_average; ?></div>
    </div>
</div>

<script>
(function ($) {

<?php $selected_symbol_type =  get_post_meta($id,'wsrp_rating_type', true);
      $change_once = get_post_meta($id,'wsrp_rating_changeable', true);
      if (!empty($change_once)) {
        $change_once_value = "false";
      }
      else{
          $change_once_value = "true";
      }
?>
    var options = {
        max_value: <?php echo get_post_meta($id,'wsrp_rating_max_value', true); ?>,
        step_size: <?php echo get_post_meta($id,'wsrp_rating_size', true); ?>,
        selected_symbol_type: "<?php echo $selected_symbol_type; ?>",
        initial_value: <?php echo get_post_meta($id,'wsrp_rating_initial_value', true); ?>,
        change_once: <?php echo $change_once_value; ?>,
        cursor: 'pointer',
        url: "<?php echo $url; ?>"
    }

    $("#rate<?php echo $post_id; ?>").rate(options);

    $('#rate<?php echo $post_id; ?>').rate('setAdditionalData', {id: <?php echo $post_id; ?>, IP:'<?php echo $user_ip; ?>', Rating_ID:<?php echo "$id"; ?>});
    $('#rate<?php echo $post_id; ?>').on('updateSuccess', function(ev, data){
    console.log(data);
    });

    $('#rate<?php echo $post_id; ?>').rate('setValue',<?php echo $prev_value; ?>);
    $('#rate<?php echo $post_id; ?>').on('updateError', function(ev, jxhr, msg, err){
    console.log('This is a custom error event');
    });

}(jQuery));
</script>