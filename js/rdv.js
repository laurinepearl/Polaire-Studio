// const date = new Date();

// const renderCalendar = () => {
//   date.setDate(1);

//   const monthDays = document.querySelector(".days");

//   const lastDay = new Date(
//     date.getFullYear(),
//     date.getMonth() + 1,
//     0
//   ).getDate();

//   const prevLastDay = new Date(
//     date.getFullYear(),
//     date.getMonth(),
//     0
//   ).getDate();

//   const firstDayIndex = date.getDay() ;

//   const lastDayIndex = new Date(
//     date.getFullYear(),
//     date.getMonth() + 1,
//     0
//   ).getDay();

//   const nextDays = 7 ;

//   const months = [
//     "Janvier",
//     "Février",
//     "Mars",
//     "Avril",
//     "Mai",
//     "Juin",
//     "Juillet",
//     "Août",
//     "Septembre",
//     "Octobre",
//     "Novembre",
//     "Decembre",
//   ];

//   document.querySelector(".date h1").innerHTML = months[date.getMonth()];

//   let options = {weekday: "long", year: "numeric", month: "long", day: "numeric"};

//   document.querySelector(".date p").innerHTML = new Date().toLocaleDateString("fr-FR", options);

//   let days = "";

//   for (let x =  firstDayIndex -2 ; x >= 0; x--) {
//     days += `<div class="prev-date">${prevLastDay - x }</div>`;
//   }

//   for (let i = 1; i <= lastDay; i++) {
//     if (
//       i == new Date().getDate() &&
//       date.getMonth() == new Date().getMonth()
//     ) {
//       days += `<div class="today">${i}</div>`;
//     } 
//     else {
//       days += `<div>${i}</div>`;
//     }
//   }
  
// //   voir les chiffres
//   for (let j = 1; j <= nextDays; j++) {
//     days += `<div class="next-date">${j}</div>`;
//     monthDays.innerHTML = days;
//   }
// };

// document.querySelector(".prev").addEventListener("click", () => {
//   date.setMonth(date.getMonth() - 1);
//   renderCalendar();
// });

// document.querySelector(".next").addEventListener("click", () => {
//   date.setMonth(date.getMonth() + 1);
//   renderCalendar();
// });

// renderCalendar();
