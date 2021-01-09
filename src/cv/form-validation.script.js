const form = document.getElementById("cvForm");
const allPatternsO = {
    contact: /[0-9]{11}/,
    summary: /^(([A-Z.])\w+).{100,500}$/im,
    streetAddress: /[a-zA-Z0-9]/i,
    area: /[a-zA-z0-9]/i,
    city: /[a-zA-Z]/i,
    state: /[a-zA-Z]/i,
    country: /[a-zA-Z]/i

};

const makeVisibleDiv = (eventData) => {
      validateFormO(eventData.name, eventData.value) ?
          eventData.nextElementSibling.className = 'is-invalid' :
          eventData.nextElementSibling.className = 'is-invalid visibility';
};

const validateFormO = (name, value) => {
    const fieldName = allPatternsO[name];
    return fieldName.test(value);
};

const forwardO = () => {
    const contactNumber = document.getElementById("contact");
    const summary = document.getElementById("actualSummary");
    if (validateFormO('contact', contactNumber.value)) {
        form.onsubmit = () => {return true;};
    }
};