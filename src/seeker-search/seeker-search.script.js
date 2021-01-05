// $(document).ready(() => {
//     $(window).scroll(() => {
//         const scroll = $(window).scrollTop();
//         const jobDetailsContainer = $("#jobDetails");
//         if (scroll > 150) {
//             jobDetailsContainer.css("position", "sticky");
//             jobDetailsContainer.css("right", 0);
//             jobDetailsContainer.css("z-index", "1");
//         } else {
//             console.log("less than 150");
//             jobDetailsContainer.css("position", "none");
//         }
//     });
// });

let mainJobsContainer;
let companiesSelectBox;
const initializeAll = () => {
    mainJobsContainer = document.getElementById('mainJobsContainer');
    companiesSelectBox = document.getElementById('companies');
    addAllJobsToPage();
    addCompaniesToSelectBox();

};
// ==================================================================
const addCompaniesToSelectBox = () => {
    const ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("GET", "../CRUD/functions.php?function=populateCompaniesSelectBox", true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = () => {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            console.log(companiesSelectBox);
            companiesSelectBox.innerHTML = ajaxRequest.responseText;
        }
    };
};
const addAllJobsToPage = () => {
    const ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("GET", '../CRUD/functions.php?function=addJobsToPage', true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = () => {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            console.log(mainJobsContainer);
            mainJobsContainer.innerHTML = ajaxRequest.responseText;
        }
    };
};

const openJobDetails = (eventData) => {

    const ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("GET", `../CRUD/functions.php?function=particularJob&jobId=${eventData.id}`, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = () => {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            const jobDetails = document.getElementById('jobDetails');
            jobDetails.innerHTML = ajaxRequest.responseText;
        }
    }
};  // it is used dude

function makeAjaxCall(eventData, functionString) {
    const string = eventData.value;
    const ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("GET", `../CRUD/functions.php?function=${functionString}&searchString=${string}`, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = () => {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            mainJobsContainer.innerHTML = ajaxRequest.responseText;
        }
    };
}


