"use strict"

const createRequest = (options = {}) => {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", options.url, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(options.params);
  xhr.onreadystatechange =  () => {
    if((xhr.readyState === 4) && (xhr.status === 200)) {
      //console.log(xhr.responseText)
      const response =  JSON.parse(xhr.responseText);
      for (let key in response) {
        if (response[key].err) {
          alert(`Ошибка обращения к базе данных ${response[key].err}: ${response[key].errMessage}`);
          return;
        }
      }
      options.callback(response);
    }
  }
}