const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

$('#datetime').datetimepicker({
  format: 'hh:mm:ss a'
});
