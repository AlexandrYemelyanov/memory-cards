<style>
    input[type="file"] {
        display: none;
    }
</style>

<template>
    <form @submit.prevent="importCSV" class="g-3">
        <div class="row justify-content-center flex-wrap">
            <div class="col-auto col-xs-12">
                <label for="csvFile" class="btn btn-outline-info me-3">
                    <i class="bi bi-file-earmark-arrow-up"></i> {{ $trans.choose_csv_file }}
                </label>
                <input type="file"
                       @change="onFileChange"
                       id="csvFile"
                       class="form-control-dark bg-dark desc-text"
                       accept=".csv">
                <div v-show="selectedFile" class="text-light w-100 text-center">
                    {{ $trans.choosed_file }}: {{ selectedFile.name }}
                </div>
            </div>
            <div class="col-auto col-xs-12">
                <select v-model="group" class="form-control form-select text-white bg-transparent">
                    <option value="0">{{ $trans.without_group }}</option>
                    <option v-for="option in groups" :value="option.id">{{ option.name }}</option>
                </select>
            </div>
            <div class="col-auto col-xs-12">
                <button @blur="clearMessage" type="submit" class="btn btn-outline-success">{{ $trans.to_import }}</button>

            </div>
        </div>
        <div class="row justify-content-center flex-wrap">
            <div class="col-auto col-xs-12">
                <div class="form-text desc-text">
                    {{ $trans.import_file_desc }}
                </div>
            </div>
        </div>
        <div class="row justify-content-center flex-wrap">
            <div class="col-auto col-xs-12">
                <div v-show="message.success" class="col-auto col-12">
                    <div class="btn btn-outline-success w-100" role="alert">
                        {{ message.success }}
                    </div>
                </div>
                <div v-show="message.error" class="col-auto col-12">
                    <div class="btn btn-outline-danger w-100" role="alert">
                        {{ message.error }}
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props: ['groups', 'currGroup'],
    data() {
        return {
            group: this.currGroup ? this.currGroup : 0,
            selectedFile: false,
            message: {}
        };
    },
    methods: {
        onFileChange(event) {
            this.selectedFile = event.target.files[0];
        },
        async importCSV() {
            if (!this.selectedFile) {
                this.message.error = this.$trans.choice_file;
                return false;
            }
            const formData = new FormData();
            formData.append('csv_file', this.selectedFile);
            formData.append('group_app', this.group);

            this.$request('/cards/import/csv', formData, 'post', {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }}).then(response => {
                this.$request('/groups/set/', {group_qty: this.group}, 'post');
                this.message = response.message;
            });
        },
        clearMessage() {
            this.message.success = '';
            this.message.error = '';
        },
    }
};
</script>
