import {WebPlusGallery} from './components/gallery';
import {WebPlusGalleryBlockControls} from './components/block-controls';


const { Component } = wp.element;

export default class WebPlusGalleryEdit extends Component {
    constructor(){
        super(...arguments);
        this.state = {
            showPopup: false,
            error: null,
            isLoaded: false,
            items: [],
            value: this.props.attributes.id,
            type: this.props.attributes.type
        };
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChangeType = this.handleChangeType.bind(this);
    }

    togglePopup() {
        this.setState({
            showPopup: !this.state.showPopup
        });
    }

    handleRemove(event) {
        this.props.setAttributes( { id: null } );
        this.setState({value: null});
    }

    handleChange(event) {
        this.setState({value: event.target.value});
    }

    handleSubmit(event) {
        const id = Number(this.state.value);
        const type = this.state.type;
        this.props.setAttributes( { id: id } );
        this.props.setAttributes( { type: type } );
        this.togglePopup();
        event.preventDefault();
    }

    handleChangeType(event) {
        this.setState({type: event.target.value});
    }

    componentDidMount() {
        fetch("admin-ajax.php?action=gutenbergwebplusgallery")
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
            )
    }

    shouldComponentUpdate(nextProps, nextState) {
        const isLoaded = this.state.isLoaded !== nextState.isLoaded;
        const showPopup = this.state.showPopup !== nextState.showPopup;
        //const id = this.props.id !== nextProps.id;
        const value = this.state.value !== nextState.value;
        const type = this.state.type !== nextState.type;

        return isLoaded || showPopup || value || type;
    }

    render() {
        if (this.state.isLoaded) {
            const button = this.props.attributes.id ? 'Edit gallery' : 'Add gallery';
            return (
                <div class="block_webplusgallery">
                    <WebPlusGalleryBlockControls
                        openPopup={this.togglePopup.bind(this)}
                        remove={this.handleRemove.bind(this)}
                        value={this.state.value}
                    />
                    {!this.state.showPopup ?
                    <div class="webplusgallery">
                        {this.props.attributes.id ?
                            <WebPlusGallery
                                id={this.props.attributes.id}
                                type={this.props.attributes.type}
                            />
                            :
                            <div>
                                <h2>WebPlus gallery</h2>
                                Select the gallery you want to insert.
                            </div>
                        }
                    </div>
                        :
                        null
                    }
                    <button class="popupbtn" onClick={this.togglePopup.bind(this)}>{button}</button>
                    {this.state.showPopup ?
                        <WebPlusGalleryPopup
                            text='WebPlus Gallery'
                            closePopup={this.togglePopup.bind(this)}
                            items={this.state.items}
                            value={this.state.value}
                            onSubmit={this.handleSubmit}
                            onChange={this.handleChange}
                            onChangeType={this.handleChangeType}
                            type={this.state.type}
                        />
                        : null
                    }
                </div>
            );
        }else {
            return null;
        }
    }
}

class WebPlusGalleryPopup extends Component {
    render() {
        return (
            <div className='popup'>
                <div className='popup_inner'>
                    <h4>{this.props.text}</h4>
                    <form onSubmit={this.props.onSubmit}>
                    <div align="center">
                        <select value={this.props.value} onChange={this.props.onChange}>
                            <option value="">Select gallery</option>
                        {this.props.items.map(item => (
                            <option value={item.ID}>
                                {item.post_name}
                            </option>
                        ))}
                        </select>
                    </div>
                        <div align="center">
                            <select value={this.props.type} onChange={this.props.onChangeType}>
                                <option value="horizontal">Horizontal</option>
                                <option value="vertical">Vartical</option>
                            </select>
                        </div>
                        <p align="center">
                        <input type="submit" class="btn-insert" value="Insert gallery" />
                        <button class="btn-close" onClick={this.props.closePopup}>close me</button>
                        </p>
                    </form>
                </div>
            </div>
        );
    }
}