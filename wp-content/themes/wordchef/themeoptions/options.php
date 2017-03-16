<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_sample_config' ) ) {

        class Redux_Framework_sample_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {    

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();
                
                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }
                
                add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);


                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }
            
            
            function compiler_action($options, $css, $changed_values) {
                global $wp_filesystem;

                $filename = get_template_directory() . '/css/wordchef-editor-fonts.css';

                if( empty( $wp_filesystem ) ) {
                    require_once( ABSPATH .'/wp-admin/includes/file.php' );
                    WP_Filesystem();
                }

                if( $wp_filesystem ) {
                    $wp_filesystem->put_contents(
                        $filename,
                        $css,
                        FS_CHMOD_FILE // predefined mode settings for WP files
                    );
                }
            }
                     

            public function setSections() {


                // ACTUAL DECLARATION OF SECTIONS
                
                /*--------------------------
                ** General Settings
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'General Settings', 'wordchef' ),
                    'icon'   => 'el-icon-cogs',
                    'fields' => array(

                        array(
                            'id'       => 'logo',
                            'type'     => 'media', 
                            'url'      => true,
                            'title'    => esc_html__('Logo Upload', 'wordchef'),
                            'subtitle' => esc_html__('Upload a logo for you site', 'wordchef'),
                        ),
                        
                        array(
                            'id'             => 'logo-spacing',
                            'type'           => 'spacing',
                            'output'         => array('#site-logo'),
                            'mode'           => 'padding',
                            'units'          => 'px',
                            'right'          => 'false', 
                            'left'           => 'false',
                            'units_extended' => 'false',
                            'title'          => esc_html__('Logo Spacing', 'wordchef'),
                            'subtitle'       => esc_html__('Choose the pixel spacing above and below the site logo.', 'wordchef'),
                            'default'        => array(
                                'padding-top'     => '90px', 
                                'padding-bottom'  => '90px',
                            )
                        ),
                        
                        array(
                            'id'          => 'title-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Site Title Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'output'      => array('.site-title'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for site title.', 'wordchef'),
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400', 
                                'color'       => '#222222', 
                                'google'      => true,
                                'font-size'   => '50px', 
                                'line-height' => '75px'
                            ),
                        ),
                        
                        array(
                            'id'          => 'tagline-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Site Tagline Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'output'      => array('.site-description'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for site tagline.', 'wordchef'),
                            'default'     => array(
                                'font-family' => 'Lato', 
                                'font-weight' => '400',
                                'color'       => '#666666', 
                                'google'      => true,
                                'font-size'   => '12px', 
                                'line-height' => '18px'
                            ),
                        ),
  
                        array(
                            'id'       => 'retina',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Retina Images', 'wordchef'),
                            'subtitle' => esc_html__('Enable or disable retina images for retina devices.', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '2'
                        ),
                        
                        array(
                            'id'       => 'lightbox',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Lightbox Images', 'wordchef'),
                            'subtitle' => esc_html__('Enable or disable lightbox effect for post images.', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '1'
                        ),
                        
                        array(
                            'id'       => 'page-comments',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Page Comments', 'wordchef'),
                            'subtitle' => esc_html__('Turn comments on or off for all pages.', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '2'
                        ),
                        
                        array(
                            'id'       => 'pagination',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Pagination Type', 'wordchef'),
                            'subtitle' => esc_html__('Select the type of pagination for your blog.', 'wordchef'),
                            'options'  => array(
                                '1' => 'Older/Newer', 
                                '2' => 'Numbered'
                             ), 
                            'default'  => '1'
                        ),
                        
                        array(
                            'id'       => 'loading-screen',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Loading Screen', 'wordchef'),
                            'subtitle' => esc_html__('Turn the page loading screen on or off', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '1'
                        ),
                        
                        array(
                            'id'       => 'rtl',
                            'type'     => 'button_set',
                            'title'    => esc_html__('RTL (Right-to-Left) Language', 'wordchef'),
                            'subtitle' => esc_html__('Turn on if your blog is rtl', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '2'
                        ),
                        
                    )
                );
                
                /*--------------------------
                ** Menu Settings
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Menu Settings', 'wordchef' ),
                    //'desc'   => esc_html__( '', 'wordchef' ),
                    'icon'   => 'el-icon-lines',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        
                        /* Main Navigation */
                        array(
                            'id'   => 'info_body',
                            'type' => 'info',
                            'title' => esc_html__('Navigation Bar', 'wordchef'),
                        ),
                        
                        array(
                            'id'       => 'fixed-nav',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Fixed Navigation', 'wordchef'),
                            'subtitle' => esc_html__('Turn on to fix your navigation to the top of the screen', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '1'
                        ),
                        
                        array(
                            'id'          => 'nav-background-color',
                            'type'        => 'color',
                            'output'      => array('background-color' => '#site-navigation'),
                            'title'       => esc_html__('Navigation Bar Background Color', 'wordchef'), 
                            'subtitle'    => esc_html__('Choose the background color for the navigation bar', 'wordchef'),
                            'transparent' => true,
                            'default'     => '#ffffff',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'       => 'nav-link-color',
                            'type'     => 'link_color',
                            'output'   => array('.main-navigation .menu a'),
                            'title'    => esc_html__('Navigation Bar Font Color', 'wordchef'),
                            'visited'  => false,
                            'active'   => false,
                            'default'  => array(
                                'regular'  => '#222222',
                                'hover'    => '#73a7bd',
                            )
                        ),
                        
                        array(
                            'id'          => 'main-navigation-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Navigation Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'color'       => false,
                            'line-height' => false,
                            'output'      => array('.main-navigation .menu > .menu-item a, #site-navigation .mobile-menu a, #site-navigation .menu > ul > li > a'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for the navigation bar.', 'wordchef'),
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400',
                                'google'      => true,
                                'font-size'   => '11px'
                            ),
                        ),
                        
                        /* Main Navigation Sub Menu */
                        array(
                            'id'   => 'info_body',
                            'type' => 'info',
                            'title' => esc_html__('Navigation Sub Menus', 'wordchef'),
                        ),
                        
                        array(
                            'id'          => 'sub-menu-color',
                            'type'        => 'color',
                            'output'      => array('background-color' => '#site-navigation .sub-menu, #site-navigation .mobile-menu'),
                            'title'       => esc_html__('Sub Menu Background Color', 'wordchef'), 
                            'subtitle'    => esc_html__('Choose the background color for the navigation sub menus', 'wordchef'),
                            'transparent' => true,
                            'default'     => '#ffffff',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'       => 'sub-link-color',
                            'type'     => 'link_color',
                            'output'   => array('#site-navigation .sub-menu a, #site-navigation .mobile-menu a'),
                            'title'    => esc_html__('Sub Menu Font Color', 'wordchef'),
                            'visited'  => false,
                            'active'   => false,
                            'default'  => array(
                                'regular'  => '#222222',
                                'hover'    => '#73a7bd',
                            )
                        ),
                        
                        array(
                            'id'          => 'sub-navigation-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Sub Menu Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'color'       => false,
                            'line-height' => false,
                            'output'      => array('.main-navigation .menu > .menu-item > .sub-menu > li > a, .main-navigation .menu > .menu-item > .sub-menu > li > .sub-menu > li > a'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for the navigation sub menus.', 'wordchef'),
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400',
                                'google'      => true,
                                'font-size'   => '10px'
                            ),
                        ),
                        
                        /* Mobile Navigation */
                        array(
                            'id'   => 'info_body',
                            'type' => 'info',
                            'title' => esc_html__('Mobile Navigation', 'wordchef'),
                        ),
                        
                        array(
                            'id'          => 'mobile-menu-toggle-color',
                            'type'        => 'color',
                            'output'      => array('background-color' => '#site-navigation .menu-toggle .bar'),
                            'title'       => esc_html__('Mobile Menu Toggle Button Color', 'wordchef'), 
                            'transparent' => false,
                            'default'     => '#222222',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'   => 'info_body',
                            'type' => 'info',
                            'title' => esc_html__('Social and Search', 'wordchef'),
                        ),
                        array(
                            'id'       => 'search-button',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Search Button', 'wordchef'),
                            'subtitle' => esc_html__('Turn the navigation search button on or off', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '1'
                        ),
                        
                        array(
                            'id'       => 'social-button',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Social Button', 'wordchef'),
                            'subtitle' => esc_html__('Turn the navigation social button on or off', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '1'
                        ),
                        
                        array(
                            'id'       => 'search-button-color',
                            'type'     => 'color',
                            'output'   => array('color' => '.search-toggle'),
                            'title'    => esc_html__('Search Button Color', 'wordchef'),
                            'subtitle' => esc_html__('Select color for the search button.', 'wordchef'),
                            'transparent' => false,
                            'default'  => '#222222',
                            'validate' => 'color',
                        ),
                        
                        array(
                            'id'       => 'social-nav-color',
                            'type'     => 'color',
                            'output'   => array('color' => '.social-nav a'),
                            'title'    => esc_html__('Social Buttons Color', 'wordchef'),
                            'subtitle' => esc_html__('Select color for the social buttons.', 'wordchef'),
                            'transparent' => false,
                            'default'  => '#888888',
                            'validate' => 'color',
                        ),
  
                        array(
                            'id'       => 'link-facebook',
                            'type'     => 'text',
                            'title'    => esc_html__('Facebook', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Facebook page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-twitter',
                            'type'     => 'text',
                            'title'    => esc_html__('Twitter', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Twitter page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-pinterest',
                            'type'     => 'text',
                            'title'    => esc_html__('Pinterest', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Pinterest page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-instagram',
                            'type'     => 'text',
                            'title'    => esc_html__('Instagram', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Instagram page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-tumblr',
                            'type'     => 'text',
                            'title'    => esc_html__('Tumblr', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Tumblr page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-googleplus',
                            'type'     => 'text',
                            'title'    => esc_html__('Google+', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Google+ page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-linkedin',
                            'type'     => 'text',
                            'title'    => esc_html__('LinkedIn', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your LinkedIn page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-youtube',
                            'type'     => 'text',
                            'title'    => esc_html__('YouTube', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your YouTube page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-vimeo',
                            'type'     => 'text',
                            'title'    => esc_html__('Vimeo', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Vimeo page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'link-rss',
                            'type'     => 'text',
                            'title'    => esc_html__('RSS', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your RSS', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
   
                    )
                );
                
                /*--------------------------
                ** Slider settings
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Slider Settings', 'wordchef' ),
                    'icon'   => 'el-icon-film',
                    'fields' => array(
                                
                        array(
                            'id'       => 'featured-posts',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Featured Posts Slider', 'wordchef'),
                            'subtitle' => esc_html__('Turn the featured posts slider on or off.', 'wordchef'),
                            'options' => array(
                                '1' => 'On', 
                                '2' => 'Off',
                             ), 
                            'default' => '1'
                        ),
                        
                        array(
                            'id'            => 'post-slider-number',
                            'type'          => 'slider',
                            'title'         => esc_html__('Max Number of Featured Posts', 'wordchef'),
                            'subtitle'      => esc_html__('Choose the maximum number of posts to appear in the featured post slider.', 'wordchef'),
                            "default"       => 6,
                            "min"           => 3,
                            "step"          => 1,
                            "max"           => 12,
                            'display_value' => 'text'
                        ),
                        
                        array(
                            'id'       => 'featured-posts-order',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Featured Post Order', 'wordchef'),
                            'subtitle' => esc_html__('Choose the order of the featured posts.', 'wordchef'),
                            'options'  => array(
                                '1' => 'Latest', 
                                '2' => 'Oldest',
                                '3' => 'Random',
                             ), 
                            'default'  => '1'
                        ),
                        
                    )
                );
                
                /*--------------------------
                ** Layout options
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Layout Options', 'wordchef' ),
                    'icon'   => 'el-icon-website',
                    'fields' => array(
                        
                        array(
                            'id'       => 'layout_type',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Layout Type', 'wordchef'),
                            'subtitle' => esc_html__('Select the main layout for your site.', 'wordchef'),
                            'options'  => array(
                                '1' => 'Full Width', 
                                '2' => 'Boxed'
                             ), 
                            'default'  => '2'
                        ),                     
                       
                        array(
                            'id'       => 'blog-layout',
                            'type'     => 'select',
                            'title'    => esc_html__('Blog Layout', 'wordchef'), 
                            'options'  => array(
                                '1'  => 'Standard Post',
                                '2'  => 'List',
                                '3'  => 'Grid 2 Columns',
                                '4'  => 'Grid 3 Columns',
                                '5'  => 'Full Post + List',
                                '6'  => 'Full Post + Grid 2 Columns',
                                '7'  => 'Full Post + Grid 3 Columns',
                            ),
                            'default' => '6'
                        ),
                        
                        array(
                            'id'       => 'blog-sidebar',
                            'type'     => 'select',
                            'title'    => esc_html__('Blog Page Sidebar', 'wordchef'), 
                            'subtitle' => esc_html__('Choose between left, right or no sidebar for the blog page', 'wordchef'),
                            'options'  => array(
                                '1' => 'No Sidebar', 
                                '2' => 'Left Sidebar', 
                                '3' => 'Right Sidebar', 
                            ),
                            'default' => '3'
                        ),
                        
                        array(
                            'id'       => 'single-post-layout',
                            'type'     => 'select',
                            'title'    => esc_html__('Single Post Sidebar', 'wordchef'), 
                            'subtitle' => esc_html__('Choose between left, right or no sidebar for single blog posts', 'wordchef'),
                            'options'  => array(
                                '1' => 'No Sidebar', 
                                '2' => 'Left Sidebar', 
                                '3' => 'Right Sidebar', 
                            ),
                            'default' => '3'
                        ),
                        
                        array(
                            'id'       => 'archive-page-layout',
                            'type'     => 'select',
                            'title'    => esc_html__('Archive Page Sidebar', 'wordchef'), 
                            'subtitle' => esc_html__('Choose between left, right or no sidebar for the archive page', 'wordchef'),
                            'options'  => array(
                                '1' => 'No Sidebar', 
                                '2' => 'Left Sidebar', 
                                '3' => 'Right Sidebar', 
                            ),
                            'default' => '1'
                        ),
                        
                        array(
                            'id'       => 'search-results-layout',
                            'type'     => 'select',
                            'title'    => esc_html__('Search Results Sidebar', 'wordchef'), 
                            'subtitle' => esc_html__('Choose between left, right or no sidebar for the search results page', 'wordchef'),
                            'options'  => array(
                                '1' => 'No Sidebar', 
                                '2' => 'Left Sidebar', 
                                '3' => 'Right Sidebar', 
                            ),
                            'default' => '1'
                        ),
                        
                    )
                );
                
                /*--------------------------
                ** Post Options
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Post Options', 'wordchef' ),
                    //'desc'   => esc_html__( '', 'wordchef' ),
                    'icon'   => 'el-icon-folder',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        
                        array(
                            'id'       => 'home-post-content',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Homepage Post Content', 'wordchef'),
                            'subtitle' => esc_html__('Choose whether to display the posts full content or excerpt on homepage.', 'wordchef'),
                            'options' => array(
                                '1' => 'Full Content', 
                                '2' => 'Excerpt',
                             ), 
                            'default' => '2'
                        ),
                        
                        array(
                            'id'       => 'share_checkbox',
                            'type'     => 'checkbox',
                            'title'    => esc_html__('Post Share Options', 'wordchef'), 
                            'subtitle' => esc_html__('Choose where posts can be shared to', 'wordchef'),
                            //Must provide key => value pairs for multi checkbox options
                            'options'  => array(
                                '1'  => 'Facebook',
                                '2'  => 'Twitter',
                                '3'  => 'Pinterest',
                                '4'  => 'Google+',
                                '5'  => 'Reddit',
                                '6'  => 'Digg',
                                '7'  => 'Delicious',
                                '8'  => 'StumbleUpon',
                                '9'  => 'LinkedIn',
                                '10' => 'Mail',
                            ),
                            //1 checked 0 unchecked
                            'default' => array(
                                '1'  => '1', 
                                '2'  => '1', 
                                '3'  => '1',
                                '4'  => '1', 
                                '5'  => '0', 
                                '6'  => '0',
                                '7'  => '0', 
                                '8'  => '0', 
                                '9'  => '0',
                                '10' => '1',
                            )
                        ),
                        
                        array(
                            'id'       => 'post-tags',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Single Post Tags', 'wordchef'),
                            'subtitle' => esc_html__('Choose to show or hide the tags on single posts.', 'wordchef'),
                            'options' => array(
                                '1' => 'Show', 
                                '2' => 'Hide'
                             ), 
                            'default' => '1'
                        ),
                        
                        array(
                            'id'       => 'author-bio',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Single Post Author Bio', 'wordchef'),
                            'subtitle' => esc_html__('Choose to show or hide the author bio on single posts.', 'wordchef'),
                            'options'  => array(
                                '1' => 'Show', 
                                '2' => 'Hide'
                             ), 
                            'default' => '1'
                        ),
                        
                        array(
                            'id'       => 'read-more-text',
                            'type'     => 'text',
                            'title'    => esc_html__('Read More Text', 'wordchef'),
                            'subtitle' => esc_html__('Choose the text that appears on a blog post to continue reading it.', 'wordchef'),
                            'default'  => 'Continue Reading'
                        ),
                        
                    )
                );
  
                /*--------------------------
                ** Typography
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Typography', 'wordchef' ),
                    'icon'   => 'el-icon-font',
                    'fields' => array(
                        
                        array(
                            'id'          => 'body-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Body Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'output'      => array('body'),
                            'compiler'    => array ('#tinymce'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for paragraphs.', 'wordchef'),
                            'color'       => false,
                            'default'     => array(
                                'font-weight' => '400', 
                                'font-family' => 'Lato', 
                                'google'      => true,
                                'font-size'   => '14px', 
                                'line-height' => '24px'
                            ),
                        ),
                        
                        array(
                            'id'          => 'heading-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Headings Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'font-size'   => false,
                            'line-height' => false,
                            'subsets'     => false,
                            'color'       => false,
                            'output'      => array('h1,h2,h3,h4,h5,h6, .comment-author .fn, .prev-link a, .next-link a, .widget_rss .rsswidget, .widget_rss cite'),
                            'compiler'    => array ('h1,h2,h3,h4,h5,h6'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for headings h1, h2, h3, h4, h5, h6.', 'wordchef'),
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400',
                                'google'      => true,
                            ),
                        ),
                        
                        array(
                            'id'          => 'post-title-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Post Title Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'output'      => array('.entry-title, .entry-title a, .read-more-link a, .cat-links a, .popular-title, .recent-post-title, button, input[type="button"], input[type="reset"], input[type="submit"], .footer-social a, .comment .reply a, .paging-navigation a, #related-posts .related-post-title, #wp-calendar thead th, #wp-calendar caption, #wp-calendar tfoot td, .wordchef-pagination li a, .page-links, .page-links a, .results-title, .archive-title, .featured-posts-container .post-date, .featured-page-title, #comments .comment-author .fn, .featured-post-title a, .featured-post-meta a, .featured-post-date, .edit-link a, .featured-post-category .post-categories a, .featured-read-more a, .post-category .post-categories a, .post-author-date, .widget_recent_entries a'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for post titles.', 'wordchef'),
                            'color'       => false,
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400',
                                'google'      => true,
                                'font-size'   => '18px', 
                                'line-height' => '27px'
                            ),
                        ),
                        
                        array(
                            'id'          => 'post-meta-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Post Meta Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'output'      => array('.post-meta a'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for post meta.', 'wordchef'),
                            'color'       => false,
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400',
                                'google'      => true,
                                'font-size'   => '10px', 
                                'line-height' => '15px'
                            ),
                        ),
                        
                        array(
                            'id'          => 'page-title-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Page Title Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'output'      => array('.type-page .entry-title, .page-title'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for page titles.', 'wordchef'),
                            'color'       => false,
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400',
                                'google'      => true,
                                'font-size'   => '18px', 
                                'line-height' => '27px'
                            ),
                        ),
                        
                        array(
                            'id'          => 'widget-title-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__('Widget Title Font', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'text-align'  => false,
                            'output'      => array('.widget-title, .comments-title, .related-title'),
                            'units'       =>'px',
                            'subtitle'    => esc_html__('Select style and size for widget titles.', 'wordchef'),
                            'color'       => false,
                            'default'     => array(
                                'font-family' => 'Montserrat',
                                'font-weight' => '400',  
                                'google'      => true,
                                'font-size'   => '11px', 
                                'line-height' => '16px'
                            ),
                        ),

                    )
                );

                /*--------------------------
                ** Styling options
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Styling Options', 'wordchef' ),
                    //'desc'   => esc_html__( '', 'wordchef' ),
                    'icon'   => 'el-icon-pencil',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        
                        array(
                            'id'          => 'body-color',
                            'type'        => 'color',
                            'output'      => array('background-color' => 'body, #loading-screen'),
                            'title'       => esc_html__('Body Background Color', 'wordchef'), 
                            'transparent' => false,
                            'default'     => '#f2f2f6',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'          => 'body-text-color',
                            'type'        => 'color',
                            'title'       => esc_html__('Body Text Color', 'wordchef'), 
                            'output'      => array('body'),
                            'compiler'    => array ('#tinymce'),
                            'transparent' => false,
                            'default'     => '#666666',
                            'validate'    => 'color',
                        ),

                        array(
                            'id'          => 'title-color',
                            'type'        => 'color',
                            'title'       => esc_html__('Titles Color', 'wordchef'),
                            'subtitle'    => esc_html__('Select a color for post and page titles', 'wordchef'),
                            'output'      => array('.entry-title, .entry-title a, .post-read-more a, .popular-title a, .recent-post-title a, .widget_categories a, .widget_archive a, #related-posts .related-post-title a, #wp-calendar thead th, .wordchef-about-me-name, .results-title:not(.results-text), .archive-title:not(span), .widget_nav_menu a, .widget_pages a, .related-title, .comments-title, .comment-reply-title, #comments .comment-author .fn, .widget_recent_entries a, .read-more-link a'),
                            'transparent' => false,
                            'default'     => '#222222',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'          => 'widget-title-color',
                            'type'        => 'color',
                            'title'       => esc_html__('Widget Titles Color', 'wordchef'),
                            'subtitle'    => esc_html__('Select a color for widget titles', 'wordchef'),
                            'output'      => array('.widget-title, .widget-title .rsswidget'),
                            'transparent' => false,
                            'default'     => '#222222',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'          => 'links-color',
                            'type'        => 'color',
                            'output'      => array('a, a:hover'),
                            'title'       => esc_html__('Links color', 'wordchef'), 
                            'transparent' => false,
                            'default'     => '#73a7bd',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'          => 'primary-color',
                            'type'        => 'color',
                            'title'       => esc_html__('Primary Color', 'wordchef'), 
                            'subtitle'    => esc_html__('Select the primary color for your website', 'wordchef'),
                            'transparent' => false,
                            'default'     => '#73a7bd',
                            'validate'    => 'color',
                            'output'      => array(
                                'color'            => '.widget .post-categories a, .widget .post-categories a:hover, .cat-links, .post-social a:hover, .post-comments a:hover .comments-number, .cat-item a:hover, .widget_archive a:hover, .wordchef .popular-title a:hover, .wordchef .recent-post-title a:hover, .recent-comment-excerpt a:hover, .site-info a, .footer-social a:hover, .search-toggle-off:hover, .social-nav a:hover, .paging-navigation a:hover, #author-area .author-social-profiles a:hover, #related-posts .related-post-title a:hover, #cancel-comment-reply-link:hover, .toggle-sub-menu:hover, .toggle-sub-menu-active, blockquote p:before, .search-toggle:hover, .recent-comment-excerpt a, .read-more-link a:hover, .featured-read-more a:hover, button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .widget_recent_comments a, .scroll-to-top a, .post-categories a, .post-categories a:hover, .entry-header a:hover',
                                
                                'background-color' => '.lSSlideOuter .lSPager.lSpg > li:hover a, .lSSlideOuter .lSPager.lSpg > li.active a, #respond .form-submit .submit:hover, input.wpcf7-submit:hover, #wp-calendar caption, .cat-item a:hover + .categories-post-count, .widget_archive a:hover + .archives-post-count, .wordchef-pagination li a:hover, .wordchef-pagination .active a, .tagcloud a:hover, .tags-links a:hover, .comment-reply-link:hover, .page-links > .post-page-nav, .page-links .post-page-nav:hover, #wp-calendar #today, .wordchef-social a:before, .social-share a:before, #author-area .author-social-profiles a:before, button, input[type="button"], input[type="reset"], input[type="submit"], .read-more-link a:before, .read-more-link a:after, .featured-post-panel, .featured a:before, .featured-page-meta, .list-image:before, .featured-posts-prev:after, .featured-posts-next:after, #loading-screen .square-1, #loading-screen .square-2, #loading-screen .square-3, #loading-screen .square-4',
                                
                                'border-color'     => '.cat-item a:hover + .categories-post-count, .widget_archive a:hover + .archives-post-count, .page-links > .post-page-nav, .page-links .post-page-nav:hover, button, input[type="button"], input[type="reset"], input[type="submit"], .widget, #site-navigation .sub-menu, .results-title, .archive-title')
                        ),
                        
                        array(
                            'id'       => 'css-editor',
                            'type'     => 'ace_editor',
                            'title'    => esc_html__('CSS Editor', 'wordchef'),
                            'subtitle' => esc_html__('Add your custom CSS code here.', 'wordchef'),
                            'mode'     => 'css',
                            'theme'    => 'monokai',
                            'desc'     => '',
                            'default'  => ""
                        ),

                    )
                );     
                
                /*--------------------------
                ** Footer settings
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Footer Settings', 'wordchef' ),
                    'icon'   => 'el-icon-minus',
                    'fields' => array(
                        
                        array(
                            'id'          => 'footer-color',
                            'type'        => 'color',
                            'output'      => array('.site-info'),
                            'mode'        => 'background-color',
                            'title'       => esc_html__('Footer Background Color', 'wordchef'), 
                            'default'     => '#111111',
                            'validate'    => 'color',          
                        ),
                        
                        array(
                            'id'       => 'footer-logo',
                            'type'     => 'media', 
                            'url'      => true,
                            'title'    => esc_html__('Footer Logo Upload', 'wordchef'),
                            'subtitle' => esc_html__('Upload a logo for you footer', 'wordchef'),
                        ),
                        
                        array(
                            'id'             => 'footer-logo-spacing',
                            'type'           => 'spacing',
                            'output'         => array('#footer-logo'),
                            'mode'           => 'padding',
                            'units'          => 'px',
                            'bottom'         => 'false',
                            'right'          => 'false', 
                            'left'           => 'false',
                            'units_extended' => 'false',
                            'title'          => esc_html__('Footer Logo Top Spacing', 'wordchef'),
                            'subtitle'       => esc_html__('Choose the pixel spacing above the footer logo.', 'wordchef'),
                            'default'        => array(
                                'padding-top'     => '15px', 
                            )
                        ),
                                 
                        array(
                            'id'          => 'copyright-typography',
                            'type'        => 'typography',
                            'output'      => array('.site-info'),
                            'title'       => esc_html__('Copyright Text', 'wordchef'),
                            'google'      => true, 
                            'font-backup' => false,
                            'units'       =>'px',
                            'default'     => array(
                                'font-family' => 'Lato',
                                'font-size'   => '12px',
                                'line-height' => '18px',
                                'text-align'  => 'center',
                                'color'       => '#888888',
                            ),
                        ),
                        
                        array(
                            'id'               => 'footer-text',
                            'type'             => 'editor',
                            'title'            => esc_html__('Copyright Bar Text', 'wordchef'), 
                            'subtitle'         => esc_html__('Text to appear in the copyright bar', 'wordchef'),
                            'default'          => '© 2015 Theme by Theme Feeder. All Rights Reserved.',
                            'args'   => array(
                                'teeny'            => true,
                                'textarea_rows'    => 10
                            ),
                        ),
                        
                        array(
                            'id'    => 'info_normal',
                            'type'  => 'info',
                            'title' => esc_html__('Footer Social Links', 'wordchef'),
                        ),
                        
                        array(
                            'id'       => 'social-footer',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Footer Social Bar', 'wordchef'),
                            'subtitle' => esc_html__('Turn the footer social bar on or off', 'wordchef'),
                            'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                             ), 
                            'default'  => '1'
                        ),
                        
                        array(
                            'id'          => 'footer-social-background-color',
                            'type'        => 'color',
                            'output'      => array('background-color' => '.footer-social'),
                            'title'       => esc_html__('Footer Social Section Background Color', 'wordchef'), 
                            'subtitle'    => esc_html__('Choose the background color for the footer social section', 'wordchef'),
                            'transparent' => true,
                            'default'     => '#1c1c1c',
                            'validate'    => 'color',
                        ),
                        array(
                            'id'          => 'footer-social-icon-color',
                            'type'        => 'color',
                            'output'      => array('.footer-social a'),
                            'title'       => esc_html__('Footer Social Icon Color', 'wordchef'), 
                            'subtitle'    => esc_html__('Choose the color for the footer social icons', 'wordchef'),
                            'transparent' => false,
                            'default'     => '#ffffff',
                            'validate'    => 'color',
                        ),
                        
                        array(
                            'id'       => 'footer-facebook',
                            'type'     => 'text',
                            'title'    => esc_html__('Facebook', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Facebook page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-twitter',
                            'type'     => 'text',
                            'title'    => esc_html__('Twitter', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Twitter page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-pinterest',
                            'type'     => 'text',
                            'title'    => esc_html__('Pinterest', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Pinterest page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-instagram',
                            'type'     => 'text',
                            'title'    => esc_html__('Instagram', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Instagram page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-tumblr',
                            'type'     => 'text',
                            'title'    => esc_html__('Tumblr', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Tumblr page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-google-plus',
                            'type'     => 'text',
                            'title'    => esc_html__('Google+', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Google+ page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-linkedin',
                            'type'     => 'text',
                            'title'    => esc_html__('LinkedIn', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your LinkedIn page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-youtube',
                            'type'     => 'text',
                            'title'    => esc_html__('YouTube', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your YouTube page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-vimeo',
                            'type'     => 'text',
                            'title'    => esc_html__('Vimeo', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your Vimeo page', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer-rss',
                            'type'     => 'text',
                            'title'    => esc_html__('RSS', 'wordchef'),
                            'subtitle' => esc_html__('Enter the url to your RSS', 'wordchef'),
                            'msg'      => 'Please enter a valid URL',
                            'default'  => ''
                        ),
                        
                    )
                );
                
                /*--------------------------
                ** Misc Settings
                --------------------------*/
                $this->sections[] = array(
                    'title'  => esc_html__( 'Misc Settings', 'wordchef' ),
                    //'desc'   => esc_html__( '', 'wordchef' ),
                    'icon'   => 'el-icon-wrench',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        
                        array(
                            'id'       => 'scroll-button',
                            'type'     => 'button_set',
                            'title'    => esc_html__('Scroll To Top Button', 'wordchef'),
                            'subtitle' => esc_html__('Button that when clicked, scrolls to the top of the web page.', 'wordchef'),
                            'options' => array(
                                '1' => 'Show', 
                                '2' => 'Hide'
                             ), 
                            'default' => '1'
                        ),
                        
                        array(
                            'id'       => 'error-404-text',
                            'type'     => 'text',
                            'title'    => esc_html__('404 Page Text', 'wordchef'),
                            'default'  => 'It looks like nothing was found at this location. Maybe searching below will help.'
                        ),

                    )
                );
                
            }
            
            
            /*--------------------------
            ** Help Tab
            --------------------------*/
            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'help-tab-0',
                    'title'   => esc_html__( 'Support', 'wordchef' ),
                    'content' => esc_html__( 'If you need any help with the theme options, please contact support@themefeeder.net', 'wordchef' )
                );

                // Set the help sidebar
                //$this->args['help_sidebar'] = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'wordchef' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'           => 'wordchef',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'       => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'    => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'          => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'     => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'         => esc_html__( 'Theme Options', 'wordchef' ),
                    'page_title'         => esc_html__( 'Theme Options', 'wordchef' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'     => '',
                    // Must be defined to add google fonts to the typography module

                    'async_typography'   => false,
                    // Use a asynchronous font on the front end or font string
                    'admin_bar'          => true,
                    // Show the panel pages on the admin bar
                    'global_variable'    => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'           => false,
                    // Show the time the page took to load, etc
                    'customizer'         => true,
                    // Enable basic customizer support

                    // OPTIONAL -> Give you extra features
                    'page_priority'      => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_type'          => 'submenu',
                    'page_parent'        => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'   => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'          => '',
                    // Specify a custom URL to an icon
                    'last_tab'           => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'          => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'          => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'      => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'       => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'       => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export' => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'     => 60 * MINUTE_IN_SECONDS,
                    'output'             => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'         => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'           => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'        => false,
                    // REMOVE

                    // HINTS
                    'hints'              => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );


                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el-icon-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el-icon-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://twitter.com/reduxframework',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el-icon-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://www.linkedin.com/company/redux-framework',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el-icon-linkedin'
                );

                // Panel Intro text -> before the form
                /* if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( esc_html__( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'wordchef' ), $v );
                } else {
                    $this->args['intro_text'] = esc_html__( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'wordchef' );
                }

                // Add content after the form.
                $this->args['footer_text'] = esc_html__( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'wordchef' ); */
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_sample_config();
    }
