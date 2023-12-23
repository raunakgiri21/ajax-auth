"use strict";

const switchTab = document.querySelector(".switch-tab");
const signinTab = document.querySelector(".sign-in-tab");
const signupTab = document.querySelector(".sign-up-tab");
const signinForm = document.querySelector(".sign-in-form");
const signupForm = document.querySelector(".sign-up-form");
const errorMsg = document.querySelector(".error-msg");

switchTab?.addEventListener("click", () => {
  signinTab.classList.toggle("active-tab");
  errorMsg.classList.add("d-none");
  if (signinTab.classList.contains("active-tab")) {
    signupTab.classList.remove("active-tab");
    signinForm.classList.remove("d-none");
    signupForm.classList.add("d-none");
  } else {
    signupTab.classList.add("active-tab");
    signinForm.classList.add("d-none");
    signupForm.classList.remove("d-none");
  }
});

const signinSubmit = document.querySelector("#sign-in-submit");
const signinEmail = document.querySelector("#email");
const signinPassword = document.querySelector("#password");

const validateEmail = (email) => {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

signinSubmit?.addEventListener("click", (e) => {
  e.preventDefault();
  errorMsg.classList.remove("d-none");
  const validEmail = validateEmail(signinEmail.value);
  if (!validEmail) {
    errorMsg.innerHTML = "Please enter a valid email";
  } else if (!signinPassword.value) {
    errorMsg.innerHTML = "Please enter your password";
  } else {
    const data =
      "email=" +
      signinEmail.value +
      "&password=" +
      signinPassword.value +
      "&action=signin";
    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = () => {
      if (ajax.readyState == 4 && ajax.status == 200) {
        const res = JSON.parse(ajax.responseText);
        if (res.err) {
          errorMsg.innerHTML = res.err;
        } else {
          errorMsg.classList.add("d-none");
          window.location.replace("index.php");
        }
      }
    };
    ajax.open("POST", "auth.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
  }
});

const signupSubmit = document.querySelector("#sign-up-submit");
const signupName = document.querySelector("#name");
const signupEmail = document.querySelector("#email2");
const signupPassword = document.querySelector("#password2");
const signupConfirmPassword = document.querySelector("#password3");

signupSubmit?.addEventListener("click", (e) => {
  errorMsg.classList.remove("d-none");
  e.preventDefault();
  const validEmail = validateEmail(signupEmail.value);

  if (!signupName) {
    errorMsg.innerHTML = "Please enter your name!";
  } else if (!validEmail) {
    errorMsg.innerHTML = "Please enter a valid email";
  } else if (signupPassword.value?.length < 8) {
    errorMsg.innerHTML = "Password must be atleast 8 characters";
  } else if (signupPassword.value !== signupConfirmPassword.value) {
    errorMsg.innerHTML = "Passwords not matching!";
  } else {
    const data =
      "name=" +
      signupName.value +
      "&email=" +
      signupEmail.value +
      "&password=" +
      signupPassword.value +
      "&cnfpassword=" +
      signupConfirmPassword.value +
      "&action=signup";
    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = () => {
      if (ajax.readyState == 4 && ajax.status == 200) {
        const res = JSON.parse(ajax.responseText);
        if (res.err) {
          errorMsg.innerHTML = res.err;
        } else {
          errorMsg.classList.add("d-none");
          window.location.replace("index.php");
        }
      }
    };
    ajax.open("POST", "auth.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(data);
  }
});
