<template>
    <div>
        <div class="mb-3 row">
            <div class="col-sm-3">
                <SelectGroup v-model="group" :groups="reactiveGroups" />
            </div>
        </div>

        <div v-if="!cards.length" class="mb-3 row">
            <div class="col text-center text-light fs-5">
                {{ $trans.empty_cards_in_group }} <br><br>
                <a href="/cards/add" class="btn btn-outline-success">{{ $trans.add }}</a>
            </div>
        </div>

        <div v-if="cards.length" class="mb-3 row">
            <div class="col">
                <div class="card card-body text-light text-lowercase  d-flex align-items-center justify-content-center"
                     @click="flipCard"
                     :style="{ backgroundColor: card.color }">
                    <h1 class="text-center">{{ cardTitle }}</h1>
                </div>
            </div>
        </div>

        <memory-card-create v-if="cards.length && Object.keys(card).length"
                            v-show="showEdit"
                            :card="card"
                            :groups="reactiveGroups"
                            @save="changeDataCard"
                            @change-groups="changeGroups"
        />

        <div v-if="cards.length" class="row">
            <div class="col">
                <CardActionMenu
                    @voice="playVoice"
                    @edit="editCard"
                    @confirm="openConfirm"
                    :listenIs="voice"
                />
            </div>
        </div>

        <memory-card-confirm
            v-if="cards.length"
            :itemName="card.foreign_word || ''"
            :open="showConfirm"
            @confirm="removeCard"
            @close="closeConfirm"
        />
    </div>
</template>

<script>
import SelectGroup from './SelectGroup.vue';
import CardActionMenu from './ActionMenu.vue';
import newGroup from "./NewGroup.vue";

export default {
    components: {
        CardActionMenu, SelectGroup
    },
    props: ['cards', 'groups', 'currentGroup', 'currentLang', 'voiceKey'],
    data() {
        return {
            cnt: -1,
            currentIndex: -1,
            group: this.currentGroup || 0,
            reactiveGroups: this.groups,
            card: {},
            voice: '',
            showFront: true,
            showEdit: false,
            showConfirm: false,
        };
    },
    mounted() {
        this.cards.length && this.loadCard() && this.voiceLoad();
    },
    watch: {
        group(newGroup) {
            this.$request('/groups/set/', {group_app: newGroup}, 'post').
            then(()=>{ location.reload(); });
        },
    },
    computed: {
        cardTitle() {
            return this.showFront ? this.card.foreign_word : this.card.translation;
        }
    },
    methods: {
        changeGroups(groups) {
            this.reactiveGroups = groups;
        },
        flipCard() {
            if (!this.showFront) {
                return this.nextCard();
            }
            this.showFront = false;
        },
        loadCard() {
            this.card = this.nextItem();
            return true;
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
        playVoice() {
            if (this.voice) {
                responsiveVoice.speak(this.card.foreign_word, this.voice);
            }
        },
        editCard() {
            this.showEdit = !this.showEdit;
        },
        removeCard() {
            this.$request('/cards/remove/' + this.card.id).then(() => {
                this.$request('/groups/set/', {group_qty: this.card.group_id}, 'post').then(() => {
                    this.$request('/groups/get/', {}, 'post').then(response => {
                        this.reactiveGroups = response.options.groups;
                    });
                });
            });

            this.removeCardFromCards();
        },
        removeCardFromCards() {
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
            if (card.group_id !== this.currentGroup) {
                this.removeCardFromCards();
                return false;
            }
            this.cards[this.currentIndex] = card;
        },
        voiceLoad() {
            const script = document.createElement('script');
            script.src = 'https://code.responsivevoice.org/responsivevoice.js?key=' + this.voiceKey;
            script.async = true;
            document.head.appendChild(script);
            script.onload = () => {
                let voiceList = responsiveVoice.getVoices(),
                    that = this;

                voiceList.forEach(voice => {
                    if (voice.name.includes(that.currentLang.name)) {
                        that.voice = voice.name;
                    }
                });
            };
        },
    }
};
</script>
