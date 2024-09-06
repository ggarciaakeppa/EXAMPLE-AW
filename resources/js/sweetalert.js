document.addEventListener('alerta', event => {
    Swal.fire({
        icon: event.detail.type,
        title: '¡Aviso!',
        text: event.detail.message,
        timer: 1500,
        showConfirmButton: false
    })
})
