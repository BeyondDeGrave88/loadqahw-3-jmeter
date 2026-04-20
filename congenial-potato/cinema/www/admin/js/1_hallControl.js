"use strict"

// Добавление залов (Вывод popup)
const buttonAddHall = dom.hallControl.getElementsByClassName('button__add-hall')[0];
buttonAddHall.addEventListener('click', showPopup("/admin/scripts/popup.php?popupname=hallAdd"));


// Добавление зала (Передача параметров в  XMLHttpRequest) 
const hallAddParams = () => {
  const hallName = document.querySelector('.popup .conf-step__input').value;
  if (!hallName) {
    alert("Введите название зала!");
    return null
  }
  return "hallName="+hallName;
}


// Удаление залов // (Вывод popup)
const buttonsDelHall = Array.from(dom.hallControl.querySelectorAll('.conf-step__button-trash'))
buttonsDelHall.forEach(buttonDelHall => buttonDelHall.addEventListener('click', showPopup("/admin/scripts/popup.php?popupname=hallDelete&hall_id="+buttonDelHall.dataset.hallId)));

// Удаление зала (Передача параметров в  XMLHttpRequest) 
const hallDelParams = () => {
  const hallId = event.target.dataset.hallId;

  // Если у зала открыта продажа билетов то прерываем дальнейшее выполнение.
  if (Array.from(dom.halls).find(hall => hall.hall_id == hallId).hall_open == 1) {
    alert("Для удаления  остановите продажи билетов для данного зала")
    return
  }

  if (confirm("Все сеансы в этом зале и все записи о проданных билетах в этот зал будут удалены!")) {
    return "hallId="+hallId;
  } else {
    return null;
  }
  
}
