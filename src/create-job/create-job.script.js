const form = document.getElementById("jobCreateForm");
let allPatterns = {
    jobName: /^(([A-Z.])\w+).{15,100}$/i,
    eligibilityCriteria: /^(([A-Z.])\w+).{100,1000}$/im,
    jobDesc: /^(([A-Z.])\w+).{500,2000}$/im,
    jobResp: /^(([A-Z.])\w+).{200,500}$/im
};
const makeVisible = (eventData) => {
    validateFormOwn(eventData.name, eventData.value) ?
        eventData.nextElementSibling.className = 'is-invalid' :
        eventData.nextElementSibling.className = 'is-invalid visibility';

};
const validateFormOwn = (name, value) => {
    const fieldName = allPatterns[name];
    return fieldName.test(value);
};
const forward = () => {
    const jobName = document.getElementById("jobName");
    const eligibility = document.getElementById("eligibilityCriteria");
    const jobDesc = document.getElementById("jobDesc");
    const jobResp = document.getElementById("jobResp");
    if (
        validateFormOwn("jobName", jobName.value) &&
        validateFormOwn("eligibilityCriteria", eligibility.value) &&
        validateFormOwn("jobDesc", jobDesc.value) &&
        validateFormOwn("jobResp", jobResp.value)
    ) {
        form.onsubmit = () => {return true;};
    }
};
