$('#datePicker').datepicker({maxDate: "-18y", minDate: new Date(1970, 1, 1), dateFormat: "yy-mm-dd"});

let actualSummary;
let summaryContainer;
let skillsContainer;
let educationContainer;
let experienceContainer;
const initializeAll = () => {
    actualSummary = document.getElementById('actualSummary');
    summaryContainer = document.getElementById("actualSummary");
    skillsContainer = document.getElementById("skillsContainer");
    educationContainer = document.getElementById("educationContainer");
    experienceContainer = document.getElementById("experienceContainer");
    addSummaryToPage();
    addSkillsToPageOnLoad();
    addEducationToPageOnLoad();
    addExperienceToPageOnLoad();
    addEventListeners();
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

const removeCurrentSkill = (idElement) => {
    console.log("helllo i am in method");
    // console.log(idElement);
    // const getElement = document.getElementById(idElement);
    // removeData('removeSkill', idElement.id);
    // getElement.remove();

}; // it is used dude

const removeCurrentEducation = (idElement) => {
    const id = idElement.id;
    if (removeData('removeEducation', id)) {
        idElement.remove();
        return;
    }
    toggleModal("Education Data Not Updated");

}; // it is used dude

const removeCurrentExperience = (idElement) => {
    const id = idElement.id;
    if (removeData('removeExperience', id)) {
        idElement.remove();
        return;
    }
    toggleModal("Experience Data Not Updated");
}; // it is used dude

const removeData = (functionValue, id) => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=${functionValue}&id=${id}`);
    ajaxCall.send();
    let isDone = false;
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const responseText = ajaxCall.responseText;
            console.log(responseText);
            console.log(typeof responseText);
            if (responseText === '1') {
                isDone = true;
            }
        }
    };
    console.log('what is going on? ' + isDone);
    return isDone;
};

const addSkill = () => {
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
const addEventListeners = () => {
    skillsPencil.addEventListener('click', addSkill)
};

const toggleModal = (string) => {
    const content = document.getElementById("content");
    content.innerText = string;
    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
    });
    myModal.toggle();
};


const skillsPencil = document.getElementById('skillsPencil');
const pencilDiv = document.getElementById('topCon');
let textArea;

function summaryToTextarea() {
    textArea = document.createElement('div');
    textArea.className = 'text-area';
    textArea.innerHTML = `
<!--<label for="summary" role="button" id="labelCross">&#10006;</label>-->
    <label for="summary" role="button" id="labelCross"></label>
    <textarea name="summary" id="summary" placeholder="Summary About Yourself" onkeyup="makeVisibleDiv(this);">${userData.summary}</textarea><div class="is-invalid">Summary must contain letters and 100-500 chars</div>`
    pencilDiv.insertAdjacentElement('afterend', textArea);
    actualSummary.remove();
}
