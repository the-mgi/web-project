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


