(function() {
	tinymce.PluginManager.add('sp_wps_mce_button', function( editor, url ) {
		editor.addButton('sp_wps_mce_button', {
			text: false,
            icon: false,
			image: url + '/icon.svg',
			tooltip: 'Product Slider for WooCommerce',
            onclick: function () {
                editor.windowManager.open({
                    title: 'Insert Shortcode',
					width: 400,
					height: 100,
					body: [
						{
							type: 'listbox',
							name: 'listboxName',
                            label: 'Select Shortcode',
							'values': editor.settings.spWPSShortcodeList
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[woo_product_slider id="' + e.data.listboxName + '"]');
					}
				});
			}
		});
	});
})();