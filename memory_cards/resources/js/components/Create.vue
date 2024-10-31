<template>
    <form @submit.prevent="createCard" class="row g-3 justify-content-center mt-3">
        <div class="col-auto col-xs-12">
            <input v-model="foreignWord"
                   type="text"
                   class="form-control text-white bg-transparent"
                   placeholder="{{ $trans.foreign_word }}"
                   required
            >
        </div>
        <div class="col-auto col-xs-12">
            <input v-model="translation"
                   type="text"
                   class="form-control text-white bg-transparent"
                   placeholder="{{ $trans.translate }}"
                   required
            >
        </div>
        <div class="col-auto col-xs-12">
            <select v-model="group" class="form-control form-select text-white bg-transparent">
                <option value="0">{{ $trans.without_group }}</option>
                <option v-for="option in groups" :value="option.id">{{ option.name }}</option>
            </select>
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
export default {
    props: ['card', 'groups'],
    data() {
        return {
            id: 0,
            group: 0,
            foreignWord: '',
            translation: '',
            message: {
                success: '',
                error: ''
            }
        };
    },
    emits: ['save'],
    mounted() {
        this.loadData(this.card);
    },
    watch: {
        card: {
            immediate: true,
            handler(newCard) {
                this.loadData(newCard);
            }
        }
    },
    methods: {
        loadData(card) {
            this.id = card.id || 0;
            this.group = card.group_id || 0;
            this.foreignWord = card.foreign_word || '';
            this.translation = card.translation || '';
        },
        async createCard() {
            try {
                const response = this.id ? await this.$axios.post('/cards/update', {
                    id: this.id,
                    foreign_word: this.foreignWord,
                    translation: this.translation,
                    group_id: this.group,
                }) : await this.$axios.post('/cards/add', {
                    foreign_word: this.foreignWord,
                    translation: this.translation,
                    group_id: this.group,
                });
                if (response.data && response.data.status && response.data.status === 200) {
                    this.message.success = response.data.message;
                    this.card.foreign_word = this.foreignWord;
                    this.card.translation = this.translation;
                    this.$emit('save', this.card);
                } else {
                    this.message.error = response.data.message;
                }
            } catch (error) {
                this.message.error = error;
            }
        },
        clearMessage() {
            this.message.success = '';
            this.message.error = '';
        },
    }
};
</script>
