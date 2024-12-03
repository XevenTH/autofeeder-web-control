import axios from 'axios';
import Swal from 'sweetalert2';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


// window.deleteConfirm = function(formId)
// {
//     Swal.fire({
//         icon: 'warning',
//         text: 'Do you want to delete this?',
//         showCancelButton: true,
//         confirmButtonText: 'Delete',
//         confirmButtonColor: '#e3342f',
//     }).then((result) => {
//         if (result.isConfirmed) {
//             document.getElementById(formId).submit();
//         }
//     });
// }

// document.addEventListener('DOMContentLoaded', function () {
//     document.querySelectorAll('[data-confirm-delete]').forEach(function (element) {
//         element.addEventListener('click', function (event) {
//             event.preventDefault();
//             const url = this.getAttribute('href');
//             Swal.fire({
//                 title: 'Are you sure?',
//                 text: "You won't be able to revert this!",
//                 icon: 'warning',
//                 showCancelButton: true,
//                 confirmButtonColor: '#3085d6',
//                 cancelButtonColor: '#d33',
//                 confirmButtonText: 'Yes, delete it!'
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     fetch(url, {
//                         method: 'DELETE',
//                         headers: {
//                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                         }
//                     }).then(response => {
//                         if (response.ok) {
//                             Swal.fire(
//                                 'Deleted!',
//                                 'Your file has been deleted.',
//                                 'success'
//                             ).then(() => {
//                                 location.reload();
//                             });
//                         } else {
//                             Swal.fire(
//                                 'Error!',
//                                 'There was a problem deleting your file.',
//                                 'error'
//                             );
//                         }
//                     });
//                 }
//             });
//         });
//     });
// });
