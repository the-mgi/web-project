$('#datePicker').datepicker({maxDate: "-18y", minDate: new Date(1970, 1, 1), dateFormat: "yy-mm-dd"});

const PENCIL_HTML_ENTITY = "&#128393;";
let summaryContainer;
let skillsContainer;
let educationContainer;
let experienceContainer;
let textArea;
let mainSkillsContainer;
let pencilSkills;
const initializeAll = () => {
    summaryContainer = document.getElementById("actualSummary");
    skillsContainer = document.getElementById("skillsContainer");
    educationContainer = document.getElementById("educationContainer");
    experienceContainer = document.getElementById("experienceContainer");
    mainSkillsContainer = document.getElementById("topCon");
    pencilSkills = document.getElementById("pencil");
    addSummaryToPage();
    addSkillsToPageOnLoad();
    addEducationToPageOnLoad();
    addExperienceToPageOnLoad();
    };

const addSummaryToPage = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", "../CRUD/functions.php?function=getSummary", true);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            summaryContainer.innerText = ajaxCall.responseText;
        }
    };
};
const summaryToTextareaContainer = () => {
    let actualSummary = document.getElementById('actualSummary');
    textArea = document.createElement('div');
    textArea.className = 'text-area mt-5';
    textArea.innerHTML = `
    <textarea name="summary" id="summary" placeholder="Summary About Yourself" onkeyup="makeVisibleDiv(this);">${actualSummary.innerText}</textarea><div class="is-invalid m-0">Summary must contain letters and 100-500 chars</div>`
    mainSkillsContainer.insertAdjacentElement('afterend', textArea);
    pencilSkills.innerHTML = `<button class="m-0" style="width: 80px;">Save</button>`;
    pencilSkills.onclick = saveSummary;
    actualSummary.remove();
};
const saveSummary = () => {
    const text = textArea.firstElementChild.value;
    if (text.length < 100) {
        toggleModal("Summary must contain at least 100 characters.");
        return;
    }
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("POST", `../CRUD/functions.php?function=updateSummary&actualSummary=${text}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const paragraph = document.createElement("p");
            paragraph.className = "summary-no-edit";
            paragraph.id = "actualSummary";
            paragraph.innerText = text;
            pencilSkills.innerHTML = PENCIL_HTML_ENTITY;
            pencilSkills.onclick = summaryToTextareaContainer;
            mainSkillsContainer.appendChild(paragraph);
            textArea.remove();
        }
    };
};

const addSkillsToPageOnLoad = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", "../CRUD/functions.php?function=getSkillsAll", true);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            skillsContainer.innerHTML = ajaxCall.responseText;
        }
    };
};
const addEducationToPageOnLoad = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", "../CRUD/functions.php?function=getEducationsAll", true);
    ajaxCall.send()
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            educationContainer.innerHTML = ajaxCall.responseText;
        }
    };
};
const addExperienceToPageOnLoad = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", "../CRUD/functions.php?function=getExperienceAll", true);
    ajaxCall.send()
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            experienceContainer.innerHTML = ajaxCall.responseText;
        }
    };
};

const removeCurrentSkill = (eventData) => {
    eventData.parentElement.remove();
}; // it is used dude

const removeCurrentEducation = (idElement) => {
    const id = idElement.id;
    removeData('removeEducation', id).then(value => {
        if (value === true) {
            idElement.parentElement.parentElement.parentElement.remove();
        } else {
            toggleModal("Education Data Not Updated");
        }
    });

}; // it is used dude

const removeCurrentExperience = (idElement) => {
    const id = idElement.id;
    removeData('removeExperience', id).then(value => {
        console.log("the value is: ");
        console.log(value);
        if (value === true) {
            idElement.parentElement.parentElement.parentElement.remove();
        } else {
            toggleModal("Education Data Not Updated");
        }
    });
}; // it is used dude

const removeData = async (functionValue, id) => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=${functionValue}&id=${id}`);
    ajaxCall.send();
    let isDone = false;
    const performAjaxCall = () => {
        return new Promise((resolve, reject) => {
            ajaxCall.onreadystatechange = () => {
                if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
                    const responseText = ajaxCall.responseText;
                    console.log("my re");
                    console.log(responseText);
                    if (responseText === '1') {
                        console.log("all true");
                        resolve(true);
                    } else {
                        resolve(false);
                    }
                }
            };
        });
    }

    await performAjaxCall().then((value) => {
        isDone = value;
    });
    return isDone;
};

const addSkillContainer = () => {
    if (document.querySelector('.add-skill')) {
        return; // because the element is already on the DOM
    }
    const editFields = document.createElement('div');
    editFields.className = 'add-skill';
    editFields.innerHTML = `<div class="fields">
                        <label for="skillTitle" class="add-skill"></label>
                        <input class="add-skill-input" type="text" id="skillTitle" placeholder="Skill">

                        <label for="skillExperience" class="add-skill"></label>
                        <input class="add-skill-input" type="number" placeholder="Experience Years" id="skillExperience">

                    </div>
                    <div class="fields">
                        <button id="skillAddBtn" type="button">Add</button>
                        <button id="skillAddRemove" type="button">Remove</button>
                    </div>`;
    skillsContainer.parentElement.insertAdjacentElement('afterend', editFields);
    document.getElementById('skillAddBtn').addEventListener('click', addNewSkill);
    document.getElementById('skillAddRemove').addEventListener('click', removeButtonSkill);
}
const addNewSkill = () => {
    const skillName = document.getElementById("skillTitle");
    const skillYears = document.getElementById("skillExperience");
    if (skillName.value.length <= 0 || skillYears.value.length <= 0) {
        toggleModal("Fields Must not be empty");
        return;
    }
    const name = escape(skillName.value);
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=addNewSkill&skillName=${name}&skillYears=${skillYears.value}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const node = new DOMParser().parseFromString(ajaxCall.responseText, "text/html");
            skillsContainer.appendChild(node.querySelector("h5"));
        }
    };
}
const removeButtonSkill = () => {
    document.querySelector('.add-skill').remove();
}

const addEducationContainer = () => {

};

const addExperienceContainer = () => {

};

const toggleModal = (string) => {
    const content = document.getElementById("content");
    content.innerText = string;
    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
    });
    myModal.toggle();
};

const addEducationExperienceContainer = () =>  {
};

const updateCitiesSelectBox = () => {
    const country = document.getElementById("countries");
    const countryCode = country.value;
    const cities = document.getElementById("cities");
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=getCities&country_code=${countryCode}`, true);
    ajaxCall.send();
    console.log("above");
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            console.log("i came in here");
            const text = ajaxCall.responseText;
            console.log(text);
            cities.innerHTML = text;
            cities.disabled = false;
        }
    };
};