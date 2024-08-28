import Team from "../../../_assets/js/Team.js";

const teamName = document.querySelector(".div-team-info").querySelector("h1");
const teamMembersArea = document.querySelector(".div-team-members");

function insertTeam(team) {
    let div = document.createElement("div");
    let h1 = document.createElement("h1");
    h1.innerHTML = team.name;
    let button = document.createElement("button");
    button.innerHTML = "Juntar-se";
    div.appendChild(h1);
    div.appendChild(button);
    document.querySelector("#div-search").appendChild(div);

    button.addEventListener("click",async () => {
        const teamClass = new Team(team.name);
        let join = await teamClass.join();
        console.log(join);
        if(join.type == "success") {
            setTimeout(() => {
                location.href = "http://localhost/beesmap/app/equipe";
            },2000);
        }
    })
}

function insertMember(memberName = "") {
    let div = document.createElement("div");
    div.className = "team-member";
    let img = document.createElement("img");
    img.src = "http://localhost/beesmap/themes/_assets/imgs/bee-black.png";
    let div2 = document.createElement("div");
    div2.className = "team-member-info";
    let h1 = document.createElement("h1");
    h1.innerHTML = memberName;

    div2.appendChild(h1);
    div.appendChild(img);
    div.appendChild(div2);
    teamMembersArea.appendChild(div);
}

async function update() {
    let team = new Team();
    let teamInfs = await team.getInfs();

    function insertJoinTeam() {
        let divArea = document.querySelector("#div-area");
        divArea.removeChild(document.querySelector(".team-focus"));
        let h1 = document.createElement("h1");
        h1.innerHTML = "Você não pertence a nenhuma equipe. Deseja se juntar a alguma?";
        divArea.appendChild(h1);

        let div = document.createElement("div");
        let label = document.createElement("label");
        let p = document.createElement("p");
        p.innerHTML = "Nome da equipe";
        let input = document.createElement("input");
        input.type = "text";
        let button = document.createElement("button");
        button.innerHTML = "Pesquisar";
        let divSearch = document.createElement("div");
        divSearch.id = "div-search";

        label.appendChild(p);
        label.appendChild(input);
        div.appendChild(label);
        div.appendChild(button);
        divArea.appendChild(div);
        divArea.appendChild(divSearch);

        button.addEventListener("click", async () => {
            const team = new Team();
            let teamselect = await team.getAllTeamsByName(input.value);

            divSearch.innerHTML = "";
            if (teamselect.type == "success") {
                teamselect.data.forEach(e => {
                    insertTeam(e);
                });
            }
        })
    }

    console.log(teamInfs);
    
    if (teamInfs.type == "success") {
        teamInfs = teamInfs.data;
        teamName.innerHTML = teamInfs.name;

        teamInfs.members.forEach(e => {
            insertMember(e.name);
        });
    } else {
        insertJoinTeam();
    }
}
update();


const btnExit = document.querySelector("#btn-exit-team");
btnExit.addEventListener("click",async () => {
    const team = new Team();
    if(await team.exit().type == "success") {
        location.href = "http://localhost/beesmap/app/equipe";
    }
});

