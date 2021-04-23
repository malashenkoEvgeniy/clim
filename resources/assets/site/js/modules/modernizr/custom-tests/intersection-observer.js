'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import Modernizr from 'modernizr';

// ----------------------------------------
// Public
// ----------------------------------------

Modernizr.addTest('intersectionobserver', 'IntersectionObserver' in window);
