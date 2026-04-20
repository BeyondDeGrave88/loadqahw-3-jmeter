"use strict";

class Dom {

  constructor() {
    this.hallControl = document.getElementById("hall-control");
    this.hallConfiguration = document.getElementById("hall-configuration");
    this.priceConfiguration = document.getElementById("price-configuration");
    this.gridSession = document.getElementById("grid-session");
    this.startSales = document.getElementById("start-sales");

    // Хранит предпоследнюю конфигурацию зала (для отмены последнего действия)
    this.lastHallConfiguration = {
      Rows: null,
      Places: null,
      Configuration: null
    }
    // Хранит предпоследнюю конфигурацию цен (для отмены последнего действия)
    this.lastPriceConfiguration = {
      standart: null,
      vip: null,
    }
    // У полей ввода создаем data-атрибут для хранения предыдущего значения
    Array.from(document.getElementsByClassName('conf-step__input')).forEach(input => input.dataset.lastValue = input.value)

    this.halls  = null; // Хранит список залов
    this.films = null; // Хранит список фильмов
    this.seances = null // Хранит список сеансов
    // Запрос списка залов
    createRequest({
      url: "/admin/scripts/events.php",
      params:  "event=update",
      callback: (data) => {
        this.halls = data.halls.result; // Получение списка залов
        this.films = data.films.result; // Получение списка залов
        this.seances = data.seances.result; // Получение списка залов
        this.drawContent();
      }     
    })
  }


  drawContent(callback = ()=>{this.createAll();}) {
    // Если залы отстутсвуют скрываем секции интерфейса "конфигурацию зала", "конфигурация цен" и "открыть продажи", а также скрываем кнопки сохранить/отменить в секции "сетка сеансов".
    this.hallControl.style.display = "block"
    this.hallConfiguration.style.display = "block"
    this.priceConfiguration.style.display = "block"
    this.gridSession.style.display = "block"
    this.startSales.style.display = "block"
    if (this.halls.length == 0) {
      this.hallConfiguration.getElementsByClassName("conf-step__wrapper")[0].style.display = "none";
      this.priceConfiguration.getElementsByClassName("conf-step__wrapper")[0].style.display = "none";
      //this.gridSession.getElementsByClassName("conf-step__buttons")[0].style.display = "none";
      this.startSales.getElementsByClassName("conf-step__wrapper")[0].style.display = "none";
    } else {
      this.hallConfiguration.getElementsByClassName("conf-step__wrapper")[0].style.display = "block";
      this.priceConfiguration.getElementsByClassName("conf-step__wrapper")[0].style.display = "block";
      //this.gridSession.getElementsByClassName("conf-step__buttons")[0].style.display = "block";
      this.startSales.getElementsByClassName("conf-step__wrapper")[0].style.display = "block";
    }
    callback();
  }


  createHallControl() {
    if (this.halls == null) {return}
    // Создаем новую разметку
    const halllist = this.hallControl.getElementsByTagName('ul')[0];
    let html = "";
    Array.from(this.halls).forEach(hall => {
      html += '<li>' + hall.hall_name;
      html += `<a href=""><button class="conf-step__button conf-step__button-trash" data-hall-id="${hall.hall_id}" data-hall-name="${hall.hall_name}"></button></a></li>`
    });
    halllist.innerHTML = html;
    // Вешаем событие  onclick на кнопки Удаление залов - (Вывод popup)
    const buttonsDelHall = Array.from(this.hallControl.querySelectorAll('.conf-step__button-trash'))
    buttonsDelHall.forEach(buttonDelHall => buttonDelHall.addEventListener('click', showPopup(`/admin/scripts/popup.php?popupname=hallDelete&hall_id=${buttonDelHall.dataset.hallId}&hall_name=${buttonDelHall.dataset.hallName}`)));
  }


