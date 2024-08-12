class User {
    name;
    email;
    password;
    confirmPassword;

    constructor(email, password, confirmPassword = "", name = "") {
        this.setName(name);
        this.setEmail(email);
        this.setPassword(password);
        this.setConfirmPassword(confirmPassword);
    }

    //setters
    setName(name) {
        this.name = name;
    }

    setEmail(email) {
        this.email = email;
    }

    setPassword(password) {
        this.password = password;
    }

    setConfirmPassword(confirmPassword) {
        this.confirmPassword = confirmPassword;
    }
    //getters
    getName() {
        return this.name;
    }

    getEmail() {
        return this.email;
    }

    getPassword() {
        return this.password;
    }

    getConfirmPassword() {
        return this.confirmPassword;
    }

    //functions
    getFormDataRegister() {
        const formData = new FormData();
        formData.append("name", this.getName());
        formData.append("email", this.getEmail());
        formData.append("password", this.getPassword());
        formData.append("confirmPassword", this.getConfirmPassword());
        return formData;
    }

    getFormDataLogin() {
        const formData = new FormData();
        formData.append("email", this.getEmail());
        formData.append("password", this.getPassword());
        return formData;
    }
}

export default User;