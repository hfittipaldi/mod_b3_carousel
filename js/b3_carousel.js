/*jslint browser: true*/
/*global $, jQuery*/
jQuery(document).ready(function ($) {
    'use strict';
    $('.b3Carousel').swiperight(function () {
        $(this).carousel('prev');
    });
    $('.b3Carousel').swipeleft(function () {
        $(this).carousel('next');
    });
});
