<template>
<div class="d-flex mt-3 justify-content-center">
    <ul class="nav nav-tabs app-nav" id="langsNav" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               :class="addTabClasses"
               id="add-lang-tab"
               data-bs-toggle="tab"
               href="#add-lang"
               role="tab"
               aria-controls="add-lang"
               aria-selected="true">
                {{ $trans.add_lang }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               :class="langsTabClasses"
               id="langs-tab"
               data-bs-toggle="tab"
               href="#langs"
               role="tab"
               aria-controls="langs"
               aria-selected="false">
                {{ $trans.langs }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               id="lang-to-tab"
               data-bs-toggle="tab"
               href="#lang-from"
               role="tab"
               aria-controls="lang-to"
               aria-selected="false">
                {{ $trans.current_language }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               id="lang-to-tab"
               data-bs-toggle="tab"
               href="#lang-to"
               role="tab"
               aria-controls="lang-to"
               aria-selected="false">
                {{ $trans.lang_to }}
            </a>
        </li>
    </ul>
</div>
    <div class="tab-content p-3" id="myTabContent">
        <div class="tab-pane fade" :class="addTabClasses" id="add-lang" role="tabpanel" aria-labelledby="add-lang-tab">
            <MemoryCardNewLang @save="addLang"
                               @blur="clearMessage"
                               :label="$trans.lang_from"
                               :access-langs="accessLangs"/>
        </div>
        <div class="tab-pane fade" :class="langsTabClasses" id="langs" role="tabpanel" aria-labelledby="langs-tab">
            <form v-if="reactiveLangs.length > 0" @submit.prevent="saveLangs" class="g-3 justify-content-center mt-3">
                <div class="row mt-3 justify-content-center" v-for="(item, index) in reactiveLangs" :key="index">
                    <div class="col-auto col-xs-12 d-flex align-items-center">
                        <select v-model="item.loc"
                                ref="langSelects"
                                @change="setName"
                                class="form-control form-select text-white bg-transparent me-3">
                            <option value="" selected="selected">{{ $trans.choice_lang }}</option>
                            <option  v-for="(aItem, ind) in accessLangs" :key="ind" :value="aItem.loc">{{aItem.name}}</option>
                        </select>

                        <a href="#" class="text-danger" @click="openConfirm(index)">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>

                <div class="row mt-3 mb-3 justify-content-center">
                    <div class="col-auto col-xs-12">
                        <button @blur="clearMessage" type="submit" class="form-control btn btn-outline-success">
                            {{ $trans.save }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="lang-from" role="tabpanel" aria-labelledby="lang-from-tab">
            <MemoryCardCurrentLang
                :langs="reactiveLangs"
                :label="$trans.current_language"
                :current-lang="currentLang"
                @change="changeLangFrom"/>
        </div>
        <div class="tab-pane fade" id="lang-to" role="tabpanel" aria-labelledby="lang-to-tab">
            <MemoryCardCurrentLang
                :langs="accessLangs"
                :label="$trans.lang_to"
                :current-lang="userLang"
                @blur="clearMessage"
                @change="changeLangTo"/>
        </div>
        <div class="row justify-content-center" v-if="message.success || message.error">
            <div v-show="message.success" class="col-auto col-xs-12">
                <div class="btn btn-outline-success w-100" role="alert">
                    {{ message.success }}
                </div>
            </div>
            <div v-show="message.error" class="col-auto col-xs-12">
                <div class="btn btn-outline-danger w-100" role="alert">
                    {{ message.error }}
                </div>
            </div>
        </div>
    </div>

    <memory-card-confirm
        :itemName="removeName"
        :question="$trans.confirm_remove_lang"
        :open="showConfirm"
        @confirm="removeLang"
    />

</template>

<script>
import MemoryCardNewLang from './NewLang.vue';
import MemoryCardCurrentLang from "./CurrentLang.vue";
export default {
    components: {
        MemoryCardCurrentLang,
        MemoryCardNewLang,
    },
    props: ['langs', 'userLang', 'currentLang', 'accessLangs'],
    data() {
        return {
            reactiveLangs: this.langs ? this.langs : [],
            removeKey: -1,
            removeName: '',
            message: {},
        };
    },
    computed: {
        showConfirm() {
            return this.removeKey > -1;
        },
        addTabClasses() {
            return {
                'show': this.langs.length === 0,
                'active': this.langs.length === 0
            };
        },
        langsTabClasses() {
            return {
                'show': this.langs.length > 0,
                'active': this.langs.length > 0
            };
        },
    },
    methods: {
        openConfirm(key) {
            const selectElement = this.$refs.langSelects[key];
            const selectedValue = this.reactiveLangs[key].loc;
            this.removeName = Array.from(selectElement.options).find(option => option.value === selectedValue).text;
            this.removeKey = key;
        },
        removeLang() {
            this.$request('/langs/remove/' + this.reactiveLangs[ this.removeKey ].id).then( response => {
                let before = this.reactiveLangs;
                this.message = response.message;
                if (!this.message.error) {
                    this.reactiveLangs.splice(this.removeKey, 1);
                    if (this.reactiveLangs[0]) {
                        this.changeLangFrom(this.reactiveLangs[0].loc);
                    }
                }
                this.removeKey = -1;
            });
        },
        saveLangs() {
            if (!this.isLangUnique()) {
                this.message.error = this.$trans.lang_unique;
                return false;
            }
            this.reactiveLangs.forEach(lang => {
                this.$request('/langs/save/' + lang.id, {
                    loc: lang.loc,
                    name: lang.name,
                }, 'post').then(response => {
                    this.message = response.message;
                });
            });
        },
        setName(event) {
            const selectElement = event.target;
            const index = this.$refs.langSelects.findIndex(el => el === selectElement);
            if (index !== -1) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                this.reactiveLangs[index].name = selectedOption.text;
            }
        },
        addLang(loc, name) {
            const validate = this.langValidate(loc);
            if (validate.length > 0) {
                this.message.error = validate;
                return false;
            }
            this.$request('/langs/new', {
                loc: loc,
                lang_app: loc,
                name: name
            }, 'post').then( response => {
                this.message = response.message;
                if (response.options) {
                    this.reactiveLangs.push(response.options);
                }
            });
        },
        changeLangTo(lang) {
            const validate = this.langValidate(lang);
            if (validate.length > 0) {
                this.message.error = validate;
                return false;
            }
            this.$request('/user/lang/save', {
                loc: lang
            }, 'post').then( response => {
                this.message = response.message;
            });
        },
        clearMessage() {
            this.message.success = '';
            this.message.error = '';
        },
        langValidate(loc) {
            let res = [];
            const langs = this.reactiveLangs.map(item => item.loc);
            if (!loc.length) {
                res.push(this.$trans.choice_lang);
            }
            if (langs.includes(loc)) {
                res.push(this.$trans.lang_unique);
            }

            return res.join(' ');
        },
        isLangUnique() {
            const langs = this.reactiveLangs.map(item => item.loc);
            const uniqueLangs = new Set(langs);
            return uniqueLangs.size === langs.length;
        },
        changeLangFrom(lang) {
            this.$request('/langs/set', {
                lang_app: lang,
            }, 'post');
        },
    }
};
</script>
