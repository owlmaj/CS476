<?php

class Qcopd_info_page
{

    function __construct()
    {
        add_action('admin_menu', array($this, 'qcichart_info_menu'));
    }

    function qcichart_info_menu()
    {
        add_menu_page(
            'iChart',
            'iChart',
            'manage_options',
            'qcopd_ichart_info_page',
            array(
                $this,
                'qcld_ichart_info_page_content'
            ),
            'dashicons-chart-bar',
            80
        );
        add_submenu_page(
            'qcopd_ichart_info_page',
            'Help',
            'Help',
            'manage_options',
            'qcopd_ichart_info_page',
            array(
                $this,
                'qcld_ichart_info_page_content'
            ),
            'dashicons-chart-bar',
            80
        );
    }

    function qcld_ichart_info_page_content()
    {
        ?>
        <div class="wrap">

            <div id="poststuff">

                <div id="poststuff">

                    <div id="post-body" class="metabox-holder columns-2">

                        <div id="post-body-content" class="support-block-info" style="position: relative;">

                            <div class="clear"></div>

                            <h1>Welcome to the iChart ! You are <strong>awesome</strong>, by the way <img
                                        draggable="false" class="emoji" alt="🙂"
                                        src="<?php echo qcld_ichart_img_url1; ?>/1f642.svg"></h1>
                            <h2 class="ichart-plugin-title">Getting Started</h2>

                            <p>iChart supports creating and building Pie Chart, Bar chart, Line Chart, Polar Area Chart,
                                Radar Chart, and Doughnut Chart that are optimized to address your WordPress data
                                visualization needs. Visualize your data now more easily than ever with iChart chart
                                builder!</p>

                            <h3>With that in mind you should start with the following simple steps.</h3>
                            <ol class="ichart-start-steps">

                                <li><p>Go to any Page or Post Editor</p>

                                </li>
                                <li><p>You will find a Shortcode Generator for iChart on the Right Side of your
                                        Browser
                                        named as <strong>"Shortcode Generator for iChart"</strong></p>

                                </li>
                                <li><p>Now go to a page or post where you want to display the directory. On the right
                                        sidebar you will see a <strong>ShortCode Generator</strong> block. Click the
                                        button
                                        and a Popup LightBox will appear with all the options that you can select. Enter
                                        information for the releavent fields. Then Click <strong>Generate
                                            Shortcode</strong>
                                        button. Shortcode will be generated. Simply <strong>copy paste</strong> that to
                                        a
                                        location on your page where you want the <strong>directory to show up</strong>.
                                    </p>
                                    <p style="margin-left: 30px;"><img
                                                src="<?php echo qcld_ichart_img_url1; ?>/chart-popup.png"></p>

                                </li>
                                <li><p>You can also find a Shortcode Generator Block on Guttenberg Editor and Tinymce
                                        Editor. Just add a new block in Gutenberg and Search for <strong>"iChart
                                            Shortcode
                                            Maker"</strong>.</p>
                                    <p style="margin-left: 30px;"><img
                                                src="<?php echo qcld_ichart_img_url1; ?>/gutenberg-block.png"></p>

                                </li>
                                <li><p>That’s it! The above steps are for the basic
                                        usages. <?php /*There are a lot of advanced options available with the <a href="https://www.quantumcloud.com/products/simple-link-directory/">Professional version</a> if you ever feel the need.*/ ?>
                                        If you had any specific questions about how something works, do not hesitate to
                                        contact us from the <a href="#support">Support Section</a>. <img
                                                draggable="false"
                                                class="emoji"
                                                alt="🙂"
                                                src="<?php echo qcld_ichart_img_url1; ?>/1f642.svg">
                                    </p></li>
                            </ol>
                            <!-- <h3>Please take a quick look at our <a href="https://dev.quantumcloud.com/smd/tutorials/" class="button button-primary" target="_blank">Video Tutorials</a></h3> -->


                            <h3>Shortcode Generator</h3>
                            <p>We encourage you to use the ShortCode generator found in the sidebar of your page/post
                                editor screen.</p>
                            <img src="<?php echo qcld_ichart_img_url1; ?>/shortcode-generator.png" alt="">
                            <img src="<?php echo qcld_ichart_img_url1; ?>/shortcode-modal.png" alt="">


                            <div>
                                <h2 class="ichart-plugin-title">Pro version Features</h2>
                                <p>Here are some important features of the Pro Version. You can <a
                                            style="text-decoration: none;"
                                            href="https://www.quantumcloud.com/products/iChart/" target="_blank">Upgrade
                                        to Pro</a> to get those:</p>
                                <ol class="ichart-feature-list">
                                    <li>
                                        Build Multiple type of Charts such as Pie Chart, Bar chart, Line Chart, Doughnut
                                        Chart, Polar Area Chart
                                    </li>
                                    <li>Support jQuery Datatable</li>
                                    <li>Support Multiple Datasets</li>
                                    <li>Customize Background Colors for each Datasets</li>
                                    <li>Three Positions to Display Chart informations Top, Bottom, and Right of the
                                        Chart
                                    </li>
                                    <li>Supports Links for each data.</li>
                                    <li>Give the option to hide Chart Information and show only the Chart</li>
                                    <li>Support Custom Text to Show after Tooltip and information</li>
                                    <li>Custom CSS to add your own style</li>
                                    <li>Fully customizable control over Typography</li>
                                    <li>Customizable Width, Text Color, Font Size, Background Color, Border etc.</li>
                                    <li>Fully control over Show and Hide Horizontal and Vertical Gridlines</li>
                                    <li>Import/Export Chart Data</li>
                                    <li>Powerful short code Generator for both Gutenberg and Classic Editor</li>
                                    <li>Live Chart Preview on Admin after Save</li>
                                </ol>
                            </div>

                            <div>
                                <link rel="stylesheet"
                                      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                                <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                                <link href="<?php echo qcld_ichart_url1; ?>/qc-support-promo-page/css/font-awesome.min.css"
                                      rel="stylesheet" type="text/css">
                                <link href="<?php echo qcld_ichart_url1; ?>/qc-support-promo-page/css/style.css"
                                      rel="stylesheet" type="text/css">
                                <link href="<?php echo qcld_ichart_url1; ?>/qc-support-promo-page/css/responsive.css"
                                      rel="stylesheet" type="text/css">

                                <div class="qc_support_container"><!--qc_support_container-->

                                    <div class="qc_tabcontent clearfix-div">
                                        <div class="qc-row">
                                            <div class="support-btn-main clearfix-div">

                                                <div id="support" class="qc-column-12">
                                                    <h2 class="plugin-title">Bug report, feature request or any feedback
                                                        – we are here for you.</h2>
                                                    <div class="support-btn">
                                                        <a class="free-support"
                                                           href="https://www.quantumcloud.com/resources/free-support/"
                                                           target="_blank">Free Support</a>
                                                    </div>
                                                </div>

                                                <div class="qc-column-12">
                                                    <h4>All our Pro Version users get Premium, Guaranteed Quick, One on
                                                        One Priority Support.</h4>
                                                    <div class="support-btn">
                                                        <a class="premium-support" href="https://qc.ticksy.com/"
                                                           target="_blank">GET PRIORITY SUPPORT</a>
                                                        <a style="width:282px" class="premium-support"
                                                           href="https://www.quantumcloud.com/resources/kb-sections/simple-link-directory/"
                                                           target="_blank">Online KnowledgeBase</a>
                                                    </div>

                                                </div>

                                            </div>
                                            <h2 class="ichart-plugin-title" style="margin: 60px auto;">
                                                Check Out Some of Our Other Works that Might Make Your Website
                                                Better</h2>

                                            <div class="qc-product-container">


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/infographic-maker-ilist/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/iList-icon-256x256.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/infographic-maker-ilist/"
                                                               target="_blank">InfoGraphic Maker – iList</a></h4>
                                                        <p>iList is first of its kind <strong>InfoGraphic maker</strong>
                                                            WordPress plugin to create Infographics and elegant Lists
                                                            effortlessly to visualize data.
                                                            It is a must have content creation and content curation
                                                            tool.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->

                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/slider-hero"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/slider-hero-icon-256x256.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4><a href="https://www.quantumcloud.com/products/slider-hero/"
                                                               target="_blank">Slider Hero</a></h4>
                                                        <p>Slider Hero is a unique slider plugin that allows you to
                                                            create <strong>Cinematic Product Intro Adverts</strong> and
                                                            <strong>Hero sliders</strong> with great Javascript
                                                            animation effects.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/simple-link-directory/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/sld-icon-256x256.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/simple-link-directory/"
                                                               target="_blank">Simple Link Directory</a></h4>
                                                        <p>Directory plugin with a unique approach! Simple Link
                                                            Directory is an advanced WordPress Directory plugin for One
                                                            Page
                                                            directory and Content Curation solution.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/simple-business-directory/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/icon.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/simple-business-directory/"
                                                               target="_blank">Simple Business Directory</a></h4>
                                                        <p>This innovative and powerful, yet<strong> Simple &amp;
                                                                Multi-purpose Business Directory</strong> WordPress
                                                            PlugIn allows you to create
                                                            comprehensive Lists of Businesses with maps and tap to call
                                                            features.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->

                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/woocommerce-chatbot-woowbot/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/logo.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/woocommerce-chatbot-woowbot/"
                                                               target="_blank">WoowBot WooCommerce ChatBot</a></h4>
                                                        <p>WooWBot is a stand alone WooCommerce Chat Bot with zero
                                                            configuration or bot training required. This plug and play
                                                            chatbot also does not require
                                                            any 3rd party service integration like Facebook.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/woocommerce-shop-assistant-jarvis/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/jarvis-icon-256x256.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/woocommerce-shop-assistant-jarvis/"
                                                               target="_blank">WooCommerce Shop Assistant</a></h4>
                                                        <p>WooCommerce Shop Assistant – <strong>JARVIS</strong> shows
                                                            recent user activities, provides advanced search, floating
                                                            cart, featured products,
                                                            store notifications, order notifications – all in one place
                                                            for easy access by buyer and make quick decisions.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/portfolio-x-plugin/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/portfolio-x-logo-dark-2.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/portfolio-x-plugin/"
                                                               target="_blank">Portfolio X</a></h4>
                                                        <p>Portfolio X is an advanced, responsive portfolio with
                                                            streamlined workflow and unique designs and templates to
                                                            show your works or projects.&nbsp;<strong>
                                                                Portfolio Showcase</strong> and <strong>Portfolio
                                                                Widgets</strong> are included.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->

                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/woo-tabbed-category-product-listing/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/woo-tabbed-icon-256x256.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/woo-tabbed-category-product-listing/"
                                                               target="_blank">Woo Tabbed Category Products</a></h4>
                                                        <p>WooCommerce plugin that allows you to showcase your products
                                                            category wise in tabbed format. This is a unique woocommerce
                                                            plugin that lets dynaimically
                                                            load your products in tabs based on your product categories
                                                            .</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/knowledgebase-helpdesk/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/knowledge-base.jpg"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/knowledgebase-helpdesk/"
                                                               target="_blank" rel="noopener noreferrer">KnowledgeBase
                                                                HelpDesk</a></h4>
                                                        <p>
                                                        <p>KnowledgeBase HelpDesk is an advanced Knowledgebase plugin
                                                            with helpdesk<strong>, </strong>glossary and FAQ features
                                                            all in one.
                                                            KnowledgeBase HelpDesk is extremely simple and easy to use.
                                                        </p></p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/express-shop/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/express-shop.png"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/express-shop/"
                                                               target="_blank">Express Shop</a></h4>
                                                        <p>Express Shop is a WooCommerce addon to show all products in
                                                            one page. User can add products to cart and go to checkout.
                                                            Filtering and search integrated in single page.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/seo-help"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/seo-help.jpg"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4><a href="https://www.quantumcloud.com/products/seo-help"
                                                               target="_blank">SEO Help</a></h4>
                                                        <p>SEO Help is a unique WordPress plugin to help you write
                                                            better Link Bait titles. The included LinkBait title
                                                            generator will take the
                                                            WordPress post title as Subject and generate alternative
                                                            ClickBait titles for you to choose from.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/ichart/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/ichart-300x300.jpg"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4><a href="https://www.quantumcloud.com/products/ichart/"
                                                               target="_blank">iChart – Easy Charts and Graphs</a></h4>
                                                        <p>Charts and graphs are now easy to build and add to any
                                                            WordPress page with just a few clicks and shortcode
                                                            generator.
                                                            iChart is a Google chartjs implementation to add graphs
                                                            &amp;
                                                            <strong>charts</strong> – directly from WordPress Visual
                                                            editor.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/analytics-tracking/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/PageSpeed-Friendly-Analytics-Tracking-1-300x300.jpg"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/analytics-tracking/"
                                                               target="_blank">PageSpeed Friendly Analytics Tracking</a>
                                                        </h4>
                                                        <p>QuantumCloud PageSpeed Friendly Analytics Tracking for Google
                                                            does the simple job of adding tracking code to your
                                                            WordPress website in all pages.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->


                                            <div class="qc-product-box"><!-- qc-product-box -->
                                                <!-- Feature Box 1 -->
                                                <div class="support-block ">
                                                    <div class="support-block-img">
                                                        <a href="https://www.quantumcloud.com/products/comment-link-remove/"
                                                           target="_blank"> <img
                                                                    src="https://www.quantumcloud.com/products/wp-content/uploads/2017/03/Comment-Link-Remove-300x300.jpg"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="support-block-info">
                                                        <h4>
                                                            <a href="https://www.quantumcloud.com/products/comment-link-remove/"
                                                               target="_blank">Comment Link Remove</a></h4>
                                                        <p>All in one solution to fight comment spammers. Tired of
                                                            deleting useless spammy comments from your WordPress blog
                                                            posts? Comment Link Remove WordPress
                                                            plugin removes author link and any other links from the user
                                                            comments.</p>

                                                    </div>
                                                </div>
                                            </div><!--/qc-product-box -->
                                            </div><!--qc-product-container-->

                                        </div>
                                        <!--qc row-->
                                    </div>


                                </div><!--qc_support_container-->
                            </div>

                            <div style="padding: 15px 10px; border: 1px solid #ccc; text-align: center; margin-top: 20px;">
                                Crafted By: <a href="https://www.quantumcloud.com" target="_blank">Web Design
                                    Company</a> - QuantumCloud
                            </div>

                        </div>
                        <!-- /post-body-content -->


                    </div>
                    <!-- /post-body-->

                </div>
                <!-- /poststuff -->

            </div>

        </div>
        <!-- /poststuff -->


        <?php
    }
}

new Qcopd_info_page;