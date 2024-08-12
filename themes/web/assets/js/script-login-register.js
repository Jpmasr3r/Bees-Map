import User from "./class/User.js";

const inpRegisterName = document.querySelector("#inp-register-name");
const inpRegisterEmail = document.querySelector("#inp-register-email");
const inpRegisterPassword = document.querySelector("#inp-register-password");
const inpRegisterConfirmPassword = document.querySelector("#inp-register-confirm-password");

const btnCreate = document.querySelector("#btn-create");
btnCreate.addEventListener("click",async () => {
    const user = new User(
        inpRegisterEmail.value,
        inpRegisterPassword.value,
        inpRegisterConfirmPassword.value,
        inpRegisterName.value,
    )

    const data = await fetch("http://localhost/beesmap/api/users/",{
        method: "POST",
        body: user.getFormDataRegister()
    }).then(res => res.json());
    console.log(data);
    
})

const inpLoginEmail = document.querySelector("#inp-login-email");
const inpLoginPassword = document.querySelector("#inp-login-password");

const btnLogin = document.querySelector("#btn-login");
btnLogin.addEventListener("click",async () => {
    const user = new User(
        inpLoginEmail.value,
        inpLoginPassword.value,
    )

    const data = await fetch("http://localhost/beesmap/api/users/login/",{
        method: "POST",
        body: user.getFormDataLogin()
    }).then(res => res.json());
    console.log(data);
    
})