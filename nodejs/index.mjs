import puppeteer from 'puppeteer';
import {writeFile} from 'fs/promises';
import readline from 'readline';

(async () => {
    const browser = await puppeteer.launch({
        devtools: false,
        headless: false,
        args: ['--window-size=800,1070', '--window-position=0,0']
    });

    const outputFilePath = 'links.json';
    const page = await browser.newPage();
    await page.setViewport({width: 1080, height: 1024});

    const parsedLinks = await parseLink(page, 'https://spectehinfo.ru/regions');

    await writeFile(outputFilePath, JSON.stringify(parsedLinks, null, 2), 'utf-8');

    console.log(parsedLinks)
    
    await browser.close();
})();

async function parseLink(page, link) {
    await page.goto(link);

    const links = await page.evaluate(() => {
        const linkElements = document.querySelectorAll('.regions-block a');
        return Array.from(linkElements).map(link => ({
            "success": false,
            "url": link.href
        }));
    });
    return links;
}

function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
