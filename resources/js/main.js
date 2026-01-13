import Swiper, {Navigation, Pagination, Thumbs} from 'swiper';
import 'swiper/css';


document.addEventListener('DOMContentLoaded', function () {
    const showPhoneButtons = document.querySelectorAll('.front__phone');

    if (showPhoneButtons) {
        showPhoneButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const phoneCart = this.closest('.phone__cart');
                if (phoneCart) {
                    const showPhoneButton = phoneCart.querySelector('.front__phone');
                    const phoneLink = phoneCart.querySelector('.back__phone');
                    showPhoneButton.style.display = 'none';
                    phoneLink.style.display = 'grid';
                }
            });
        });
    }


    new Swiper('.full', {
        modules: [Navigation, Pagination, Thumbs],
        loop: true,
        autoHeight: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    const galleryThumbsObject = new Swiper('.gallery-thumbs-object', {
        modules: [Navigation, Pagination, Thumbs],
        spaceBetween: 10,
        slidesPerView: 5,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        loop: false,
        observer: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 2,
            },
            701: {
                slidesPerView: 3,
            },
            1201: {
                slidesPerView: 5,
            }
        }
    });
    const galleryTopObject = new Swiper('.gallery-top-object', {
        modules: [Navigation, Pagination, Thumbs],
        spaceBetween: 10,
        slidesPerView: 1,
        loop: false,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: '.my-swiper-button-next',
            prevEl: '.my-swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbsObject
        }
    });


    function showMoreCategories(event) {
        event.preventDefault();

        const showMoreLink = event.target;
        const categoryList = showMoreLink.parentElement; // Родительский ul списка
        const allCategories = categoryList.querySelectorAll('li');

        for (let i = 0; i < allCategories.length; i++) {
            allCategories[i].classList.remove('d-none');
        }

        showMoreLink.style.display = 'none';
    }

    const showMoreLinks = document.querySelectorAll('.categories li.show-list');

    showMoreLinks.forEach(link => {
        link.addEventListener('click', showMoreCategories);
    });

    const selectElement = document.getElementById('select_search');
    if (selectElement) {
        selectElement.addEventListener('change', function () {
            window.location.href = this.value;
        });
    }
    const company_check = document.getElementById('company-check')
    const company_container = document.getElementById('company_container');
    if (company_check) {
        company_check.addEventListener('change', function () {
            if (this.checked) {
                company_container.style.display = 'block'
            } else {
                company_container.style.display = 'none'
            }
        })
    }

    const tabsContainers = document.querySelectorAll('.tabs_mb');

    tabsContainers.forEach(container => {
        const tabTargets = container.querySelectorAll('[data-target]');
        const tabContents = container.querySelectorAll('[data-tab]');

        tabTargets.forEach(tabTarget => {
            tabTarget.addEventListener('click', () => {
                const targetTab = tabTarget.getAttribute('data-target');

                tabTargets.forEach(target => {
                    if (target.getAttribute('data-target') === targetTab) {
                        target.classList.add('active_tab');
                    } else {
                        target.classList.remove('active_tab');
                    }
                });

                tabContents.forEach(content => {
                    if (content.getAttribute('data-tab') === targetTab) {
                        content.classList.add('active_tab');
                    } else {
                        content.classList.remove('active_tab');
                    }

                    // Добавляем активный класс ко всем элементам внутри выбранной вкладки
                    const childElements = content.querySelectorAll('*');
                    childElements.forEach(child => {
                        child.classList.add('active_tab');
                    });
                });
            });
        });
    });

});



