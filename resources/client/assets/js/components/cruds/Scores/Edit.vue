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
                                    <label for="company">Team</label>
                                    <v-select
                                            name="company"
                                            label="name"
                                            @input="updateCompany"
                                            :value="item.company"
                                            :options="contactcompaniesAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="contact">Participant *</label>
                                    <v-select
                                            name="contact"
                                            label="name"
                                            @input="updateContact"
                                            :value="item.contact"
                                            :options="contactsAll"
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
        ...mapGetters('ScoresSingle', ['item', 'loading', 'eventsAll', 'contactcompaniesAll', 'contactsAll']),
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
        ...mapActions('ScoresSingle', ['fetchData', 'updateData', 'resetState', 'setEvent', 'setCompany', 'setContact', 'setScore']),
        updateEvent(value) {
            this.setEvent(value)
        },
        updateCompany(value) {
            this.setCompany(value)
        },
        updateContact(value) {
            this.setContact(value)
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
