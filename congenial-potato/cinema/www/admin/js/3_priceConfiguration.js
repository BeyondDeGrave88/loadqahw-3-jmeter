"use strict"

// Поля ввода кол-ва рядов и мест в ряду
const inputPriceStandart = document.getElementById('input_price_standart');
const inputPriceVip = document.getElementById('input_price_vip');
// Кнопки Сохъранить и Отменить 
const buttonSavePriceConfiguration = dom.priceConfiguration.getElementsByClassName('conf-step__button-accent')[0];
const buttonCancelPriceConfiguration = dom.priceConfiguration.getElementsByClassName('conf-step__button-regular')[0]

const confStepInputsPrice  = Array.from(dom.priceConfiguration.getElementsByClassName('conf-step__input'));


// Запоминание прошлого значения при нажатии кнопки в поле ввода
confStepInputsPrice.forEach(confStepInputPrice => confStepInputPrice.addEventListener('keydown', (event)=>{
    inputPriceStandart.dataset.lastValue = inputPriceStandart.value;
    inputPriceVip.dataset.lastValue = inputPriceVip.value;
}))


confStepInputsPrice.forEach(confStepInputPrice => confStepInputPrice.addEventListener('input', (event)=>{
    // Если введенное значение не число то возвращаем прошлое
    if (isNaN(event.target.value)) {
        event.target.value = event.target.dataset.lastValue
        return
    }
    // Получаем стоимость в числовом виде
    const priceStandart = Number(inputPriceStandart.value);
    const priceVip = Number(inputPriceVip.value);
    // Если стоимость 0 то деактивируем кнопку "Сохранить". Иначе - делаем кнопу "Сохранить" активной
    if ((priceStandart == 0) || (priceVip  == 0)) {buttonSavePriceConfiguration.setAttribute("disabled", true)}
    else {buttonSavePriceConfiguration.removeAttribute("disabled")}
    // Запоминаем текущую конфигурацию
    dom.lastPriceConfiguration.standart = inputPriceStandart.dataset.lastValue;
    dom.lastPriceConfiguration.vip = inputPriceVip.dataset.lastValue;
    //Активируем кнопки "Отменить"
    buttonCancelPriceConfiguration.removeAttribute("disabled");
}))


buttonSavePriceConfiguration.addEventListener('click', (event)=>{
    // Получаем id зала активной вкладки
    Array.from(dom.priceConfiguration.getElementsByClassName('conf-step__radio')).forEach(hall => {
        if (hall.checked) { // Определяем активную вкладку (зал)
            // Если у зала открыта продажа билетов то прерываем дальнейшее выполнение.
            if (Array.from(dom.halls).find(h => h.hall_id == hall.dataset.hallId).hall_open == 1) {
                alert("Для внесения изменений остановите продажи билетов для данного зала")
                return
            }
            //Формируем параметры запроса
            const hallId = hall.dataset.hallId;
            const priceStandart = inputPriceStandart.value;
            const priceVip = inputPriceVip.value;
            const params = `hallId=${hallId}&priceStandart=${priceStandart}&priceVip=${priceVip}&event=price_configuration_save`
            // Отправляем запрос на изменение данных конфигурации цен
            createRequest({
                params: params,
                url: "/admin/scripts/events.php",
                callback: (data) => {
                    // При успешном сохранении информации на сервере, вносим изменения в свойство halls объекта класса Dom (чтобы лишний раз не запрашивать информацию для обновления на сервере)
                    Array.from(dom.halls).forEach(hall => {
                        if (hall.hall_id == hallId) {
                            hall.hall_price_standart = priceStandart;
                            hall.hall_price_vip = priceVip;
                        }
                    })
                    // Выводим  и через секунду скрываем сообщение о том что изменения внесены
                    const saveStatus = dom.priceConfiguration.getElementsByClassName("conf-step__wrapper__save-status")[0]
                    saveStatus.innerHTML = "Изменения сохранены";
                    setTimeout(() => {
                        saveStatus.innerHTML = "";
                    }, 1000);
                    // Деактивация кнопки "Отменить"
                    buttonCancelPriceConfiguration.setAttribute("disabled", true);
                }
            });
        }
    })
})


// Событие клик для кнопки ОТМЕНИТЬ (откат последнего изменения в конфигурации)
buttonCancelPriceConfiguration.addEventListener('click', (event)=>{
    if (dom.lastPriceConfiguration.standart === null) {return};
    inputPriceStandart.value = dom.lastPriceConfiguration.standart;
    inputPriceVip.value = dom.lastPriceConfiguration.vip;
        dom.lastPriceConfiguration.standart = null;
        dom.lastPriceConfiguration.vip = null;
    // Деактивация кнопки "Отменить"
    buttonCancelPriceConfiguration.setAttribute("disabled", true);
    // Активация кнопки "Сохранить"
    if ((Number(inputPriceStandart.value) == 0) || (Number(inputPriceVip.value) == 0)) {
        buttonSavePriceConfiguration.setAttribute("disabled", true);
    } else {
        buttonSavePriceConfiguration.removeAttribute("disabled")
    }
})
