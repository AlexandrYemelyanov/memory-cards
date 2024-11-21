<template>
    <form @submit.prevent="saveGroup" class="g-3 justify-content-center mt-3">
        <div class="row justify-content-center mt-3 mb-3">
            <div class="col-auto col-xs-12">
                <input v-model="newGroup"
                       type="text"
                       class="form-control text-white bg-transparent"
                       @blur="focusOut"
                       :placeholder="$trans.name_new_group"
                       required
                >
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
    data() {
        return {
            newGroup: '',
            message: {},
            messageNew: {},
        };
    },
    emits: ['save', 'blur'],
    methods: {
        saveGroup() {
            this.$emit('save', this.newGroup);
        },
        focusOut() {
            this.$emit('blur');
        },
    }
};
</script>
