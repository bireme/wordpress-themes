(function () {
    'use strict';

    const skipLink = document.querySelector('.vitrines-skip');
    const content = skipLink && document.getElementById(skipLink.hash.slice(1));

    if (content && !content.hasAttribute('tabindex')) {
        content.setAttribute('tabindex', '-1');
    }
}());
