<?php

/*
Plugin Name: Webphone
Plugin URI: http://Webphone.net
Description: Webphone is click-to-call. The button that turns click into calls, users into clients, visits into sales. From telephone to telephone. Immediate. Profitable.
Version: 0.1
Author: Webphone
Author URI: http://Webphone.net
*/

//**************		FUNCTIONS        ******************/


//Enqueuing our admin styles
function webphone_admin_styles() {
    wp_register_style( 'wph_admin_stylesheet', plugins_url( '/css/AdminWphstyles.css', __FILE__ ) );
    wp_enqueue_style( 'wph_admin_stylesheet' );   
    global $wp_styles;
    $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
    if ( !in_array('font-awesome.css', $srcs) || !in_array('font-awesome.min.css', $srcs)  ) {  
        wp_register_style( 'wph_admin_stylesheet_font', plugins_url( '/css/font-awesome.min.css', __FILE__ ) );
        wp_enqueue_style( 'wph_admin_stylesheet_font' );
    }   
}

add_action( 'admin_enqueue_scripts', 'webphone_admin_styles' );

// action function for above hook
function Webphone_add_pages() {
    
    // Add a new menu entry
    add_menu_page('Webphone', 'Webphone', 'administrator', 'Webphone settings', 'Webphone_toplevel_page', plugins_url( 'img/webphone-xs.png', __FILE__ ));

}

function webphone_loading_scripts_uniform() {
        wp_enqueue_script('custom-js', plugins_url( 'js/functions.js', __FILE__ ));

}

add_action('admin_init', 'webphone_loading_scripts_uniform');


