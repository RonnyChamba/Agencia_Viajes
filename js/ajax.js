export function createQueryString(data) {
  let queryString = "";
  let index = 0;
  let longitud = Object.keys(data).length;
  for (let property in data) {
    queryString += `${property}=${encodeURI(data[property])}${
      index !== longitud - 1 ? "&" : ""
    }`;
    index++;
  }
  return queryString;
}
export function ajax(file) {
  const miPromise = new Promise((resolve, reject) => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", file);
    xhr.addEventListener("readystatechange", function () {
      if (this.readyState !== 4) return;

      if (this.status >= 200 && this.status < 300)
        return resolve({ estado: true, xhr });
      else return reject({ estado: false, xhr });
    });
    xhr.send();
  });

  return miPromise;
}
