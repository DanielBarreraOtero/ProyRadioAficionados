function creaModal() {
    var cuerpo = document.querySelector('#cuerpo');
    var modal = document.createElement('div');
    modal.classList.add('c-modal');

    modal.onclick = (ev) => {
        if (ev.target.className === "c-modal") {
            modal.remove();
        }
    }

    cuerpo.insertBefore(modal, cuerpo.firstChild);

    return modal;
}