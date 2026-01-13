import {promises as fs} from "fs";
import {log} from "debug";

export const updateCategories = async (categories, categoriesArray) => {
    try {
        await fs.writeFile(categories, JSON.stringify(categoriesArray, null, 2), 'utf-8');
    } catch (e) {
        console.log('Ошибка записи');
        console.log(e);
    }
}
export const writeItems = async (object) => {
    const itemsFile = 'items.json';

    try {
        let existingDataArray = [];

        try {
            // Проверка наличия файла и чтение текущих данных
            const existingData = await fs.readFile(itemsFile, 'utf-8');
            existingDataArray = JSON.parse(existingData);
        } catch (readError) {
            // Если файл не существует или содержит некорректные данные JSON
            if (readError.code === 'ENOENT' || readError instanceof SyntaxError) {
                console.log('Файл не найден или содержит некорректные данные JSON. Создаем новый файл.');
            } else {
                throw readError;
            }
        }

        // Объединение текущих данных с новыми данными
        const newDataArray = [...existingDataArray, object];

        // Запись обновленных данных обратно в файл
        await fs.writeFile(itemsFile, JSON.stringify(newDataArray, null, 2), 'utf-8');

        console.log('Данные успешно дописаны в файл');
    } catch (e) {
        console.log('Ошибка записи');
        console.log(e);
    }
};
