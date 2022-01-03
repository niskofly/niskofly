<template>
    <div>
        <div class="tab"
             :class="{ activeTab: selectTab === category.name}"
             @click="selectTab = category.name"
             v-for="(category) in getSortMaskArr">
            {{category.name}}
           <!-- {{category_name}}-->
        </div>

        <div>Сравнение товаров</div>
        <div v-show="selectTab == category.name" class="content" v-for="(category) in getSortMaskArr">

            <div v-for="(feature) in category.feature">
               {{feature.name}}
               <div class="table_feature" v-for="(item) in feature.items_all">


                   <div class="table_feature-item">{{getProductCompareLine(category.name,json_categories,feature.name,item.name)[0].name}}</div>
                   <div class="table_feature-item" v-for="feature_line in getProductCompareLine(category.name,json_categories,feature.name,item.name)">
                       {{feature_line.value}}
                   </div>
               </div>
            </div>


            <!--<div v-for="(product) in getProducts(category_name,json_categories)" class="compare-table">

                <div>{{product.name}}</div>
            </div>-->
        </div>

    </div>
</template>
<style>
    .table_feature{
        display: flex;
    }
    .table_feature-item{
        flex: 1;
    }
</style>
<script>
    export default {
        props: [
            'categories',
        ],
        data: function () {
            return {
                json_categories: JSON.parse(this.categories),
                selectTab: ''
            }
        },
        mounted: function () {

        },
        computed: {
            getSortMaskArr: function () {
                let sortArr = {};
                for (let category in this.json_categories) {
                    sortArr[category] = this.json_categories[category]
                    sortArr[category].feature = {}

                    for (let product in this.json_categories[category].products) {
                        for (let product_param_category in this.json_categories[category].products[product].params) {
                            if (sortArr[category]['feature'][product_param_category] === undefined) {
                                sortArr[category]['feature'][product_param_category] = this.json_categories[category].products[product].params[product_param_category]
                            }

                            if (sortArr[category]['feature'][product_param_category].items_all === undefined){
                                sortArr[category]['feature'][product_param_category].items_all = []
                            }


                            sortArr[category]['feature'][product_param_category].items_all =
                            sortArr[category]['feature'][product_param_category].items_all.concat(this.json_categories[category].products[product].params[product_param_category].items)

                            /*sortArr[category]['feature'][product_param_category].items_all
                                = sortArr[category]['feature'][product_param_category].items_all.filter((item, index, self) =>
                                index === self.findIndex((t) => (
                                    t.name === item.name
                                ))
                            )*/

                        }
                    }

                export-yml-categories-several
                    let category_keys = Object.keys(sortArr)
                    for (let i = 0; i < category_keys.length; i++){
                       console.log(sortArr[category_keys[i]])
                    }
                            /*if (true) {

                                for (let i = 0; i < sortArr[category]['feature'][product_param_category].items_all.length; i++) {
                                    let arr_same = {}

                                    for (let j = 0; j < sortArr[category]['feature'][product_param_category].items_all.length; j++) {
                                        if (sortArr[category]['feature'][product_param_category].items_all[i].name ==
                                            sortArr[category]['feature'][product_param_category].items_all[j].name) {
                                            arr_same[j] = []
                                            arr_same[j].push(sortArr[category]['feature'][product_param_category].items_all[j])
                                        }

                                    }
                                    console.log(arr_same)
                                    /!*if (arr_same[i].length > 1) {
                                        let item_same = false
                                        for (let j = 0; j < arr_same[i].length; j++) {
                                            if (arr_same[i][0].value !== arr_same[i][j].value) {
                                                item_same = true
                                            }
                                        }
                                        if (!item_same) {

                                        }
                                    }
                                    console.log(arr_same)*!/
                                }
                            }*/



                }


                return sortArr;
            }
        },
        methods:{
            getProductCompareLine: (category_name,json_categories,feature_group,feature_name) => {
                let categories = JSON.parse(JSON.stringify(json_categories),true)
                categories = Object.values(categories);

                let products =  categories.filter(function(val) {
                    return val.name == category_name;
                })[0].products

                let product_line = []
                products = Object.values(products);
                products.forEach(function (product) {


                    let current_product_category = product.params.filter(function (category) {
                        return category.name === feature_group
                    })[0]
                    let product_feature = current_product_category.items.filter(function (feature) {
                        return feature.name === feature_name
                    })[0]

                    product_line.push(product_feature)
                    let param_prototype = {}
                    for (let i = 0; i < product_line.length; i++) {
                        if (typeof product_line[i] === 'object' && !Object.keys(product_line[i]).length == 0) {
                            param_prototype.id = product_line[i].id
                            param_prototype.name = product_line[i].name
                            param_prototype.value = ''
                        }
                    }
                    for (let i = 0; i < product_line.length; i++) {
                        if (product_line[i] === undefined || Object.keys(product_line[i]).length == 0) {
                            product_line[i] = param_prototype
                        }
                    }


                })
                return product_line
            },
        }
    }
</script>

<style scoped>
    .activeTab {
        color: #16C0B0;
        text-decoration: underline;
    }
    .tab {
        margin-left: 20px;
        cursor: pointer;
    }
</style>