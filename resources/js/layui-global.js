/**
 * 初始化layui
 * 用于布局
 */

layui.use(['element', 'jquery'], function () {
    let element = layui.element,
        $ = layui.jquery;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    });

    // 展开收起菜单
    $(".newidc-nav-show-button").on('click', function () {
        let nav = $("#newidc-nav");
        let width = $(window).width();
        if (width > 768) {
            if (nav.is(":hidden")) {
                nav.css("width", "0");
                nav.show();
                nav.animate({width: '200px'}, function () {
                    nav.css("width", "");
                });
                changeMenuIcon(1, 1);
                modBodyLeft(width, false)
            } else {
                nav.animate({width: '0'}, function () {
                    nav.css("width", "");
                    nav.hide();
                });
                changeMenuIcon(1, 2);
                modBodyLeft(width, true)
            }
        } else {
            nav.slideToggle(function () {
                let hidden = nav.is(":hidden");
                changeMenuIcon(width > 768 ? 1 : 2, hidden ? 2 : 1);
                modBodyLeft(width)
            });

        }
    });

    $(window).on('resize', () => {
        setMenuStatus()
    });

    $(document).ready(() => {
        setMenuStatus();
        const url = window.location.href;
        let candidate = null;
        $(".layui-side .layui-nav-item a").each(function () {
            let href = $(this).attr("href");
            if (url === href) {
                candidate = this;
                return false
            } else if (url.indexOf(href) !== -1) {
                if (candidate === null || $(candidate).attr("href").length < href.length)
                    candidate = this;
            }
        });
        setMenuItemActive(candidate)
    });

    function setMenuItemActive(obj) {
        if (!obj || $(obj).length === 0) return;
        let parent = $(obj).parent();
        parent.addClass("layui-this");
        if (parent.is("dd"))
            parent.parent().parent().addClass("layui-nav-itemed")
    }

    function setMenuStatus() {
        let width = $(window).width();
        let hidden = $("#newidc-nav").is(":hidden");
        changeMenuIcon(width > 768 ? 1 : 2, hidden ? 2 : 1);
        modBodyLeft(width, hidden, true)
    }

    function modBodyLeft(width, hidden, immediate = false) {
        let body = $("#newidc-body");
        let footer = $('.newidc-footer');
        if (immediate) {
            body.css("left", width <= 768 || hidden ? "0" : "");
            footer.css("left", width <= 768 || hidden ? "0" : "")
        } else {
            body.animate({left: width <= 768 || hidden ? "0" : "200px"}, function () {
                if (body.css("left") === "200px") body.css("left", "")
            })
            footer.animate({left: width <= 768 || hidden ? "0" : "200px"}, function () {
                if (body.css("left") === "200px") body.css("left", "")
            })
        }
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
