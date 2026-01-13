import puppeteer from 'puppeteer';
import {writeFile} from 'fs/promises';
import readline from 'readline';

(async () => {
    const browser = await puppeteer.launch({
        // devtools: false,
        // headless: false,
        // args: ['--window-size=800,1070', '--window-position=0,0']
    });

    const outputFilePath = 'categories.json';
    const page = await browser.newPage();
    await page.setViewport({width: 1080, height: 1024});

    const links = [
        'https://belgorod.spectehinfo.ru/',
        'https://bryansk.spectehinfo.ru/',
        'https://vladimir.spectehinfo.ru/',
        'https://voronezh.spectehinfo.ru/',
        'https://ivanovo.spectehinfo.ru/',
        'https://kaluga.spectehinfo.ru/',
        'https://kostroma.spectehinfo.ru/',
        'https://kursk.spectehinfo.ru/',
        'https://lipetsk.spectehinfo.ru/',
        'https://moskva.spectehinfo.ru/',
        'https://mosobl.spectehinfo.ru/',
        'https://orel.spectehinfo.ru/',
        'https://ryazan.spectehinfo.ru/',
        'https://smolensk.spectehinfo.ru/',
        'https://tambov.spectehinfo.ru/',
        'https://tver.spectehinfo.ru/',
        'https://tula.spectehinfo.ru/',
        'https://yaroslavl.spectehinfo.ru/',
        'https://ufa.spectehinfo.ru/',
        'https://kirov.spectehinfo.ru/',
        'https://mariel.spectehinfo.ru/',
        'https://saransk.spectehinfo.ru/',
        'https://nnov.spectehinfo.ru/',
        'https://orenburg.spectehinfo.ru/',
        'https://penza.spectehinfo.ru/',
        'https://perm.spectehinfo.ru/',
        'https://samara.spectehinfo.ru/',
        'https://saratov.spectehinfo.ru/',
        'https://kazan.spectehinfo.ru/',
        'https://izhevsk.spectehinfo.ru/',
        'https://ulyanovsk.spectehinfo.ru/',
        'https://cheboksary.spectehinfo.ru/',
        'https://altay.spectehinfo.ru/',
        'https://barnaul.spectehinfo.ru/',
        'https://buryatiya.spectehinfo.ru/',
        'https://chita.spectehinfo.ru/',
        'https://irkutsk.spectehinfo.ru/',
        'https://kemerovo.spectehinfo.ru/',
        'https://krasnoyarsk.spectehinfo.ru/',
        'https://nsk.spectehinfo.ru/',
        'https://omsk.spectehinfo.ru/',
        'https://tomsk.spectehinfo.ru/',
        'https://kyzyl.spectehinfo.ru/',
        'https://abakan.spectehinfo.ru/',
        'https://kurgan.spectehinfo.ru/',
        'https://ekaterinburg.spectehinfo.ru/',
        'https://tyumen.spectehinfo.ru/',
        'https://hmao.spectehinfo.ru/',
        'https://chelyabinsk.spectehinfo.ru/',
        'https://yamal.spectehinfo.ru/',
        'https://maykop.spectehinfo.ru/',
        'https://astrahan.spectehinfo.ru/',
        'https://volgograd.spectehinfo.ru/',
        'https://kalmykia.spectehinfo.ru/',
        'https://krasnodar.spectehinfo.ru/',
        'https://rosdon.spectehinfo.ru/',
        'https://krym.spectehinfo.ru/',
        'https://arhangelsk.spectehinfo.ru/',
        'https://vologda.spectehinfo.ru/',
        'https://kaliningrad.spectehinfo.ru/',
        'https://petrozavodsk.spectehinfo.ru/',
        'https://komi.spectehinfo.ru/',
        'https://lenobl.spectehinfo.ru/',
        'https://murmansk.spectehinfo.ru/',
        'https://ao.spectehinfo.ru/',
        'https://novgorod.spectehinfo.ru/',
        'https://pskov.spectehinfo.ru/',
        'https://spb.spectehinfo.ru/',
        'https://amur.spectehinfo.ru/',
        'https://eao.spectehinfo.ru/',
        'https://kamchatka.spectehinfo.ru/',
        'https://magadan.spectehinfo.ru/',
        'https://vladivostok.spectehinfo.ru/',
        'https://sahalin.spectehinfo.ru/',
        'https://habarovsk.spectehinfo.ru/',
        'https://chukotka.spectehinfo.ru/',
        'https://yakutsk.spectehinfo.ru/',
        'https://dagestan.spectehinfo.ru/',
        'https://ingushetiya.spectehinfo.ru/',
        'https://nalchik.spectehinfo.ru/',
        'https://cherkessk.spectehinfo.ru/',
        'https://alaniya.spectehinfo.ru/',
        'https://stavropol.spectehinfo.ru/',
        'https://chechnya.spectehinfo.ru/',
    ];

    const allLinks = [];
    let i = 0;
    for (const link of links) {
        console.log(i++);
        const parsedLinks = await parseLink(page, link + 'arenda/');
        allLinks.push(...parsedLinks);
        await delay(100);
    }

    console.log(allLinks)
    await writeFile(outputFilePath, JSON.stringify(allLinks, null, 2), 'utf-8');

    await browser.close();
})();

async function parseLink(page, link) {
    console.log(link);

    await page.goto(link);
    const parsedLinks = [];

    const links = await page.evaluate(() => {
        const linkElements = document.querySelectorAll('.category-plate a');
        return Array.from(linkElements).map(link => ({
            "success": false,
            "name": link.querySelector('p.title').textContent,
            "img": link.querySelector('img').src,
            "url": link.href,
            "region": document.querySelector('.region-name').textContent
        }));
    });

    return links;
}

function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
