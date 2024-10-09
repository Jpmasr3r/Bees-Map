import Area from "../../../_assets/js/Area.js";
import Notification from "../../../_assets/js/Notification.js";
import Team from "../../../_assets/js/Team.js";
import User from "../../../_assets/js/User.js";
import WindowInput from "../../../_assets/js/WindowInput.js";

const teamName = document.querySelector(".div-team-info h1");
const teamMembersArea = document.querySelector(".div-team-members");

async function update() {
	const userInfs = await new User().getInfs();
	if (!userInfs.data.team_name) {
		insertJoinTeam();
	} else {
		teamName.innerHTML = userInfs.data.team_name;

		const team = await new Team().getInfs();

		team.data.members.forEach((member) => {
			insertMember(member.name);
		});
	}
}
update();

// Funções de equipe
function insertTeam(team) {
	const div = document.createElement("div");
	const h1 = document.createElement("h1");
	h1.innerHTML = team.name;
	const button = document.createElement("button");
	button.innerHTML = "Juntar-se";
	div.appendChild(h1);
	div.appendChild(button);
	document.querySelector("#div-search").appendChild(div);

	button.addEventListener("click", async () => {
		const teamClass = new Team(team.name);
		const join = await teamClass.join();
		if (join.type === "success") {
			location.href = "http://localhost/beesmap/app/equipe";
		}
	});
}

function insertMember(memberName = "") {
	const div = document.createElement("div");
	div.className = "team-member";
	const img = document.createElement("img");
	img.src = "http://localhost/beesmap/themes/_assets/imgs/bee-black.png";
	const div2 = document.createElement("div");
	div2.className = "team-member-info";
	const h1 = document.createElement("h1");
	h1.innerHTML = memberName;

	div2.appendChild(h1);
	div.appendChild(img);
	div.appendChild(div2);
	teamMembersArea.appendChild(div);
}

function insertJoinTeam() {
	const divArea = document.querySelector("#div-area");
	divArea.removeChild(document.querySelector(".team-focus"));
	const h1 = document.createElement("h1");
	h1.innerHTML =
		"Você não pertence a nenhuma equipe. Deseja se juntar a alguma?";
	divArea.appendChild(h1);

	const div = document.createElement("div");
	const label = document.createElement("label");
	const p = document.createElement("p");
	p.innerHTML = "Nome da equipe";
	const input = document.createElement("input");
	input.type = "text";
	const button = document.createElement("button");
	button.innerHTML = "Pesquisar";
	const divSearch = document.createElement("div");
	divSearch.id = "div-search";

	label.appendChild(p);
	label.appendChild(input);
	div.appendChild(label);
	div.appendChild(button);
	divArea.appendChild(div);
	divArea.appendChild(divSearch);

	button.addEventListener("click", async () => {
		const team = new Team();
		const teamselect = await team.getAllTeamsByName(input.value);

		const btn_2 = document.createElement("button");
		btn_2.innerHTML = "Crie sua própria equipe";
		div.appendChild(btn_2);

		divSearch.innerHTML = "";
		if (teamselect.type === "success") {
			teamselect.data.forEach((e) => {
				insertTeam(e);
			});
		}

		btn_2.addEventListener("click", async () => {
			const newTeam = new Team(input.value);
			await newTeam.insert();
			location.reload();
		});
	});
}

const btnInsertArea = document.querySelector("#btn-insert-area");
btnInsertArea.addEventListener("click", insertArea);

// Funções de área
async function insertArea() {
	const windowInput = new WindowInput(
		"Nome da área",
		"Descrição da área",
		"Localização da área",
	);
	const params = await windowInput.createWindow("Criar área");

	const newArea = new Area(
		params["Nome da área"],
		params["Descrição da área"],
		params["Localização da área"],
	);
	const data = await newArea.insert();

	new Notification(data.message, data.type);

	listAreas();
}

async function listAreas() {
	const divAreas = document.querySelector("#div-areas");
	divAreas.innerHTML = "<h1>Areas</h1>";
	const response = await new Area().list();

	response.data.forEach((area) => {
		const divArea = document.createElement("div");
		divArea.className = "area";

		const h1 = document.createElement("h1");
		h1.innerHTML = area["name"];

		const h2 = document.createElement("h2");
		h2.innerHTML = area["locate"];

		const h3 = document.createElement("h3");
		h3.innerHTML = area["description"];

		const divBoxes = document.createElement("div");
		divBoxes.className = "div-boxes";

		divArea.appendChild(h1);
		divArea.appendChild(h2);
		divArea.appendChild(divBoxes);

		divAreas.appendChild(divArea);
	});
}

const btnExit = document.querySelector("#btn-exit-team");
btnExit.addEventListener("click", async () => {
	const team = await new Team().exit();
	if (team.type === "success") {
		location.reload();
	}
});

const btnDelete = document.querySelector("#btn-delete-team");
btnDelete.addEventListener("click", async () => {
	const team = await new Team().delete();

	if (team.type === "success") {
		location.reload();
	}
});

listAreas();
