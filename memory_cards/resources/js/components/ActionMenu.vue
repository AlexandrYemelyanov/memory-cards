<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#" @click="edit">
                    <i class="bi bi-pen"></i> {{ $trans.edit }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" @click="confirm">
                    <i class="bi bi-trash"></i> {{ $trans.remove }}
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    methods: {
        edit() {
            this.$emit('edit');
        },
        confirm() {
            this.$emit('confirm');
        }
    }
};
</script>
