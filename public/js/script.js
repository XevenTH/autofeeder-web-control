const hamBurger = document.querySelectorAll(".toggle-btn");

hamBurger.forEach((element) => {

  element.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
  });

});