document.getElementById('openMail').addEventListener('click', () => {
    console.log('i am good');
    window.open("mailto:" + 'job.stash.themgi@gmail.com' + '?cc=' + '' + '&subject=' + 'Need Support' + '&body=' + 'Type Your Query Message Here');

});
const array = [];
const validateForm = (eventData) => {
    const allPatterns = {
        firstName: /[a-zA-Z]{5,10}/i,
        lastName: /[a-zA-Z]{5,10}/i,
        username: /^[a-z0-9]{5,12}$/i,
        email: /^([a-z0-9.-]+)@([a-z0-9-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/,
        password: /((?=.*[0-9])+(?=.*[A-Z])+(?=.*[a-zA-Z]{6,})){8,20}/
    }
    const name = allPatterns[eventData.name];
    if (!name.test(eventData.value)) {
        eventData.nextElementSibling.className = 'is-invalid visibility';
        const index = array.indexOf(name);
        index > -1 ? array.splice(index, 1) : undefined;
        return;
    }
    eventData.nextElementSibling.className = 'is-invalid';
    array.indexOf(name) < 0 ? array.push(name) : undefined;
};

const validateFirstName = () => {
    return array.indexOf('firstName') > -1;
};
const validateLastName = () => {
    return array.indexOf('lastName') > -1;
};
const validateUsername = () => {
    return array.indexOf('username') > -1;
};
const validatePassword = () => {
    return array.indexOf('password') > -1;
};

const validateEmailAddress = () => {
    return array.indexOf('email') > -1;
};

const common = () => {
    document.getElementById('formSignUp').onsubmit = () => {
        return true;
    };
};

const validateAll = () => {
    if (validateFirstName() && validateLastName() && validateEmailAddress() && validatePassword() && validateUsername()) {
       common();
    }
};

const forForgotPassword = () => {
    if (validateEmailAddress()) {
        common();
    }
};

const forLogin = () => {
  if (validateUsername() && validatePassword()) {
      common();
  }
};