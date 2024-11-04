<template>
<div class="d-flex mt-3 justify-content-center">
    <ul class="nav nav-tabs" id="groupsNav" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active"
               id="add-group-tab"
               data-bs-toggle="tab"
               href="#add-group"
               role="tab"
               aria-controls="add-group"
               aria-selected="true">
                {{ $trans.add_group }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
               id="groups-tab"
               data-bs-toggle="tab"
               href="#groups"
               role="tab"
               aria-controls="groups"
               aria-selected="false">
                {{ $trans.groups }}
            </a>
        </li>
    </ul>
</div>
    <div class="tab-content p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="add-group" role="tabpanel" aria-labelledby="add-group-tab">
            <MemoryCardNewGroup @save="addGroup"></MemoryCardNewGroup>
        </div>
        <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="groups-tab">
            <form v-if="reactiveGroups.length > 0" @submit.prevent="saveGroups" class="g-3 justify-content-center mt-3">
                <h4 class="text-center text-light mb-4 fs-4">{{ $trans.groups }}</h4>

                <div class="row mt-3 justify-content-center" v-for="(group, index) in reactiveGroups" :key="index">
                    <div class="col-auto col-xs-12 d-flex align-items-center">
                        <input v-model="group.name"
                               type="text"
                               class="form-control text-white bg-transparent me-3"
                               placeholder="{{ $trans.name_group }}"
                               required
                        >

                        <a href="#" class="text-danger" @click="openConfirm(index)">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>

                <div class="row mt-3 mb-3 justify-content-center">
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
        </div>
    </div>

    <memory-card-confirm
        :itemName="removeName"
        :question="$trans.cards_whithout_groups"
        :open="showConfirm"
        @confirm="removeGroup"
        @close="closeConfirm"
    />

</template>

<script>
import MemoryCardNewGroup from './NewGroup.vue';
export default {
    components: {
        MemoryCardNewGroup,
    },
    props: ['groups'],
    data() {
        return {
            reactiveGroups: this.groups || [],
            removeKey: 0,
            removeName: '',
            newGroup: '',
            message: {},
            messageNew: {},
        };
    },
    computed: {
        showConfirm() {
            return this.removeKey > 0;
        }
    },
    methods: {
        openConfirm(key) {
            this.clearMessage();
            this.removeName = this.reactiveGroups[key].name;
            this.removeKey = key + 1;
        },
        removeGroup() {
            this.removeKey--;
            this.request('/groups/remove/' + this.reactiveGroups[ this.removeKey ].id, {});
            this.reactiveGroups.splice(this.removeKey, 1);
            this.removeKey = 0;
        },
        closeConfirm() {
            this.removeKey = 0;
        },
        saveGroups() {
            this.request('/groups/save', {
                groups: this.reactiveGroups,
            }, 'post');
        },
        addGroup($group) {
            this.reactiveGroups.push($group);
        },
        clearMessage() {
            this.message.success = '';
            this.message.error = '';
        },
        async request(url, data, method = 'get') {
            try {
                const response = await this.$axios[method](url, data);
                (response.data && response.data.status && response.data.status === 200) ?
                    this.message.success = response.data.message :
                    this.message.error = response.data.message;

            } catch (error) {
                this.message.error = 'Error: ' + error;
            }
        }
    }
};
</script>
