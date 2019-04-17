<template>
    <section class="content-wrapper">
        <section class="content-header no-print">
            <h1>Dashboard</h1>
        </section>

        <section class="content">
            <div class="row no-print">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Outstanding Scores and Current Results</h3><br />
                            <span>See what is still waiting to be scored as well as the current results.</span>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" @click="selectOverall">
                                    <i class="fa fa-university"></i> Overall
                                </button>
                                <button type="button" class="btn btn-default btn-sm" @click="selectTeam">
                                    <i class="fa fa-users"></i> Team
                                </button>
                                <button type="button" class="btn btn-default btn-sm" @click="selectIndividual">
                                    <i class="fa fa-user-plus"></i> Individual
                                </button>
                                <button type="button" class="btn btn-default btn-sm" @click="selectCeremony">
                                    <i class="fa fa-trophy"></i> Ceremony
                                </button>
                            </div>

                            <div class="form-group" v-show="outstandingSelection != 'ceremony'">
                                <label for="event">Event</label>
                                <v-select
                                    name="event"
                                    label="name"
                                    @input="updateEvent"
                                    :value="event"
                                    :options="eventsAll" />
                            </div>

                            <div class="form-group" v-show="outstandingSelection != 'ceremony'">
                                <label for="category">Category</label>
                                <v-select
                                    name="category"
                                    label="name"
                                    @input="updateCategory"
                                    :value="category"
                                    :options="categoriesAll" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <ceremony-results v-if="outstandingSelection == 'ceremony'"></ceremony-results>
            <category-completion v-if="outstandingSelection == 'overall'" :event="event" :category="category"></category-completion>
            <team-completion v-if="outstandingSelection == 'team'" :event="event" :category="category"></team-completion>
            <individual-completion v-if="outstandingSelection == 'individual'" :event="event" :category="category"></individual-completion>

        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <overall-results v-if="outstandingSelection == 'overall'" :event="event" :category="category"></overall-results>
                    <team-results v-if="outstandingSelection == 'team'" :event="event" :category="category"></team-results>
                    <individual-results v-if="outstandingSelection == 'individual'" :event="event" :category="category"></individual-results>
                </div>
            </div>
        </section>

    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    computed: {
        ...mapGetters('HomeIndex', ['event', 'category', 'outstandingSelection', 'loading', 'eventsAll', 'categoriesAll']),
    },
    created() {
        this.fetchEventsAll();
        this.fetchCategoriesAll();
    },
    methods: {
        ...mapActions('HomeIndex', ['setEvent', 'setCategory', 'setOutstandingSelection', 'fetchEventsAll', 'fetchCategoriesAll']),
        updateEvent(value) {
            this.setEvent(value)
        },
        updateCategory(value) {
            this.setCategory(value)
        },
        selectOverall: function () {
            this.setOutstandingSelection('overall');
        },
        selectTeam: function () {
            this.setOutstandingSelection('team');
        },
        selectIndividual: function () {
            this.setOutstandingSelection('individual');
        },
        selectCeremony: function () {
            this.setOutstandingSelection('ceremony');
        },
    }
}
</script>


<style scoped>

</style>
