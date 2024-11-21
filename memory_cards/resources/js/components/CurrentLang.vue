<template>
    <div class="row justify-content-center align-items-center mt-3 mb-3">
        <div class="col-auto col-xs-12">
            <span class="desc-text">{{ label }}</span>
        </div>
        <div class="col-auto col-xs-12">
            <select id="clang"
                    v-model="reactiveLang"
                    @change="setLang"
                    @blur="focusOut"
                    class="form-control form-select text-white bg-transparent">
                <option value="" selected="selected">{{ $trans.choice_lang }}</option>
                <option  v-for="(aItem, ind) in langs" :key="ind" :value="aItem.loc">{{aItem.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    props: ['currentLang', 'langs', 'label'],
    data() {
        return {
            reactiveLang: this.currentLang,
        };
    },
    emits: ['change', 'blur'],
    methods: {
        setLang() {
            this.$emit('change', this.reactiveLang);
        },
        focusOut() {
            this.$emit('blur');
        },
    }
}
</script>
