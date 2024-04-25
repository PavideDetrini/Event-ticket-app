let alert = document.querySelector('#error');
alert.style.display = 'none';
document.querySelector("form").addEventListener("submit", (e) => {
        pass = document.querySelector("input[name='password']").value
        if (/[A-Z]/.test(pass) && /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pass) && /[a-z]/.test(pass) && pass.length > 8 && /[0-9]/.test(pass)) {
            console.log("pass")
        }else{
            console.log("NOOO")
            alert.style.display = 'block'
            alert.innerHTML = "La password deve contenere almeno 8 caratteri tra cui un numero, un carattere speciale e una lettera maiuscola";
            e.preventDefault()
        }
    }
)