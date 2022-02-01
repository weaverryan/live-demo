import { Controller } from '@hotwired/stimulus';
import { Dropdown } from 'bootstrap';

export default class extends Controller {
    connect() {
        this.dropDown = new Dropdown(this.element.querySelector('.dropdown-toggle'));
    }
}
