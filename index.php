<?php
/*
Plugin Name: Sticky Adz Standard
Plugin URI: http://www.stickyadz.com
Description: This plugin makes a div sticky int the sidebar.
Version: 1.0
Author: Blue Mountain Entertainment
Author URI: http://www.stickyadz.com

Copyright (C) <2011> <Blue Mountain Entertainment>

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


*/
// DEFINE CONSTANTS
if( !defined('STICKYADZ_VER') ) define( 'STICKYADZ_VER', '1.0' );

 //Load the widget on widgets_init
function load_adz_sticky_widget() {
	register_widget('AdzstickyWidget');
}
add_action('widgets_init', 'load_adz_sticky_widget');
function Astick_front(){
?>
<style>
#AS_Sticky{
        position: relative;
        right: 0;
        top: 0px;
        width:inherit;
        padding: 0;
		background:inherit;
}
</style>
<script type="text/javascript">
$.noConflict();

jQuery(document).ready(function(){

jQuery.fn.css2 = jQuery.fn.css;
jQuery.fn.css = function() {
    if (arguments.length) return jQuery.fn.css2.apply(this, arguments);
    var attr = ['font-family','font-size','font-weight','font-style','color',
        'text-transform','text-decoration','letter-spacing','word-spacing',
        'line-height','text-align','vertical-align','direction','background-color',
        'background-image','background-repeat','background-position',
        'background-attachment','opacity','width','height','top','right','bottom',
        'left','margin-top','margin-right','margin-bottom','margin-left',
        'padding-top','padding-right','padding-bottom','padding-left',
        'border-top-width','border-right-width','border-bottom-width',
        'border-left-width','border-top-color','border-right-color',
        'border-bottom-color','border-left-color','border-top-style',
        'border-right-style','border-bottom-style','border-left-style','position',
        'display','visibility','z-index','overflow-x','overflow-y','white-space',
        'clip','float','clear','cursor','list-style-image','list-style-position',
        'list-style-type','marker-offset'];
    var len = attr.length, obj = {};
    for (var i = 0; i < len; i++) 
        obj[attr[i]] = jQuery.fn.css2.call(this, attr[i]);
    return obj;
}

});

</script>
<?php
}

	if (!is_admin()) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js');
        wp_enqueue_script( 'jquery' );
    }else{
	wp_enqueue_script( 'jquery' );
	}
	
	
	add_action('wp_head','Astick_front');


