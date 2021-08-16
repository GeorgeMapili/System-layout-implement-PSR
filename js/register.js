const form = document.querySelector("#register")
const first_name = document.querySelector("#first_name")
const last_name = document.querySelector("#last_name")
const email = document.querySelector("#email")
const password = document.querySelector("#password")
const confirm_password = document.querySelector("#confirm_password")

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


// let input_field = [first_name, last_name, email, password, confirm_password]

// function required_field(element){

//     let messages = []

//     element.forEach(el => {
//         if(el.value === '' || el.value == null){
//             messages.push(el.name.charAt(0).toUpperCase() + el.name.slice(1).replace("_", " ")+ " is required")
//         }
//     });

//     return messages
// }

// function display_message(message){

//     message.forEach(element => {
//         if(element == "First name is required"){
//             const small = document.createElement('small')
//             small.innerText = ''
//             small.classList.add('text-danger')
//             small.innerHTML = element

//             first_name.classList.add('is-invalid')
//             const parent = first_name.parentNode
//             parent.append(small)
//         }else if(element == "Last name is required"){
//             const small = document.createElement('small')
//             small.classList.add('text-danger')
//             small.innerHTML = element

//             last_name.classList.add('is-invalid')
//             const parent = last_name.parentNode
//             parent.append(small)
//         }
//     });

// }

// function success_validation(message){

//     message.forEach(element => {

//         if(element != "First name is required")

//         first_name.classList.add('is-valid');
//         last_name.classList.add('is-valid');
//         email.classList.add('is-valid');
//         password.classList.add('is-valid');
//         confirm_password.classList.add('is-valid');

//     });

// }

// form.addEventListener("submit", (e) => {

//     e.preventDefault()

//     const message = required_field(input_field)

//     if(message.length > 0){
//         display_message(message)
//     }else{
//         success_validation(message);
//     }

// });