// WebCallButton_toplevel_page() displays the page content for the custom Test Toplevel menu
function Webphone_toplevel_page() {

    // Read in existing options value from database
    $objectid       = get_option( 'objectidwph' );
    $gtelephone     = "";
    $gtuser         = "";
    $gtpassword     = "";
    $gtmailbox      = "";
    $gtserver       = "";
    $gobjectposwph  = get_option( 'objectposwph' );
    $gtcall         = '';    
    // See if the user has posted us some information    
    if (( $_POST[ 'hf_objectidwph' ] != '' ) || ( $_POST[ 'hf_objectposwph' ] != '' || ( $_POST[  'ghf_gnumber2call' ] != '' ) )) {
        
        // Read their posted value
        $objectidwph = stripslashes($_POST[ 'objectidwph' ]);
        $gtcall = stripslashes($_POST[ 'gnumber2call' ]);        
        if (stripslashes($_POST[ 'hf_objectposwph' ]) == "")	$gobjectposwph = "r-b";				
        else $gobjectposwph = stripslashes($_POST[ 'hf_objectposwph' ]);

        // Save the posted value in the database
        update_option( 'objectidwph' , $objectidwph );
        update_option( 'objectposwph' , $gobjectposwph );
        update_option( 'gnumber2call' , $gtcall );
    

    }else{
        $gobjectposwph = "r-b"; 
    }
 // Display the options editing screen
    echo '<div class="wrap">';
// header
?>  
<div class="wphHeader">
    <a title="Webphone" rel="alternate"><img src=" <?php echo plugins_url( 'img/webphoneLogo.png', __FILE__ ) ?>" alt=""/></a>
    
    <?php
    if (get_option( 'objectidwph' ) == '' || get_option( 'objectposwph' ) == '' ){
    ?>    
        <div class="wpherror">
            <p><div><b><i class="fa fa-exclamation-triangle"></i>THE WEBPHONE PLUG-IN IS NOT INSTALLED</b></div>
                  <div>To activate the plug-in Webphone need an ID and indicates where you want to display your button. <br> Please perform the following steps.</div> </p>
        </div>
    <?php
    }else{
        ?>    
        <div class="wphupdated">
            <p>
                <div><b><i class="fa fa-thumbs-up"></i>THE WEBPHONE PLUG-IN HAS BEEN SUCCESSFULLY </b></div>
                <div>Please make sure the widget ID is valid and start receiving calls right now. Welcome to <font class="wphcolor">Webphone!</font>!</div></p>
        </div>
<?php
    }
?>
    <h2>Activate your <font class="wphcolor">Webphone</font> in 3 easy steps</h2>
</div>


<div class="wphcontainer">
    <div class="wphrow-fluid">           
        <div class="wphspan4">
            <div class="wphcol">
                <div class="step">
                    1. Register in <font class="wphcolor">Webphone</font>
                </div>
                <div class="wphcaption-icon">
                    <!-- <i class="fa fa-laptop"></i> -->
                    <img src=" <?php echo plugins_url( 'img/register.png', __FILE__ ) ?>" alt=""/>
                </div>
                <div class="wphcaption">
                    You need to be registered for Webphone to be used. Please, visit <a target="_blank" href="http://www.webphone.net/en/signup/"><span class="wphnormalcolor">www.webphone.net/signup</span></a> and sign up.
                </div>            
            </div>
        </div>
        <div class="wphspan4">
            <div class="wphcol">
                <div class="step">2. Get your <font class="wphcolor">Webphone</font> ID</div>
                  <div class="wphcaption-icon-2">
                    <!-- <i class="fa fa-tag"></i> -->
                    <img src=" <?php echo plugins_url( 'img/getid.png', __FILE__ ) ?>" alt=""/>
                </div>
                <div class="wphcaption">
                    After signing up, your access details by emailed to you. Access your account at your WordPress panel (see below) or at <a target="_blank" href="http://www.webphone.net/en/"><span class="wphnormalcolor">www.webphone.net</span></a> and follow the instructions to set up your button and generate your ID.
                </div>            
            </div>
        </div>
        <div class="wphspan4">
            <div class="wphcol">
                <div class="step">3. Insert <font class="wphcolor">Webphone</font> in your website </div>
                <div class="wphcaption">
                    <form name="form1" method="post" action="">
                    <input type="hidden" name="<?php echo 'hf_objectidwph'; ?>" value="id">
                    <input type="hidden" name="<?php echo 'hf_objectposwph'; ?>" id="hf_objectposwph" value=""> 
                    <input type="hidden" name="<?php echo 'hf_gnumber2call'; ?>" value="call">                   
                    <!--[if lt IE 9]>
                    <div id="objectbundle_object_follow_startPos" class="positionChoiceField-IE8">    
                    <![endif]-->
                    <!--[if gt IE 8]>
                    <div id="objectbundle_object_follow_startPos" class="positionChoiceField">           
                    <![endif]-->  
                    <!--[if !IE]>-->
                     <div id="objectbundle_object_follow_startPos" class="positionChoiceField">            
                   <!--<![endif]-->                              
<?php                        
                        $gobjectposwph = get_option( 'objectposwph');                        
                        if ($gobjectposwph == "l-t"){ $checked = 'checked';}else{ $checked = '';}
                        ?><div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_l-t" onclick="setPos(this,'l-t')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>"  id="objectbundle_object_follow_startPos_l-t" name="objectbundle_object_follow[startPos]" required="required" value="l-t" style="opacity: 0;"></span></div> <?php 
                                if($gobjectposwph == "c-t"){ $checked = 'checked';}else{ $checked = '';}
                        ?><div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_c-t" onclick="setPos(this,'c-t')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>"  id="objectbundle_object_follow_startPos_c-t" name="objectbundle_object_follow[startPos]" required="required" value="c-t" style="opacity: 0;"></span></div><?php 
                                if($gobjectposwph == "r-t"){ $checked = 'checked';}else{ $checked = '';}
                        ?><div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_r-t" onclick="setPos(this,'r-t')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>" id="objectbundle_object_follow_startPos_r-t" name="objectbundle_object_follow[startPos]" required="required" value="r-t" style="opacity: 0;"></span></div><?php 
                                if($gobjectposwph == "l-m"){ $checked = 'checked';}else{ $checked = '';}
                        ?><div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_l-m" onclick="setPos(this,'l-m')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>"  id="objectbundle_object_follow_startPos_l-m" name="objectbundle_object_follow[startPos]" required="required" value="l-m" style="opacity: 0;"></span></div>
                          <div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_c-m"><span  class="radio-hide"><input type="radio" id="objectbundle_object_follow_startPos_c-m" name="objectbundle_object_follow[startPos]" required="required" value="c-m" style="opacity: 0;"></span></div><?php
                                if($gobjectposwph == "r-m") { $checked = 'checked';}else{ $checked = '';}
                        ?><div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_r-m" onclick="setPos(this,'r-m')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>"  id="objectbundle_object_follow_startPos_r-m" name="objectbundle_object_follow[startPos]" required="required" value="r-m" style="opacity: 0;"></span></div><?php 
                                if($gobjectposwph == "l-b"){ $checked = 'checked';}else{ $checked = '';}
                        ?><div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_l-b" onclick="setPos(this,'l-b')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>" id="objectbundle_object_follow_startPos_l-b" name="objectbundle_object_follow[startPos]" required="required" value="l-b" style="opacity: 0;"></span></div><?php 
                                if($gobjectposwph == "c-b"){ $checked = 'checked';}else{ $checked = '';}
                        ?><div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_c-b" onclick="setPos(this,'c-b')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>"  id="objectbundle_object_follow_startPos_c-b" name="objectbundle_object_follow[startPos]" required="required" value="c-b" style="opacity: 0;"></span></div><?php 
                                if($gobjectposwph == "r-b"){ $checked = 'checked';}else{ $checked = '';}                     ?>    
                          <div class="radio-wph" id="uniform-objectbundle_object_follow_startPos_r-b" onclick="setPos(this,'r-b')"><span class="<?php echo $checked; ?>"><input type="radio" checked="<?php echo $checked; ?>"  id="objectbundle_object_follow_startPos_r-b" name="objectbundle_object_follow[startPos]" required="required" value="r-b" style="opacity: 0;"></span></div>
                    </div>    
                     <div><i class="font-icon fa fa-arrow-circle-o-right"></i> Please select the Webphone position in the site</div> 
                    <div class="separator-two"></div>
                     <span style="">Enter your Webphone ID</span>
<?php 
                        $objectidwph = get_option( 'objectidwph' );                       
?>
                    <input type="text" size="15"  class="input-id" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="<?php echo 'objectidwph'; ?>" id="<?php echo 'objectidwph'; ?>" value="<?php echo $objectidwph; ?>" maxlength="15" >
                                
                    <p class="">                                        
<?php
                        if (get_option( 'objectidwph' ) == ''){
?> 
                    <input type="submit" id="wph_submit" class="btn" title="<?php _e('ACTIVE WEBPHONE', 'Webphone_domain' ) ?>" value="<?php _e('ACTIVE WEBPHONE', 'Webphone_domain' ) ?>" > 
 <?php
                        }else{
 ?> 
                     <input type="submit" id="wph_submit" class="btn" title="<?php _e('REFRESH WEBPHONE', 'Webphone_domain' ) ?>" value="<?php _e('REFRESH WEBPHONE', 'Webphone_domain' ) ?>" > 
<?php
                        }
?> 
                    </p>
                    </form>    
                </div>            
            </div>
        </div>
    </div>
</div>



<div class="separator"></div>
<div class="blue-wph"><div><div class="text"><div class="h2-wph">What is Webphone?</div><div class="group"><div class="left">Webphone is the button to be inserted in your website so that your customers can call you for free. It prevents them to leave the site without contacting and helps you to increase your online sales.</div><div class="right"><img class="img-responsive" src="<?php echo plugins_url( 'img/footer-wph.png', __FILE__ ) ?>" alt="What is Webphone?" title="What is Webphone?"></div></div></div>
<div class="text">Discover more about Webphone at <a class="white" href="http://www.webphone.net/en/">www.webphone.net</a></div></div>
<div class="grey-wph">
        <div class="wphcolor">Access your account</div>
        <form action="http://dashboard.webphone.net/wph_login" id="formLogin" method="post" class="loginForm" target="_blank">            
         <div class="input-prepend">
            <input name="_username" id="user" type="text" class="loginInput" required="required" placeholder="Username">
        </div>
        <div class="input-prepend">
          <input name="_password" id="password" type="password" class="loginInput" required="required" placeholder="Password">
        </div>       
        <input type="submit" id="wph_login" class="btn" value="Log in">
        <div class="input-prepend">              
          <a href="http://dashboard.webphone.net/recover/password/" target="_blank" class="help-block">Forgot your password?</a>
        </div>        
        </form>                   
    </div>
</div>

</div>
<?php
}