  createHallConfiguration() {
    if (this.halls.length == 0) {return}
    // Находим и запоминаем активную вкладку
    let tabActive = null;
    Array.from(this.hallConfiguration.getElementsByClassName('conf-step__radio')).forEach(hall => {
      if (hall.checked) {tabActive = hall.dataset.hallId;}
    })
    // Создаем новую разметку
    const halllist = this.hallConfiguration.getElementsByTagName('ul')[0];
    let html = "";
    Array.from(this.halls).forEach(hall => {
      html += `<li><input type="radio" class="conf-step__radio" name="chairs-hall" value="${hall.hall_name}" data-hall-id="${hall.hall_id}"`;
      if (tabActive == hall.hall_id) {
        html += ' checked>';
        tabActive = true;
      } else {
        html += '>';
      }
      html += '<span class="conf-step__selector">' + hall.hall_name + '</span></li>'
    });
    halllist.innerHTML = html;
    // Вешаем событие  onclick на вкладки с залами - (Отображение конфигурации зала)
    Array.from(this.hallConfiguration.getElementsByClassName('conf-step__radio')).forEach(tabHall => 
      tabHall.addEventListener("click", (event)=> {
        // удаляем из памяти предпоследнюю конфигурацию зала
        this.lastHallConfiguration.Configuration = null;
        this.lastHallConfiguration.Rows =null;
        this.lastHallConfiguration.Places = null;
        Array.from(this.halls).forEach(hall => {
          if (hall.hall_id == event.target.dataset.hallId) {
            this.hallConfiguration.getElementsByClassName('conf-step__input')[0].value = hall.hall_rows;
            this.hallConfiguration.getElementsByClassName('conf-step__input')[1].value = hall.hall_places;
            this.hallConfiguration.getElementsByClassName('conf-step__hall-wrapper')[0].innerHTML = hall.hall_config
            chairChecked() // Вешаем событие onclick на кресла
          }
          // Деактивация кнопки "Отменить"
          this.hallConfiguration.getElementsByClassName('conf-step__button-regular')[0].setAttribute("disabled", true);
          // Активация кнопки "Сохранить"
          this.hallConfiguration.getElementsByClassName('conf-step__button-accent')[0].removeAttribute("disabled");
        })
      })
    )
    // Если активная вкладка не найдена/удалена делаем активной 1-ю
    if (tabActive !== true) {
      this.hallConfiguration.getElementsByClassName('conf-step__radio')[0].checked = true;
      this.hallConfiguration.getElementsByClassName('conf-step__radio')[0].click();
      // удаляем из памяти предпоследнюю конфигурацию зала
      this.lastHallConfiguration.Configuration = null;
      this.lastHallConfiguration.Rows =null;
      this.lastHallConfiguration.Places = null;
    }
  };
 

  createPriceConfiguration() {
    if (this.halls.length == 0) {return}
    // Находим и запоминаем активную вкладку
    let tabActive = null;
    Array.from(this.priceConfiguration.getElementsByClassName('conf-step__radio')).forEach(hall => {
      if (hall.checked) {tabActive = hall.dataset.hallId;}
    })
    // Создаем новую разметку
    const halllist = this.priceConfiguration.getElementsByTagName('ul')[0];
    let html = "";
    Array.from(this.halls).forEach(hall => {
      html += '<li><input type="radio" class="conf-step__radio" name="prices-hall" value="' + hall.hall_name + '" data-hall-id="' + hall.hall_id + '"';
      if (tabActive == hall.hall_id) {
        html += ' checked>';
        tabActive = true;
      } else {
        html += '>';
      }
      html += '<span class="conf-step__selector">' + hall.hall_name + '</span></li>'
    });
    halllist.innerHTML = html;
    // Вешаем событие  onclick на вкладки с залами  - (Отображение цен на билеты) 
    Array.from(this.priceConfiguration.getElementsByClassName('conf-step__radio')).forEach(tabHall => 
      tabHall.addEventListener("click", (event)=> {
        Array.from(this.halls).forEach(hall => {
          if (hall.hall_id == event.target.dataset.hallId) {
            this.priceConfiguration.getElementsByClassName('conf-step__input')[0].value = hall.hall_price_standart	;
            this.priceConfiguration.getElementsByClassName('conf-step__input')[1].value = hall.hall_price_vip	;
          }
          // Деактивация кнопки "Отменить"
          this.priceConfiguration.getElementsByClassName('conf-step__button-regular')[0].setAttribute("disabled", true);
          // Активация кнопки "Сохранить"
          this.priceConfiguration.getElementsByClassName('conf-step__button-accent')[0].removeAttribute("disabled");
        })
      })
    )
    // Если активная вкладка не найдена/удалена делаем активной 1-ю
    if (tabActive !== true) {
      this.priceConfiguration.getElementsByClassName('conf-step__radio')[0].checked = true;
      this.priceConfiguration.getElementsByClassName('conf-step__radio')[0].click();
    }
  };