class AdzstickyWidget extends WP_Widget
{
    function AdzstickyWidget(){
		$widget_ops = array('description' => 'Displays Sticky Content in the Sidebar');
		$control_ops = array('width' => 300, 'height' => 450);
		parent::WP_Widget("AdzstickyWidget",$name='Sticky Adz',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);


		if (!isset($instance['floatside']) OR $instance['floatside'] == ''){
			$floatside = 'right';
			$nofloatside = 'left';
		}else{
			$floatside = $instance['floatside'];
			$nofloatside = $floatside == 'left' ? 'right' : 'left' ;
		}

		
		?>
<script>
  jQuery(document).ready(function($) {

			$('#AS_Sticky').css($('#AS_Sticky').css());
			$('#AS_Sticky').find('*').each(function(){
				$(this).css($(this).css());
			});



		<?php if ($instance['floatstyle'] == 'fixed'): ?>
		<?php endif; ?>

<?php if (isset($instance['alwaysfloat']) AND $instance['alwaysfloat'] == 1): ?>

	<?php if (isset($instance['floatstyle']) AND $instance['floatstyle'] == 'follow'): ?>


	document.body.appendChild(document.getElementById('AS_Sticky'));


            $('#AS_Sticky').css('position','absolute');
            $('#AS_Sticky').css('top','10px');
            $('#AS_Sticky').css('<?php echo $nofloatside; ?>','');
            $('#AS_Sticky').css('<?php echo $floatside; ?>','0px');
	    $('#AS_Sticky').css('margin',0);
	    $("#AS_Sticky").css('z-index',100);

		var el = $('#AS_Sticky');
		var elpos_original = 10;

		 $(window).scroll(function(){
		     var elpos = el.offset().top;
		     var windowpos = $(window).scrollTop();
		     var finaldestination = windowpos;
		     if(windowpos<elpos_original) {
		         finaldestination = elpos_original;
		         el.stop().animate({'top':elpos_original},400);
		     } else {
		         el.stop().animate({'top':windowpos+10},400);
		     }
		 });


	<?php else: ?>
            $('#AS_Sticky').css('position','fixed');
            $('#AS_Sticky').css('top','10px');
            $('#AS_Sticky').css('<?php echo $nofloatside; ?>','');
            $('#AS_Sticky').css('<?php echo $floatside; ?>','0px');
	    $('#AS_Sticky').css('margin',0);
	    $("#AS_Sticky").css('z-index',100);



	<?php endif; ?>


<?php else: ?>




	<?php if (isset($instance['floatstyle']) AND $instance['floatstyle'] == 'follow'): ?>
	var pos = 1;
	var fadein = <?php echo $instance['fadein']; ?>;

		var el = $("#AS_Sticky");
		var elpos_original = 10;
		var orig_css = new Object;
		orig_css['position'] = $("#AS_Sticky").css('position');
		orig_css['top'] = $("#AS_Sticky").css('top');
		orig_css['left'] = $("#AS_Sticky").css('left');
		orig_css['right'] = $("#AS_Sticky").css('right');
		orig_css['margin'] = $("#AS_Sticky").css('margin');

		
		$("#AS_Sticky").find("script").each(function(){
			$(this).removeAttr('src');
		
		});

		 $(window).scroll(function(){
		        if (document.documentElement.scrollTop > 150 || self.pageYOffset > 150) {
				if (pos == 1 && fadein == 1){
					
					
					$("#AS_Sticky").stop(true,true).fadeOut(300);
					setTimeout(function(){
						$("body").prepend($("#AS_Sticky")); 


						$("#AS_Sticky").css('position','absolute');
						$("#AS_Sticky").css('top','10px');
				                $("#AS_Sticky").css('<?php echo $nofloatside; ?>','');
				            	$("#AS_Sticky").css('<?php echo $floatside; ?>','2px');
						$("#AS_Sticky").css('margin',0);
						$("#AS_Sticky").css('z-index',100);
						$("#AS_Sticky").stop(true,true).fadeIn(300);
					},350);

					timeout = 720;


				}

				if (pos == 1 && fadein == 0){
					

						$("body").prepend($("#AS_Sticky")); 
						$("#AS_Sticky").css('position','absolute');
						$("#AS_Sticky").css('top','10px');
				                $("#AS_Sticky").css('<?php echo $nofloatside; ?>','');
				            	$("#AS_Sticky").css('<?php echo $floatside; ?>','2px');
						$("#AS_Sticky").css('margin',0);
						$("#AS_Sticky").css('z-index',100);

					timeout = 300;
				}
				    
				setTimeout(function(){
					if (pos == 2){
				     var elpos = el.offset().top;
				     var windowpos = $(window).scrollTop();
				     var finaldestination = windowpos;
				     if(windowpos<elpos_original) {
				         finaldestination = elpos_original;
				         el.stop().animate({'top':elpos_original},400);
				     } else {
				         el.stop().animate({'top':windowpos+10},400);
				     }
				}
				},timeout);
				
				pos = 2;
			}else{
				if (pos == 2 && fadein == 1){
					

					$("#AS_Sticky").stop(true,true).fadeOut(300);
					setTimeout(function(){
						$("#sticky_inserthere").after($("#AS_Sticky"));
	 		 			$("#AS_Sticky").css('position',orig_css['position']);
			 			$("#AS_Sticky").css('top',orig_css['top']);
			 			$("#AS_Sticky").css('left',orig_css['left']);
			 			$("#AS_Sticky").css('right',orig_css['right']);
			 			$("#AS_Sticky").css('margin',orig_css['margin']);

				


						$("#AS_Sticky").stop(true,true).fadeIn(300);
					},350);

				}

				if (pos == 2 && fadein == 0){
					$("#AS_Sticky").stop();
					$("#sticky_inserthere").after($("#AS_Sticky"));
 		 			$("#AS_Sticky").css('position',orig_css['position']);
		 			$("#AS_Sticky").css('top',orig_css['top']);
		 			$("#AS_Sticky").css('left',orig_css['left']);
		 			$("#AS_Sticky").css('right',orig_css['right']);
		 			$("#AS_Sticky").css('margin',orig_css['margin']);
					
				}

				pos = 1;

			}
		 });


	<?php else: ?>

	var pos = 1;
	var fadein = <?php echo $instance['fadein']; ?>;
			    jQuery('#AS_Sticky').css('margin',0);
			    jQuery("#AS_Sticky").css('z-index',100);

jQuery(window).scroll(function()
{

    if( window.XMLHttpRequest ) {
        if (document.documentElement.scrollTop > 150 || self.pageYOffset > 150) {
		if (pos == 1 && fadein == 1){
			$('#AS_Sticky').hide(400);
			setTimeout("jQuery('#AS_Sticky').css('position','fixed');  jQuery('#AS_Sticky').css('top','10px');		        jQuery('#AS_Sticky').css('<?php echo $nofloatside; ?>',''); jQuery('#AS_Sticky').css('<?php echo $floatside; ?>','0px');jQuery('#AS_Sticky').show('fast');","450");
		}

		if (fadein == 0){
			jQuery('#AS_Sticky').css('position','fixed');
			jQuery('#AS_Sticky').css('top','10px');
		        jQuery('#AS_Sticky').css('<?php echo $nofloatside; ?>',''); 
			jQuery('#AS_Sticky').css('<?php echo $floatside; ?>','0px');


		}

		pos = 2;
        } else if (document.documentElement.scrollTop < 150 || self.pageYOffset < 150) {
		if (pos == 2 && fadein == 1){

			$('#AS_Sticky').hide(400);
			setTimeout("jQuery('#AS_Sticky').css('position','relative'); jQuery('#AS_Sticky').css('top','0px');		        jQuery('#AS_Sticky').css('<?php echo $nofloatside; ?>',''); jQuery('#AS_Sticky').css('<?php echo $floatside; ?>','');jQuery('#AS_Sticky').show('fast');","450");

		}

		if (fadein == 0){
			jQuery('#AS_Sticky').css('position','relative');
			jQuery('#AS_Sticky').css('top','0px');		        
			jQuery('#AS_Sticky').css('<?php echo $nofloatside; ?>',''); 
			jQuery('#AS_Sticky').css('<?php echo $floatside; ?>','');
		}

		pos = 1;
        }
    }
});
	<?php endif; ?>






<?php endif; ?>
});


</script>
		<?php

		$title = apply_filters('widget_title', empty($instance['title']) ? 'Sticky' : $instance['title']);
		$A_Sinnerhtml = empty($instance['A_Sinnerhtml']) ? '' : $instance['A_Sinnerhtml'];
		$width = empty($instance['width']) ? '0' : $instance['width'];

		if (!isset($instance['bgcolor']) OR $instance['bgcolor'] == ''){
			$bgcolor = 0;
		}else{
			$bgcolor = $instance['bgcolor'];
		}

		if (!isset($instance['headerbgcolor']) OR $instance['headerbgcolor'] == ''){
			$headerbgcolor = 0;
		}else{
			$headerbgcolor = $instance['headerbgcolor'];
		}

		if (!isset($instance['headerfontcolor']) OR $instance['headerfontcolor'] == ''){
			$headerfontcolor = 0;
		}else{
			$headerfontcolor = $instance['headerfontcolor'];
		}

	echo "<div id='sticky_inserthere'></div><div id='AS_Sticky'  style='";
	if ($width !== 0 AND $width !== '0'){
		echo "width:{$width}px;";
	}
	if ($bgcolor !== 0){
		echo "background:#{$bgcolor} !important";
	}
	echo "' >".str_replace('><div style="background:transparent url(../wp-content/plugins/StickyADZ/transparent_black.png) repeat;overflow:hidden;"','><div ',str_replace('<div','<div style="background:transparent url(../wp-content/plugins/StickyADZ/transparent_black.png) repeat;overflow:hidden;"',$before_widget));

		if ( $title )
		echo "<div style='";
	if ($headerbgcolor !== 0){
		echo "background:#{$headerbgcolor} !important; ";
	}

	if ($headerfontcolor !== 0){
		echo "color:#{$headerfontcolor} !important; ";
		$before_title = str_replace(">"," style='color:#{$headerfontcolor} !important;'>",$before_title);
	}


		echo "'>";

		echo $before_title . $title . $after_title;

		echo "</div>";

?>	
<div class="A_stickybox" style="margin-top:10px;">
	<?php echo($A_Sinnerhtml)?>
	
</div> 
<?php
		echo $after_widget."</div>";
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['A_Sinnerhtml'] = stripslashes($new_instance['A_Sinnerhtml']);
		$instance['width'] = $new_instance['width'];
		$instance['bgcolor'] = $new_instance['bgcolor'];
		$instance['headerbgcolor'] = $new_instance['headerbgcolor'];
		$instance['headerfontcolor'] = $new_instance['headerfontcolor'];
		if (!isset($new_instance['alwaysfloat']) OR $new_instance['alwaysfloat'] == ''){
			$new_instance['alwaysfloat'] = 0;
		}
		$instance['alwaysfloat'] = $new_instance['alwaysfloat'];
		if (!isset($new_instance['floatstyle']) OR $new_instance['floatstyle'] == ''){
			$new_instance['floatstyle'] = 'fixed';
		}
		$instance['floatstyle'] = $new_instance['floatstyle'];
		if (!isset($new_instance['fadein']) OR $new_instance['fadein'] == ''){
			$new_instance['fadein'] = 0;
		}
		$instance['fadein'] = $new_instance['fadein'];
		if (!isset($new_instance['floatside']) OR $new_instance['floatside'] == ''){
			$new_instance['floatside'] = 'right';
		}
		$instance['floatside'] = $new_instance['floatside'];

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
			'title'=>'Sticky', 
			'A_Sinnerhtml'=>'', 
			'width'=>0,
			'bgcolor'=>'', 
			'headerbgcolor'=>'',
			'headerfontcolor'=>'', 
			'alwaysfloat'=>0,
			'floatstyle'=>'fixed',
			'fadein'=>0,
			'floatside'=>'right'
			) 
		);

		$title = htmlspecialchars($instance['title']);
		$A_Sinnerhtml = htmlspecialchars($instance['A_Sinnerhtml']);
		echo "<script src='".plugins_url("jscolor/jscolor.js",__FILE__)."'></script>";
		echo "<div onmouseover='jscolor.init();'>";
		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# widget code Code
		echo '<p><label for="' . $this->get_field_id('A_Sinnerhtml') . '">' . 'Enter Ads or Text/HTML:' . '</label><textarea cols="20" rows="12" class="widefat" id="' . $this->get_field_id('A_Sinnerhtml') . '" name="' . $this->get_field_name('A_Sinnerhtml') . '" >'. $A_Sinnerhtml .'</textarea></p>';	
		# Width
		echo '<p><label for="' . $this->get_field_id('width') . '">' . 'Width:' . '</label><input style="float:right;" size="6" id="' . $this->get_field_id('width') . '" name="' . $this->get_field_name('width') . '" type="text" value="' . $instance['width']. '" /><br /><input type="checkbox" name="' . $this->get_field_name('width') . '" value="0" id="' . $this->get_field_id('width') . '" /> Auto </p>';

		# HeaderBGColor
		echo '<p><label for="' . $this->get_field_id('headerbgcolor') . '">' . 'Header Background Color:' . '</label> #<input onclick="jscolor.init();this.focus()" class="color" style="float:right;" size="9" id="' . $this->get_field_id('headerbgcolor') . '" name="' . $this->get_field_name('headerbgcolor') . '" type="text" value="' . $instance['headerbgcolor']. '" /></p>';


		# HeaderFontColor
		echo '<p><label for="' . $this->get_field_id('headerfontcolor') . '">' . 'Header Font Color:' . '</label> #<input onclick="jscolor.init();this.focus()" class="color" style="float:right;" size="9" id="' . $this->get_field_id('headerfontcolor') . '" name="' . $this->get_field_name('headerfontcolor') . '" type="text" value="' . $instance['headerfontcolor']. '" /></p>';


		# BGColor
		echo '<p><label for="' . $this->get_field_id('bgcolor') . '">' . 'Background Color:' . '</label> #<input onclick="jscolor.init();this.focus()"   class="color" style="float:right;" size="9" id="' . $this->get_field_id('bgcolor') . '" name="' . $this->get_field_name('bgcolor') . '" type="text" value="' . $instance['bgcolor']. '" /></p>';


		#Always Float
		echo '<p><label for="' . $this->get_field_id('alwaysfloat') . '">' . 'Always Float:' . '</label><input style="float:right;"  type="checkbox" name="' . $this->get_field_name('alwaysfloat') . '" value="1"'; if ($instance['alwaysfloat'] == '1'){ echo 'checked="checked"'; } echo ' id="' . $this->get_field_id('alwaysfloat') . '" /> </p>';

		#Float Style
		echo '<p><label for="' . $this->get_field_id('floatstyle') . '">' . 'Float Style:' . '</label><select style="float:right;"  name="' . $this->get_field_name('floatstyle') . '" id="' . $this->get_field_id('floatstyle') . '"> 
			<option value="fixed"';
				if ($instance['floatstyle'] == 'fixed'){
					echo ' selected="selected" ';
				}
			echo '>fixed</option>
			<option value="follow"';
				if ($instance['floatstyle'] == 'follow'){
					echo ' selected="selected" ';
				}
			echo '>follow</option>
			</select></p>';

		#FAde In
		echo '<p><label for="' . $this->get_field_id('fadein') . '">' . 'Fade In:' . '</label><input style="float:right;"  type="checkbox" name="' . $this->get_field_name('fadein') . '" value="1"'; if ($instance['fadein'] == '1'){ echo 'checked="checked"'; } echo ' id="' . $this->get_field_id('fadein') . '" /><br /><small>Has no affect when Always Float is selected</small></p>';

		#Float Side
		echo '<p><label for="' . $this->get_field_id('floatside') . '">' . 'Float Side:' . '</label><select style="float:right;"  name="' . $this->get_field_name('floatside') . '" id="' . $this->get_field_id('floatside') . '"> 
			<option value="right"';
				if ($instance['floatside'] == 'right'){
					echo ' selected="selected" ';
				}
			echo '>right</option>
			<option value="left"';
				if ($instance['floatside'] == 'left'){
					echo ' selected="selected" ';
				}
			echo '>left</option>
			</select></p>';



		echo "</div>
			<script>
			jscolor.init();
			</script>";




	}

}// end Widget class

function AdzstickyWidgetInit() {
  register_widget('AdzstickyWidget');
}

add_action('widgets_init', 'AdzstickyWidgetInit');
?>
