class Area {
	name;
	description;
	weathered;
	locate;

	constructor(name, description, locate) {
		this.name = name;
		this.description = description;
		this.locate = locate;
		this.weathered = false;
	}

	// Getters
	getName() {
		return this.name;
	}

	getDescription() {
		return this.description;
	}

	getWeathered() {
		return this.weathered;
	}

	getLocate() {
		return this.locate;
	}

	// Setters
	setName(name) {
		this.name = name;
	}

	setDescription(description) {
		this.description = description;
	}

	setWeathered(weathered) {
		this.weathered = weathered;
	}

	setLocate(locate) {
		this.locate = locate;
	}

	getFormData() {
		const formData = new FormData();
		formData.append("name", this.getName());
		formData.append("description", this.getDescription());
		formData.append("locate", this.getLocate());
		formData.append("weathered", this.getWeathered());
		return formData;
	}

	async insert() {
		try {
			const data = await fetch("http://localhost/beesmap/api/areas", {
				method: "POST",
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

	async list() {
		try {
			const data = await fetch("http://localhost/beesmap/api/areas", {
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
}

export default Area;
