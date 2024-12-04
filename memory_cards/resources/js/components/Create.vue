<template>
    <form @submit.prevent="saveCard" class="row g-3 justify-content-center mt-3">
        <div class="col-auto col-xs-12">
            <div class="input-group">
                <input v-model="foreignWord"
                       type="text"
                       class="form-control text-white bg-transparent"
                       :placeholder="$trans.foreign_word"
                       required
                >
                <button  @click="translateForeign()"
                         @blur="clearMessage"
                         class="btn btn-outline-primary"
                         type="button"
                >
                    <i class="bi" :class="buttonTranslateClass"></i>
                </button>
            </div>
        </div>
        <div class="col-auto col-xs-12">
            <div class="input-group">
                <input v-model="translation"
                       type="text"
                       class="form-control text-white bg-transparent"
                       :placeholder="$trans.translate"
                       required
                >
                <button @click="translateTrans()"
                        @blur="clearMessage"
                        class="btn btn-outline-primary"
                        type="button"
                >
                    <i class="bi" :class="buttonTranslateClass"></i>
                </button>
            </div>
        </div>
        <div class="col-auto col-xs-12">
            <SelectGroup v-model="group" :groups="reactiveGroups" />
        </div>

        <div class="col-auto col-xs-12 mb-3">
            <button @blur="clearMessage" type="submit" class="form-control btn btn-outline-success">
                {{ $trans.save }}
            </button>
        </div>
        <div class="row justify-content-center" v-show="message.success || message.error">
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
    </form>
</template>

<script>

import SelectGroup from "./SelectGroup.vue";

export default {
    components: {SelectGroup},
    props: ['card', 'groups', 'currGroup'],
    data() {
        return {
            id: 0,
            group: this.currGroup || 0,
            loadedGroup: this.currGroup || 0,
            reactiveGroups: this.groups,
            foreignWord: '',
            translation: '',
            isTransIcon: true,
            isSpinner: false,
            message: {
                success: '',
                error: ''
            }
        };
    },
    emits: ['save', 'changeGroups'],
    mounted() {
        this.loadData(this.card);
    },
    watch: {
        card(newCard) {
            this.loadData(newCard);
        },
        groups(newGroups) {
            this.reactiveGroups = newGroups;
        },
    },
    computed: {
        buttonTranslateClass() {
            return {
                'bi-translate': this.isTransIcon,
                'spinner-border spinner-border-small': this.isSpinner
            }
        },
    },
    methods: {
        translateForeign() {
            if (!this.foreignWord.length) {
                return this.message.error = this.$trans.empty_field;
            }
            this.setSpinner();
            this.$request('/cards/translate', {
                foreign: this.foreignWord
            }, 'post').then(response => {
                this.message = response.message;
                if (response.options.length) {
                    this.translation = response.options;
                }
                this.removeSpinner();
            });
        },
        translateTrans() {
            if (!this.translation.length) {
                return this.message.error = this.$trans.empty_field;
            }
            this.setSpinner();
            this.$request('/cards/translate', {
                translation: this.translation
            }, 'post').then(response => {
                this.message = response.message;
                if (response.options.length) {
                    this.foreignWord = response.options;
                }
                this.removeSpinner();
            });
        },
        loadData(card) {
            this.id = card.id || 0;
            this.group = card.group_id || this.currGroup;
            this.loadedGroup = card.group_id || 0;
            this.foreignWord = card.foreign_word || '';
            this.translation = card.translation || '';
        },
        saveCard() {
            this.$request('/groups/set/', {group_app: this.group}, 'post');
            const data = {
                foreign_word: this.foreignWord,
                translation: this.translation,
                group_id: this.group,
            };
            const url = '/cards/' + (this.id ? 'update/' + this.id : 'add');
            this.$request(url, data, 'post').then(response => {
                this.message = response.message;
                this.updateQtyGroup(this.group).then(() => {
                    this.$emit('save', response.options);
                });

            });
        },
        updateQtyGroup(group) {
            return new Promise((resolve, reject) => {
                const changedGroup = this.loadedGroup !== this.group;
                const request1 = changedGroup ?
                    this.$request('/groups/set/', {group_qty: group}, 'post'):
                    Promise.resolve();
                const request2 = this.loadedGroup && changedGroup ?
                    this.$request('/groups/set/', {group_qty: this.loadedGroup}, 'post'):
                    Promise.resolve();
                Promise.all([request1, request2]).then(() => {
                    changedGroup ?
                        this.setGroups().then(() => {
                            resolve();
                        }) :
                        resolve();
                });
            });
        },
        setGroups() {
            return new Promise((resolve, reject) => {
                this.$request('/groups/get/', {}, 'post').then(response => {
                    this.reactiveGroups = response.options.groups;
                    this.$emit('changeGroups', this.reactiveGroups);
                    resolve();
                });
            });
        },
        clearMessage() {
            this.message.success = '';
            this.message.error = '';
        },
        setSpinner() {
            this.isTransIcon = false;
            this.isSpinner = true;
        },
        removeSpinner() {
            this.isTransIcon = true;
            this.isSpinner = false;
        },
    }
};
</script>
