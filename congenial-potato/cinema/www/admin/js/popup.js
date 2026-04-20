"use strict"

// Показ popup окна 
function showPopup(url) {
  return (event)=>{
    event.preventDefault();
    createRequest({
      url: url,
      callback: (data) => {
        document.getElementsByTagName('body')[0].insertAdjacentHTML("afterbegin", data.popup.result);
        popupStart();
      }
    });
  }
}


function popupStart() {
  // Кнопка ЗАКРЫТЬ
  const buttonClose = document.getElementsByClassName('popup__dismiss')[0];
  buttonClose.addEventListener('click', popupClose);
  // Кнопка ОТМЕНА
  const buttonCancel = document.getElementsByClassName('conf-step__button-regular')[0];
  buttonCancel.addEventListener('click', popupClose);
  // Кнопка OK
  const buttonOk = document.getElementsByClassName('conf-step__button-accent')[0];
  buttonOk.addEventListener('click', (event) => {
    event.preventDefault();
    let params ="";
    if (event.target.dataset.event == "hall_add") {params = hallAddParams()}
    if (event.target.dataset.event == "hall_del") {params = hallDelParams()}
    if (event.target.dataset.event == "film_add") {params = filmAddParams()}
    if (event.target.dataset.event == "film_del") {params = filmDelParams()}
    if (event.target.dataset.event == "seance_add") {params = seanceAddParams()}
    if (event.target.dataset.event == "seance_del") {params = seanceDelParams()}
    if (!params) {return};
    params += "&event=" + event.target.dataset.event
    createRequest({
      params: params,
      url: "/admin/scripts/events.php",
      callback: (data) => {
        if (data.halls) {dom.halls = data.halls.result}
        if (data.films) {dom.films = data.films.result}
        if (data.seances) {dom.seances = data.seances.result}
        dom.drawContent(); // Обновляем все содержимое        
        popupClose(event);
      }
    });
  }); 
 
  if (buttonOk.dataset.event == "film_add") {
    // Кнопка загрузить постер 
    const posterButton = document.querySelectorAll('.popup .conf-step__button-accent')[1];
    // Создаем виртуальный input с type=file чтобы запустить окно выбора файла для загрузки картинки
    const input = document.createElement('input');
    input.type = 'file';
    let content = "";
    posterButton.addEventListener('click', (event) => {
      event.preventDefault();
      input.onchange = (e) => { 
        const file = e.target.files[0];
        if (file === undefined) {return}
        // Проверяем является ли файл изображением (допускаются файлы jpg и png)
        if (file.type != 'image/png')  {
          alert('Ошибка загрузки файла. Загружаемый файл должен быть формата png');
          return; 
        }
        // Проверяем размер файла
        if (file.size > 1000000) {
          alert('Ошибка загрузки файла! Максимально допустимый размер загружаемого файла 1МБ.');
          return; 
        }
        const reader = new FileReader();
        reader.readAsDataURL(file);
        // Если изображение загружено, то отобразим его в popup окне рядом с форомй
        reader.onload = (readerEvent) => {
          content = readerEvent.target.result;
          if (content != "") {
            const poster =  document.querySelector('.popup__poster');
            poster.style.backgroundImage = `url(${content})`;
            posterFile = content; // Записываем содержимое файла в переменную (объявлена в 4_gridSession.js)
            poster.style.width = '150px';
            poster.style.marginRight = "20px"
          }
        }  
      }
      input.click();
    })
    // Контроль ввода данных в поле "Продолжительность фильма"
    const inputFilmDuration = document.querySelectorAll('.popup .conf-step__input')[1]
    inputFilmDuration.addEventListener('keydown', (event)=>{ // Запоминаем текущее значение при нажатии кнопки 
      event.target.dataset.lastValue = event.target.value;
    })
    inputFilmDuration.addEventListener('input', (event)=>{ // контроль значения
      const value = event.target.value;
      if ((value !== "") &&  ((isNaN(Number(value))) || (Number(value) <= 0) || (value.indexOf('.') >= 0))) {
        event.target.value = event.target.dataset.lastValue
      }
    })
  }

  // Если событие - "Добавление сеанса" то заполняем <select> с залами и фильмами 
  if (buttonOk.dataset.event == "seance_add") {
    // Залы
    const selectHall = document.querySelectorAll('.popup .conf-step__input')[0];
    const hallId = document.querySelector('.popup').dataset.hallId;
    let html = "";
    Array.from(dom.halls).forEach(hall => {
      const selected = (hall.hall_id ==  hallId) ? 'selected' : '';
      html += `<option value="${hall.hall_id}"  ${selected}>${hall.hall_name}</option>`
    });
    selectHall.innerHTML = html;
    // Фильмы
    const selectFilm = document.querySelectorAll('.popup .conf-step__input')[1];
    const filmId = document.querySelector('.popup').dataset.filmId;
    html = "";
    Array.from(dom.films).forEach(film => {
      const selected = (film.film_id ==  filmId) ? 'selected' : '';
      html += `<option value="${film.film_id}"  ${selected}>${film.film_name}</option>`
    });
    selectFilm.innerHTML = html;
  }
}


function popupClose(event) {
  event.preventDefault();
  const popup = document.getElementsByClassName('popup')[0];
  popup.classList.toggle('active');
  popup.remove();
  posterFile = "" // Обнуляем переменную хранящую изображение постера 
}
