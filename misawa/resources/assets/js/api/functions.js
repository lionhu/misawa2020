/**
 * Mocking client-server processing
 */


import Swal from 'sweetalert2';

export default {

    ShowMessage(_type,_message){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            type: _type,
            title: _message
        })
    }
};