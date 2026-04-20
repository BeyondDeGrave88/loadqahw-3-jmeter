"use strict"


// Установка события клик на кресла для переключения их типа (standart/vip/disabled)
const chairChecked = () => {
    const chairs = Array.from(document.querySelectorAll('.conf-step__row  .conf-step__chair'));
    chairs.forEach(chair => chair.addEventListener('click', () => {
        // Перед изменением сохраняем текущую конфигурацию
        dom.lastHallConfiguration.Configuration = dom.hallConfiguration.getElementsByClassName('conf-step__hall-wrapper')[0].innerHTML;
        dom.lastHallConfiguration.Rows = inputRowsCount.value;
        dom.lastHallConfiguration.Places = inputPlacesCount.value
        // Переключение типов кресел
        if (chair.classList.contains('conf-step__chair_standart')) {
            chair.classList.toggle('conf-step__chair_standart');
            chair.classList.toggle('conf-step__chair_vip');
        } else if (chair.classList.contains('conf-step__chair_vip')) {
            chair.classList.toggle('conf-step__chair_vip');
            chair.classList.toggle('conf-step__chair_disabled');
        } else if (chair.classList.contains('conf-step__chair_disabled')) {
            chair.classList.toggle('conf-step__chair_disabled');
            chair.classList.toggle('conf-step__chair_standart')
        };
        //Активируем кнопки "Отменить"
        buttonCancelHallConfiguration.removeAttribute("disabled");
    }));
}


// Поля ввода кол-ва рядов и мест в ряду
const inputRowsCount = document.getElementById('input_rows_count');
const inputPlacesCount = document.getElementById('input_places_count');
// Кнопки Сохъранить и Отменить 
const buttonSaveHallConfiguration = dom.hallConfiguration.getElementsByClassName('conf-step__button-accent')[0];
const buttonCancelHallConfiguration = dom.hallConfiguration.getElementsByClassName('conf-step__button-regular')[0]


const confStepInputsHall  = Array.from(dom.hallConfiguration.getElementsByClassName('conf-step__input'));
// Запоминание прошлого значения при нажатии кнопки в поле ввода
confStepInputsHall.forEach(confStepInputHall => confStepInputHall.addEventListener('keydown', (event)=>{
    inputRowsCount.dataset.lastValue = inputRowsCount.value;
    inputPlacesCount.dataset.lastValue = inputPlacesCount.value;
}))


//Автоматическая отрисовка зала при изменении кол-ва рядов и мест.
confStepInputsHall.forEach(confStepInputHall => confStepInputHall.addEventListener('input', (event)=>{
    // Если введенное значение не число то возвращаем прошлое
    if (isNaN(event.target.value)) {
        event.target.value = event.target.dataset.lastValue
        return
    }
    // Кол-во мест в ряду не может быть больше 20
    if (inputPlacesCount.value > 20) {inputPlacesCount.value = "20"};
    // Получаем кол-во рядов и мест в ряду в числовом виде
    const rows = Number(inputRowsCount.value);
    const places = Number(inputPlacesCount.value);
    // Если кол-во мест(рядов) 0 то деактивируем кнопку "Сохранить". Иначе - делаем кнопу "Сохранить" активной
    if ((rows == 0) || (places  == 0)) {buttonSaveHallConfiguration.setAttribute("disabled", true)}
    else {buttonSaveHallConfiguration.removeAttribute("disabled")}
    // Формируем новую конфигурацию
    let html = '<div class="conf-step__hall-wrapper">';
    for (let i=1; i<=rows; i++) {
        html += '<div class="conf-step__row">';
        for (let j=1; j<=places; j++) {
            html += '<span class="conf-step__chair conf-step__chair_standart"></span>';
        }
        html += '</div>'
    }
    html += '<div class="conf-step__wrapper__save-status"></div>';  
    html += '</div>' 
    // Запоминаем текущую конфигурацию если она не пустая. (прошлые значения полей не должны быть равны 0)
    if ((inputPlacesCount.dataset.lastValue != 0) && (inputRowsCount.dataset.lastValue != 0)){
        dom.lastHallConfiguration.Configuration = dom.hallConfiguration.getElementsByClassName('conf-step__hall-wrapper')[0].innerHTML;
        // Текущие значения в полях ввода уже изменены и соответствуют новой (будущей) конфигурации. 
        // Значения полей текущей конфигурации берем из прошлых значений.
        dom.lastHallConfiguration.Rows = inputRowsCount.dataset.lastValue;
        dom.lastHallConfiguration.Places = inputPlacesCount.dataset.lastValue;
    }
    // Удаляем текущую конфигурацию
    dom.hallConfiguration.getElementsByClassName('conf-step__hall-wrapper')[0].remove();
    //Создаем новую конфигурацию залла
    dom.hallConfiguration.getElementsByClassName('conf-step__hall')[0].insertAdjacentHTML("afterbegin", html); 
    chairChecked(); // Вешаем событие клик(переключение) на новые элементы.
    //Активируем кнопки "Отменить"
    buttonCancelHallConfiguration.removeAttribute("disabled");
}))


