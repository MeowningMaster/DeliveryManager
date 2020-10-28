class Body {
    constructor(properties) {
        this.element = document.getElementsByTagName('body')[0];

        if (properties !== undefined) {
            if (properties.custom_scrollbars !== undefined) {
                if (properties.custom_scrollbars === true) {
                    this.element.classList.add('with-custom-webkit-scrollbars');
                    this.element.classList.add('with-custom-css-scrollbars');
                }
            }

            if (properties.theme_shortcut !== undefined) {
                if (properties.theme_shortcut === true) {
                    this.element.setAttribute('data-dm-shortcut-enabled', 'true');
                }
            }

            if (properties.content !== undefined) {
                for (const child of properties.content) {
                    this.element.appendChild(child.element);
                }
            }
        }
    }
}
class Button {
    static types = {
        standard: '',
        primary: 'btn-primary',
        secondary: 'btn-secondary',
        success: 'btn-success',
        danger: 'btn-danger',
        link: 'btn-link'
    };

    type = Button.types.standard;

    constructor(properties) {
        this.element = document.createElement('button');
        this.element.classList.add('btn');
        this.element.type = 'button';

        if (properties !== undefined) {
            if (properties.type !== undefined) {
                this.set_type(properties.type);
            }

            if (properties.text !== undefined) {
                this.element.innerText = properties.text;
            }

            if (properties.onclick !== undefined) {
                this.element.addEventListener('onclick', properties.onclick);
            }
        }
    }

    set_type(type) {
        if (this.type !== type) {
            if (this.type !== '') {
                this.element.classList.remove(this.type);
            }

            this.type = type;
            this.element.classList.add(type);
        }
    }
}
class Modal{
    elements = {};

    constructor(properties) {
        this.element = document.createElement('div');
        this.element.classList.add('modal');
        this.element.classList.add('show');
        this.element.tabIndex = -1;
        this.element.setAttribute('role', 'dialog');

        this.elements.dialog = document.createElement('div');
        this.elements.dialog.classList.add('modal-dialog');
        this.elements.dialog.setAttribute('role', 'document');

        this.elements.content = document.createElement('div');
        this.elements.content.classList.add('modal-content');

        this.elements.title = document.createElement('h5');
        this.elements.title.classList.add('modal-title');

        if (properties !== undefined) {
            if (properties.dismissible !== undefined) {
                if (properties.dismissible === false) {
                    this.element.setAttribute('data-overlay-dismissal-disabled', 'true');
                    this.element.setAttribute('data-esc-dismissal-disabled', 'true');
                }
            }

            if (properties.content !== undefined) {
                for (const child of properties.content) {
                    this.elements.content.appendChild(child.element);
                }
            }
        }

        this.elements.content.appendChild(this.elements.title);
        this.elements.dialog.appendChild(this.elements.content);
        this.element.appendChild(this.elements.dialog);
    }
}
class Form {
    constructor(properties) {
        this.element = document.createElement('form');

        if (properties !== undefined) {
            if (properties.onsubmit !== undefined) {
                this.element.addEventListener('onsubmit', properties.onsubmit);
            }
        }
    }
}