  createGridSession() {
    // Выводим список фильмов (если они есть)
    const filmList = this.gridSession.getElementsByClassName('conf-step__movies')[0];
    filmList.innerHTML = '';
    if (this.films.length > 0) {
      // Создаем новую разметку
      let html = '';
      Array.from(this.films).forEach(film => {
        html += `<div class="conf-step__movie" draggable="true" data-film-id="${film.film_id}" draggable>
                   <img class="conf-step__movie-poster" draggable="false" alt="poster" src="../img/posters/${film.film_id}.png" width="100" height="100">
                   <h3 class="conf-step__movie-title">${film.film_name}</h3>
                   <p class="conf-step__movie-duration">${film.film_duration} мин.</p>
                   <a href="" draggable="false"><button  class="conf-step__button conf-step__button-trash" data-film-id="${film.film_id}" data-film-name="${film.film_name}"></button></a>
                 </div>`
      });
      filmList.innerHTML = html; 
      // Вешаем событие  onclick на кнопки Удаление фильмов - (Вывод popup)
      const buttonsDelFilm = Array.from(this.gridSession.querySelectorAll('.conf-step__button-trash'))
      buttonsDelFilm.forEach(buttonDelFilm => buttonDelFilm.addEventListener('click', showPopup(`/admin/scripts/popup.php?popupname=filmDelete&film_id=${buttonDelFilm.dataset.filmId}&film_name=${buttonDelFilm.dataset.filmName}`)));
      // Вешаем события  drag'n'drop на фильмы
      const films = Array.from(document.querySelectorAll('.conf-step__movie'));
      films.forEach(film  => {
        film.addEventListener('dragstart', (event)=>{ // Начало 
          const img = event.target.getElementsByTagName('img')[0];
          event.dataTransfer.setDragImage(img, 15, 25)
        })
        film.addEventListener('dragend', (event)=>{ // Конец
          const elem = document.elementFromPoint(event.clientX, event.clientY);
          if (elem.closest('.conf-step__seances-hall')) {
            const filmId = event.target.dataset.filmId;
            const hallId = elem.closest('.conf-step__seances-hall').dataset.hallId;
            showPopup(`/admin/scripts/popup.php?popupname=showtimeAdd&film_id=${filmId}&hall_id=${hallId}`)(event);
          }
        });
      })

      // Выводим список сеансов заллов
      const  seancesHallList = this.gridSession.getElementsByClassName('conf-step__seances')[0];
      this.gridSession.ondragover = () => {return false}
      seancesHallList.innerHTML = '';
      if (this.halls.length > 0) {
        // Создаем новую разметку
        let html = '';
        Array.from(this.halls).forEach(hall => {
          html += `<div ondragover="return false" class="conf-step__seances-hall" data-hall-id="${hall.hall_id}">
                     <img class="trash-seance" src="i/trash-seance.png" alert="Trash icon">
                     <h3 class="conf-step__seances-title">${hall.hall_name}</h3>
                     <div class="conf-step__seances-timeline">${this.addSeanceToTimeLine(hall.hall_id)}</div>
                   </div>`
        });
        html += `<p class="explanation-text">Для удаления сеанса перетащите его в корзину, которая появится слева в процессе перетаскивания</p>`
        seancesHallList.innerHTML = html;
      }
      // Вешаем события  drag'n'drop на сеансы (удаление сеансов)
      const seances = Array.from(document.querySelectorAll('.conf-step__seances-movie'));
      seances.forEach(seance => {
        const imgTrash = seance.closest('.conf-step__seances-hall').getElementsByTagName('img')[0]; // иконка корзины
        seance.addEventListener('dragstart', (event)=>{ // Начало
          imgTrash.style.display = 'block'; // Показываем корзину
          event.dataTransfer.effectAllowed = "move";
          const filmId = this.seances.find(seance => seance.seance_id == event.target.dataset.seanceId).seance_filmid
          const imgSeance = Array.from(this.gridSession.getElementsByClassName("conf-step__movie")).find(movie => movie.dataset.filmId == filmId).getElementsByTagName("img")[0]
          event.dataTransfer.setDragImage(imgSeance, 15, 25)
        })
        seance.addEventListener('dragend', (event)=>{ // Конец
          const elem = document.elementFromPoint(event.clientX, event.clientY);
          if (elem.closest('.trash-seance')) { // Если элемент отпустили над корзиной то удаляем сеанс
            const seanceId = event.target.dataset.seanceId;
            const filmName = this.films.find(film => film.film_id == this.seances.find(seance => seance.seance_id == seanceId).seance_filmid).film_name;
            showPopup(`/admin/scripts/popup.php?popupname=showtimeDelete&seance_id=${seanceId}&film_name=${filmName}`)(event);
          }
          imgTrash.style.display = 'none'; // Скрываем корзинк
        });
      })
    }
  };


