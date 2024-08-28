import User from "../../../_assets/js/User.js";

const profileName = document.querySelector("#div-profile-info").querySelector("h1");
const profileTeamName = document.querySelector("#div-profile-info").querySelector("p");
const profileImage = document.querySelector("#div-profile").querySelector("img");

async function updateInfs() {
    let user = new User();
    let data = await user.getInfs();    
    profileName.innerHTML = data.data.name;
    profileTeamName.innerHTML = data.data.team_name;
}
updateInfs()
