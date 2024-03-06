let signUpBtn = document.querySelector(".signup-btn");
let signInBtn = document.querySelector(".signin-btn");
let wrapper = document.querySelector(".wrapper");

signUpBtn.addEventListener("click", () => {
  wrapper.classList.add("active");
});

signInBtn.addEventListener("click", () => {
  wrapper.classList.remove("active");
});
