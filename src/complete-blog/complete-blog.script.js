let blogContainer;
let popup;
const initializationsVars = () => {
    blogContainer = document.getElementById("con");
    popup = document.getElementById("popup");
};

/**
 * getting value of id from link
 * converting the link's {window.location.search} into json, for future use
 */
const getLinkObject = () => {
    const link = window.location.search.substring(1); // missing out (?)
    const array = link.split("&");  // splitting into array using (&) to get all search Queries
    const finalArray = {};
    array.forEach(singleQuery => {
        const keyValuePairs = singleQuery.split("=");  // splitting again to get the key value pair
        finalArray[`${keyValuePairs[0]}`] = keyValuePairs[1]
    });
    return finalArray;  // resulting json object
};

const bookmarkAddOrRemove = (eventData) => {
    const blogId = getLinkObject()["id"];
    let text;
    let path;

    const imageSrc = eventData.firstElementChild.getAttribute("src");
    let choice;
    imageSrc.indexOf("Filled") > -1 ?
        (choice = "remove", text = "Bookmark Removed", path = "../assets/svgs/bookmark.svg") :
        (choice = "add", text = "Bookmark Added", path = "../assets/svgs/bookmarkFilled.svg");

    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `../CRUD/functions.php?function=addOrRemoveBookmark&choice=${choice}&blogID=${blogId}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const responseText = ajaxCall.responseText;
            responseText === 'FALSE' ?
                (text = "Status not Updated", toggleModalGeneric("Error", "You need to be Signed in to bookmark blogs.<br>Sign in <a href='../login/login.page.php'><ins>Here</ins></a>"), path = imageSrc) :
                undefined;
            popup.innerHTML = text;
            popup.style.visibility = "visible";
            eventData.firstElementChild.setAttribute("src", path)
            setTimeout(() => {
                popup.style.visibility = "hidden";
            }, 1000);
        }
    };
}; // it is used dude
