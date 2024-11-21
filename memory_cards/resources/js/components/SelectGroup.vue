<template>
    <select v-model="group" @change="changeGroup" class="form-control form-select text-white bg-transparent" required>
        <option value="0">{{ $trans.without_group }}</option>
        <option v-for="option in groups" :value="option.id">{{ option.name }} ({{ option.qty }})</option>
    </select>
</template>

<script>
export default {
    emits: ['change'],
    props: ['currentGroup', 'groups'],
    data() {
        return {
            group: this.currentGroup || 0
        };
    },
    methods: {
        changeGroup() {
            this.$emit('change', this.group);
        }
    },
}
</script>
