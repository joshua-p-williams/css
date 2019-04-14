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
                                <h3 class="box-title">Edit</h3>
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
                                    <label for="team">Team</label>
                                    <v-select
                                            name="team"
                                            label="name"
                                            @input="updateTeam"
                                            :value="item.team"
                                            :options="TeamsAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="participant">Participant *</label>
                                    <v-select
                                            name="participant"
                                            label="name"
                                            @input="updateParticipant"
                                            :value="item.participant"
                                            :options="participantsByTeam"
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
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
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
            // Code...
        }
    },
    computed: {
        ...mapGetters('ScoresSingle', ['item', 'loading', 'eventsAll', 'TeamsAll', 'participantsAll']),
        participantsByTeam() {
            let participants = this.participantsAll;

            if (this.item.team && this.item.team.id) {
                participants = participants.filter(i => i.team_id == this.item.team.id);
            }
            return participants;
        }
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('ScoresSingle', ['fetchData', 'updateData', 'resetState', 'setEvent', 'setTeam', 'setParticipant', 'setScore']),
        updateEvent(value) {
            this.setEvent(value)
        },
        updateTeam(value) {
            this.setTeam(value)
        },
        updateParticipant(value) {
            this.setParticipant(value)
        },
        updateScore(e) {
            this.setScore(e.target.value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'scores.index' })
                    this.$eventHub.$emit('update-success')
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
