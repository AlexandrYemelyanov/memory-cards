<template>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-bottom-0">
                    <button type="button"
                            class="btn-close btn-close-white"
                            @click="closeModal"
                            aria-label="{{ $trans.close }}"
                    ></button>
                </div>
                <div class="modal-body text-center">
                    {{ question }}{{ $trans.remove }} <span class="text-danger text-uppercase">{{ itemName }}</span> ?
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary" @click="closeModal">{{ $trans.cancel }}</button>
                    <button type="button" class="btn btn-danger" @click="confirmDelete">{{ $trans.remove }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        itemName: {
            type: String,
            required: true,
            default: '',
        },
        question: {
            type: String,
            required: false,
            default: '',
        },
        open: false,
    },
    data() {
        return {
            modalInstance: null
        };
    },
    emits: ['confirm', 'close'],
    watch: {
        open: {
            immediate: true,
            handler(newOpen) {
                if (newOpen) {
                    this.showModal();
                }
            }
        }
    },
    methods: {
        showModal() {
            if (!this.modalInstance) {
                this.modalInstance = new this.$bootstrap.Modal(this.$refs.modal);
            }
            this.modalInstance.show();
        },
        closeModal() {
            if (this.modalInstance) {
                this.modalInstance.hide();
                this.$emit('close');
            }
        },
        confirmDelete() {
            this.$emit('confirm');
            this.closeModal();
        }
    }
};
</script>
