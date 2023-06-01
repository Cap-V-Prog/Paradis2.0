const slidePage = document.querySelector(".slide-page");
const nextBtnFirst = document.querySelector(".firstNext");
const prevBtnSec = document.querySelector(".prev-1");
const nextBtnSec = document.querySelector(".next-1");
const prevBtnThird = document.querySelector(".prev-2");
const nextBtnThird = document.querySelector(".next-2");
const prevBtnFourth = document.querySelector(".prev-3");
const submitBtn = document.querySelector(".submit");
const progressText = document.querySelectorAll(".step p");
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bullet");
let current = 1;

nextBtnFirst.addEventListener("click", function(event){
  event.preventDefault();
  if (validateStep1()) {
    slidePage.style.marginLeft = "-25%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
  }
});

nextBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  if (validateStep2()) {
    slidePage.style.marginLeft = "-50%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
  }
});

nextBtnThird.addEventListener("click", function(event){
  event.preventDefault();
  if (validateStep3()) {
    slidePage.style.marginLeft = "-75%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
  }
});

submitBtn.addEventListener("click", function(event){
  if (validateStep4()) {
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
    setTimeout(function(){
      showPopup("O seu formulário foi enviado com sucesso.");
      location.reload();
    }, 800);
  }else{
    event.preventDefault();
  }
});

prevBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "0%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});

prevBtnThird.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-25%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});

prevBtnFourth.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-50%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});

function validateStep1() {
  const nameInput = document.getElementById("name");
  const name = nameInput.value.trim();

  if (name === "") {
    showPopup("Por favor, insira o seu nome.");
    return false;
  } else if (/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(name)) {
    showPopup("O nome só deve conter letras.");
    return false;
  }

  return true;
}

function validateStep2() {
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const email = emailInput.value.trim();
  const phone = phoneInput.value.trim();

  if (email === "") {
    showPopup("Por favor, insira o seu email.");
    return false;
  } else if (!validateEmail(email)) {
    showPopup("Por favor, insira um endereço de email válido.");
    return false;
  }

  if (phone === "") {
    showPopup("Por favor, insira o seu número de telefone.");
    return false;
  } else if (!validatePhoneNumber(phone)) {
    showPopup("Por favor, insira um número de telefone válido.");
    return false;
  }

  return true;
}

function validateStep3() {
  const dateInput = document.getElementById("date");
  const genderInput = document.getElementById("gender");
  const date = dateInput.value;
  const gender = genderInput.value;

  if (date === "") {
    showPopup("Por favor, insira a sua data de nascimento.");
    return false;
  } else if (!validateAge(date)) {
    showPopup("Deve ter pelo menos 18 anos para se inscrever.");
    return false;
  }

  if (gender === "") {
    showPopup("Por favor, selecione o seu género.");
    return false;
  }

  return true;
}

function validateStep4() {
  const nifInput = document.getElementById("nif");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirmPassword");
  const nif = nifInput.value.trim();
  const password = passwordInput.value.trim();
  const confirmPassword = confirmPasswordInput.value.trim();

  if (nif === "") {
    showPopup("Por favor, insira o seu NIF.");
    return false;
  } else if (!validateNIF(nif)) {
    showPopup("Por favor, insira um NIF válido.");
    return false;
  }

  if (password === "") {
    showPopup("Por favor, insira uma palavra-passe.");
    return false;
  } else if (confirmPassword === "") {
    showPopup("Por favor, confirme a sua palavra-passe.");
    return false;
  } else if (password !== confirmPassword) {
    showPopup("As palavras-passe não coincidem.");
    return false;
  }

  return true;
}

function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function validatePhoneNumber(phone) {
  const phoneRegex = /^9[1236]\d{7}$/;
  return phoneRegex.test(phone);
}

function validateAge(date) {
  const today = new Date();
  const birthDate = new Date(date);
  const age = today.getFullYear() - birthDate.getFullYear();
  const monthDiff = today.getMonth() - birthDate.getMonth();

  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
    return age - 1;
  }

  return age;
}

function validateNIF(nif) {
  const nifRegex = /^[12356789]\d{8}$/;
  return nifRegex.test(nif);
}

function showPopup(message) {
  const popup = document.createElement("div");
  popup.className = "popup my-custom-popup";
  popup.innerHTML = '<h3><i class="bi bi-info-circle-fill"></i> Alerta</h3>' +
      '<p>' + message + '</p>';
  document.body.appendChild(popup);
  setTimeout(function() {
    popup.remove();
  }, 2000);
}

