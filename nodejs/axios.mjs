import axios from 'axios';

export const store = await (async () => {
    await axios.post('http://buldozer.local/api/test', {
        name: 'foo',
        age: 10
    }).then((res) => {
        console.log(res);
    })
});


