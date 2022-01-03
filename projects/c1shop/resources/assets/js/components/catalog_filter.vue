<template>
    <div class="b-catalog-filter">

        <!--марка-->
        <div class="catalog-filter__item" v-if="json_AllParameterFilter.mark && json_ExistentFilter.mark">
            <div class="filter-item__title">
                Марка
                <svg class="icon icon-33"><use xlink:href="#33"></use></svg>
            </div>
            <div class="filter-item__selects">

                <div v-for="filter in json_AllParameterFilter.mark"
                     class="wrap-checkbox filter-item__option"
                     v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.mark[filter.value] != filter.value && json_ActiveFilter.mark != filter.value  }"
                    >
                    <input name="mark"
                           v-model="settingFilter.mark"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="filter.value"
                           v-on:click="setThisFilterParam('mark')"
                           class="checkbox">
                    <label v-bind:for="filter.value" class="checkbox-label">
                        <span class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </span>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--тип оборудования-->
        <div class="catalog-filter__item"  v-if="json_AllParameterFilter.type && json_ExistentFilter.type">
            <div class="filter-item__title">
                Тип оборудования
                <svg class="icon icon-33"><use xlink:href="#33"></use></svg>
            </div>

            <div class="filter-item__selects">

                <div v-for="filter in json_AllParameterFilter.type"
                     class="wrap-checkbox filter-item__option"
                     v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.type[filter.value] != filter.value && json_ActiveFilter.type != filter.value  }">
                    <input name="type"
                           v-model="settingFilter.type"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="filter.value"
                           v-on:click="setThisFilterParam('type')"
                           class="checkbox">
                    <label v-bind:for="filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!--растворители-->
        <div class="catalog-filter__item"  v-if="json_AllParameterFilter.solvent && json_ExistentFilter.solvent">
            <div class="filter-item__title">
                Растворители
                <svg class="icon icon-33"><use xlink:href="#33"></use></svg>
            </div>
            <div class="filter-item__selects">

                <div v-for="filter in json_AllParameterFilter.solvent"
                    class="wrap-checkbox filter-item__option"
                    v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.solvent[filter.value] != filter.value && json_ActiveFilter.solvent != filter.value  }"
                >
                    <input name="solvent"
                        v-model="settingFilter.solvent"
                        v-bind:value="filter.value"
                        type="radio"
                        v-bind:id="'solvent-'+filter.value"
                        v-on:click="setThisFilterParam('solvent')"
                        class="checkbox">
                    <label v-bind:for="'solvent-'+filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--серия-->
        <div class="catalog-filter__item" v-if="json_AllParameterFilter.series && json_ExistentFilter.series">
            <div class="filter-item__title">
                Серия
                <svg class="icon icon-33"><use xlink:href="#33"></use></svg>
            </div>
            <div class="filter-item__selects two-column">

                <div v-for="filter in json_AllParameterFilter.series"
                     class="wrap-checkbox filter-item__option"
                     v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.series[filter.value] != filter.value && json_ActiveFilter.series != filter.value  }"
                >
                    <input name="series"
                           v-model="settingFilter.series"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="filter.value"
                           v-on:click="setThisFilterParam('series')"

                           class="checkbox">
                    <label v-bind:for="filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--загрузка-->
        <div class="catalog-filter__item"  v-if="json_AllParameterFilter.loading && json_ExistentFilter.loading">
            <div class="filter-item__title">
                Загрузка, кг
                <svg class="icon icon-33"><use xlink:href="#33"></use></svg>
            </div>
            <div class="filter-item__selects two-column">

                <div v-for="filter in json_AllParameterFilter.loading"
                     class="wrap-checkbox filter-item__option"
                     v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.loading[filter.value] != filter.value && json_ActiveFilter.loading != filter.value  }"
                >
                    <input name="loading"
                           v-model="settingFilter.loading"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="'loading-'+filter.value"
                           v-on:click="setThisFilterParam('loading')"
                           class="checkbox">
                    <label v-bind:for="'loading-'+filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--ширина зоны глажения-->
        <div class="catalog-filter__item"  v-if="json_AllParameterFilter.width_area && json_ExistentFilter.width_area">
            <div class="filter-item__title">Ширина зоны глажения, мм</div>
            <div class="filter-item__selects two-column">

                <div v-for="filter in json_AllParameterFilter.width_area"
                     class="wrap-checkbox filter-item__option"
                     v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.width_area[filter.value] != filter.value && json_ActiveFilter.width_area != filter.value  }"
                >
                    <input name="width_area"
                           v-model="settingFilter.width_area"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="'width_area-'+filter.value"
                           v-on:click="setThisFilterParam('width_area')"
                           class="checkbox">
                    <label v-bind:for="'width_area-'+filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--Производительность-->
        <div class="catalog-filter__item"  v-if="json_AllParameterFilter.performance && json_ExistentFilter.performance">
            <div class="filter-item__title">Производительность, кг/ч</div>
            <div class="filter-item__selects two-column">

                <div v-for="filter in json_AllParameterFilter.performance"
                     class="wrap-checkbox filter-item__option"
                     v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.performance[filter.value] != filter.value && json_ActiveFilter.performance != filter.value  }"
                >
                    <input name="performance"
                           v-model="settingFilter.performance"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="'performance-'+filter.value"
                           v-on:click="setThisFilterParam('performance')"
                           class="checkbox">
                    <label v-bind:for="'performance-'+filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--реверс барабана-->
        <div class="catalog-filter__item"  v-if="json_AllParameterFilter.revers && json_ExistentFilter.revers">
            <div class="filter-item__title">Реверс барабана</div>
            <div class="filter-item__selects two-column">

                <div v-for="filter in json_AllParameterFilter.revers"
                     class="wrap-checkbox filter-item__option"
                     v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.revers[filter.value] != filter.value && json_ActiveFilter.revers != filter.value  }"
                >
                    <input name="revers"
                           v-model="settingFilter.revers"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="filter.value"
                           v-on:click="setThisFilterParam('revers')"
                           class="checkbox">
                    <label v-bind:for="filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--направление деятельности-->
        <div class="catalog-filter__item"  v-if="json_AllParameterFilter.action && json_ExistentFilter.action">
            <div class="filter-item__title">Направление деятельности</div>
            <div class="filter-item__selects ">

                <div v-for="filter in json_AllParameterFilter.action"
                     class="wrap-checkbox filter-item__option"
                     <!--v-bind:class="{ 'filter-item__option_disable' : json_ExistentFilter.action[filter.value] != filter.value && json_ActiveFilter.action != filter.value  }"-->
                >
                    <input name="action"
                           v-model="settingFilter.action"
                           v-bind:value="filter.value"
                           type="radio"
                           v-bind:id="filter.value"
                           v-on:click="setThisFilterParam('action')"
                           class="checkbox">
                    <label v-bind:for="filter.value" class="checkbox-label">
                        <div class="icon-wrap">
                            <svg class="icon icon-35 ">
                                <use xlink:href="#35"></use>
                            </svg>
                        </div>
                        {{filter.name}}
                    </label>
                    <div class="b-tooltip" v-if="filter.help">
                        <button class="b-tooltip__activation">
                            <svg class="icon icon-28 ">
                                <use xlink:href="#28"></use>
                            </svg>
                        </button>
                        <div class="b-tooltip__text">
                            {{filter.help}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    function getCookieValueByArrayFunctions(a, b, c) {
        b = '; ' + document.cookie;
        c = b.split('; ' + a + '=');
        return !!(c.length - 1) ? c.pop().split(';').shift() : '';
    };

    export default {
        props: [
            'ExistentFilter',
            'AllParameterFilter',
            'ActiveFilter',
            'category',
            'is_no_add_url_category'
        ],
        data: function(){
            return {
                json_ExistentFilter :  JSON.parse(this.ExistentFilter),
                json_AllParameterFilter : JSON.parse(this.AllParameterFilter),
                json_ActiveFilter : JSON.parse(this.ActiveFilter),
                jsonCategory: JSON.parse(this.category),
                settingFilter : {
                    mark : '',
                    type : '',
                    series : '',
                    loading : '',
                    width_area: '',
                    performance : '',
                    revers : '',
                    action : '',
                    solvent : ''
                },
                temp_settingFilter : {
                    mark : '',
                    type : '',
                    series : '',
                    loading : '',
                    width_area: '',
                    performance : '',
                    revers : '',
                    action : '',
                    solvent : ''
                },
            }
        },
        mounted: function() {
            for (var key in this.json_ActiveFilter) {
                this.settingFilter[key] = this.json_ActiveFilter[key]
                this.temp_settingFilter[key] = this.json_ActiveFilter[key]
            }
            window.activeFilter = this.getUrlFilter('catalog');

            if(this.json_ActiveFilter.in_stock){
                document.querySelector('#show-stock').checked = true;
            }
        },
        methods: {
            setThisFilterParam: function (typeFilter) {
                if (!event.target.parentNode.classList.contains('filter-item__option_disable')) {
                    this.temp_settingFilter[typeFilter] = event.target.value;
                    if (this.settingFilter[typeFilter] == this.temp_settingFilter[typeFilter]) {
                        // Очистка значения
                        this.settingFilter[typeFilter] = '';
                        this.temp_settingFilter[typeFilter] = '';
                    }
                    // Установка текущего значения в фильтр
                    this.settingFilter[typeFilter] = this.temp_settingFilter[typeFilter];
                }
                // Обновление фильтра (с обновлением страницы)
                // TODO: Переделать на ajax-запросы
                // axios({
                //     method: 'post',
                //     url: '/ajax/catalog',
                //     responseType: 'document',
                // }).
                //     then(function (response) {
                //         // handle success
                //         console.log(response);
                //         var catalog = response.data.getElementById('catalog-products');
                //         document.getElementById('catalog-products').innerHTML = catalog.innerHTML;
                //     }).
                //     catch(function (error) {
                //         // handle error
                //         console.log(error);
                //     }).
                //     finally(function () {
                //         // always executed
                //     });
                location.href = this.getUrlFilter()+'#scroll-catalog-filters';
            },

            getUrlFilter : function () {
                var filterUrl = '/catalog/' + this.jsonCategory.url + '/';
                var key;

                if(this.is_no_add_url_category){
                    filterUrl = '/catalog/';
                }

                for (key in this.settingFilter) {
                    if (
                        this.settingFilter[key] !== ''
                        && key !== 'in-stock'
                    ) {
                        filterUrl += key +'-'+ this.settingFilter[key] +'/';
                    }
                    if (
                        this.settingFilter[key] === 1
                        && key === 'in-stock'
                    ) {
                        filterUrl += 'in-stock/';
                    }
                }

                /**
                 * Bug fix
                 * Сохранение выбраных категорий в фильтре на странице "Оборудование на складе"
                 * Может использоваться на прочих страницах
                 * Смотреть реализацию вывода фильтра "Категории оборудования" на странице "Оборудование на складе"
                 */
                if(typeof FILTER_CATEGORY_QUERY != 'undefined' && FILTER_CATEGORY_QUERY) {
                    filterUrl += FILTER_CATEGORY_QUERY;
                }

                return filterUrl;
            }
        }
    }
</script>
