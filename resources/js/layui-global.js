/**
 * 初始化layui
 * 用于布局
 */

layui.use(['element','jquery'],() => {
    let element = layui.element,
        $ = layui.jquery;

    $(".newidc-nav-show-button").on('click', () => {
        let nav = $("#newidc-nav");
        let width = $(window).width();
        if (width > 768) {
            if (nav.is(":hidden")) {
                nav.css("width","0");
                nav.show();
                nav.animate({width: '200px'},() => {
                    nav.css("width","");
                });
                changeMenuIcon(1, 1);
                modBodyLeft(width, false)
            } else {
                nav.animate({width: '0'},() => {
                    nav.css("width","");
                    nav.hide();
                    changeMenuIcon(1, 2);
                    modBodyLeft(width, true)
                });
            }
        } else {
            nav.slideToggle(() => {
                let hidden = nav.is(":hidden");
                changeMenuIcon(width > 768 ? 1 : 2, hidden ? 2 : 1);
                modBodyLeft(width, hidden ? 2 : 1)
            });

        }
    });

    $(window).on('resize',() => {
        setMenuStatus()
    });

    $(document).ready(() => {
        setMenuStatus()
    });

    function setMenuStatus() {
        let width = $(window).width();
        let hidden = $("#newidc-nav").is(":hidden");
        changeMenuIcon(width > 768 ? 1 : 2, hidden ? 2 : 1);
        modBodyLeft(width, hidden)
    }

    function modBodyLeft(width, hidden) {
        $("#newidc-body").css("left", width<=768||hidden?"0":"")
    }

    function changeMenuIcon(type, status) {
        let icon = $(".newidc-nav-show-button .layui-icon");
        // type是PC:1还是移动:2 status是收:1还是展:2
        if (type === 1 && status === 1) {
            icon.html("&#xe668;")
        } else if (type === 1 && status === 2) {
            icon.html("&#xe66b;")
        } else if (type === 2 && status === 1) {
            icon.html("&#xe619;")
        } else if (type === 2 && status === 2) {
            icon.html("&#xe61a;")
        }
    }
});
