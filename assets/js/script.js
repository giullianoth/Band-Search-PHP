$(function () {

    // LOADING
    const loadingBars = () => {
        let loading = `
            <div class="bs_main_content_loading j_loading">
            <div class="loading_bar bar1"></div>
            <div class="loading_bar bar2"></div>
            <div class="loading_bar bar3"></div>
            </div>
        `;
        return loading;
    }

    // ERROR
    const errorScreen = (message) => {
        let error = `
            <section class="bs_main_content_error j_error">
            <p>${message}</p>
            </section>
        `;
        return error;
    }

    // DYNAMIC VIEWPORT
    const setViewport = () => {

        let headerHeight = $(".j_header")[0].offsetHeight;
        let footerHeight = $(".j_footer")[0].offsetHeight;

        let windowHeight = window.innerHeight;
        let mainHeight = windowHeight - headerHeight - footerHeight;

        $(".j_main").css("height", `${mainHeight}px`);
        $(".j_form").css("height", `${mainHeight}px`);

        let formHeight = $(".j_form")[0].offsetHeight;
        let resultsHeaderHeight = window.innerWidth < 1024 ? $(".j_results_header").offsetHeight : 0;
        let paddingDiff = window.innerWidth < 1024 ? 40 : 80;
        let resultsListHeight = mainHeight - formHeight - resultsHeaderHeight - paddingDiff;

        if ($(".j_results_list")) {
            $(".j_results_list").css("height", `${resultsListHeight}px`);
        }

        if ($(".j_error")) {
            $(".j_error").css("height", `${resultsListHeight}px`);
        }
    }

    setViewport();
    window.onresize = setViewport;

    // LIST HEADER
    const socialItemElement = (network, link) => {

        const socialInfos = {
            facebook: {
                color: "#1877F2",
                title: "Facebook",
            },

            instagram: {
                color: "#D62976",
                title: "Instagram",
            },

            youtube: {
                color: "#FE0002",
                title: "YouTube",
            },

            twitter: {
                color: "#1DA1F2",
                title: "Twitter",
            },

            spotify: {
                color: "#1ED760",
                title: "Spotify",
            },

            itunes: {
                color: "#EA4CC0",
                title: "iTunes",
            }
        }

        let isValidSocialNetwork = network && link ? Object.keys(socialInfos).some((social) => social === network) : false;

        if (!isValidSocialNetwork) {
            return "";
        }

        let socialItem = `
            <li>
            <a href="${link}" target="_blank" style="background-color: ${socialInfos[network].color};">${socialInfos[network].title}</a>
            </li>
        `;

        return socialItem;
    }

    const listHeader = ({ mainTitle, socialInfo }) => {

        let socialNetworks = socialInfo ? Object.keys(socialInfo) : [];
        let socialLinks = socialInfo ? Object.values(socialInfo).map((item) => item[0].url) : [];

        let socialList = "";

        socialNetworks.forEach((network, index) => {
            socialList += socialItemElement(network, socialLinks[index]);
        });

        let listHeaderElement = `
        <div class="bs_main_content_results_header j_results_header">
        <header class="bs_main_content_results_header_title">
        <h1>${mainTitle}</h1>
        </header>
        <ul class="bs_main_content_results_header_desc">${socialList}</ul>
        <button class="back">Voltar</button>
        </div>
        `;

        return listHeaderElement;
    }

    // RESULTS LIST
    const listItemElement = (data) => {

        let { thumbnails, title, description } = data.snippet;

        let itemElement = `
        <article class="bs_main_content_results_list_item j_results_list_item" data-url="${data.id.videoId}">
        <div class="bs_main_content_results_list_item_thumbnail">
        <div class="img open_modal" style="background-image: url('${thumbnails.medium.url}');"></div>
        </div>
        <div class="bs_main_content_results_list_item_info">
        <header class="bs_main_content_results_list_item_info_title">
        <h2 class="open_modal">${title}</h2>
        </header>
        <p class="bs_main_content_results_list_item_info_desc open_modal">${description}</p>
        </div>
        </article>
        `;

        return itemElement;
    }

    const listElement = (list) => {

        let listArea = "";

        list.forEach((item) => {
            listArea += listItemElement(item);
        })

        let listAreaElement = `
        <div class="bs_main_content_results_list j_results_list" style="height: 698px;">${listArea}</div>
        `;

        return listAreaElement;
    }

    // DARK THEME
    $(".j_switch").on("click", () => {
        $("body").toggleClass("dark_theme");

        let isDarkTheme = $("body").hasClass("dark_theme");
        $(".j_theme_logo").attr("src", `assets/images/${isDarkTheme ? "logo_light" : "logo_dark"}.png`);
        $(".j_card_container").css("background-image", `url(assets/images/${isDarkTheme ? "cant-see" : "my-eyes"}.gif)`);
        $(".j_switch").attr("title", isDarkTheme ? "Muito escuro? Mude para o tema claro." : "Muito claro? Mude para o tema escuro.");
    })

    // AJAX FORM
    $(".j_search").on("submit", (event) => {
        event.preventDefault();

        if ($(".j_error")) {
            $(".j_error").remove();
        }

        $(".j_results").fadeOut().html("");

        let formSearch = $(this);
        let searchValue = formSearch.find("#search").val();

        $(".j_form").addClass("list");
        $(".j_main_content").append(loadingBars()).find(".j_loading").css("display", "none").fadeIn();

        $.ajax({
            url: window.location.href,
            method: "POST",
            data: { search: searchValue },
            dataType: "json"
        }).done((response) => {
            $(".j_loading").remove();

            if (response.error) {
                $(".j_main_content").append(errorScreen(response.error));
            } else {
                $(".j_results")
                    .append(listHeader(response))
                    .append(listElement(response.listItems))
                    .fadeIn();
            }

            setViewport();
        })
    })
})