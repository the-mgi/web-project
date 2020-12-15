// ==================================================================
const companiesSelectBox = document.getElementById('companies');
const getAllCompaniesFromDB = () => {
    return [
        {"companyName": 'Facebook', "companyID": 'comp01'},
        {"companyName": 'Apple', "companyID": 'comp02'},
        {"companyName": 'Netflix', "companyID": 'comp03'},
        {"companyName": 'Google', "companyID": 'comp04'}
    ];
};
const addCompaniesToSelectBox = () => {
    const allCompanies = getAllCompaniesFromDB();
    allCompanies.sort((a, b) => {
        const first = a.companyName;
        const second = b.companyName;
        return (first > second) ? 1 : (first < second) ? -1 : 0;
    });
    console.log('i am good');
    allCompanies.forEach(singleCompany => {
        const newOption = document.createElement('option');
        newOption.value = singleCompany.companyID;
        newOption.innerText = singleCompany.companyName;
        companiesSelectBox.appendChild(newOption);
    });
};
addCompaniesToSelectBox();
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
            "companyID": 'Google Inc.'
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
            "companyID": 'Facebook Inc.'
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
            "companyID": 'Apple Inc.'
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
            "companyID": 'Netflix Inc.'
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
        <p><span><strong>Summary</strong></span> <br> <span>${singleJob.jobDescription}</span></p>`
        mainJobsContainer.appendChild(singleJobContainer);
    });
};
getTopTenJobsFromDbAndAddInPage();

