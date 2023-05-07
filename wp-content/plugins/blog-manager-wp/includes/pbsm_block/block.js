(function(blocks, editor, components, i18n, element){
	var el = element.createElement;
	blocks.registerBlockType(
		'post-blog-showcase-manager/post-blog-showcase-manager-block',
		{
			title : i18n.__( 'Blog Manager' ),
			description : i18n.__( 'Display Blog Manager Posts' ),
			icon : 'universal-access-alt',
			category: 'layout',
			edit : function() {
				return el(
					'p',
					{},
					'[wp_pbsm]'
				);
			},
			save : function(props){
				return null;
			}
		},
	)
}(
	window.wp.blocks,
	window.wp.editor,
	window.wp.components,
	window.wp.i18n,
	window.wp.element
));
