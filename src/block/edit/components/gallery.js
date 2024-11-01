const { Component } = wp.element;

export class WebPlusGallery extends Component {
    constructor(){
        super(...arguments);
        this.state = {
            isLoaded: false,
            isRender: false,
            error: null,
            items: [],
            itemsNew: []
        };
    }



    componentDidMount() {

        fetch("admin-ajax.php?action=gutenbergwebplusgalleryitems&galleryID=" + this.props.id)
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        items: result.items
                    });
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error
                    });
                }
            );
    }

    componentDidUpdate()  {
        const type = jQuery( this.el ).data('type');
        jQuery( this.el ).webplusGallery(type);
    }

    render(){
        if(this.state.isLoaded) {
            return (
                <div>
                    <div class="wp-block-WebPlusGallery" data-type={this.props.type} ref={el => this.el = el}>
                        {this.state.items.map(item => (
                            <div data-thumb={item.thumb} data-src={item.src}>
                                <img src={item.src}/>
                            </div>
                        ))}
                    </div>
                </div>
            );
        }else {
            return null;
        }
    }
}