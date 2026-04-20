

"use strict"

document.addEventListener("DOMContentLoaded", ()=>{
  const buttonAcceptin = document.querySelector('.acceptin-button'); // Кнопка "Бронировать"
  const chairs = Array.from(document.querySelectorAll('.buying-scheme__row .buying-scheme__chair')); // Все кресла
  let chairsSelected = Array.from(document.querySelectorAll('.buying-scheme__row .buying-scheme__chair_selected')); // Выбранные кресла
  if (chairsSelected.length) {
    buttonAcceptin.removeAttribute("disabled");
  } else {
    buttonAcceptin.setAttribute("disabled", true);
  }

  // Вешаем событие onclixk на кресла
  chairs.forEach(chair => chair.addEventListener('click', (event) => {
    if (event.target.classList.contains('buying-scheme__chair_taken')) {return}; // Прерываем выполнение если клик был по забронированному месту
    event.target.classList.toggle('buying-scheme__chair_selected');
    chairsSelected = Array.from(document.querySelectorAll('.buying-scheme__row .buying-scheme__chair_selected'));
    if (chairsSelected.length) {
      buttonAcceptin.removeAttribute("disabled");
    } else {
      buttonAcceptin.setAttribute("disabled", true);
    }    
  }));

  // Вешаем событие onclick на кнопку
  buttonAcceptin.addEventListener("click", (event) => {
    event.preventDefault();
    // Формируем список выбранных мест
    const selectedPlaces = Array();
    const divRows = Array.from(document.getElementsByClassName("buying-scheme__row"));
    for (let i=0; i < divRows.length; i++) {
      const spanPlaces = Array.from(divRows[i].getElementsByClassName("buying-scheme__chair"));
      for (let j=0; j < spanPlaces.length; j++) {
        if (spanPlaces[j].classList.contains("buying-scheme__chair_selected")) {
          // Определяем тип выбранного кресла
          const typePlace = (spanPlaces[j].classList.contains("buying-scheme__chair_standart")) ? "standart" : "vip"
          selectedPlaces.push({
            "row": i+1,
            "place": j+1,
            "type":  typePlace
          })
        }
      }
    }
    // Изменяем выбранные места на занятые и сохраняем новую конфигурацию 
    chairsSelected.forEach(chair => {
      //chair.classList.toggle("buying-scheme__chair_selected");
      //chair.classList.toggle("buying-scheme__chair_taken");
    })
    const configurationHall = document.querySelector('.buying-scheme__wrapper').innerHTML;
    // Формируем и отправляем запрос
    const params = `hallConfiguration=${configurationHall}&salesPlaces=${JSON.stringify(selectedPlaces)}`
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/client/scripts/reservation.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    xhr.onreadystatechange =  () => {
      if((xhr.readyState === 4) && (xhr.status === 200)) {
        console.log(xhr.responseText);
        const link = document.createElement('a');
        link.href = "/client/payment.php";
        link.click();
      }
    }
  })


});