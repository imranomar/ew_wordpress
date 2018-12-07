<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "theme_options";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'theme_options',
        'dev_mode' => FALSE,
        'use_cdn' => FALSE,
        'display_name' => 'Eazy Wash',
        'display_version' => '1.0.0',
        'page_slug' => 'theme-options',
        'page_title' => 'Theme Options',
        'intro_text' => 'Manage Theme Options from Here.',
        'footer_text' => '',
        'admin_bar' => TRUE,
        'menu_type' => 'menu',
        'menu_title' => 'Theme Options',
        'allow_sub_menu' => TRUE,
        'page_parent_post_type' => 'your_post_type',
        'customizer' => TRUE,
        'default_mark' => '*',
        'hints' => array(
            'icon' => 'el el-bulb',
            'icon_position' => 'right',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://www.upwork.com/freelancers/~014ffd27aa77bcd248',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'mailto:davanwp@gmail.com',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'mailto:davanwp@gmail.com',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://in.linkedin.com/in/devendra-mer-155619139',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'How can i help you', 'admin_folder' ),
            'content' => __( '<p>Please Contact me at <a href="mailto:davanwp@gmail.com">davanwp@gmail.com</a></p>', 'admin_folder' )
        ),
        
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    //$content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'admin_folder' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*Redux::setSection( $opt_name, array(
        'title'  => __( 'Basic Field', 'redux-framework-demo' ),
        'id'     => 'basic',
        'desc'   => __( 'Basic field with no subsections.', 'redux-framework-demo' ),
        'icon'   => 'el el-home',
        'fields' => array(
            array(
                'id'       => 'opt-text',
                'type'     => 'text',
                'title'    => __( 'Example Text', 'redux-framework-demo' ),
                'desc'     => __( 'Example description.', 'redux-framework-demo' ),
                'subtitle' => __( 'Example subtitle.', 'redux-framework-demo' ),
            )
        )
    ) );*/

    Redux::setSection( $opt_name, array(
        'title' => __( 'General Settings', 'redux-framework-demo' ),
        'id'    => 'generalsettings-sec',
        'desc'  => __( 'Setup website general settings.', 'redux-framework-demo' ),
        'icon'  => 'el el-cog',

        'fields' => array(
            array(
                'id'       => 'site-address',
                'type'     => 'textarea',
                'title'    => __( 'Address', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Address', 'redux-framework-demo' ),
            ),

            array(
                'id'       => 'site-phone',
                'type'     => 'text',
                'title'    => __( 'Phone', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Phone Number', 'redux-framework-demo' ),
            ),
            array(
                'id'       => 'site-email',
                'type'     => 'text',
                'title'    => __( 'Email', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Email Address', 'redux-framework-demo' ),
            )
        )

    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Logos & Favicon', 'redux-framework-demo' ),
        'id'         => 'logo-sec',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'header-logo',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Header Logo', 'redux-framework-demo'),
                'desc' => __('Select image for Header Logo', 'redux-framework-demo'),
                'default'  => array( 'url'=> esc_url( get_template_directory_uri() ).'/images/logo.png' ),
            ),
            array(
                'id'       => 'footer-logo',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Footer Logo', 'redux-framework-demo'),
                'desc' => __('Select image for Footer Logo', 'redux-framework-demo'),
                'default'  => array( 'url'=> esc_url( get_template_directory_uri() ).'/images/foot-logo.png' ),
            ),
            array(
                'id'       => 'site-favicon',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Website Favicon', 'redux-framework-demo'),
                'desc' => __('Select image for Favicon', 'redux-framework-demo'),
                'default'  => array( 'url'=> esc_url( get_template_directory_uri() ).'/images/favicon.png' ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __( 'Header', 'redux-framework-demo' ),
        'id'    => 'header-sec',
        'desc'  => __( 'Setup theme general settings.', 'redux-framework-demo' ),
        'icon'  => 'el el-arrow-up'
    ) );


    

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Header Settings', 'redux-framework-demo' ),
        'id'         => 'header-settings',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'page-header-bg-img',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Page Header Background Image', 'redux-framework-demo'),
                'desc' => __('Select image for page header background', 'redux-framework-demo'),
                'default'  => array( 'url'=> esc_url( get_template_directory_uri() ).'/images/headerbg.png' ),
            ),

            array(
                'id'       => 'first-lang-icon',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Header First Language Icon', 'redux-framework-demo'),
                'desc' => __('Select image for firat language icon (<b>Recommended Size: Width: 30px and Height: 20px</b>)', 'redux-framework-demo'),
                'default'  => array( 'url'=> esc_url( get_template_directory_uri() ).'/images/uk.png' ),
            ),

            array(
                'id'       => 'second-lang-icon',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Header Second Language Icon', 'redux-framework-demo'),
                'desc' => __('Select image for second language icon (<b>Recommended Size: Width: 30px and Height: 20px</b>)', 'redux-framework-demo'),
                'default'  => array( 'url'=> esc_url( get_template_directory_uri() ).'/images/denmark.png' ),
            ),
        )
    ) );

    
    Redux::setSection( $opt_name, array(
        'title' => __( 'Footer', 'redux-framework-demo' ),
        'id'    => 'footer-sec',
        'desc'  => __( 'Setup website footer settings.', 'redux-framework-demo' ),
        'icon'  => 'el el-arrow-down',

        'fields' => array(

            array(
                'id'       => 'footer-bg-img',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Footer Section Background Image', 'redux-framework-demo'),
                'desc' => __('Select image for footer section background', 'redux-framework-demo'),
                'default'  => array( 'url'=> esc_url( get_template_directory_uri() ).'/images/footer-bg.png' ),
            ),

            array(
                'id'       => 'first-col-title',
                'type'     => 'text',
                'title'    => __( 'Footer First Column Title', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Footer First Column Title', 'redux-framework-demo' ),
                'default'  => 'Userful Links'
            ),

            array(
                'id'       => 'second-col-title',
                'type'     => 'text',
                'title'    => __( 'Footer Second Column Title', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Footer Second Column Title', 'redux-framework-demo' ),
                'default'  => 'Contact Us'
            ),
            array(
                'id'       => 'second-col-subtitle',
                'type'     => 'text',
                'title'    => __( 'Footer Second Column Sub Title', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Footer Second Column Sub Title', 'redux-framework-demo' ),
                'default'  => 'EazyWash'
                
            )
            ),

    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Social Media Links', 'redux-framework-demo' ),
        'id'         => 'socialmedia-sec',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'facebook-link',
                'type'     => 'text',
                'title'    => __( 'Facebook Link', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Facebook Link', 'redux-framework-demo' ),
                'default'  => '',
            ),
            array(
                'id'       => 'twitter-link',
                'type'     => 'text',
                'title'    => __( 'Twitter Link', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Twitter Link', 'redux-framework-demo' ),
                'default'  => '',
            ),
            array(
                'id'       => 'gp-link',
                'type'     => 'text',
                'title'    => __( 'Google Plus Link', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Google Plus Link', 'redux-framework-demo' ),
                'default'  => '',
            ),
            array(
                'id'       => 'linkedin-link',
                'type'     => 'text',
                'title'    => __( 'Linked In Link', 'redux-framework-demo' ),
                'desc'     => __( 'Enter Linked In Link', 'redux-framework-demo' ),
                'default'  => '',
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Copyright Info', 'redux-framework-demo' ),
        'id'         => 'copyright-sec',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'copyright-info',
                'type'     => 'textarea',
                'title'    => __( 'Copyright Text', 'redux-framework-demo' ),
                'desc'     => __( 'Enter copyright text', 'redux-framework-demo' ),
                'default'  => '© 2018 Eazywash — All Rights Reserved',
            ),
        )
    ) );

    /*
     * <--- END SECTIONS
     */
