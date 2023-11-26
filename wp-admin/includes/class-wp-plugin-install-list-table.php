<?php
/**
 * List Table API: WP_Plugin_Install_List_Table class
 *
 * @package WordPress
 * @subpackage Administration
 * @since 3.1.0
 */

/**
 * Core class used to implement displaying plugins to install in a list table.
 *
 * @since 3.1.0
 * @access private
 *
 * @see WP_List_Table
 */
class WP_Plugin_Install_List_Table extends WP_List_Table {

	public $order   = 'ASC';
	public $orderby = null;
	public $groups  = array();

	private $error;

	/**
	 * @return bool
	 */
	public function ajax_user_can() {
		return current_user_can( 'install_plugins' );
	}

	/**
	 * Return the list of known plugins.
	 *
	 * Uses the transient data from the updates API to determine the known
	 * installed plugins.
	 *
	 * @since 4.9.0
	 * @access protected
	 *
	 * @return array
	 */
	protected function get_installed_plugins() {
		$plugins = array();

		$plugin_info = get_site_transient( 'update_plugins' );
		if ( isset( $plugin_info->no_update ) ) {
			foreach ( $plugin_info->no_update as $plugin ) {
				$plugin->upgrade          = false;
				$plugins[ $plugin->slug ] = $plugin;
			}
		}

		if ( isset( $plugin_info->response ) ) {
			foreach ( $plugin_info->response as $plugin ) {
				$plugin->upgrade          = true;
				$plugins[ $plugin->slug ] = $plugin;
			}
		}

		return $plugins;
	}

	/**
	 * Return a list of slugs of installed plugins, if known.
	 *
	 * Uses the transient data from the updates API to determine the slugs of
	 * known installed plugins. This might be better elsewhere, perhaps even
	 * within get_plugins().
	 *
	 * @since 4.0.0
	 *
	 * @return array
	 */
	protected function get_installed_plugin_slugs() {
		return array_keys( $this->get_installed_plugins() );
	}

	/**
	 * @global array  $tabs
	 * @global string $tab
	 * @global int    $paged
	 * @global string $type
	 * @global string $term
	 */
	public function prepare_items() {
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

		global $tabs, $tab, $paged, $type, $term;

		wp_reset_vars( array( 'tab' ) );

		$paged = $this->get_pagenum();

		$per_page = 36;

		// These are the tabs which are shown on the page
		$tabs = array();

		if ( 'search' === $tab ) {
			$tabs['search'] = __( 'Search Results' );
		}
		if ( $tab === 'beta' || false !== strpos( get_bloginfo( 'version' ), '-' ) ) {
			$tabs['beta'] = _x( 'Beta Testing', 'Plugin Installer' );
		}
		$tabs['featured']    = _x( 'Featured', 'Plugin Installer' );
		$tabs['popular']     = _x( 'Popular', 'Plugin Installer' );
		$tabs['recommended'] = _x( 'Recommended', 'Plugin Installer' );
		$tabs['favorites']   = _x( 'Favorites', 'Plugin Installer' );
		if ( current_user_can( 'upload_plugins' ) ) {
			// No longer a real tab. Here for filter compatibility.
			// Gets skipped in get_views().
			$tabs['upload'] = __( 'Upload Plugin' );
		}

		$nonmenu_tabs = array( 'plugin-information' ); // Valid actions to perform which do not have a Menu item.

		/**
		 * Filters the tabs shown on the Plugin Install screen.
		 *
		 * @since 2.7.0
		 *
		 * @param string[] $tabs The tabs shown on the Plugin Install screen. Defaults include 'featured', 'popular',
		 *                      'recommended', 'favorites', and 'upload'.
		 */
		$tabs = apply_filters( 'install_plugins_tabs', $tabs );

		/**
		 * Filters tabs not associated with a menu item on the Plugin Install screen.
		 *
		 * @since 2.7.0
		 *
		 * @param string[] $nonmenu_tabs The tabs that don't have a menu item on the Plugin Install screen.
		 */
		$nonmenu_tabs = apply_filters( 'install_plugins_nonmenu_tabs', $nonmenu_tabs );

		// If a non-valid menu tab has been selected, And it's not a non-menu action.
		if ( empty( $tab ) || ( ! isset( $tabs[ $tab ] ) && ! in_array( $tab, (array) $nonmenu_tabs ) ) ) {
			$tab = key( $tabs );
		}

		$installed_plugins = $this->get_installed_plugins();

		$args = array(
			'page'     => $paged,
			'per_page' => $per_page,
			// Send the locale to the API so it can provide context-sensitive results.
			'locale'   => get_user_locale(),
		);

		switch ( $tab ) {
			case 'search':
				$type = isset( $_REQUEST['type'] ) ? wp_unslash( $_REQUEST['type'] ) : 'term';
				$term = isset( $_REQUEST['s'] ) ? wp_unslash( $_REQUEST['s'] ) : '';

				switch ( $type ) {
					case 'tag':
						$args['tag'] = sanitize_title_with_dashes( $term );
						break;
					case 'term':
						$args['search'] = $term;
						break;
					case 'author':
						$args['author'] = $term;
						break;
				}

				break;

			case 'featured':
			case 'popular':
			case 'new':
			case 'beta':
				$args['browse'] = $tab;
				break;
			case 'recommended':
				$args['browse'] = $tab;
				// Include the list of installed plugins so we can get relevant results.
				$args['installed_plugins'] = array_keys( $installed_plugins );
				break;

			case 'favorites':
				$action = 'save_wporg_username_' . get_current_user_id();
				if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( wp_unslash( $_GET['_wpnonce'] ), $action ) ) {
					$user = isset( $_GET['user'] ) ? wp_unslash( $_GET['user'] ) : get_user_option( 'wporg_favorites' );

					// If the save url parameter is passed with a falsey value, don't save the favorite user.
					if ( ! isset( $_GET['save'] ) || $_GET['save'] ) {
						update_user_meta( get_current_user_id(), 'wporg_favorites', $user );
					}
				} else {
					$user = get_user_option( 'wporg_favorites' );
				}
				if ( $user ) {
					$args['user'] = $user;
				} else {
					$args = false;
				}

				add_action( 'install_plugins_favorites', 'install_plugins_favorites_form', 9, 0 );
				break;

			default:
				$args = false;
				break;
		}

