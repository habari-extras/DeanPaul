<?php

/**
 * MyTheme is a custom Theme class for the K2 theme.
 *
 * @package Habari
 */

// We must tell Habari to use MyTheme as the custom theme class:
define( 'THEME_CLASS', 'MyTheme' );

/**
 * A custom theme for K2 output
 */
class MyTheme extends Theme
{
	protected $defaults = array(
		'login_display_location' => 'sidebar',
		'home_label' => 'Blog',
		'show_author' => false,
	);

	/**
	 * Add the K2 menu block to the nav area upon theme activation if there's nothing already there
	 */
	public function action_theme_activated()
	{
		$opts = Options::get_group( __CLASS__ );
		if ( empty( $opts ) ) {
			Options::set_group( __CLASS__, $this->defaults );
		}

	}

	/**
	 * Execute on theme init to apply these filters to output
	 */
	public function action_init_theme()
	{
// Apply Format::autop() to post content...
Format::apply( 'autop', 'post_content_out' );
// Apply Format::autop() to comment content...
Format::apply( 'autop', 'comment_content_out' );
// Apply Format::tag_and_list() to post tags...
Format::apply( 'tag_and_list', 'post_tags_out' );

// Remove the comment on the following line to limit post length on the home page to 1 paragraph or 100 characters
//Format::apply_with_hook_params( 'more', 'post_content_out', _t('more'), 100, 1 );
	}

/**
	 * Add additional template variables to the template output.
	 *
	 *  You can assign additional output values in the template here, instead of
	 *  having the PHP execute directly in the template.  The advantage is that
	 *  you would easily be able to switch between template types (RawPHP/Smarty)
	 *  without having to port code from one to the other.
	 *
	 *  You could use this area to provide "recent comments" data to the template,
	 *  for instance.
	 *
	 *  Note that the variables added here should possibly *always* be added,
	 *  especially 'user'.
	 *
	 *  Also, this function gets executed *after* regular data is assigned to the
	 *  template.  So the values here, unless checked, will overwrite any existing
	 *  values.
	 */
	public function add_template_vars()
	{
		//Theme Options
		$this->assign( 'display_login', Options::get( __CLASS__ . '__login_display_location', 'sidebar' ) );
		$this->assign( 'home_label' , Options::get( __CLASS__ . '__home_label', _t( 'Blog' ) ) );
		$this->assign( 'show_author', Options::get( __CLASS__ . '__show_author', false ) );

		if( !$this->template_engine->assigned( 'pages' ) ) {
			$this->assign('pages', Posts::get( array( 'content_type' => 'page', 'status' => Post::status('published'), 'nolimit' => 1 ) ) );
		}
		if( !$this->template_engine->assigned( 'page' ) ) {
			$page = Controller::get_var( 'page' );
			$this->assign('page', isset( $page ) ? $page : 1 );
		}
		parent::add_template_vars();

		if ( User::identify()->loggedin ) {
			Stack::add( 'template_header_javascript', Site::get_url('scripts') . '/jquery.js', 'jquery' );
		}
	}

	/**
	 * function action_theme_ui
	 * Create and display the Theme configuration
	 **/
	public function action_theme_ui()
	{
		$opts = Options::get_group( __CLASS__ );
		if ( empty( $opts ) ) {
			Options::set_group( __CLASS__, $this->defaults );
		}

		$controls = array();
		$controls['home_label'] = array(
			'label' => _t('Home tab label:', 'deanpaul'),
			'type' => 'text'
		);
		$controls['login_display_location'] = array(
			'label' => _t('Login display:', 'deanpaul'),
			'type' => 'select',
			'options' => array(
				'nowhere' => _t( 'Nowhere', 'deanpaul' ),
				'header' => _t( 'As a navigation tab', 'deanpaul' ),
				'sidebar' => _t( 'In the sidebar', 'deanpaul' )
			)
		);
		$controls['show_author'] = array(
			'label' => _t( 'Display author:', 'deanpaul' ),
			'type' => 'checkbox',
		);

		$ui = new FormUI( strtolower( get_class( $this ) ) );
		$wrapper = $ui->append( 'wrapper', 'config', 'config' );
		$wrapper->class = "settings clear";

		foreach ( $controls as $option_name => $option ) {
			$field = $wrapper->append( $option['type'], $option_name, __CLASS__. '__' . $option_name, $option['label'] );
			$field->template = 'optionscontrol_' . $option['type'];
			$field->class = "item clear";
			if ( $option['type'] === 'select' and isset( $option['options'] ) ) {
				$field->options = $option['options'];
			}
		}
		$ui->append( 'submit', 'save', _t( 'Save', 'deanpaul' ) );
		$ui->on_success( array( $this, 'config_updated') );
		$ui->out();
	}

	/**
	 * function config_updated
	 * Return a success message
	 **/
	public function config_updated( $ui )
	{
		Session::notice( _t( 'Configuration updated', 'deanpaul' ) );
		$ui->save();
	}

	public function k2_comment_class( $comment, $post )
	{
		$class = 'class="comment';
		if ( $comment->status == Comment::STATUS_UNAPPROVED ) {
			$class.= '-unapproved';
		}
		// check to see if the comment is by a registered user
		if ( $u = User::get( $comment->email ) ) {
			$class.= ' byuser comment-author-' . Utils::slugify( $u->displayname );
		}
		if( $comment->email == $post->author->email ) {
			$class.= ' bypostauthor';
		}

		$class.= '"';
		return $class;
	}
	public function action_form_comment( $form ) {
        $form->cf_content->caption = '';
	}
}

?>
