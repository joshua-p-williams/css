<template>
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Dashboard</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Scores Outstanding</h3><br />
                            <span>See what is still waiting to be scored</span>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" @click="selectCategory">
                                    <i class="fa fa-university"></i> Category
                                </button>
                                <button type="button" class="btn btn-default btn-sm" @click="selectTeam">
                                    <i class="fa fa-users"></i> Team
                                </button>
                                <button type="button" class="btn btn-default btn-sm" @click="selectIndividual">
                                    <i class="fa fa-user-plus"></i> Individual
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <category-completion v-if="outstandingSelection == 'category'"></category-completion>
            <team-completion v-if="outstandingSelection == 'team'"></team-completion>
            <individual-completion v-if="outstandingSelection == 'individual'"></individual-completion>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Event Results</h3><br />
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="event">Event</label>
                                <v-select
                                    name="event"
                                    label="name"
                                    @input="updateEvent"
                                    :value="event"
                                    :options="eventsAll" />
                            </div>
                            <div class="form-group">
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
            <div class="row">
                <div class="col-xs-12">
                    <individual-results :event="event" :category="category"></individual-results>
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
            selection: 'category',
        }
    },
    computed: {
        ...mapGetters('HomeIndex', ['event', 'category', 'outstandingSelection', 'loading', 'eventsAll', 'categoriesAll']),
    },
    created() {
        this.fetchEventsAll()
        this.fetchCategoriesAll()
    },
    methods: {
        ...mapActions('HomeIndex', ['setEvent', 'setCategory', 'setOutstandingSelection', 'fetchEventsAll', 'fetchCategoriesAll']),
        updateEvent(value) {
            this.setEvent(value)
        },
        updateCategory(value) {
            this.setCategory(value)
        },
        selectCategory: function () {
            this.setOutstandingSelection('category');
        },
        selectTeam: function () {
            this.setOutstandingSelection('team');
        },
        selectIndividual: function () {
            this.setOutstandingSelection('individual');
        },
    }
}
</script>


<style scoped>

</style>
