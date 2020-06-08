// import external dependencies
import 'jquery';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';


/** Populate Router instance with DOM routes */
const routes = new Router({

});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