  createStartSales() {
    if (this.halls.length == 0) {return}
    // Находим и запоминаем активную вкладку
    let tabActive = null;
    Array.from(this.startSales.getElementsByClassName('conf-step__radio')).forEach(hall => {
      if (hall.checked) {tabActive = hall.dataset.hallId;}
    })
    // Создаем новую разметку
    const halllist = this.startSales.getElementsByTagName('ul')[0];
    let html = "";
    Array.from(this.halls).forEach(hall => {
      html += `<li><input type="radio" class="conf-step__radio" name="sales-hall" value="${hall.hall_name}" data-hall-id="${hall.hall_id}"`;
      if (tabActive == hall.hall_id) {
        html += ' checked>';
        tabActive = true;
      } else {
        html += '>';
      }
      html += '<span class="conf-step__selector">' + hall.hall_name + '</span></li>'
    });
    halllist.innerHTML = html;

    const buttonSales = this.startSales.getElementsByClassName("conf-step__button-accent")[0];
    const statusText =  this.startSales.getElementsByClassName("conf-step__paragraph")[1]
    // Вешаем событие  onclick на вкладки с залами  - (Отображение цен на билеты) 
    Array.from(this.startSales.getElementsByClassName('conf-step__radio')).forEach(tabHall => 
      tabHall.addEventListener("click", (event)=> {
        Array.from(this.halls).forEach(hall => {
          // Вешаем на кнопку старта/остановки продаж id выбранного зала и статус (открыто/закрыто)
          if (hall.hall_id == event.target.dataset.hallId) {
            buttonSales.dataset.hallId = hall.hall_id;
            buttonSales.dataset.hallOpen = hall.hall_open;
          }
        })
        // Если залл закрыт
        if (!Number(buttonSales.dataset.hallOpen)) {       
          // --Если сеансы есть 
          if (this.seances.find(seance => seance.seance_hallid == buttonSales.dataset.hallId)) { 
            statusText.textContent = "Все готово к открытию"
            statusText.style.color = "#008800"
            buttonSales.textContent = "Открыть продажу билетов"
            buttonSales.removeAttribute("disabled")
          } else { // --Если сеансов нет (блокируем кнопку запуска продаж)
            statusText.textContent = "Нет сеансов"
            statusText.style.color = "#ff0000"
            buttonSales.textContent = "Открыть продажу билетов"
            buttonSales.setAttribute("disabled", true);
          } 
        } else {
          statusText.textContent = "Продажа билетов открыта!!!"
          statusText.style.color = "#008800"
          buttonSales.textContent = "Закрыть продажу билетов"
          buttonSales.removeAttribute("disabled")
        } 
      })
    )
    // Если активная вкладка не найдена/удалена делаем активной 1-ю
    if (tabActive !== true) {
      this.startSales.getElementsByClassName('conf-step__radio')[0].checked = true;
      this.startSales.getElementsByClassName('conf-step__radio')[0].click();
    } else { // Иначе обновляем данные на активной вкладке
      Array.from(this.startSales.getElementsByClassName('conf-step__radio')).find(tabHall => tabHall.checked).click()
    }
    // Вешаем событие click для кнопки старт/остановка продаж
    buttonSales.addEventListener("click", startSales);
  };


