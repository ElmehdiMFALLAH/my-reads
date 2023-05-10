/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/app.css';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
import {deleteRead,storeReadId, refresh} from './js/delete';
window.deleteRead = deleteRead;
window.storeReadId = storeReadId;
window.refresh = refresh;
import './js/sidebar';
import 'bootstrap';
import './js/datatable';