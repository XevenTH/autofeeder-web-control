const hamBurger = document.querySelectorAll(".toggle-btn");

hamBurger.forEach((element) => {

  element.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
  });

});

document.getElementById('sidebar-logout').addEventListener('submit', function(e) {
  let form = this;

  e.preventDefault(); // <--- prevent form from submitting

  swal({
      title: "Keluar FinBites?",
      text: "Harap kondirmasi sebelum anda keluar",
      icon: "warning",
      buttons: [
        'Tidak, batalkan!',
        'Ya, saya ingin keluar!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      form.submit(); // <--- submit form programmatically
    })
});