<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Scores</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="event">Event *</label>
                                    <v-select
                                            name="event"
                                            label="name"
                                            @input="updateEvent"
                                            :value="item.event"
                                            :options="eventsAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <v-select
                                            name="category"
                                            label="name"
                                            @input="updateCategory"
                                            :value="item.category"
                                            :options="categoriesAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="participant">Participant *</label>
                                    <v-select
                                            name="participant"
                                            label="name"
                                            @input="updateParticipant"
                                            :value="item.participant"
                                            :options="limitedParticipants"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="team">Team</label>
                                    <v-select
                                            name="team"
                                            label="name"
                                            @input="updateTeam"
                                            :value="item.team"
                                            :options="limitedTeams"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="score">Score *</label>
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="score"
                                            placeholder="Enter Score *"
                                            :value="item.score"
                                            @input="updateScore"
                                            >
                                </div>
                            </div>

                            <div class="box-footer">
                                    <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading">
                                        Save
                                    </vue-button-spinner>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-warning btn-sm"
                                        @click="clear">
                                        Clear
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        @click="close">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            selectedTeam: null,
        }
    },
    computed: {
        ...mapGetters('ScoresSingle', ['item', 'loading', 'eventsAll', 'teamsAll', 'categoriesAll', 'participantsAll']),
        limitedParticipants() {
            let participants = this.participantsAll;

            if (this.item.category && this.item.category.id) {
                participants = participants.filter(i => i.category_id == this.item.category.id);
            }

            if (this.item.team && this.item.team.id) {
                participants = participants.filter(i => i.team_id == this.item.team.id);
            }

            return participants;
        },
        limitedTeams() {
            let teams = this.teamsAll;

            if (this.item.category && this.item.category.id) {
                teams = teams.filter(i => i.category_id == this.item.category.id);
            }

            if (this.item.participant && this.item.participant.id) {
                teams = teams.filter(i => i.id == this.item.participant.team_id);
            }

            return teams;
        },
    },
    created() {
        this.init()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('ScoresSingle', ['storeData', 'resetState', 'setEvent', 'setCategory', 'setTeam', 'setParticipant', 'setScore', 'fetchEventsAll', 'fetchCategoriesAll', 'fetchTeamsAll', 'fetchParticipantsAll']),
        init() {
            this.fetchEventsAll(),
            this.fetchCategoriesAll(),
            this.fetchTeamsAll(),
            this.fetchParticipantsAll()
        },
        byName(a, b) {
            if (a.name < b.name) {
                return -1;
            }
            if (a.name > b.name) {
                return 1;
            }
            else {
                return 0;
            }
        },
        updateEvent(value) {
            this.setEvent(value)
        },
        updateCategory(value) {
            this.setCategory(value)
        },
        updateTeam(value) {
            this.setTeam(value)
        },
        updateParticipant(value) {
            this.setParticipant(value);
            if (this.limitedTeams && this.limitedTeams.length == 1) {
                this.updateTeam(this.limitedTeams[0]);
            }
        },
        updateScore(e) {
            this.setScore(e.target.value)
        },
        clear() {
            this.resetState();
            this.init();
        },
        close() {
            this.$router.push({ name: 'scores.index' });
        },
        submitForm() {
            let event = this.item.event;
            let category = this.item.category;
            this.storeData()
                .then(() => {
                    this.$eventHub.$emit('create-success')
                    this.resetState();
                    this.init();
                    this.updateEvent(event);
                    this.updateCategory(category);
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
