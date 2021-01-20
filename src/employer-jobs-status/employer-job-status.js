let mainJobsContainer;

const addAllJobsToPageEmployer = () => {
    const ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("GET", '../CRUD/functions.php?function=addJobsToPageForEmployer', true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = () => {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            console.log(mainJobsContainer);
            mainJobsContainer.innerHTML = ajaxRequest.responseText;
        }
    };
};

const openJobDetails = (eventData) => {
    if (eventData.id.length < 1) {
        return;
    }
    const jobDetails = document.getElementById('jobDetails');

    const ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("GET", `../CRUD/functions.php?function=particularJobEmployer&jobId=${eventData.id}`, true);
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = () => {
        if (ajaxRequest.readyState === 4 && ajaxRequest.status === 200) {
            const text = ajaxRequest.responseText;
            if (window.innerWidth >= 900) {
                jobDetails.innerHTML = text;
            } else {
                toggleModalGeneric("Job Details", text);
            }
        }
    }
};  // it is used dude

const initializeAll = () => {
    mainJobsContainer = document.getElementById('mainJobsContainer');
    addAllJobsToPageEmployer();
};