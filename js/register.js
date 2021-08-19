const form = document.querySelector("#register")
const first_name = document.querySelector("#first_name")
const last_name = document.querySelector("#last_name")
const email = document.querySelector("#email")
const password = document.querySelector("#password")
const confirm_password = document.querySelector("#confirm_password")
const message_prnt = document.querySelector("#message")
const children = message_prnt.children
const alert_btn = document.querySelector("#alert-btn")
const message_strong = document.querySelector("#message_strong")

let inputs = [first_name, last_name, email, password, confirm_password]
let errors = []

function validateName(input, element){
    const regex = /^[a-zA-Z ]{2,30}$/
    
    if(!(input.match(regex) == null)){
        display_success(element, "Valid name")
    }else{
        display_error(element, "Invalid name")
    }

}

function validateEmail(input, element){
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(re.test(String(input).toLowerCase())){
        display_success(element, "Valid email")
    }else{
        display_error(element, "Invalid email")
    }

}

function validatePassword(input, element){
    
    const regex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/

    if(regex.test(input)){
        display_success(element, "Valid password")
    }else{
        display_error(element,"Your password must be at least 8 characters, with at least a symbol, upper and lower case letters and a number")
    }

}

function validateConfirmPassword(input, element){

    if(input === password.value){
        display_success(element, "Password match")
    }else{
        display_error(element,"Password didn't match")
    }

}

function display_error(element, message){

    const parnt = element.parentNode;
    const input_field = parnt.querySelector('input');
    const small = parnt.querySelector('small')
    input_field.className = 'form-control is-invalid'
    small.innerHTML = message
    small.className = 'text-danger'

}

function display_success(element, message){

    const parnt = element.parentNode;
    const input_field = parnt.querySelector('input');
    const small = parnt.querySelector('small')
    input_field.className = 'form-control is-valid'
    small.innerHTML = message
    small.className = 'text-success'

}

function required_fields(elements){

    elements.forEach(element => {
        validate_input(element.value, element);
    });

}

function validate_input(input, element){
    
    if(input == ""){
        const prnt = element.parentNode
        const input_field = prnt.querySelector('input');
        const small = prnt.querySelector('small')
        input_field.className = 'form-control is-invalid'
        small.innerHTML = element.name.charAt(0).toUpperCase() + element.name.slice(1).replace("_", " ")+ " is required"
        errors.push(small.innerHTML)
        small.className = 'text-danger'
    }
    
}

function remove_all(arr){
    for (let i = arr.length - 1; i >= 0; i--) {
        arr.splice(i, 1);
    }
}

first_name.addEventListener("keyup", e => {
    validateName(e.target.value.trim(), first_name)
});

last_name.addEventListener("keyup", e => {
    validateName(e.target.value.trim(), last_name)
});

email.addEventListener("keyup", e => {
    validateEmail(e.target.value.trim(), email)
});

password.addEventListener("keyup", e => {
    validatePassword(e.target.value, password)
});

confirm_password.addEventListener("keyup", e => {
    validateConfirmPassword(e.target.value, confirm_password)
});

form.addEventListener("submit", (e) => {

    e.preventDefault()
    
    required_fields(inputs) 

    let postData = new FormData();
    postData.append('first_name', first_name.value.trim())
    postData.append('last_name', last_name.value.trim())
    postData.append('email', email.value.trim())
    postData.append('password', password.value.trim())
    postData.append('confirm_password', confirm_password.value.trim())

    if(errors.length <= 0){

        fetch('http://localhost/system/api/register.php', {
            method: 'POST',
            mode: 'no-cors',
            headers: {
                'Content-Type': 'application/json'
            },
            body: postData
        })
        .then(res => {
            if(res.ok){
                return res.json()
            }
        })
        .then(data => {

            if(data.status){
                children.className = "alert alert-success alert-dismissible fade show"
                alert_btn.removeAttribute("hidden")
                message_strong.innerHTML = data.message
            }else{
                children.className = "alert alert-danger alert-dismissible fade show"
                alert_btn.removeAttribute("hidden")
                message_strong.innerHTML = data.message
            }

        })
        .catch(error => console.log(error))

    }else{
        remove_all(errors)
    }

});
