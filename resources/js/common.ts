document.addEventListener('DOMContentLoaded', () => {
    const showMoreCities = document.querySelector('.show-all-city') as HTMLDivElement;
    showMoreCities?.addEventListener('click', () => {
        const cityList = document.querySelector('.city_block__list_page') as HTMLElement;
        cityList?.classList.add('active')
        showMoreCities.classList.add('none');
    })
})
