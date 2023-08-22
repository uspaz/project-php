const forms = document.querySelectorAll('.FormAjax');

function submitForm(e) {
    e.preventDefault();

    let accept = confirm('¿Desea enviar el formulario?');
    
    if (accept) {
        let data = new FormData(this);
        let action = this.getAttribute('action');
        let method = this.getAttribute('method');
        let headers = new Headers();

        let config = {
            method,
            headers,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };
        
        fetch(action, config)
            .then( res => res.text())
            .then( data => {
                let content = document.querySelector('.form-res');
                content.innerHTML = data;
        });
    }  

}   

forms.forEach( (form) => {
    form.addEventListener('submit', submitForm);
})