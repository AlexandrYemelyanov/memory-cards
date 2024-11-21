<template>
    <form @submit.prevent="saveLang" class="g-3 justify-content-center mt-3">
        <div class="row justify-content-center align-items-end mt-3 mb-3">
            <div class="col-auto col-xs-12">
                <label class="desc-text" for="nlangfrom">{{ label }}</label>
                <select id="nlangfrom"
                        v-model="newLang"
                        class="form-control form-select text-white bg-transparent">
                    <option value="" selected="selected">{{ $trans.choice_lang }}</option>
                    <option  v-for="(aItem, ind) in accessLangs" :key="ind" :value="aItem.loc">{{aItem.name}}</option>
                </select>
            </div>
            <div class="col-auto col-xs-12">
                <button @blur="focusOut" type="submit" class="form-control btn btn-outline-success">
                    {{ $trans.save }}
                </button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        accessLangs: Object,
        label: String,
        lang: {
            type: String,
            default: '',
        }
    },
    data() {
        return {
            newLang: '',
        };
    },
    mounted() {
        this.newLang = this.lang;
    },
    emits: ['save', 'blur'],
    methods: {
        saveLang() {
            const selectedOption = this.accessLangs.find(item => item.loc === this.newLang);
            const selectedText = selectedOption ? selectedOption.name : '';
            this.$emit('save', this.newLang, selectedText);
        },
        focusOut() {
            this.$emit('blur');
        },
    }
};
</script>
