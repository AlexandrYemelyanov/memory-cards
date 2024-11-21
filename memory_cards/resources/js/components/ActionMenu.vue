<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
        <ul class="navbar-nav">

            <li class="nav-item" v-if="listenShow">
                <a class="nav-link" href="#" @click="voice">
                    <i class="bi bi-volume-up"></i> {{ $trans.listen }}
                </a>
            </li>
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
    props: ['listenIs'],
    emits: ['edit', 'confirm', 'voice'],
    data() {
        return {
            listenShow: false
        };
    },
    watch: {
        listenIs: {
            immediate: true,
            handler(newListenIs) {
                if (newListenIs) {
                    this.listenShow = true;
                }
            }
        }
    },
    methods: {
        edit(e) {
            e.preventDefault();
            this.$emit('edit');
        },
        confirm(e) {
            e.preventDefault();
            this.$emit('confirm');
        },
        voice(e) {
            e.preventDefault();
            this.$emit('voice');
        }
    }
};
</script>
