"use strict"

// Добавление фильмов (Вывод popup)
const buttonAddFilm = document.getElementsByClassName('button__add-movie')[0];
buttonAddFilm.addEventListener('click', showPopup("/admin/scripts/popup.php?popupname=filmAdd"));

 // здесь будет храниться содержимое файла картинки постера нового (добавляемого) фильма в формате base64
let posterFile = ""


// Добавление фильма(Передача параметров в  XMLHttpRequest) 
const filmAddParams = () => {
  const filmName = document.querySelectorAll('.popup .conf-step__input')[0].value;
  const filmDuration = Number(document.querySelectorAll('.popup .conf-step__input')[1].value);
  const filmDescription = document.querySelectorAll('.popup .conf-step__input')[2].value;
  const filmOrigin = document.querySelectorAll('.popup .conf-step__input')[3].value;
  const filmPoster = posterFile;
  if ((!filmName) || (!filmDuration)  || (!filmDescription) || (!filmOrigin))  {
    alert("Все поля обязательны для заполнения!");
    return null
  }
  if (filmPoster == "") {
    alert("Загрузите изображение постера для фильма!");
    return null
  }
  return `filmName=${filmName}&filmDuratione=${filmDuration}&filmDescription=${filmDescription}&filmOrigin=${filmOrigin}&filmPoster=${posterFile}`;
}


// Удаление фильма(Передача параметров в  XMLHttpRequest) 
const filmDelParams = () => {
  const filmId = event.target.dataset.filmId;
  if (confirm("Все сеансы c этим фильмом будут удалены автоматически")) {
    return `filmId=${filmId}`;
  } else {
    return null;
  }
}

//===================================================================================================

// Добавление фильма в сеанс (Передача параметров в  XMLHttpRequest) 
const seanceAddParams = () => {
  const hallId = document.querySelectorAll('.popup .conf-step__input')[0].value;
  const filmId = document.querySelectorAll('.popup .conf-step__input')[1].value;
  const time = document.querySelectorAll('.popup .conf-step__input')[2].value;
  const filmDuration = Number(dom.films.find(film => film.film_id == filmId).film_duration)

  // Если у зала открыта продажа билетов то прерываем дальнейшее выполнение.
  if (Array.from(dom.halls).find(hall => hall.hall_id == hallId).hall_open == 1) {
    alert("Для добавления сеанса остановите продажи билетов для данного зала")
    return
  }

  // Проверяем правильность ввода времени начала сеанса.
  if (time == "") {
    alert("Время сеанса указано некорректно!");
    return null
  }

  // Проверям пересекается ли создаваемый сеанс с уже существующими по времени.
  const seanceStart = getSeanceStart(time);
  const seanceEnd = seanceStart + filmDuration;
  let seanceOverly = false // Пересечения нет
  dom.seances.forEach(seance => {
    if ((seance.seance_hallid == hallId) && (((seanceStart >= seance.seance_start) && (seanceStart <=  seance.seance_end)) || ((seanceEnd >= seance.seance_start) && (seanceEnd <= seance.seance_end)) || (seanceEnd >= 1440))) {
      seanceOverly = true // Найдено пересечение сеансов
      return 
    }
  });
  if (seanceOverly) {
    alert("Ошибка добавления нового сеанса! \n Возможно сеанс пересекается с уже существующими. \n Время оканчания последнего сеанса не может быть позже 23:59");
    return null
  }

  return `hallId=${hallId}&filmId=${filmId}&time=${time}&filmDuration=${filmDuration}`;
}


// Удаление фильма из сеанса(Передача параметров в  XMLHttpRequest) 
const seanceDelParams = () => {
  const seanceId = event.target.dataset.seanceId;
  // Если у зала открыта продажа билетов то прерываем дальнейшее выполнение.
  const hallId = Array.from(dom.seances).find(seance => seance.seance_id == seanceId).seance_hallid
  if (Array.from(dom.halls).find(hall => hall.hall_id == hallId).hall_open == 1) {
    alert("Для удаления сеанса остановите продажи билетов для данного зала")
    return
  }

  if (confirm("Вся информация о билетах, проданных на этот сеанс, будет удалена!")) {
    return `seanceId=${seanceId}`;
  } else {
    return null;
  }
}

//------------------------------------------------------------

const getSeanceStart = (time) => {
  const now = new Date()
  const h = time.substr(0,2);
  const m = time.substr(3,2);
  const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
  const seance = new Date(now.getFullYear(), now.getMonth(), now.getDate(), h, m);
  return  (seance - today)/60000; 
}


/*
var input = document.createElement('input');
input.type = 'file';

input.onchange = e => { 

   // getting a hold of the file reference
   var file = e.target.files[0]; 

   // setting up the reader
   var reader = new FileReader();
   reader.readAsDataURL(file); // this is reading as data url

   // here we tell the reader what to do when it's done reading...
   reader.onload = readerEvent => {
      var content = readerEvent.target.result; // this is the content!
	console.log(content)
      document.querySelector('.container').style.backgroundImage = 'url('+ content +')';
   }

}

input.click();


*/


/*// drag&drop фильмов
const films = Array.from(document.querySelectorAll('.conf-step__movie'));
console,log(films);
films.forEach(film => film.addEventListener('dragend', (event)=>{
  const elem = document.elementFromPoint(event.clientX, event.clientY);
  if (elem.closest('.conf-step__seances')) {
    showPopup("/admin/scripts/popup.php?popupname=showtimeAdd")(event);
  }
}));*/