import './modules/hamburger-menu';
// import './modules/header';


jQuery(document).ready(function ($) {
    $('.sw-caruosel').slick({
        autoplay: true
    });

    $('.carousel-full-width').slick({
        autoplay: true,

    });

});

document.addEventListener('DOMContentLoaded', function () {



    // Find all anchor tags on the page
    const links = document.querySelectorAll('a');
    const baseEndings = ['/book-me', '/book-now']; // Base array of valid endings

    // Extend baseEndings to include both versions (with and without trailing slash)
    const validEndings = baseEndings.flatMap(ending => {
        // Check if the ending already has a trailing slash
        if (ending.endsWith('/')) {
            return [ending, ending.slice(0, -1)]; // Include version without the trailing slash
        } else {
            return [ending, ending + '/']; // Include version with the trailing slash
        }
    });

    links.forEach(link => {
        const href = link.getAttribute('href');
        // Check if the href ends with any of the valid endings
        if (validEndings.some(ending => href.endsWith(ending))) {
            // Set the target attribute to open in a new tab
            link.setAttribute('target', '_blank');
            // Add rel attribute for security
            link.setAttribute('rel', 'noopener noreferrer');
        }
    });
});
