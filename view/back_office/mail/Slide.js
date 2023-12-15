const openMailerBtn = document.getElementById('open-mailer-btn');
const closeMailerBtn = document.getElementById('close-mailer-btn');
const col1 = document.querySelector('.col1');
const col3 = document.querySelector('.col3');

openMailerBtn.addEventListener('click', () => {
  col3.style.transform = 'translateX(0)'; /* Slide col3 into view */
});

closeMailerBtn.addEventListener('click', () => {
  col3.style.transform = 'translateX(100%)'; /* Slide col3 out of view */
});