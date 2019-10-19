export default function getData() {
    return new Promise((resolve, reject) => {
        resolve('Hi, from async function getData');
    })
}