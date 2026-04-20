const startSales = (event) => {
  const hallId = event.target.dataset.hallId;
  const hallStatus = (Number(event.target.dataset.hallOpen)) ? 0 : 1; // 0 - закрыть 1 - открыть
  /*// Предупреждение о том что билеты аннулируются
  if (!hallStatus) {
    if (!confirm("Все билеты проданные в этот зал будут аннулированы!")) {
      return  
    } 
  }*/
  createRequest({
    params: `event=hall_open&hallId=${hallId}&hallStatus=${hallStatus}`,
    url: "/admin/scripts/events.php",
    callback: (data) => {
      if (data.halls) {dom.halls = data.halls.result}
      dom.drawContent(); // Обновляем все содержимое        
    }
  });
}