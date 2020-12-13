$('#datePicker').datepicker({maxDate: "-18y", minDate: new Date(1970, 1, 1)});

const userData = {
    "firstName": "Muhammad Usama",
    "lastName": "Ali Mardan",
    "emailAddress": "the.mgi@outlook.com",
    "contactNumber": "+923156180891",
    "skills": [
        {"skillTitle": "Angular 2+", "experienceYears": "2 years"},
        {"skillTitle": "HTML", "experienceYears": "2 years"},
        {"skillTitle": "CSS", "experienceYears": "2 years"},
        {"skillTitle": "Bootstrap", "experienceYears": "2 years"},
        {"skillTitle": "Database Design", "experienceYears": "2 years"},
        {"skillTitle": "Advanced Web Scraping", "experienceYears": "2 years"},
        {"skillTitle": "Automation and Scripting", "experienceYears": "2 years"},
        {"skillTitle": "Microsoft Office", "experienceYears": "2 years"},
        {"skillTitle": "Java", "experienceYears": "2 years"},
        {"skillTitle": "Python", "experienceYears": "2 years"}
    ],
    "address": {streetAddress: "Misha Cottage, Main Street, Usman Park, Rahim Yar Khan", country: "Pakistan"},
    "summary": "To seek for a challenging position in a competitive environment, where I can utilize my professional skills and capabilities to excel the organization and myself in future, I am self-motivated, having the capabilities of handling the responsibilities. To obtain a position that will enable me to use my strong organizational skills, award-winning educational background, and ability to work well with people.",
    "education": [
        {
            "courseTitle": "BS in Computer Sciences",
            "instituteName": "COMSATS University",
            "instituteCity": "Islamabad",
            "durationStartYear": 2018,
            "durationStartMonth": 'September',
            "durationEndYear": 2022,
            "durationEndMonth": 'January',
            "isOnGoing": true
        },
        {
            "courseTitle": "Fsc. Pre-Engineering in Sciences",
            "instituteName": "Superior Group Of Colleges",
            "instituteCity": "Rahim Yar Khan",
            "durationStartYear": 2016,
            "durationStartMonth": 'May',
            "durationEndYear": 2018,
            "durationEndMonth": 'April',
            "isOnGoing": false
        }
    ],
    "experience": [
        {
            "organizationName": "Invotyx Software Solutions",
            "orgCity": "Rawalpindi",
            "post": "Internee",
            "durationStartYear": 2020,
            "durationStartMonth": 'January',
            "durationEndYear": 2020,
            "durationEndMonth": 'February',
            "isOnGoing": false
        },
        {
            "organizationName": "Silkbank",
            "orgCity": "Rahim Yar Khan",
            "post": "CSR",
            "durationStartYear": 2016,
            "durationStartMonth": 'March',
            "durationEndYear": 2016,
            "durationEndMonth": 'April',
            "isOnGoing": false
        }
    ]
};

const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const emailAddress = document.getElementById('email');

const actualSummary = document.getElementById('actualSummary');
actualSummary.innerText = userData.summary;

firstName.value = userData.firstName;
lastName.value = userData.lastName;
emailAddress.value = userData.emailAddress;

firstName.disabled = true;
lastName.disabled = true;
emailAddress.disabled = true;

const selectBox = document.getElementById('select-box');
const selectBoxOptions = selectBox.querySelectorAll('option');
selectBoxOptions[0].selected = false;
selectBoxOptions[2].selected = true;
selectBox.disabled = true;

