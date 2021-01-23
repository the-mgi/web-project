let container;
let allBlogs; // object
/**
 * will contain all the blogs preview data, for the purpose of sorting
 * later, and not making the ajax call, to reduce the overhead.
 */

const allInitializations = () => {
    container = document.getElementById("allPreviews");
    addBlogPreviews();
};

const addBlogPreviews = () => {
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", "../CRUD/functions.php?function=addBlogPreview");
    ajaxCall.send()
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            allBlogs = ajaxCall.responseText;
            allBlogs = JSON.parse(allBlogs);
            writeOnDocument(allBlogs);
        }
    };
};

const sortBlogs = (eventData) => {
    const selectedValue = eventData.value;
    if (selectedValue === 'showBookmarked') {
        container.innerHTML = '';
        writeOnDocument(allBlogs.filter(currentValue => {
            return currentValue["isBookmarked"] === 'TRUE';
        }));
        return;
    }
    let sortFunction;
    switch (selectedValue) {
        case 'date':
            sortFunction = (a, b) => {
                return a["writtenDate"] - b["writtenDate"]
            };
            break;
        case 'numberOfReads':
            sortFunction = (a, b) => {
                return b["numberOfTimesRead"] - a["numberOfTimesRead"]
            };
            break;
        case 'readingTime':
            sortFunction = (a, b) => {
                return a["minsRead"] - b["minsRead"]
            };
            break;
        case 'showBookmarked':
            break;
    }
    allBlogs = allBlogs.sort(sortFunction);
    writeOnDocument(allBlogs);
};

const writeOnDocument = (allBlogs) => {
    container.innerHTML = '';
    if (allBlogs.length === 0) {
        const emptyContainer = document.createElement("div");
        emptyContainer.className = 'empty-container';
        emptyContainer.innerHTML = "You've not bookmarked any blogs yet.";
        container.appendChild(emptyContainer);
        return;
    }
    allBlogs.forEach(singleBlog => {
        const mainContainer = document.createElement("div");
        let imageSource = "";
        singleBlog["isBookmarked"] === "TRUE" ?
            imageSource = "../assets/svgs/bookmarkFilled.svg" :
            imageSource = "../assets/svgs/bookmark.svg";
        mainContainer.className = 'container-o';
        mainContainer.innerHTML = `
            <a href='../complete-blog/complete-blog.page.php?id=${singleBlog["blogID"]}' style='text-decoration: none; color: inherit;'>
                <div class='blog-preview' id=${singleBlog["blogID"]}>
                    <div class='hover-written-by'>${singleBlog["writtenBy"]}</div>
                    <div class='con'>
                        <div class='col'>
                            <h2>${singleBlog["heading"]}</h2>
                            <h3>${singleBlog["description"]}</h3>
                        </div>
                        <div class='row'>
                            <div class='right row'>
                                <p class='for-margin' style='margin-right: 30px'>
                                    <span>&#128339;</span>
                                    Reads:
                                    <span>${singleBlog["numberOfTimesRead"]}</span>
                                </p>
                                <p class='for-margin'>
                                    <span>&#128214;</span>
                                    <span>${singleBlog["minsRead"]}</span>
                                    mins read
                                </p>
                                <p class='for-margin'>
                                    <span>&#128198;</span>
                                    <span>${singleBlog["writtenDate"]}</span>
                                </p>
                                <p class="for-margin">
                                    <span><img src="${imageSource}" alt="bookmark-icon" style="width: 18px;opacity: .6;"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
    `;
        container.appendChild(mainContainer);
    });
}