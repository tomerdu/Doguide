
fetch("json/danger_type.json")
.then(response => response.json())
.then(data => dynamic_load(data));

function dynamic_load(data)
{
    let place = document.getElementById("option_type");
    for(el of data["dangers_types"])
    {

        let opt = document.createElement("option");
        opt.value = el["type"];
        opt.innerHTML = el["type"];
        place.appendChild(opt);
    }

}

