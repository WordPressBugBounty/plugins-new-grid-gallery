(function(blocks, editor, components, element) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var SelectControl = components.SelectControl;
    var InspectorControls = editor.InspectorControls;
    var ServerSideRender = wp.serverSideRender || wp.components.ServerSideRender;

    registerBlockType('new-grid-gallery/gallery-select', {
        title: 'Grid Gallery Premium',
        icon: 'grid-view',
        category: 'common',
        attributes: {
            galleryId: {
                type: 'string',
                default: ''
            }
        },
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            // Retrieve galleries passed from PHP
            var galleries = window.ggGutenbergGalleries || [];
            var options = [{ value: '', label: 'Select a Gallery...' }];
            galleries.forEach(function(gal) {
                options.push({ value: gal.id, label: gal.title });
            });

            var control = el(SelectControl, {
                label: 'Choose Grid Gallery',
                value: attributes.galleryId,
                options: options,
                onChange: function(newId) {
                    setAttributes({ galleryId: newId });
                }
            });

            var inspector = el(InspectorControls, {}, 
                el(components.PanelBody, { title: 'Gallery Settings', initialOpen: true }, control)
            );

            var preview = '';
            if (attributes.galleryId) {
                preview = el(ServerSideRender, {
                    block: 'new-grid-gallery/gallery-select',
                    attributes: attributes
                });
            } else {
                preview = el('div', { style: { padding: '20px', border: '1px dashed #ccc', textAlign: 'center' } }, 'Please select a Grid Gallery from block settings.');
            }

            return [inspector, preview];
        },
        save: function() {
            // Rendered server-side dynamically
            return null;
        }
    });
})(
    window.wp.blocks,
    window.wp.blockEditor || window.wp.editor,
    window.wp.components,
    window.wp.element
);
