import $ from 'jquery';
import bsCustomFileInput from 'bs-custom-file-input'
import 'bootstrap';
import 'datatables.net-responsive-bs';
import 'datatables.net-bs4';
import 'admin-lte';
import select2 from 'select2';
import Swal from 'sweetalert2';

global.Popper = require('popper.js').default;
global.$ = global.jQuery = $;

$(function() {

    $('.select2').select2();
    bsCustomFileInput.init()

})

const _confirmColor = '#3482F6';

window.deleteConfirm = function (el) {
    Swal.fire({
        icon: 'warning',
        title: 'Delete',
        text: 'Are you sure you want to delete the data?',
        showCancelButton: true,
        confirmButtonText: 'Yes, I\'m sure',
        confirmButtonColor: _confirmColor,
    }).then((result) => {
        if (result.isConfirmed) {
            el.closest('form').submit();
        }
    });
}

window.justConfirm = function (el) {
    Swal.fire({
        icon: 'question',
        text: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, I\'m sure',
        confirmButtonColor: _confirmColor,
    }).then((result) => {
        if (result.isConfirmed) {
            el.closest('form').submit();
        }
    });
}

window.logoutConfirm = function (el) {
    Swal.fire({
        icon: 'warning',
        title: 'Logout',
        text: 'Are you sure you want to logout?',
        showCancelButton: true,
        confirmButtonText: 'Yes, I\'m sure',
        confirmButtonColor: _confirmColor,
    }).then((result) => {
        if (result.isConfirmed) {
            el.closest('form').submit();
        }
    });
}

