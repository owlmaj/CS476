<?php
/**
 * Welcome class.
 *
 * @since 1.1.4
 *
 * @package OMAPI
 * @author  Devin Vinson
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Welcome class.
 *
 * @since 1.1.4
 */
class OMAPI_Welcome {

	/**
	 * Holds the class object.
	 *
	 * @since 1.1.4.2
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 1.1.4.2
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the base class object.
	 *
	 * @since 1.1.4.2
	 *
	 * @var object
	 */
	public $base;

	/**
	 * Holds the welcome slug.
	 *
	 * @since 1.1.4.2
	 *
	 * @var string
	 */
	public $hook;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.1.4.2
	 */
	public function __construct() {
		// If we are not in admin or admin ajax, return.
		if ( ! is_admin() ) {
			return;
		}

		// If user is in admin ajax or doing cron, return.
		if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX  ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
			return;
		}

		// If user is not logged in, return.
		if ( ! is_user_logged_in() ) {
			return;
		}

		// If user cannot manage_options, return.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Set our object.
		$this->set();

		//Load the Welcome screen
		add_action( 'admin_menu', array($this, 'register_welcome_page' ) );

		//maybe redirect
		add_action( 'admin_init', array( $this, 'maybe_welcome_redirect' ) );

		//maybe add body classes
		add_action( 'current_screen', array( $this, 'welcome_screen_helpers' ) );

