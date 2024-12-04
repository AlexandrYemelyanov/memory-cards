<template>
    <select v-model="reactiveGroup" class="form-control form-select text-white bg-transparent" required>
        <option value="0">{{ $trans.without_group }}</option>
        <option v-for="option in reactiveGroups" :value="option.id">{{ option.name }} ({{ option.qty }})</option>
    </select>
</template>

<script>
export default {
    emits: ['update:modelValue'],
    props: ['modelValue', 'groups'],
    data() {
        return {
            reactiveGroup: this.modelValue || 0,
            reactiveGroups: this.groups,
        };
    },
    watch: {
        modelValue(newGroup) {
            this.reactiveGroup = newGroup;
        },
        reactiveGroup(newGroup) {
            this.$emit('update:modelValue', newGroup);
        },
        groups(newGroups) {
            this.reactiveGroups = newGroups;
        },
    },
}
</script>