		/**
		 * Filters API request arguments for each Plugin Install screen tab.
		 *
		 * The dynamic portion of the hook name, `$tab`, refers to the plugin install tabs.
		 * Default tabs include 'featured', 'popular', 'recommended', 'favorites', and 'upload'.
		 *
		 * @since 3.7.0
		 *
		 * @param array|bool $args Plugin Install API arguments.
		 */
		$args = apply_filters( "install_plugins_table_api_args_{$tab}", $args );

		if ( ! $args ) {
			return;
		}

		$api = plugins_api( 'query_plugins', $args );

		if ( is_wp_error( $api ) ) {
			$this->error = $api;
			return;
		}

		$this->items = $api->plugins;

		if ( $this->orderby ) {
			uasort( $this->items, array( $this, 'order_callback' ) );
		}

		$this->set_pagination_args(
			array(
				'total_items' => $api->info['results'],
				'per_page'    => $args['per_page'],
			)
		);

		if ( isset( $api->info['groups'] ) ) {
			$this->groups = $api->info['groups'];
		}

		if ( $installed_plugins ) {
			$js_plugins = array_fill_keys(
				array( 'all', 'search', 'active', 'inactive', 'recently_activated', 'mustuse', 'dropins' ),
				array()
			);

			$js_plugins['all'] = array_values( wp_list_pluck( $installed_plugins, 'plugin' ) );
			$upgrade_plugins   = wp_filter_object_list( $installed_plugins, array( 'upgrade' => true ), 'and', 'plugin' );

			if ( $upgrade_plugins ) {
				$js_plugins['upgrade'] = array_values( $upgrade_plugins );
			}

			wp_localize_script(
				'updates',
				'_wpUpdatesItemCounts',
				array(
					'plugins' => $js_plugins,
					'totals'  => wp_get_update_data(),
				)
			);
		}
	}

	/**
	 */
	public function no_items() {
		if ( isset( $this->error ) ) { ?>
			<div class="inline error"><p><?php echo $this->error->get_error_message(); ?></p>
				<p class="hide-if-no-js"><button class="button try-again"><?php _e( 'Try Again' ); ?></button></p>
			</div>
		<?php } else { ?>
			<div class="no-plugin-results"><?php _e( 'No plugins found. Try a different search.' ); ?></div>
			<?php
		}
	}

	/**
	 * @global array $tabs
	 * @global string $tab
	 *
	 * @return array
	 */
	protected function get_views() {
		global $tabs, $tab;

		$display_tabs = array();
		foreach ( (array) $tabs as $action => $text ) {
			$current_link_attributes                     = ( $action === $tab ) ? ' class="current" aria-current="page"' : '';
			$href                                        = self_admin_url( 'plugin-install.php?tab=' . $action );
			$display_tabs[ 'plugin-install-' . $action ] = "<a href='$href'$current_link_attributes>$text</a>";
		}
		// No longer a real tab.
		unset( $display_tabs['plugin-install-upload'] );

		return $display_tabs;
	}

	/**
	 * Override parent views so we can use the filter bar display.
	 */
	public function views() {
		$views = $this->get_views();

		/** This filter is documented in wp-admin/inclues/class-wp-list-table.php */
		$views = apply_filters( "views_{$this->screen->id}", $views );

		$this->screen->render_screen_reader_content( 'heading_views' );
		?>
<div class="wp-filter">
	<ul class="filter-links">
		<?php
		if ( ! empty( $views ) ) {
			foreach ( $views as $class => $view ) {
				$views[ $class ] = "\t<li class='$class'>$view";
			}
			echo implode( " </li>\n", $views ) . "</li>\n";
		}
		?>
	</ul>

		<?php install_search_form(); ?>
</div>
		<?php
	}

	/**
	 * Displays the plugin install table.
	 *
	 * Overrides the parent display() method to provide a different container.
	 *
	 * @since 4.0.0
	 */
	public function display() {
		$singular = $this->_args['singular'];

		$data_attr = '';

		if ( $singular ) {
			$data_attr = " data-wp-lists='list:$singular'";
		}

		$this->display_tablenav( 'top' );

		?>
<div class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
		<?php
		$this->screen->render_screen_reader_content( 'heading_list' );
		?>
	<div id="the-list"<?php echo $data_attr; ?>>
		<?php $this->display_rows_or_placeholder(); ?>
	</div>
</div>
		<?php
		$this->display_tablenav( 'bottom' );
	}

	/**
	 * @global string $tab
	 *
	 * @param string $which
	 */
	protected function display_tablenav( $which ) {
		if ( $GLOBALS['tab'] === 'featured' ) {
			return;
		}

		if ( 'top' === $which ) {
			wp_referer_field();
			?>
			<div class="tablenav top">
				<div class="alignleft actions">
					<?php
					/**
					 * Fires before the Plugin Install table header pagination is displayed.
					 *
					 * @since 2.7.0
					 */
					do_action( 'install_plugins_table_header' );
					?>
				</div>
				<?php $this->pagination( $which ); ?>
				<br class="clear" />
			</div>
		<?php } else { ?>
			<div class="tablenav bottom">
				<?php $this->pagination( $which ); ?>
				<br class="clear" />
			</div>
			<?php
		}
	}

	/**
	 * @return array
	 */
	protected function get_table_classes() {
		return array( 'widefat', $this->_args['plural'] );
	}

	/**
	 * @return array
	 */
	public function get_columns() {
		return array();
	}

	/**
	 * @param object $plugin_a
	 * @param object $plugin_b
	 * @return int
	 */
	private function order_callback( $plugin_a, $plugin_b ) {
		$orderby = $this->orderby;
		if ( ! isset( $plugin_a->$orderby, $plugin_b->$orderby ) ) {
			return 0;
		}

		$a = $plugin_a->$orderby;
		$b = $plugin_b->$orderby;

		if ( $a == $b ) {
			return 0;
		}

		if ( 'DESC' === $this->order ) {
			return ( $a < $b ) ? 1 : -1;
		} else {
			return ( $a < $b ) ? -1 : 1;
		}
	}

	public function display_rows() {
		$plugins_allowedTags = array(
			'a'       => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
			),
			'abbr'    => array( 'title' => array() ),
			'acronym' => array( 'title' => array() ),
			'code'    => array(),
			'pre'     => array(),
			'em'      => array(),
			'strong'  => array(),
			'ul'      => array(),
			'ol'      => array(),
			'li'      => array(),
			'p'       => array(),
			'br'      => array(),
		);

		$plugins_group_titles = array(
			'Performance' => _x( 'Performance', 'Plugin installer group title' ),
			'Social'      => _x( 'Social', 'Plugin installer group title' ),
			'Tools'       => _x( 'Tools', 'Plugin installer group title' ),
		);

		$group = null;

		foreach ( (array) $this->items as $plugin ) {
			if ( is_object( $plugin ) ) {
				$plugin = (array) $plugin;
			}

			// Display the group heading if there is one
			if ( isset( $plugin['group'] ) && $plugin['group'] != $group ) {
				if ( isset( $this->groups[ $plugin['group'] ] ) ) {
					$group_name = $this->groups[ $plugin['group'] ];
					if ( isset( $plugins_group_titles[ $group_name ] ) ) {
						$group_name = $plugins_group_titles[ $group_name ];
					}
				} else {
					$group_name = $plugin['group'];
				}

				// Starting a new group, close off the divs of the last one
				if ( ! empty( $group ) ) {
					echo '</div></div>';
				}

				echo '<div class="plugin-group"><h3>' . esc_html( $group_name ) . '</h3>';
				// needs an extra wrapping div for nth-child selectors to work
				echo '<div class="plugin-items">';

				$group = $plugin['group'];
			}
			$title = wp_kses( $plugin['name'], $plugins_allowedTags );

			// Remove any HTML from the description.
			$description = strip_Tags( $plugin['short_description'] );
			$version     = wp_kses( $plugin['version'], $plugins_allowedTags );

			$name = strip_Tags( $title . ' ' . $version );

			$author = wp_kses( $plugin['author'], $plugins_allowedTags );
			if ( ! empty( $author ) ) {
				/* translators: %s: Plugin author. */
				$author = ' <cite>' . sprintf( __( 'By %s' ), $author ) . '</cite>';
			}

			$requires_php = isset( $plugin['requires_php'] ) ? $plugin['requires_php'] : null;
			$requires_wp  = isset( $plugin['requires'] ) ? $plugin['requires'] : null;

			$compatible_php = is_php_version_compatible( $requires_php );
			$compatible_wp  = is_wp_version_compatible( $requires_wp );
			$tested_wp      = ( empty( $plugin['tested'] ) || version_compare( get_bloginfo( 'version' ), $plugin['tested'], '<=' ) );

			$action_links = array();

			if ( current_user_can( 'install_plugins' ) || current_user_can( 'update_plugins' ) ) {
				$status = install_plugin_install_status( $plugin );

				switch ( $status['status'] ) {
					case 'install':
						if ( $status['url'] ) {
							if ( $compatible_php && $compatible_wp ) {
								$action_links[] = sprintf(
									'<a class="install-now button" data-slug="%s" href="%s" aria-label="%s" data-name="%s">%s</a>',
									esc_attr( $plugin['slug'] ),
									esc_url( $status['url'] ),
									/* translators: %s: Plugin name and version. */
									esc_attr( sprintf( __( 'Install %s now' ), $name ) ),
									esc_attr( $name ),
									__( 'Install Now' )
								);
							} else {
								$action_links[] = sprintf(
									'<button type="button" class="button button-disabled" disabled="disabled">%s</button>',
									_x( 'Cannot Install', 'plugin' )
								);
							}
						}
						break;

					case 'update_available':
						if ( $status['url'] ) {
							if ( $compatible_php && $compatible_wp ) {
								$action_links[] = sprintf(
									'<a class="update-now button aria-button-if-js" data-plugin="%s" data-slug="%s" href="%s" aria-label="%s" data-name="%s">%s</a>',
									esc_attr( $status['file'] ),
									esc_attr( $plugin['slug'] ),
									esc_url( $status['url'] ),
									/* translators: %s: Plugin name and version. */
									esc_attr( sprintf( __( 'Update %s now' ), $name ) ),
									esc_attr( $name ),
									__( 'Update Now' )
								);
							} else {
								$action_links[] = sprintf(
									'<button type="button" class="button button-disabled" disabled="disabled">%s</button>',
									_x( 'Cannot Update', 'plugin' )
								);
							}
						}
						break;

					case 'latest_installed':
					case 'newer_installed':
						if ( is_plugin_active( $status['file'] ) ) {
							$action_links[] = sprintf(
								'<button type="button" class="button button-disabled" disabled="disabled">%s</button>',
								_x( 'Active', 'plugin' )
							);
						} elseif ( current_user_can( 'activate_plugin', $status['file'] ) ) {
							$button_text = __( 'Activate' );
							/* translators: %s: Plugin name. */
							$button_label = _x( 'Activate %s', 'plugin' );
							$activate_url = add_query_arg(
								array(
									'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $status['file'] ),
									'action'   => 'activate',
									'plugin'   => $status['file'],
								),
								network_admin_url( 'plugins.php' )
							);

							if ( is_network_admin() ) {
								$button_text = __( 'Network Activate' );
								/* translators: %s: Plugin name. */
								$button_label = _x( 'Network Activate %s', 'plugin' );
								$activate_url = add_query_arg( array( 'networkwide' => 1 ), $activate_url );
							}

							$action_links[] = sprintf(
								'<a href="%1$s" class="button activate-now" aria-label="%2$s">%3$s</a>',
								esc_url( $activate_url ),
								esc_attr( sprintf( $button_label, $plugin['name'] ) ),
								$button_text
							);
						} else {
							$action_links[] = sprintf(
								'<button type="button" class="button button-disabled" disabled="disabled">%s</button>',
								_x( 'Installed', 'plugin' )
							);
						}
						break;
				}
			}

			$details_link = self_admin_url(
				'plugin-install.php?tab=plugin-information&amp;plugin=' . $plugin['slug'] .
				'&amp;TB_iframe=true&amp;width=600&amp;height=550'
			);

			$action_links[] = sprintf(
				'<a href="%s" class="thickbox open-plugin-details-modal" aria-label="%s" data-title="%s">%s</a>',
				esc_url( $details_link ),
				/* translators: %s: Plugin name and version. */
				esc_attr( sprintf( __( 'More information about %s' ), $name ) ),
				esc_attr( $name ),
				__( 'More Details' )
			);

			if ( ! empty( $plugin['icons']['svg'] ) ) {
				$plugin_icon_url = $plugin['icons']['svg'];
			} elseif ( ! empty( $plugin['icons']['2x'] ) ) {
				$plugin_icon_url = $plugin['icons']['2x'];
			} elseif ( ! empty( $plugin['icons']['1x'] ) ) {
				$plugin_icon_url = $plugin['icons']['1x'];
			} else {
				$plugin_icon_url = $plugin['icons']['default'];
			}

			/**
			 * Filters the install action links for a plugin.
			 *
			 * @since 2.7.0
			 *
			 * @param string[] $action_links An array of plugin action links. Defaults are links to Details and Install Now.
			 * @param array    $plugin       The plugin currently being listed.
			 */
			$action_links = apply_filters( 'plugin_install_action_links', $action_links, $plugin );

			$last_updated_timestamp = strtotime( $plugin['last_updated'] );
			?>
		<div class="plugin-card plugin-card-<?php echo sanitize_html_class( $plugin['slug'] ); ?>">
			<?php
			if ( ! $compatible_php || ! $compatible_wp ) {
				echo '<div class="notice inline notice-error notice-alt"><p>';
				if ( ! $compatible_php && ! $compatible_wp ) {
					_e( 'This plugin doesn&#8217;t work with your versions of WordPress and PHP.' );
					if ( current_user_can( 'update_core' ) && current_user_can( 'update_php' ) ) {
						printf(
							/* translators: 1: URL to WordPress Updates screen, 2: URL to Update PHP page. */
							' ' . __( '<a href="%1$s">Please update WordPress</a>, and then <a href="%2$s">learn more about updating PHP</a>.' ),
							self_admin_url( 'update-core.php' ),
							esc_url( wp_get_update_php_url() )
						);
						wp_update_php_annotation( '</p><p><em>', '</em>' );
					} elseif ( current_user_can( 'update_core' ) ) {
						printf(
							/* translators: %s: URL to WordPress Updates screen. */
							' ' . __( '<a href="%s">Please update WordPress</a>.' ),
							self_admin_url( 'update-core.php' )
						);
					} elseif ( current_user_can( 'update_php' ) ) {
						printf(
							/* translators: %s: URL to Update PHP page. */
							' ' . __( '<a href="%s">Learn more about updating PHP</a>.' ),
							esc_url( wp_get_update_php_url() )
						);
						wp_update_php_annotation( '</p><p><em>', '</em>' );
					}
				} elseif ( ! $compatible_wp ) {
					_e( 'This plugin doesn&#8217;t work with your version of WordPress.' );
					if ( current_user_can( 'update_core' ) ) {
						printf(
							/* translators: %s: URL to WordPress Updates screen. */
							' ' . __( '<a href="%s">Please update WordPress</a>.' ),
							self_admin_url( 'update-core.php' )
						);
					}
				} elseif ( ! $compatible_php ) {
					_e( 'This plugin doesn&#8217;t work with your version of PHP.' );
					if ( current_user_can( 'update_php' ) ) {
						printf(
							/* translators: %s: URL to Update PHP page. */
							' ' . __( '<a href="%s">Learn more about updating PHP</a>.' ),
							esc_url( wp_get_update_php_url() )
						);
						wp_update_php_annotation( '</p><p><em>', '</em>' );
					}
				}
				echo '</p></div>';
			}
			?>
			<div class="plugin-card-top">
				<div class="name column-name">
					<h3>
						<a href="<?php echo esc_url( $details_link ); ?>" class="thickbox open-plugin-details-modal">
						<?php echo $title; ?>
						<img src="<?php echo esc_attr( $plugin_icon_url ); ?>" class="plugin-icon" alt="">
						</a>
					</h3>
				</div>
				<div class="action-links">
					<?php
					if ( $action_links ) {
						echo '<ul class="plugin-action-buttons"><li>' . implode( '</li><li>', $action_links ) . '</li></ul>';
					}
					?>
				</div>
				<div class="desc column-description">
					<p><?php echo $description; ?></p>
					<p class="authors"><?php echo $author; ?></p>
				</div>
			</div>
			<div class="plugin-card-bottom">
				<div class="vers column-rating">
					<?php
					wp_star_rating(
						array(
							'rating' => $plugin['rating'],
							'type'   => 'percent',
							'number' => $plugin['num_ratings'],
						)
					);
					?>
					<span class="num-ratings" aria-hidden="true">(<?php echo number_format_i18n( $plugin['num_ratings'] ); ?>)</span>
				</div>
				<div class="column-updated">
					<strong><?php _e( 'Last Updated:' ); ?></strong>
					<?php
						/* translators: %s: Human-readable time difference. */
						printf( __( '%s ago' ), human_time_diff( $last_updated_timestamp ) );
					?>
				</div>
				<div class="column-downloaded">
					<?php
					if ( $plugin['active_installs'] >= 1000000 ) {
						$active_installs_millions = floor( $plugin['active_installs'] / 1000000 );
						$active_installs_text     = sprintf(
							/* translators: %s: Number of millions. */
							_nx( '%s+ Million', '%s+ Million', $active_installs_millions, 'Active plugin installations' ),
							number_format_i18n( $active_installs_millions )
						);
					} elseif ( 0 == $plugin['active_installs'] ) {
						$active_installs_text = _x( 'Less Than 10', 'Active plugin installations' );
					} else {
						$active_installs_text = number_format_i18n( $plugin['active_installs'] ) . '+';
					}
					/* translators: %s: Number of installations. */
					printf( __( '%s Active Installations' ), $active_installs_text );
					?>
				</div>
				<div class="column-compatibility">
					<?php
					if ( ! $tested_wp ) {
						echo '<span class="compatibility-untested">' . __( 'Untested with your version of WordPress' ) . '</span>';
					} elseif ( ! $compatible_wp ) {
						echo '<span class="compatibility-incompatible">' . __( '<strong>Incompatible</strong> with your version of WordPress' ) . '</span>';
					} else {
						echo '<span class="compatibility-compatible">' . __( '<strong>Compatible</strong> with your version of WordPress' ) . '</span>';
					}
					?>
				</div>
			</div>
		</div>
			<?php
		}

		// Close off the group divs of the last one
		if ( ! empty( $group ) ) {
			echo '</div></div>';
		}
	}
}
