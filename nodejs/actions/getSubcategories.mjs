export const getSubcategories = async (page) => {
    return await page.evaluate(() => {
        let linksSubCat = [];
        const linkElements = document.querySelectorAll('.nav.nav-pills.second-menu');
        if (linkElements.length >= 2) {
            const arrayLinksSubCat = linkElements[1].querySelectorAll('a');
            linksSubCat = Array.from(arrayLinksSubCat).map(link => ({
                "name": link.textContent,
                "url": link.href
            }));
            return linksSubCat
        }
        return false;
    });
}
export const getCities = async (page) => {
    return await page.evaluate(() => {
        let linksCities = [];
        const selectorCities = document.querySelectorAll('.catalog-localies-link');
        if (selectorCities) {
            linksCities = Array.from(selectorCities).map(link => ({
                "name": link.textContent,
                "url": link.href
            }));
        }
        return linksCities
    });
}
