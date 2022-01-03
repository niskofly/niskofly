<template>
    <div class="b-admin-parameter">


        <div class="b-admin-parameter_item" v-for="category in json_params" :key="category.id">
            <div class="row hidden-sm" style="margin-bottom: 25px;">
                <div class="col-md-4">
                    <strong>Название категории</strong>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-element-text ">
                        <input type="text" placeholder="Название категории"
                               class="form-control"
                               :value="category.name" @input="changeCategoryList($event,category.id,'name')"
                               :name="'categories['+category.name+']'"
                        >
                    </div>
                </div>
            </div>
            <div class="row hidden-sm" style="margin-bottom: 25px;">
                <div class="col-md-4">
                    Название параметра
                </div>
                <div class="col-md-4">
                    Значение параметра
                </div>
            </div>
            <div class="">
                <div class="row" v-for="item in category.items" :key="item.id">
                    <div class="col-md-4">
                        <div class="form-group form-element-text ">
                            <input type="text"
                                   placeholder="Название параметра"
                                   class="form-control"
                                   :value="item.name" @input="changeItemList($event,item.id,category.id,'name')"
                                   :name="'params['+category.name+'][c'+category.id+'i'+item.id+'][name]'"
                            >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-element-text ">
                            <input type="text"
                                   placeholder="Значение параметра"
                                   class="form-control"
                                   :value="item.value" @input="changeItemList($event,item.id,category.id,'value')"
                                   :name="'params['+category.name+'][c'+category.id+'i'+item.id+'][value]'"
                            >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-delete"
                                v-on:click="deleteItem(item.id,category.id)"
                        >
                            <i class="fa fa-times"></i>
                            Удалить
                        </button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 15px;margin-bottom: 25px;">
                <div class="col-md-4">
                    <button type="button"
                            class="btn btn-primary js-add-row-params"
                            v-on:click="addItem(category.id)"
                    >
                        <i class="fa fa-plus"></i>
                        Добавить строку параметров
                    </button>
                </div>

                <div class="col-md-ofset-4 col-md-4">
                    <button type="button" class="btn btn-danger btn-delete"
                            v-on:click="deleteCategory(category.id)"
                    >
                        <i class="fa fa-times"></i>
                        Удалить категорию
                    </button>
                </div>

            </div>

        </div>
        <div class="row" style="margin-top: 15px;margin-bottom: 25px;">
            <div class="col-md-12">
                <button type="button"
                        class="btn btn-primary js-add-row-params"
                        v-on:click="addCategory()"
                >
                    <i class="fa fa-plus"></i>
                    Добавить блок категории
                </button>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: [
            'params'
        ],
        data: function () {
            return {
                json_params:JSON.parse(this.params),
            }
        },
        methods: {
            changeCategoryList(event, id, property) {
                let value = event.target.value
                this.json_params.forEach((item) => {
                    if (item.id === id) {
                        if (property === 'name') {
                            item.name = value
                        }
                    }
                })
            },
            changeItemList(event, id, category_id, property) {
                let value = event.target.value
                this.json_params.forEach((category) => {
                    if (category.id === category_id) {
                        category.items.forEach((item) => {
                            if (item.id === id) {
                                if (property === 'name') {
                                    item.name = value
                                }
                                if (property === 'value') {
                                    item.value = value
                                }
                            }
                        })
                    }
                })
            },
            addItem(category_id){
                this.json_params.forEach((category) => {
                    if (parseInt(category.id,10) === parseInt(category_id,10)) {
                        let max_id = 0
                        category.items.forEach((item) => {
                            if (parseInt(max_id,10) < item.id){
                                max_id = item.id
                            }
                        })
                       category.items.push({
                           'id': parseInt(max_id,10) + 1,
                           'name': '',
                           'value': '',
                       })
                    }
                })
            },
            addCategory(){
                let max_id = 0
                this.json_params.forEach((category) => {
                    if (parseInt(max_id,10) < category.id){
                        max_id = category.id
                    }
                })
                this.json_params.push({
                    'id' : parseInt(max_id,10) + 1,
                    'items': [{
                        'id': 0,
                        'name': '',
                        'value': '',
                    }],
                    'name': ''
                })
            },
            deleteItem(id, category_id){
                if (confirm("Удалить элемент?") === true) {
                    this.json_params.forEach((category) => {
                        if (parseInt(category.id, 10) === parseInt(category_id, 10)) {
                            category.items.forEach((item, index) => {
                                if (parseInt(id, 10) === parseInt(item.id, 10)) {
                                    category.items.splice(index, 1)
                                }
                            })
                        }
                    })
                }
            },
            deleteCategory(category_id){
                if (confirm("Удалить элемент?") === true) {
                    this.json_params.forEach((category, index) => {
                        if (parseInt(category.id, 10) === parseInt(category_id, 10)) {
                            this.json_params.splice(index, 1)
                        }
                    })
                }
            }
        }
    }
</script>

