import Notification from "./Notification.js";

class User {
	name;
	email;
	password;
	confirmPassword;

	constructor(email = "", password = "", confirmPassword = "", name = "") {
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
	getFormData() {
		const formData = new FormData();
		formData.append("name", this.getName());
		formData.append("email", this.getEmail());
		formData.append("password", this.getPassword());
		formData.append("confirmPassword", this.getConfirmPassword());
		return formData;
	}

	async insert() {
		try {
			const data = await fetch("http://localhost/beesmap/api/users", {
				method: "POST",
				body: this.getFormData(),
			}).then((res) => res.json());

			new Notification(data.message, data.type);

			return data;
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}

	async login() {
		try {
			const data = await fetch("http://localhost/beesmap/api/users/login", {
				method: "POST",
				body: this.getFormData(),
			}).then((res) => res.json());

			new Notification(data.message, data.type);

			return data;
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}

	loginOut() {
		try {
			localStorage.removeItem("token");

			new Notification("Deslogado com sucesso", "sucess");

			return {
				type: "sucess",
				message: "Deslogado com sucesso",
			};
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}

	async update() {
		try {
			const data = await fetch("http://localhost/beesmap/api/users/update", {
				method: "PUT",
				body: this.getFormData(),
				headers: {
					token: localStorage.getItem("token"),
				},
			}).then((res) => res.json());
			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async updatePassword(newPassword = "", confirmNewPassword = "") {
		try {
			const formData = this.getFormData();
			formData.append("newPassword", newPassword);
			formData.append("confirmNewPassword", confirmNewPassword);
			const data = await fetch(
				"http://localhost/beesmap/api/users/updatePassword",
				{
					method: "PUT",
					body: this.getFormData(),
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());
			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async deconste() {
		try {
			const data = await fetch("http://localhost/beesmap/api/users/deconste", {
				method: "DEconstE",
				body: this.getFormData(),
				headers: {
					token: localStorage.getItem("token"),
				},
			}).then((res) => res.json());
			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async logged() {
		try {
			const data = await fetch("http://localhost/beesmap/api/users/logged", {
				method: "GET",
				headers: {
					token: localStorage.getItem("token"),
				},
			}).then((res) => res.json());

			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async exitTeam() {
		try {
			const data = await fetch("http://localhost/beesmap/api/teams/exit", {
				method: "POST",
				headers: {
					token: localStorage.getItem("token"),
				},
			}).then((res) => res.json());

			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async getInfs() {
		try {
			const data = await fetch("http://localhost/beesmap/api/users/infs", {
				method: "GET",
				headers: {
					token: localStorage.getItem("token"),
				},
			}).then((res) => res.json());

			return data;
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}
}

export default User;