		// Maybe load a dashboard widget.
		add_action( 'wp_dashboard_setup', array( $this, 'dashboard_widget' ) );
	}

	/**
	 * Sets our object instance and base class instance.
	 *
	 * @since 1.1.4.2
	 */
	public function set() {

		self::$instance = $this;
		$this->base     = OMAPI::get_instance();
		$this->view     = isset( $_GET['optin_monster_api_view'] ) ? stripslashes( $_GET['optin_monster_api_view'] ) : $this->base->get_view();

	}

	public function welcome_screen_helpers() {

		$screen = get_current_screen();

		if ( 'admin_page_optin-monster-api-welcome' === $screen->id ) {
			update_option( 'optin_monster_viewed_welcome', true );
			add_filter( 'admin_body_class', array( $this, 'add_body_classes' ) );
		}

		// Make sure welcome page is always first page to view.
		if ( 'toplevel_page_optin-monster-api-settings' === $screen->id ) {
			// If We don't have the OM API Key set, and the "Bypass welcome screen" query string isn't set
			if ( ! $this->base->get_api_credentials() && ! isset( $_GET['om-bypass-api-check'] ) ) {
				die( wp_redirect( 'admin.php?page=optin-monster-api-welcome' ) );
			}
		}
	}
	/**
	 * Add body classes
	 */
	public function add_body_classes( $classes ) {

		$classes .= ' omapi-welcome ';

		return $classes;
	}

	/**
	 * Maybe Redirect new users to the welcome page after install.
	 *
	 * @since 1.1.4.2
	 */
	public function maybe_welcome_redirect() {

		$options = $this->base->get_option();

		//Check for the new option
		if ( ! empty( $options['welcome']['status'] ) ){

			// Check if they have been welcomed
			if ( 'none' === $options['welcome']['status'] ) {

				// Update the option.
				$options['welcome']['status'] = 'welcomed';
				update_option('optin_monster_api', $options );

				// If this was not a bulk activate send them to the page
				if ( ! isset( $_GET['activate-multi'] ) ) {
					// Only redirect if no trial is found.
					$trial = $this->base->menu->has_trial_link();
					if ( ! $trial ) {
						wp_redirect( 'admin.php?page=optin-monster-api-welcome' );
					}
				}

			}

		} else {
			//welcome option didn't exist so must be pre-existing user updating
			$options['welcome']['status'] = 'welcomed';
			update_option('optin_monster_api', $options );
		}

	}

	/**
	 * Loads the OptinMonster admin menu.
	 *
	 * @since 1.1.4.2
	 */
	public function register_welcome_page() {
		$slug = 'optin-monster-api-welcome';
		$is_current = isset( $_GET['page'] ) && $slug === $_GET['page'];

		$this->hook = add_submenu_page(
			$is_current ? 'optin-monster-api-settings' : 'optin-monster-api-settings-no-menu', //parent slug
			esc_html__( 'Welcome to OptinMonster', 'optin-monster-api' ), //page title,
			esc_html__( 'Welcome', 'optin-monster-api' ),
			apply_filters( 'optin_monster_api_menu_cap', 'manage_options', $slug ), //cap
			$slug, //slug
			array( $this, 'callback_to_display_page' ) //callback
		);

		// Load settings page assets.
		if ( $this->hook ) {
			add_action( 'load-' . $this->hook, array( $this, 'assets' ) );
		}

	}

	/**
	 * Outputs the OptinMonster settings page.
	 *
	 * @since 1.1.4.2
	 */
	public function callback_to_display_page() {

		$text = $this->base->menu->has_trial_link() ? esc_html__( 'Get Started for Free', 'optin-monster-api' ) : esc_html__( 'Get OptinMonster Now', 'optin-monster-api' );
		$link = esc_url( $this->base->menu->get_action_link() );
		$api_link = esc_url_raw( admin_url( 'admin.php?page=optin-monster-api-settings&om-bypass-api-check=true' ) );
	?>
		<div class="omapi-welcome-content">
			<div class="inner-container">
				<h1><?php esc_html_e( 'Welcome to OptinMonster', 'optin-monster-api' ); ?></h1>

				<div class="omapi-well welcome-connect">
					<p><?php esc_html_e( 'Please connect to or create an OptinMonster account to start using OptinMonster. This will enable you to start turning website visitors into subscribers & customers.', 'optin-monster-api' ); ?></p>
					<div class="actions">
						<a class="button button-omapi-green button-hero" href="<?php echo $link; ?>" target="_blank"><?php echo $text; ?></a>
						<span class="or">or</span>
						<a class="button button-omapi-gray button-hero" href="<?php echo $api_link; ?>"><?php esc_html_e( 'Connect Your Account', 'optin-monster-api' ) ?></a>
					</div>
				</div>
				<div id="js__omapi-video-well" class="omapi-well welcome-data-vid">
					<h2><?php esc_html_e( 'Get More Email Subscribers, FAST!', 'optin-monster-api' ); ?></h2>
					<p><?php esc_html_e( 'OptinMonster helps you convert abandoning website visitors into email subscribers with smart web forms and behavior personalization.', 'optin-monster-api' ); ?></p>
					<div class="actions">
						<a id="js_omapi-welcome-video-link" class="omapi-video-link" href="https://www.youtube.com/embed/jbP9C9bQtv4?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1">
							<img width="188" src="<?php echo plugins_url( '/assets/css/images/video-cta-button.png', OMAPI_FILE ) ?>">
						</a>
					</div>
					<div class="omapi-welcome-video-holder">
						<iframe id="js__omapi-welcome-video-frame" width="640" height="360" src="" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>

				<div class="omapi-sub-title">
					<h2><?php esc_html_e( 'Top 4 Reasons Why People Love OptinMonster', 'optin-monster-api' ); ?></h2>
					<p><?php esc_html_e( 'Here\'s why smart business owners love OptinMonster, and you will too!', 'optin-monster-api' ); ?></p>
				</div>
				<div class="divider"></div>

				<div class="omapi-feature-box omapi-clear">
					<div class="omapi-feature-image"><img src="<?php echo plugins_url( '/assets/css/images/features-builder.png', OMAPI_FILE ); ?>" alt="<?php esc_attr_e( 'OptinMonster Form Builder', 'optin-monster-api' ); ?>" /></div>
					<div class="omapi-feature-text">
						<h3><?php esc_html_e( 'Build high converting forms in minutes, not hours', 'optin-monster-api' ); ?></h3>
						<p><?php esc_html_e( 'Create visually stunning optin forms that are optimized for the highest conversion rates.', 'optin-monster-api' ); ?></p>
						<p><?php esc_html_e( 'You can create various types of optin forms such as lightbox popups, floating bars, slide-ins, and more.', 'optin-monster-api' ); ?></p>
					</div>
				</div>

				<div class="omapi-feature-box omapi-clear">
					<div class="omapi-feature-text">
						<h3><?php esc_html_e( 'Convert abandoning visitors into subscribers & customers', 'optin-monster-api' ); ?></h3>
						<p><?php esc_html_e( 'Did you know that over 70% of visitors who abandon your website will never return?', 'optin-monster-api' ); ?></p>
						<p><?php esc_html_e( 'Our exit-intent&reg; technology detects user behavior and prompts them with a targeted campaign at the precise moment they are about to leave.', 'optin-monster-api' ); ?></p>
					</div>
					<div class="omapi-feature-image"><img src="<?php echo plugins_url( '/assets/css/images/features-exit-animated.gif', OMAPI_FILE ); ?>" alt="<?php esc_attr_e( 'OptinMonster Exit Intent Technology', 'optin-monster-api' ); ?>" /></div>
				</div>

				<div class="omapi-feature-box omapi-clear">
					<div class="omapi-feature-image"><img src="<?php echo plugins_url( '/assets/css/images/features-ab-testing.png', OMAPI_FILE ); ?>" alt="<?php esc_attr_e( 'OptinMonster uses smart A/B testing', 'optin-monster-api' ); ?>" /></div>
					<div class="omapi-feature-text">
						<h3><?php esc_html_e( 'Easily A/B test your ideas and increase conversions', 'optin-monster-api' ); ?></h3>
						<p><?php esc_html_e( 'A/B testing helps you eliminate the guess work and make data-driven decisions on what works best.', 'optin-monster-api' ); ?></p>
						<p><?php esc_html_e( 'Try different content, headlines, layouts, and styles to see what converts best with our smart and easy to use A/B testing tool.', 'optin-monster-api' ); ?></p>
					</div>
				</div>

				<div class="omapi-feature-box omapi-clear">
					<div class="omapi-feature-text">
						<h3><?php esc_html_e( 'Measuring your results has never been easier', 'optin-monster-api' ); ?></h3>
						<p><?php esc_html_e( 'Get the stats that matter and take action to imrpove your lead-generation strategy.', 'optin-monster-api' ); ?></p>
						<p><?php esc_html_e( 'Our built-in analytics help you analyze clicks, views, and overall conversion rates for each page and optin form.', 'optin-monster-api' ); ?></p>
					</div>
					<div class="omapi-feature-image"><img src="<?php echo plugins_url( '/assets/css/images/features-analytics.png', OMAPI_FILE ); ?>" alt="<?php esc_attr_e( 'OptinMonster Segmenting with Page Level Targeting', 'optin-monster-api' ); ?>" /></div>
				</div>

				<div class="omapi-single-cta">
					<a class="button button-omapi-green button-hero" href="<?php echo $link; ?>" target="_blank"><?php echo $text; ?></a>
				</div>
				<div class="omapi-well welcome-featuredin">
					<h2><?php esc_html_e( 'OptinMonster has been featured in:', 'optin-monster-api' ); ?></h2>
					<img src="<?php echo plugins_url( '/assets/css/images/featured-logos.png', OMAPI_FILE ); ?>" alt="<?php esc_attr_e( 'OptinMonster has been featured in Inc., Forbes, VB, Yahoo, Entrepreneur, Huff Post, and more', 'optin-monster-api' ); ?>" />
				</div>

				<div class="omapi-reviews">
					<div class="omapi-well omapi-mini-well">
						<div class="omapi-talking-head">
							<img src="<?php echo plugins_url( '/assets/css/images/michaelstelzner.png', OMAPI_FILE ); ?>">
						</div>
						<p class="ompai-review">
							<?php _e( '<strong>We added more than 95,000 names to our email list</strong> using OptinMonster\'s Exit Intent&reg; technology. We strongly recommend it!', 'optin-monster-api' ); ?>
							<span class="reviewer-name"><?php esc_html_e( 'Michael Stelzner', 'optin-monster-api' ); ?></span>
							<span class="reviewer-title"><?php esc_html_e( 'Founder Social Media Examiner', 'optin-monster-api' ); ?></span>
						</p>
					</div>
					<div class="omapi-well omapi-mini-well">
						<div class="omapi-talking-head">
							<img src="<?php echo plugins_url( '/assets/css/images/neilpatel.png', OMAPI_FILE ); ?>">
						</div>
						<p class="ompai-review">
							<?php _e( 'Exit Intent&reg; popups have doubled my email opt-in rate. <strong>When done right, you can see an instant 10% lift on driving sales.</strong> I highly recommend that you use OptinMonster for growing your email list and sales.', 'optin-monster-api' ); ?>
							<span class="reviewer-name"><?php esc_html_e( 'Neil Patel', 'optin-monster-api' ); ?></span>
							<span class="reviewer-title"><?php esc_html_e( 'Founder QuickSprout', 'optin-monster-api' ); ?></span>
						</p>
					</div>
					<div class="omapi-well omapi-mini-well">
						<div class="omapi-talking-head">
							<img src="<?php echo plugins_url( '/assets/css/images/matthewwoodward.png', OMAPI_FILE ); ?>">
						</div>
						<p class="ompai-review">
							<?php _e( 'OptinMonster played a critical role in increasing my email optin conversion rate by 469%. In real numbers, <strong>that is the difference between $7,765 and $47,748 per month.</strong>', 'optin-monster-api' ); ?>
							<span class="reviewer-name"><?php esc_html_e( 'Matthew Woodward', 'optin-monster-api' ); ?></span>
							<span class="reviewer-title"><?php esc_html_e( 'SEO Expert', 'optin-monster-api' ); ?></span>
						</p>
					</div>
				</div>

				<div class="omapi-well welcome-connect">
					<p><?php esc_html_e( 'Join the thousands of users who use OptinMonster to convert abandoning website visitors into subscribers and customers.', 'optin-monster-api' ); ?></p>
					<div class="actions">
						<a class="button button-omapi-green button-hero" href="<?php echo $link; ?>" target="_blank"><?php echo $text; ?></a>
						<span class="or">or</span>
						<a class="button button-omapi-gray button-hero" href="<?php echo $api_link; ?>"><?php esc_html_e( 'Connect Your Account', 'optin-monster-api' ) ?></a>
					</div>
				</div>

			</div>

		</div>

	<?php

	}

	/**
	 * Loads a dashboard widget if the user has not entered and verified API credentials.
	 *
	 * @since 1.1.5.1
	 */
	public function dashboard_widget() {
		if ( $this->base->get_api_credentials() ) {
			return;
		}

		wp_add_dashboard_widget(
			'optin_monster_db_widget',
			esc_html__( 'Please Connect OptinMonster', 'optin-monster-api' ),
			array( $this, 'dashboard_widget_callback' )
		);

		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$example_widget_backup = array( 'optin_monster_db_widget' => $normal_dashboard['optin_monster_db_widget'] );
		unset( $normal_dashboard['optin_monster_db_widget'] );
		$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}

	/**
	 * Dashboard widget callback.
	 *
	 * @since 1.1.5.1
	 */
	public function dashboard_widget_callback() {
		?>
		<div class="optin-monster-db-widget" style="text-align:center;">
			<p><img src="<?php echo plugins_url( '/assets/css/images/dashboard-icon.png', OMAPI_FILE ); ?>" alt="<?php esc_attr_e( 'Archie', 'optin-monster-api' ); ?>" width="64px" height="64px"></p>
			<h3 style="font-weight:normal;font-size:1.3em;"><?php esc_html_e( 'Please Connect OptinMonster', 'optin-monster-api' ); ?></h3>
			<p><?php _e( 'OptinMonster helps you convert abandoning website visitors into subscribers and customers. <strong>Get more email subscribers now.</strong>', 'optin-monster-api' ); ?></p>
			<p><a href="<?php echo esc_url( $this->base->menu->get_dashboard_link() ); ?>" class="button button-primary" title="<?php esc_attr_e( 'Connect OptinMonster', 'optin-monster-api' ); ?>"><?php esc_html_e( 'Connect OptinMonster', 'optin-monster-api' ); ?></a></p>
		</div>
		<?php
	}

	/**
	 * Loads assets for the settings page.
	 *
	 * @since 1.1.4.2
	 */
	public function assets() {

		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'admin_print_footer_scripts', array( $this, 'scripts' ) );
		add_filter( 'admin_footer_text', array( $this, 'footer' ) );
		add_action( 'in_admin_header', array( $this->base->menu, 'output_plugin_screen_banner' ) );

	}

	/**
	 * Register and enqueue settings page specific CSS.
	 *
	 * @since 1.1.4.2
	 */
	public function styles() {

		wp_register_style( $this->base->plugin_slug . '-settings', plugins_url( '/assets/css/settings.css', OMAPI_FILE ), array(), $this->base->version );
		wp_enqueue_style( $this->base->plugin_slug . '-settings' );

	}

	public function scripts() {
		?>
		<script type="text/javascript">
			jQuery( '#js_omapi-welcome-video-link' )
				.on( 'click', function ( e ) {
					e.preventDefault();
					jQuery( this ).parents( '#js__omapi-video-well' ).addClass( 'active' );
					jQuery( '#js__omapi-welcome-video-frame' ).prop( 'src', jQuery( e.currentTarget ).attr( 'href' ) );
				})
		</script>
		<?php
	}

	/**
	 * Customizes the footer text on the OptinMonster settings page.
	 *
	 * @since 1.0.0
	 *
	 * @param string $text  The default admin footer text.
	 * @return string $text Amended admin footer text.
	 */
	public function footer( $text ) {

		$new_text = sprintf( __( 'Thank you for using <a href="%1$s" target="_blank">OptinMonster</a>!', 'optin-monster-api' ),
			'https://optinmonster.com'
		);
		return str_replace( '</span>', '', $text ) . ' | ' . $new_text . '</span>';

	}

}
