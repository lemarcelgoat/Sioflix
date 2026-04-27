const btnLogin = document.getElementById('show-login');
const btnSignup = document.getElementById('show-signup');
const formLogin = document.getElementById('form_Connexion');
const formSignup = document.getElementById('form_Inscri');

btnLogin.addEventListener('click', login) 

function login() {
    formLogin.classList.remove('hidden');
    formSignup.classList.add('hidden');

    btnLogin.classList.add('active');
    btnSignup.classList.remove('active');
};

btnSignup.addEventListener('click', signup)

function signup() {    
    formSignup.classList.remove('hidden');
    formLogin.classList.add('hidden');
    
    btnSignup.classList.add('active');
    btnLogin.classList.remove('active');
}; 
