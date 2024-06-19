/*=============== CLOCK ===============*/
const hour = document.getElementById('clock-hour'),
      minutes = document.getElementById('clock-minutes')

const clock = () =>{
   let date = new Date()

   // Mendapatkan jam dan menit
   // (current time) / 12(hours) * 360(deg circle)
   // (Current minute) / 60(minutes) * 360(deg circle)
   let hh = date.getHours() / 12 * 360,
       mm = date.getMinutes() / 60 * 360
   // Mengubah rotasi jarum
   hour.style.transform = `rotateZ(${hh + mm / 12}deg)`
   minutes.style.transform = `rotateZ(${mm}deg)`
}
setInterval(clock, 1000) // (Perbarui setiap 1s) 1000 = 1s 

/*=============== TIME AND DATE TEXT ===============*/
const dateDayWeek = document.getElementById('date-day-week'),
      dateMonth = document.getElementById('date-month'),
      dateDay = document.getElementById('date-day'),
      dateYear = document.getElementById('date-year'),
      textHour = document.getElementById('text-hour'),
      textMinutes = document.getElementById('text-minutes'),
      textSeconds = document.getElementById('text-seconds')
      // textAmPm = document.getElementById('text-ampm')

const clockText = () =>{
   let date = new Date()

   // Mendapatkan data waktu
   let dayWeek = date.getDay(),
       month = date.getMonth(),
       day = date.getDate(),
       year = date.getFullYear(),
       hh = date.getHours(),
       mm = date.getMinutes(),
       ss = date.getSeconds(),
       ampm

   // Menyiapkan nama hari dan bulan
   let daysWeek = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
   let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']

   // Menampilkan tanggal yang sesuai
   dateDayWeek.innerHTML = `${daysWeek[dayWeek]}`
   dateMonth.innerHTML = `${months[month]} `
   dateDay.innerHTML = `${day} `
   dateYear.innerHTML = year

   // Jika jam lebih dari 12 (siang), maka dikurangi -12, sehingga dimulai dari 1 (siang)
   // if(hh >= 12){
   //    hh = hh - 12
   //    ampm = 'PM'
   // } else{
   //    ampm = 'AM'
   // }

   // textAmPm.innerHTML = ampm

   // Ketika jam 0 (dini hari), ubah jadi 12
   // if(hh == 0){hh = 12}

   // Jika jam kurang dari 10, tambahkan 0 (01,02,03...09)
   if(hh < 10){hh = `0${hh}`}

   textHour.innerHTML = `${hh}:`

   // Jika menit kurang dari 10, tambahkan 0 (01,02,03...09)
   if(mm < 10){mm = `0${mm}`}

   textMinutes.innerHTML = `${mm}:`

    // Jika detik kurang dari 10, tambahkan 0 (01,02,03...09)
    if(ss < 10){ss = `0${ss}`}

   textSeconds.innerHTML = ss
}
setInterval(clockText, 1000) // (Perbarui setiap 1s) 1000 = 1s