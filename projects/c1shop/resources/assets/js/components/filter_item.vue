<template>
    <div v-for="filter in json_AllParameterFilter.mark" class="wrap-checkbox filter-item__option">
        <input name="mark"
               v-model="settingFilter.mark"
               v-bind:value="filter.value"
               type="radio"
               v-bind:id="filter.value"
               v-on:click="setThisFilterParam('mark')"
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
</template>
<script>
    export default {
        props : {
            filte : filter
        }
    }
</script>