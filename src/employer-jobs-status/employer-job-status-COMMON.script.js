// ==================================================================
const mainJobsContainer = document.getElementById('mainJobsContainer');
const getFirstTenJobsFromDB = () => {
    // first need to get all the jobs, then need to replace company id with company name
    // as that resides in another database table
    return [
        {
            "jobID": 'job01',
            "postedBy": 'emp01',
            "postName": 'Customer Sales Representative',
            "jobDescription": 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            "eligibilityCriteria": 'these are the eligibility criterion to be able to apply for the job',
            "responsibilities": 'these are the list of responsibilities which you will be given on this job',
            "jobCity": 'Islamabad',
            "minimumPay": '10000',
            "maximumPay": '20000',
            "companyID": 'Google Inc.',
            "jobStatus": "Open"
        },
        {
            "jobID": 'job02',
            "postedBy": 'emp01',
            "postName": 'Customer Sales Representative',
            "jobDescription": 'this is the complete description of this job',
            "eligibilityCriteria": 'these are the eligibility criterion to be able to apply for the job',
            "responsibilities": 'these are the list of responsibilities which you will be given on this job',
            "jobCity": 'Islamabad',
            "minimumPay": '10000',
            "maximumPay": '20000',
            "companyID": 'Facebook Inc.',
            "jobStatus": "Closed"
        },
        {
            "jobID": 'job03',
            "postedBy": 'emp01',
            "postName": 'Customer Sales Representative',
            "jobDescription": 'this is the complete description of this job',
            "eligibilityCriteria": 'these are the eligibility criterion to be able to apply for the job',
            "responsibilities": 'these are the list of responsibilities which you will be given on this job',
            "jobCity": 'Islamabad',
            "minimumPay": '10000',
            "maximumPay": '20000',
            "companyID": 'Apple Inc.',
            "jobStatus": "Open"
        },
        {
            "jobID": 'job04',
            "postedBy": 'emp01',
            "postName": 'Customer Sales Representative',
            "jobDescription": 'this is the complete description of this job',
            "eligibilityCriteria": 'these are the eligibility criterion to be able to apply for the job',
            "responsibilities": 'these are the list of responsibilities which you will be given on this job',
            "jobCity": 'Islamabad',
            "minimumPay": '10000',
            "maximumPay": '20000',
            "companyID": 'Netflix Inc.',
            "jobStatus": "Closed"
        },
    ];
}
const getTopTenJobsFromDbAndAddInPage = () => {
    const tenJobs = getFirstTenJobsFromDB();
    tenJobs.forEach(singleJob => {
        const singleJobContainer = document.createElement('div');
        singleJobContainer.className = 'single-container mb-3';
        singleJobContainer.innerHTML = ` 
        <h3>${singleJob.postName}</h3>
        <h5>by: <strong>${singleJob.companyID}</strong></h5>
        <p><span><strong>Summary</strong></span> <br> <span>${singleJob.jobDescription}</span></p>
`
        const className = 'badge rounded-pill ' + (singleJob.jobStatus === 'Open' ? 'bg-primary' : 'bg-danger');
        const statusDisplay = document.createElement('h5');
        statusDisplay.innerHTML = `<strong>Job Status: </strong> <span class="${className}" style="color: white; font-size: 18px;">${singleJob.jobStatus}</span>`;
        singleJobContainer.appendChild(statusDisplay);
        mainJobsContainer.appendChild(singleJobContainer);
    });
};
getTopTenJobsFromDbAndAddInPage();
