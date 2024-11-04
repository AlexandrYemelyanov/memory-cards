<template>
    <form @submit.prevent="saveGroup" class="g-3 justify-content-center mt-3">
        <h4 class="text-center text-light mb-4 fs-4">{{ $trans.add_group }}</h4>
        <div class="row justify-content-center mt-3 mb-3">
            <div class="col-auto col-xs-12">
                <input v-model="newGroup"
                       type="text"
                       class="form-control text-white bg-transparent"
                       :placeholder="$trans.name_new_group"
                       required
                >
            </div>
            <div class="col-auto col-xs-12">
                <button @blur="clearMessage" type="submit" class="form-control btn btn-outline-success">
                    {{ $trans.save }}
                </button>
            </div>
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
    </form>
</template>

<script>
export default {
    data() {
        return {
            newGroup: '',
            message: {},
            messageNew: {},
        };
    },
    emits: ['save'],
    mounted() {

    },
    methods: {
        async saveGroup(key) {
            try {
                const response = await this.$axios.post('/groups/new', {
                    name: this.newGroup,
                });

                if (response.data && response.data.status && response.data.status === 200) {
                    this.message.success = response.data.message;
                    this.$emit('save', response.data.group);
                } else {
                    this.message.error = response.data.message;
                }

            } catch (error) {
                this.message.error = 'Error: ' + error;
            }
        },
        clearMessage() {
            this.message.success = '';
            this.message.error = '';
        },
    }
};
</script>
