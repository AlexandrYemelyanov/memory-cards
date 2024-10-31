<style>
    input[type="file"] {
        display: none;
    }
</style>

<template>
    <form @submit.prevent="importCSV" class="row g-3 justify-content-center">
        <div class="col-auto w-auto">
            <div class="d-flex flex-wrap justify-content-center">
                <label for="csvFile" class="btn btn-outline-info me-3">
                    <i class="bi bi-file-earmark-arrow-up"></i> {{ $trans.choose_csv_file }}
                </label>
                <input type="file"
                       @change="onFileChange"
                       id="csvFile"
                       class="form-control-dark bg-dark desc-text"
                       accept=".csv">
                <button @blur="clearMessage" type="submit" class="btn btn-outline-success">{{ $trans.to_import }}</button>
                <div v-show="selectedFile" class="text-light w-100 text-center">
                    {{ $trans.choosed_file }}: {{ selectedFile.name }}
                </div>
            </div>

            <div class="form-text desc-text">
                {{ $trans.import_file_desc }}
            </div>
        </div>
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
    </form>
</template>

<script>
export default {
    data() {
        return {
            selectedFile: false,
            message: {
                success: '',
                error: ''
            }
        };
    },
    methods: {
        onFileChange(event) {
            this.selectedFile = event.target.files[0];
        },
        async importCSV() {
            if (!this.selectedFile) {
                this.message.error = $trans.choice_file;
                return false;
            }
            const formData = new FormData();
            formData.append('csv_file', this.selectedFile);
            try {
                const response = await this.$axios.post('/cards/import',  formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                response.data && response.data.status && response.data.status === 200 ?
                    this.message.success = response.data.message :
                    this.message.error = response.data.message;
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
