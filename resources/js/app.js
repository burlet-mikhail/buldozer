import './main';
import './common.ts';
import * as bootstrap from 'bootstrap';
import Swiper from 'swiper';
import './vue';
import 'swiper/css';
import {Fancybox} from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

import.meta.glob([
    '../images/**',
    '../fonts/**',
])
Fancybox.bind("[data-fancybox]", // Array containing gallery items
    {
        animated: false,
    });
Fancybox.bind(".fancybox_modal", // Array containing gallery items
    {
        backFocus: false,
        keyboard: false,
        arrows: false,
        buttons: [
            'zoom',
            'close'
        ]
    });

Fancybox.bind(".fancybox_iframe", // Array containing gallery items
    {
        type: 'iframe',
        iframe: {
            scrolling: 'auto',
            preload: true
        }
    });


