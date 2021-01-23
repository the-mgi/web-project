$('#datePicker').datepicker({maxDate: "-18y", minDate: new Date(1970, 1, 1), dateFormat: "yy-mm-dd"});
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};


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
    pencilSkills.innerHTML = `<button class="m-0" style="width: 80px;" type="button">Save</button>`;
    pencilSkills.onclick = saveSummary;
    actualSummary.remove();
};
const saveSummary = () => {
    const text = textArea.firstElementChild.value;
    if (text.length < 100) {
        toggleModalGeneric("Error", "Summary must contain at least 100 characters.");
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
            idElement.parentElement.parentElement.remove();
        } else {
            toggleModalGeneric("Error", "Education Data Not Updated");
        }
    });

}; // it is used dude

const removeCurrentExperience = (idElement) => {
    const id = idElement.id;
    removeData('removeExperience', id).then(value => {
        if (value === true) {
            idElement.parentElement.parentElement.remove();
        } else {
            toggleModalGeneric("Error", "Education Data Not Updated");
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
                    if (responseText === '1') {
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
        toggleModalGeneric("Error", "Fields Must not be empty");
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

const ajaxCallUpdateEducationExperience = (functionName = "education", type = "ed") => {
    let crsName = document.getElementById(`course${type}`);
    let insName = document.getElementById(`instituteName${type}`);
    let insCity = document.getElementById(`instituteCity${type}`);
    let fromYear = document.getElementById(`fromYear${type}`);
    let fromMonth = document.getElementById(`fromMonth${type}`);
    let toYear = document.getElementById(`toYear${type}`);
    let toMonth = document.getElementById(`toMonth${type}`);

    crsName = crsName.value;
    crsName = escape(crsName);

    insName = insName.value;
    insName = escape(insName);

    insCity = insCity.value;
    insCity = escape(insCity);

    fromYear = fromYear.value;
    fromMonth = fromMonth.value;
    toYear = toYear.value;
    toMonth = toMonth.value;

    const checkValidityAll = () => {
        return crsName.length <= 0 || insName.length <= 0 ||
            insCity.length <= 0 || fromYear.length <= 0 ||
            toYear.length <= 0 || fromMonth.length <= 0 || toMonth.length <= 0;
    };

    if (checkValidityAll()) {
        toggleModalGeneric("Error", "Field(s) cannot be empty");
        return;
    }

    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=${functionName}&crsName=${crsName}&insName=${insName}&insCity=${insCity}&fromYear=${fromYear}&fromMonth=${fromMonth}&toYear=${toYear}&toMonth=${toMonth}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const responseText = ajaxCall.responseText;
            console.log(responseText);
            if (responseText === '1') {
                toggleModalGeneric("Success", `${functionName.capitalize()} added Successfully`);
            }
        }
    };
};

const addEducationContainer = () => {
    const container = addEducationExperienceContainer();
    educationContainer.insertAdjacentElement("afterend", container);

    const saveButton = document.getElementById("saveEducationed");
    saveButton.onclick = () => {
        ajaxCallUpdateEducationExperience();
    };

    const removeButton = document.getElementById("removeEducationContainered");
    removeButton.onclick = () => {
        container.remove();
    };

    addMonth();
};

const addExperienceContainer = () => {
    const container = addEducationExperienceContainer(
        "newExperienceContainer",
        "Post",
        "Organization Name",
        "Organization City",
        "ex"
    );
    experienceContainer.insertAdjacentElement("afterend", container);

    const saveButton = document.getElementById("saveEducationex");
    saveButton.onclick = () => {
        ajaxCallUpdateEducationExperience("experience", "ex");
    };

    const removeButton = document.getElementById("removeEducationContainerex");
    removeButton.onclick = () => {
        container.remove();
    };

    addMonth("ex");
};

const addMonth = (type = "ed") => {
    const listMonths = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    const selectFromMonth = document.getElementById(`fromMonth${type}`);
    const selectToMonth = document.getElementById(`toMonth${type}`);

    listMonths.forEach(singleMonth => {

        const element = document.createElement("option");
        element.value = singleMonth;
        element.innerHTML = singleMonth;

        const element02 = document.createElement("option");
        element02.value = singleMonth;
        element02.innerHTML = singleMonth;

        selectFromMonth.appendChild(element);
        selectToMonth.appendChild(element02);
    });

    const START_YEAR = 1970;
    const arrayOfYears = Array.from(Array(50).keys()).map(value => {
        return value + START_YEAR
    });

    const selectFromYear = document.getElementById(`fromYear${type}`);
    const selectToYear = document.getElementById(`toYear${type}`);

    arrayOfYears.forEach(singleYear => {
        const element = document.createElement("option");
        element.value = singleYear.toString();
        element.innerHTML = singleYear.toString();

        const element02 = document.createElement("option");
        element02.value = singleYear.toString();
        element02.innerHTML = singleYear.toString();

        selectFromYear.appendChild(element);
        selectToYear.appendChild(element02);
    });
};

const addEducationExperienceContainer = (
    containerId = "newEducationContainer",
    courseName = "Course Name",
    instituteName = "Institute Name",
    instituteCity = "Institute City",
    type = "ed"
) => {
    const mainContainer = document.createElement("div");
    mainContainer.id = containerId;
    mainContainer.innerHTML = `
        <div class="row-name full-width">
            <label for="course" class="zero"></label>
            <input type="text" id="course${type}" placeholder="${courseName}">
        </div>
        <div class="row-name">
            <label for="instituteName" class="zero"></label>
            <input type="text" id="instituteName${type}" placeholder="${instituteName}">

            <label for="instituteCity" class="zero"></label>
            <input type="text" id="instituteCity${type}" placeholder="${instituteCity}">
        </div>
        <div class="row-name">
            <select
                    required
                    class="form-select px-2"
                    aria-label="Default select example"
                    style="width: 408px; height: 50px; border-radius: 5px; margin: 10px; transition: .3s"
                    id="fromYear${type}"
                    name="citySelected"
            >
                <option value="" selected>Select Start Year</option>
            </select>
            <select
                    required
                    class="form-select px-2"
                    aria-label="Default select example"
                    style="width: 408px; height: 50px; border-radius: 5px; margin: 10px; transition: .3s"
                    id="fromMonth${type}"
                    name="citySelected"
            >
                <option value="" selected>Select Start Month</option>
            </select>
        </div>
        <div class="row-name">
            <select
                    required
                    class="form-select px-2"
                    aria-label="Default select example"
                    style="width: 408px; height: 50px; border-radius: 5px; margin: 10px; transition: .3s"
                    id="toYear${type}"
                    name="citySelected"
            >
                <option value="" selected>Select End Year</option>
            </select>
            <select
                    required
                    class="form-select px-2"
                    aria-label="Default select example"
                    style="width: 408px; height: 50px; border-radius: 5px; margin: 10px; transition: .3s"
                    id="toMonth${type}"
                    name="citySelected"
            >
                <option value="" selected>Select End Month</option>
            </select>
        </div>
        <div class="row-name">
            <button id="saveEducation${type}" type="button">Save</button>
            <button id="removeEducationContainer${type}" type="button">Remove</button>
        </div>`;
    return mainContainer;
};

const updateCitiesSelectBox = () => {
    const country = document.getElementById("countries");
    const countryCode = country.value;
    const cities = document.getElementById("cities");
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=getCities&country_code=${countryCode}`, true);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const text = ajaxCall.responseText;
            cities.innerHTML = text;
            cities.disabled = false;
        }
    };
};