function webphone_widget_menu(){

    $data = get_option('gphone_title'); 

?>
    <p><label>Title:  <input name="gphone_title" type="text" value="<?php echo $data['gtitle']; ?>" /></label></p>

<?php

    if (isset($_POST['gphone_title'])){
        $data['gtitle'] = attribute_escape($_POST['gphone_title']);
        update_option('gphone_title', $data); 
     }
}

function webphone_init_button(){
	register_widget_control('Webphone', 'webphone_widget_menu');	
}

//**************        ACTIONS        ******************/

add_action('admin_menu', 'Webphone_add_pages');
add_action('plugins_loaded', 'webphone_init_button');

function webphone_add_object(){
	$objectidwph   = get_option( 'objectidwph' );
	$gobjectposwph = get_option( 'objectposwph' );		        
    echo '<div id="div-'.$gobjectposwph.'"><object id="'.$objectidwph.'" type="button/webphone" classid="webphone" style="display: none;"></object></div>';	
}

function webphone_add_script() {
        wp_register_script('webphone_script', '//app.webphone.net/script/script.js');
        wp_enqueue_script( 'webphone_script' );

}

function webphone_add_styles() {      
    wp_enqueue_style( 'webphone_styles', plugins_url( '/css/styles.css', __FILE__ ) );     
}

$objectidwph   = get_option( 'objectidwph' );
$gobjectposwph = get_option( 'objectposwph' );
if(is_numeric($objectidwph)){           
    add_action('wp_enqueue_scripts', 'webphone_add_styles' );
    add_action('wp_enqueue_scripts', 'webphone_add_script');
    add_action( 'the_content', 'webphone_add_object');  
}

?>
