class LazyLoad {
    constructor($wrapper) {
        this.$wrapper = $wrapper;
        this.$moreWrapper = $wrapper.find(".js-lazy-load-more-wrapper");
        this.$contentWrapper = $wrapper.find(".js-lazy-load-content");
        this.$paginationWrapper = $wrapper.find(
            ".js-lazy-load-more-pagination"
        );

        this.eventHandler();

        this.loadByFilter = href => {
            this.request(href, this.filterRender);
        };

        return this;
    }

    eventHandler() {
        let self = this;

        this.$wrapper.find(".js-lazy-load-more-link").on("click", function() {
            launchWindowPreloader();
            self.request($(this).attr("href"), self.lazyRender);
            return false;
        });

        this.$wrapper.find(".js-lazy-load-paginate").on("click", function() {
            launchWindowPreloader();
            self.request($(this).attr("href"), self.paginateRender);
            return false;
        });
    }

    request(href, render) {
        let resultUrl =
            href.indexOf("?") != -1
                ? href + "&ACTION=AJAX_LAZY"
                : href + "?ACTION=AJAX_LAZY";

        axios
            .get(resultUrl)
            .then(response => {
                render.call(this, response.data);

                this.eventHandler();

                history.pushState(null, null, href);
                stopWindowPreloader();
            })
            .catch(() => {
                messageError({ title: "Ошибка при загрузке данных" });
                stopWindowPreloader();
            });
    }

    lazyRender(data) {
        if (typeof data.content != "undefined") {
            this.$contentWrapper.append(data.content);
        }

        if (typeof data.more != "undefined") {
            this.$moreWrapper.html(data.more);
        }

        if (typeof data.pagination != "undefined") {
            this.$paginationWrapper.html(data.pagination);
        }
    }

    paginateRender(data) {
        if (typeof data.content != "undefined") {
            this.$contentWrapper.html(data.content);
        }

        if (typeof data.more != "undefined") {
            this.$moreWrapper.html(data.more);
        }

        if (typeof data.pagination != "undefined") {
            this.$paginationWrapper.html(data.pagination);
        }

        $("html, body").animate(
            { scrollTop: this.$contentWrapper.offset().top - 20 },
            500
        );
    }

    filterRender(data) {
        if (typeof data.content != "undefined") {
            this.$contentWrapper.html(data.content);
        }

        if (typeof data.more != "undefined") {
            this.$moreWrapper.html(data.more);
        }

        if (typeof data.pagination != "undefined") {
            this.$paginationWrapper.html(data.pagination);
        }
    }
}

export default LazyLoad