// ==================================================================
const giveMeh4 = (skillTitle, experienceYears) => {
    if (experienceYears.length > 0) {
        if (!experienceYears.toLowerCase().includes('year')) {
            experienceYears = experienceYears.trim() + ' Years';
        }
        experienceYears = ' -- ' + experienceYears.toLowerCase();
    }
    const h4 = document.createElement('h5');
    h4.className = 'space-between';
    h4.innerHTML = `
        <span class="badge rounded-pill span-tag">${skillTitle}${experienceYears}</span>
        <span class="cross" role="button">&#10006;</span>`;
    h4.lastChild.addEventListener('click', function (e) {
        h4.remove();
    });
    return h4;
}
const skillsPencil = document.getElementById('skillsPencil');
const skillsContainer = document.getElementById('skillsContainer');
const addAllSkillsInDoc = () => {
    userData.skills.forEach((singleSkill) => {
        skillsContainer.appendChild(giveMeh4(singleSkill.skillTitle, singleSkill.experienceYears));
    });
};
addAllSkillsInDoc();
const appendSkill = (skillTitle, experienceYears) => {
    skillsContainer.appendChild(giveMeh4(skillTitle, experienceYears))
}
// ==================================================================
const outerEducationContainer = document.getElementById('educationContainer');
const giveMeContainer = (title, institute, city, fromYear, fromMonth, toYear, toMonth) => {
    const mainDiv = document.createElement('div');
    mainDiv.className = 'first';
    mainDiv.innerHTML = `
    <p class="add-margin-5 space-between"><strong><span>${title}</span></strong> <span role="button">&#10006;</span></p>
    <p class="add-margin-5"><span>${institute}</span> - <span>${city}</span></p>
    <p class="add-margin-5">
        <span>${fromMonth}</span>
            <span>${fromYear}</span>
        to
        <span>${toMonth}</span>
            <span>${toYear}</span>
    </p>
    <hr>`
    mainDiv.firstElementChild.lastChild.addEventListener('click', function (e) {
        mainDiv.remove();
    });
    return mainDiv;
};
const addEducationToDoc = () => {
    userData.education.forEach((educationEntry) => {
        outerEducationContainer.appendChild(giveMeContainer(
            educationEntry.courseTitle,
            educationEntry.instituteName,
            educationEntry.instituteCity,
            educationEntry.durationStartYear,
            educationEntry.durationStartMonth,
            educationEntry.durationEndYear,
            educationEntry.durationEndMonth
        ))
    });
};
addEducationToDoc();
// ==================================================================
const experienceContainer = document.getElementById('experienceContainer');
const addExperienceInDoc = () => {
    userData.experience.forEach((educationEntry) => {
        experienceContainer.appendChild(giveMeContainer(
            educationEntry.post,
            educationEntry.organizationName,
            educationEntry.orgCity,
            educationEntry.durationStartYear,
            educationEntry.durationStartMonth,
            educationEntry.durationEndYear,
            educationEntry.durationEndMonth
        ))
    });
};
addExperienceInDoc();
//===================================================================

// const skills = document.getElementById('skills');
// const education = document.getElementById('education');
// const experience = document.getElementById('experience');

const pencilDiv = document.getElementById('topCon');
let textArea;

function summaryToTextarea() {
    textArea = document.createElement('div');
    textArea.className = 'text-area';
    textArea.innerHTML = `
<!--<label for="summary" role="button" id="labelCross">&#10006;</label>-->
    <label for="summary" role="button" id="labelCross"></label>
    <textarea name="summary" id="summary" placeholder="Summary About Yourself">${userData.summary}</textarea>`
    pencilDiv.insertAdjacentElement('afterend', textArea);
    actualSummary.remove();
}

const addButtonSkill = () => {
    const skill = document.getElementById('skillTitle').value;
    const experience = document.getElementById('skillExperience').value;
    appendSkill(
        skill,
        experience
    );
    userData.skills.push({skillTitle: skill, experienceYears: experience});
}

const removeButtonSkill = () => {
    document.querySelector('.add-skill').remove();
}

const addSkill = () => {
    if (document.querySelector('.add-skill')) {
        return; // because the element is already on the DOM
    }
    console.log('i am clicked..!');
    const editFields = document.createElement('div');
    editFields.className = 'add-skill';
    editFields.innerHTML = `<div class="fields">
                        <label for="skillTitle" class="add-skill"></label>
                        <input class="add-skill-input" type="text" id="skillTitle" placeholder="Skill">

                        <label for="skillExperience" class="add-skill"></label>
                        <input class="add-skill-input" type="text" placeholder="Experience Years" id="skillExperience">

                    </div>
                    <div class="fields">
                        <button id="skillAddBtn" type="button">Add</button>
                        <button id="skillAddRemove" type="button">Remove</button>
                    </div>`;
    skillsContainer.parentElement.insertAdjacentElement('afterend', editFields);
    document.getElementById('skillAddBtn').addEventListener('click', addButtonSkill);
    document.getElementById('skillAddRemove').addEventListener('click', removeButtonSkill);
}

const addEventListeners = () => {
    skillsPencil.addEventListener('click', addSkill)
};
addEventListeners();
