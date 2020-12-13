$(document).ready(function () {
    $(window).scroll(() => {
        const scroll = $(window).scrollTop();
        const navbar = $(".navbar");
        let backColor = '#5890FF';
        let borderProps = '0 0 3px 1px #000000';
        if (window.innerWidth > 900) {
            if (scroll < 300) {
                backColor = 'transparent';
                borderProps = 'none';
            }
            navbar.css("background-color", backColor);
            navbar.css("box-shadow", borderProps);
        } else {
            navbar.css("background-color", '#5890FF');
            navbar.css("box-shadow", `none`);
        }
    });
})
