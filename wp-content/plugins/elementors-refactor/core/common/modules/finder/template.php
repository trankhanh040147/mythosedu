<?php

namespace Elementor\Modules\Finder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<script type="text/template" id="tmpl-co-finder">
	<div id="co-finder__search">
		<i class="eicon-search"></i>
		<input id="co-finder__search__input" placeholder="<?php echo __( 'Type to find anything in Drag & Drop Layout', 'elementor' ); ?>">
	</div>
	<div id="co-finder__content"></div>
</script>

<script type="text/template" id="tmpl-co-finder-results-container">
	<div id="co-finder__no-results"><?php echo __( 'No Results Found', 'elementor' ); ?></div>
	<div id="co-finder__results"></div>
</script>

<script type="text/template" id="tmpl-co-finder__results__category">
	<div class="co-finder__results__category__title">{{{ title }}}</div>
	<div class="co-finder__results__category__items"></div>
</script>

<script type="text/template" id="tmpl-co-finder__results__item">
	<a href="{{ url }}" class="co-finder__results__item__link">
		<div class="co-finder__results__item__icon">
			<i class="eicon-{{{ icon }}}"></i>
		</div>
		<div class="co-finder__results__item__title">{{{ title }}}</div>
		<# if ( description ) { #>
			<div class="co-finder__results__item__description">- {{{ description }}}</div>
		<# } #>
	</a>
	<# if ( actions.length ) { #>
		<div class="co-finder__results__item__actions">
		<# jQuery.each( actions, function() { #>
			<a class="co-finder__results__item__action co-finder__results__item__action--{{ this.name }}" href="{{ this.url }}" target="_blank">
				<i class="eicon-{{{ this.icon }}}"></i>
			</a>
		<# } ); #>
		</div>
	<# } #>
</script>
