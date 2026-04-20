"use strict"
document.addEventListener("DOMContentLoaded", ()=>{
  const dayLinks = Array.from(document.getElementsByClassName("page-nav__day"));
  const movieSeances = Array.from(document.getElementsByClassName("movie-seances__time"));
  // Вешаем событие onclixk на вкладки с датами
  dayLinks.forEach(dayLink => dayLink.addEventListener('click', (event)=> {
    event.preventDefault();
    document.getElementsByClassName("page-nav__day_chosen")[0].classList.toggle("page-nav__day_chosen");
    dayLink.classList.toggle("page-nav__day_chosen");

    let timeStampDay = Number(event.target.dataset.timeStamp);
    if (isNaN(timeStampDay)) {
      timeStampDay = Number(event.target.closest('.page-nav__day').dataset.timeStamp)
    }
    movieSeances.forEach(movieSeance => {
      const timeStampSeanceDay = Number(movieSeance.dataset.seanceStart) * 60;
      const timeStampSeance = timeStampDay + timeStampSeanceDay;
      const timeStampNow = Math.trunc(+new Date() / 1000);
      movieSeance.dataset.seanceTimeStamp = timeStampSeance;
      if ((timeStampSeance - timeStampNow) > 0) { // Если сеанс еще не начался
        movieSeance.classList.remove('acceptin-button-disabled');
      } else {
        movieSeance.classList.add('acceptin-button-disabled');
      }
    })
  }))
  dayLinks[0].click();

  movieSeances.forEach(movieSeance => movieSeance.addEventListener('click', (event)=>{
      const seanceId = event.target.dataset.seanceId;
      const seanceTimeStamp = event.target.dataset.seanceTimeStamp;
      event.preventDefault();
      const params = `seanceId=${seanceId}&seanceTimeStamp=${seanceTimeStamp}`
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "/client/scripts/selectSeance.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send(params);
      xhr.onreadystatechange =  () => {
        if((xhr.readyState === 4) && (xhr.status === 200)) {
          console.log(xhr.responseText);
          const link = document.createElement('a');
          link.href = "/client/hall.php";
          link.click();
        }
      }
    })
  )

 /* movieSeances.forEach(movieSeance => movieSeance.addEventListener('click', (event)=>{
    event.preventDefault();
    const seanceId = event.target.dataset.seanceId;
    const timeStampDay = Number(document.getElementsByClassName('page-nav__day_chosen')[0].dataset.timeStamp);
    const timeStampSeanceDay = Number(event.target.dataset.seanceStart) * 60;
    const timeStampSeance = timeStampDay + timeStampSeanceDay;
    const timeStampNow = Math.trunc(+new Date() / 1000);
    if ((timeStampSeance - timeStampNow) > 0) { // Если сеанс еще не начался
      event.target.removeAttribute("disabled");
    } else {
      event.target.setAttribute("disabled", true);
    }

    const params = `seanceId=${seanceId}&timeStampDay=${timeStampDay}`
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/client/scripts/events.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    xhr.onreadystatechange =  () => {
      if((xhr.readyState === 4) && (xhr.status === 200)) {
        const link = document.createElement('a');
        link.href = "/client/hall.php";
       // link.click();
      }
    }
  }))*/
});
