import puppeteer from 'puppeteer';
import {promises as fs} from 'fs';
import {getCities, getSubcategories} from "./actions/getSubcategories.mjs";
import {delay} from "./actions/delay.mjs";
import {updateCategories} from "./actions/updateCategories.mjs";
import axios from "axios";

(async () => {


    const browser = await puppeteer.launch({
        // devtools: false,
        // headless: false,
        // args: ['--window-size=800,1070', '--window-position=0,0']
    });
    const page = await browser.newPage();
    await page.setViewport({width: 1080, height: 1024});
    const categories = 'categories.json';
    const categoriesArray = JSON.parse(await fs.readFile(categories, 'utf-8'));

    let i = 0;
    for (const category of categoriesArray) {
        i++;
        if (category.success) continue;
        const parsed = await parseCategoryPage(page, category);
        console.log(category.url, parsed.length);
        await updateCategories(categories, categoriesArray);
        category.success = true;
        console.log(i)
    }
    await browser.close();
})();


async function parseCategoryPage(page, category) {
    await page.goto(category.url, {waitUntil: 'load', timeout: 0});
    const subCategories = await getSubcategories(page);
    if (subCategories) {
        for (const subCategory of subCategories) {
            if (subCategory.name.indexOf('Все ') === 0) continue;

            await page.goto(subCategory.url, {waitUntil: 'load', timeout: 0});
            const cities = await getCities(page)
            if (cities) {
                for (const city of cities) {
                    if (city.name === 'еще') {
                        continue;
                    }
                    if (city.name === 'другие') {
                        continue;
                    }
                    await page.goto(city.url, {waitUntil: 'load', timeout: 0});
                    console.log(city.name)
                    await delay(300);
                    const listItem = await parseItem(page);
                    const objects = {
                        "category": category.name,
                        "region": category.region,
                        "subCategory": subCategory.name,
                        "city": city.name,
                        "list": listItem
                    };
                    await axios.post('http://buldozer.local/api/test', {
                        data: objects,
                    }).then((res) => {
                        console.log(res.data);
                    });
                }
                return true;
            }
            await delay(300);
        }
    } else {
        const cities = await getCities(page);

        if (cities) {
            for (const city of cities) {

                if (city.name === 'еще') continue;
                if (city.name === 'другие') continue;

                await page.goto(city.url, {waitUntil: 'load', timeout: 0});

                const listItem = await parseItem(page);

                const objects = {
                    "category": category.name,
                    "region": category.region,
                    "city": city.name,
                    "list": listItem
                };

                await axios.post('http://buldozer.local/api/test', {
                    data: objects,
                }).then((res) => {
                    console.log(res.data);
                });

            }
            return true;
        }
    }


}


const parseItem = async (page) => {
    await scroll(page);
    return await page.evaluate(() => {
        const cards = document.querySelectorAll('.post-card');
        return Array.from(cards).map(card => ({
            "name": card.querySelector('h2 a').textContent,
            "url": card.querySelector('h2 a').href
        }))
    });
}


const scroll = async (page) => {
    if (!page) {
        return;
    }
    while (true) {
        const previousHeight = await page.evaluate(() => document.body.scrollHeight);
        await page.evaluate(() => {
            window.scrollTo(0, document.body.scrollHeight);
        });
        await delay(300);

        const currentHeight = await page.evaluate(() => document.body.scrollHeight);

        if (currentHeight === previousHeight) {
            break;
        }
    }
}