  createAll() {
    this.createHallControl();
    this.createHallConfiguration();
    this.createPriceConfiguration();
    this.createGridSession();
    this.createStartSales();
  }

  //-----------------------------

  addSeanceToTimeLine(hallId) {
    let html = "";
    this.seances.forEach(seance => {
      if (seance.seance_hallid == hallId) {
        const minPx = 0.5 // Кол-во пикселей соответствующее одной минуте на шкале timeLine

        const left = seance.seance_start * minPx; 
        const width = (seance.seance_end - seance.seance_start) * minPx;
        const filmTitle = this.films.find(film => film.film_id == seance.seance_filmid).film_name;
        const time = seance.seance_time;
        const color = window.getComputedStyle(Array.from(this.gridSession.getElementsByClassName('conf-step__movie')).find(film => film.dataset.filmId == seance.seance_filmid)).backgroundColor;
        
        html += `<div class="conf-step__seances-movie" data-seance-id="${seance.seance_id}" draggable="true" ondragover="return false" style="width: ${width}px; background-color: ${color}; left: ${left}px;">
                    <p class="conf-step__seances-movie-title">${filmTitle}</p>
                    <p class="conf-step__seances-movie-start">${time}</p>
                </div>`         
      }
    })
    return html;
  }


  // Метод блокирует все элементы заллов у которых открыты продажи
 /* blockHall() {
    const elements = Array.from(document.querySelectorAll(`[data-hall-id]`));
    console.log(elements)
    elements.forEach(element => {
      // Проверяем все элементы кроме тех что в разделе старт продаж (они всегда будут активны)
      if (!element.closest('#start-sales')) { 
        //-- Если продажи открыты то блокируем элементы (изменять их нельзя)
        if (this.halls.find(hall => hall.hall_id == element.dataset.hallId).hall_open == 1) { 
          element.setAttribute("disabled", true)
        } else { // Иначе (продажи остановлены) - снимаем блокировку
          element.removeAttribute("disabled")
        }
      }
    })
  }*/

}





/*const drawingHallControl = (elem, data) => {
  const halllist = elem.getElementsByTagName('ul')[0];
  let html = "";
  Array.from(data).forEach(hall => {
    html += '<li>' + hall.hall_name;
    html += '<a href=""><button class="conf-step__button conf-step__button-trash" data-hall-id="' + hall.hall_id + '"></button></a></li>'
  });
  halllist.innerHTML = html;
  // Вешаем событие  onclick на кнопки Удаление залов - (Вывод popup)
  const buttonsDelHall = Array.from(document.querySelectorAll('.conf-step__button-trash'))
  buttonsDelHall.forEach(buttonDelHall => buttonDelHall.addEventListener('click', showPopup("/admin/scripts/popup.php?popupname=hallDelete&hall_id="+buttonDelHall.dataset.hallId)));
}*/