<template>
    <div>
        <div class="mb-3 row">
            <div class="col-sm-3">
                <select v-model="group" @change="changeGroup" class="form-control form-select text-white bg-transparent">
                    <option value="0">{{ $trans.without_group }}</option>
                    <option v-for="option in groups" :value="option.id">{{ option.name }}</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <div class="card card-body text-center text-light text-lowercase"
                     @click="flipCard"
                     :style="{ backgroundColor: card.color }">
                    <h1 class="fs-1">{{ cardTitle }}</h1>
                </div>
            </div>
        </div>

        <memory-card-create v-if="Object.keys(card).length"
                            v-show="showEdit"
                            :card="card"
                            :groups="groups"
                            @save="changeDataCard"
        />

        <div class="row">
            <div class="col">
                <CardActionMenu
                    @edit="editCard"
                    @confirm="openConfirm"
                />
            </div>
        </div>

        <memory-card-confirm
            :itemName="card.foreign_word || ''"
            :open="showConfirm"
            @confirm="removeCard"
            @close="closeConfirm"
        />
    </div>
</template>

<script>
import CardActionMenu from './ActionMenu.vue';
import Cookies from 'js-cookie';

export default {
    components: {
        CardActionMenu
    },
    props: ['cards', 'groups'],
    data() {
        return {
            cnt: -1,
            currentIndex: -1,
            group: 0,
            card: {},
            showFront: true,
            showEdit: false,
            showConfirm: false,
        };
    },
    mounted() {
        this.loadCardData();
    },
    computed: {
        cardTitle() {
            return this.showFront ? this.card.foreign_word : this.card.translation;
        }
    },
    methods: {
        changeGroup() {
            Cookies.set('view-group', this.group, { expires: 7 });
            location.reload();
        },
        flipCard() {
            if (!this.showFront) {
                return this.nextCard();
            }
            this.showFront = false;
        },
        loadCard() {
            this.card = this.nextItem();
        },
        async loadCardData() {
            this.loadCard();
            this.group = this.card.group_id;
        },
        nextCard() {
            this.loadCard();
            this.showFront = true;
        },
        nextItem() {
            this.cnt ++;
            this.currentIndex = this.cnt % this.cards.length;
            return this.cards[this.currentIndex];
        },
        editCard() {
            this.showEdit = !this.showEdit;
        },
        async removeCard() {
            await this.$axios.get('/cards/remove/' + this.card.id);
            this.cards.splice(this.currentIndex, 1);
            this.nextCard();
        },
        openConfirm() {
            this.showConfirm = true;
        },
        closeConfirm() {
            this.showConfirm = false;
        },
        changeDataCard(card) {
            this.card = card;
            this.cards[this.currentIndex] = card;
        },
    }
};
</script>
