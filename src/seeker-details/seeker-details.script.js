let mainDivContainer
let userId;
const initializeVariables = () => {
    mainDivContainer = document.querySelector(".user-data");
    userId = mainDivContainer.id;
    addData();
};

const addData = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=writeSkillsEmployer&userID=${userId}`, true);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const skillsGot = ajaxCall.responseText;
            const skillCon = document.createElement("div");
            skillCon.innerHTML = skillsGot;
            mainDivContainer.appendChild(skillCon);
            addEducationData();
        }
    };
}

const addEducationData = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=addEducationDataEmployer&userID=${userId}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const responseText = ajaxCall.responseText;
            const educationCon = document.createElement("div");
            educationCon.innerHTML = responseText;
            mainDivContainer.appendChild(educationCon);
            addExperienceData();
        }
    };
};

const addExperienceData = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=addExperienceDataEmployer&userID=${userId}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const responseText = ajaxCall.responseText;
            const experience = document.createElement("div");
            experience.innerHTML = responseText;
            mainDivContainer.appendChild(experience);
        }
    };
};

const hireSeeker = () => {

    const getSalary = (statement = "What will be your initial salary Package?") => {
        while (true) {
            let salaryOffered = prompt(statement);
            if (+salaryOffered || salaryOffered.length === 0) {
                return salaryOffered;
            }
            statement = "You have entered an invalid value.\nEnter package again?"
        }
    };

    let seekerId = document.querySelector(".user-data");
    seekerId = seekerId.id;
    let jobId = window.localStorage["jobId"];
    let salaryOffered = getSalary();
    if (salaryOffered.length === 0) {
        toggleModalGeneric("Error", "The seeker cannot be hired");
        return;
    }

    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=hireSeeker&seekerId=${seekerId}&jobId=${jobId}&salaryOffered=${salaryOffered}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const responseText = ajaxCall.responseText;
            console.log(responseText);
            if (responseText === '1') {
                window.location.href = '../employer-jobs-status/employer-jobs-status.page.php';
            } else {
                toggleModalGeneric("Error", "The seeker cannot be hired");
            }
        }
    };
};

const deleteJobApplication = () => {
    let seekerId = document.querySelector(".user-data");
    seekerId = seekerId.id;
    let jobId = window.localStorage["jobId"]
    console.log("in method");

    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=deleteJobApplication&jobId=${jobId}&seekerId=${seekerId}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        console.log("in function");
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const responseText = ajaxCall.responseText;
            console.log(responseText);
            if (responseText === '1') {
                window.location.href = '../employer-jobs-status/employer-jobs-status.page.php';
            } else {
                toggleModalGeneric("Error", `The application of <strong>${seekerId}</strong> is NOT deleted.`);
            }
        }
    };
}; // this is used dude