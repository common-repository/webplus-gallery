const {Component, Fragment} = wp.element;
const {Toolbar, IconButton, Button} = wp.components;
const {BlockControls, InspectorControls} = !!wp.blockEditor ? wp.blockEditor : wp.editor;

export class WebPlusGalleryBlockControls extends Component {
    constructor() {
        super(...arguments);
        this.state = {};
    }

    render() {
        return (
            <Fragment className="wp-block-webplusplugin-webplusgallery">
                <BlockControls>
                    <Toolbar>
                        <IconButton icon="edit" label="Edit" onClick={this.props.openPopup}/>
                        {this.props.value ? <IconButton icon="trash" label="Trash" onClick={this.props.remove}/> : null}
                    </Toolbar>
                </BlockControls>
                <InspectorControls>
                    <div className="webplusgallery-inspector-controls__button-container">
                        {this.props.value ? <IconButton isDefault isLarge icon="trash" label="Remove" onClick={this.props.remove} /> : null}&nbsp;
                        <Button isPrimary isLarge onClick={this.props.openPopup}>Select gallery</Button>
                    </div>
                </InspectorControls>
            </Fragment>
        );
    }
}