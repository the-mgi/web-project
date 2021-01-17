const afterOnload = (aboutPath = '../about-us/about-us.page.php', blogsPreview = '../blog-preview/blog-preview.page.php') => {
    const currentPath = window.location.pathname;
    if (currentPath.indexOf("about-us") > -1) { // i am already on about-us-page
        aboutPath = '#';
    } else if (currentPath.indexOf("blog-preview") > -1) { // i am already on blog-preview-page
        blogsPreview = '#';
    }
    const body = document.querySelector("body");
    const footer = document.createElement("footer");
    footer.innerHTML = `
    <div class="footer-main-row-def">
        <div class="col-zero col-footer">
            <h3 class="footer-h3">Our Company</h3>
            <h5><span class="fa fa-id-card-alt span-footer"></span> <a href="${aboutPath}">About
                    Us</a></h5>
            <h5><span class="fas fa-blog span-footer"></span> <a href="${blogsPreview}">Blogs</a>
            </h5>
        </div>
        <div class="col-two col-footer">
            <h3 class="footer-h3">Follow Us</h3>
            <h5><span class="fa fa-facebook-square span-footer"></span> <a href="https://www.facebook.com/job.stash"
                                                                           target="_blank">Facebook</a></h5>
            <h5><span class="fa fa-twitter-square span-footer"></span> <a href="https://twitter.com/JobStash?s=20"
                                                                          target="_blank">Twitter</a></h5>
            <h5><span class="fa fa-linkedin-square span-footer"></span> <a
                        href="https://www.linkedin.com/in/job-stash-55bb66201/" target="_blank">LinkedIn</a></h5>
        </div>

        <div class="col-two col-footer">
            <h3 class="footer-h3">Contact Us</h3>
            <h5><span class="fa fa-envelope span-footer"></span> <span role="button"
                                                                       id="openMail">support@josbstash.com</span></h5>
            <h5><span class="fa fa-phone span-footer"></span> <span role="button">+923156180891</span></h5>
            <h5><span class="fab fa-telegram span-footer"></span> <span role="button">@jobstash</span></h5>
        </div>

        <div class="col-one col-footer">
            <h3 class="footer-h3">Newsletter</h3>
            <label for="letter-email" id=""></label>
            <input class="news-e" type="email" placeholder="Email Address" id="letter-email">
            <button class="blue-on-white button-300" onclick="addEmailToTable()">Sign Up For News Letter</button>
        </div>
    </div>
    <div class="outer">
        <div class="bottom-rights">
            <span class="fa fa-copyright"></span>
            <span>themgi inc. </span>
            <span>2020 All Right Reserved</span>
        </div>
    </div>`;
    body.appendChild(footer);
    document.getElementById('openMail').addEventListener('click', () => {
        window.open("mailto:" + 'job.stash.themgi@gmail.com' + '?cc=' + '' + '&subject=' + 'Need Support' + '&body=' + 'Type Your Query Message Here');
    });

    const addModal = () => {
        const main = document.querySelector("main");
        const divContainer = document.createElement("div");
        divContainer.className = 'modal fade';
        divContainer.id = "exampleModal";
        divContainer.tabIndex = -1;
        divContainer.setAttribute("aria-labelledby", "exampleModalLabel");
        divContainer.setAttribute("aria-hidden", "true");
        divContainer.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 60px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: 100px;">Close
                    </button>
                </div>
            </div>
        </div>`;
        main.appendChild(divContainer);
    };
    addModal();
};

const toggleModalGeneric = (modalTitle, modalBody) => {
    const content = document.getElementById("content");
    const title = document.getElementById("exampleModalLabel");
    content.innerText = modalBody;
    title.innerText = modalTitle;
    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
    });
    myModal.toggle();
};

const addEmailToTable = () => {
    console.log("i am called");
    let value = document.getElementById("letter-email");
    value = value.value;
    if (value.length === 0) {
        toggleModalGeneric("Error", "Email not valid");
        return;
    }
    const ajaxCall = new XMLHttpRequest();
    ajaxCall.open("GET", `./CRUD/functions.php?function=subscribeToNewsletter&emailNewsLetter=${value}`);
    ajaxCall.send();
    ajaxCall.onreadystatechange = () => {
        if (ajaxCall.readyState === 4 && ajaxCall.status === 200) {
            const text = ajaxCall.responseText;
            if (text === '1') {
                toggleModalGeneric("Success", "Email Added to newsletter");
            }
        }
    };
};