// Событие клик для кнопки СОХРАНИТЬ
buttonSaveHallConfiguration.addEventListener('click', (event)=>{
    // Получаем id зала активной вкладки
    Array.from(dom.hallConfiguration.getElementsByClassName('conf-step__radio')).forEach(hall => {
        if (hall.checked) { // Определяем активную вкладку (зал)
            // Если у зала открыта продажа билетов то прерываем дальнейшее выполнение.
            if (Array.from(dom.halls).find(h => h.hall_id == hall.dataset.hallId).hall_open == 1) {
                alert("Для внесения изменений остановите продажи билетов для данного зала")
                return
            }
            //Формируем параметры запроса
            const hallId = hall.dataset.hallId;
            const hallRows = inputRowsCount.value;
            const hallPlaces = inputPlacesCount.value;
            const hallConfig = dom.hallConfiguration.getElementsByClassName('conf-step__hall-wrapper')[0].innerHTML;
            const params = `hallId=${hallId}&hallRows=${hallRows}&hallPlaces=${hallPlaces}&hallConfig=${hallConfig}&event=hall_configuration_save`
            // Предупреждаем о том что все проданные билеты будут аннулированы
            if (!confirm("Все билеты проданные в этот зал будут аннулированы!")) {
                return  
              } 
            // Отправляем запрос на изменение данных конфигурации зала
            createRequest({
                params: params,
                url: "/admin/scripts/events.php",
                callback: (data) => {
                    // При успешном сохранении информации на сервере, вносим изменения в свойство halls объекта класса Dom (чтобы лишний раз не запрашивать информацию для обновления на сервере)
                    Array.from(dom.halls).forEach(hall => {
                        if (hall.hall_id == hallId) {
                            hall.hall_rows = hallRows;
                            hall.hall_places = hallPlaces;
                            hall.hall_config = hallConfig;
                        }
                    })
                    // Выводим  и через секунду скрываем сообщение о том что изменения внесены
                    const saveStatus = dom.hallConfiguration.getElementsByClassName("conf-step__wrapper__save-status")[0];
                    saveStatus.innerHTML = "Изменения сохранены";
                    setTimeout(() => {
                        saveStatus.innerHTML = "";
                    }, 1000);
                    // Деактивация кнопки "Отменить"
                    buttonCancelHallConfiguration.setAttribute("disabled", true)
                }
            });
        }
    })
})


// Событие клик для кнопки ОТМЕНИТЬ (откат последнего изменения в конфигурации)
buttonCancelHallConfiguration.addEventListener('click', (event)=>{
    if (dom.lastHallConfiguration.Configuration === null) {return};
    dom.hallConfiguration.getElementsByClassName('conf-step__hall-wrapper')[0].innerHTML = dom.lastHallConfiguration.Configuration;
    inputRowsCount.value = dom.lastHallConfiguration.Rows;
    inputPlacesCount.value = dom.lastHallConfiguration.Places;
        dom.lastHallConfiguration.Configuration = null;
        dom.lastHallConfiguration.Rows =null;
        dom.lastHallConfiguration.Places = null;
    // Вешаем событие клик(переключение) на кресла
    chairChecked();
    // Деактивация кнопки "Отменить"
    buttonCancelHallConfiguration.setAttribute("disabled", true);
    // Активация кнопки "Сохранить"
    buttonSaveHallConfiguration.removeAttribute("disabled")
})