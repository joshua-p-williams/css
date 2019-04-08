<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Individual Completion</h3><br />
                    <span>See what individuals are still awaiting scores</span>
                    <span v-if="event"><br /><strong>Event:</strong> {{event.name}}</span>
                    <span v-if="category"><br /><strong>Category:</strong> {{category.name}}</span>
                </div>

                <div class="box-body">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" @click="refresh">
                            <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
                        </button>
                    </div>
                </div>

                <div class="box-body">

                    <div class="row" v-if="loading">
                        <div class="col-xs-4 col-xs-offset-4">
                            <div class="alert text-center">
                                <i class="fa fa-spin fa-refresh"></i> Loading
                            </div>
                        </div>
                    </div>

                    <datatable
                            v-if="!loading"
                            :columns="columns"
                            :data="data"
                            :total="total"
                            :query="query"
                            :xprops="xprops"
                            />

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import DatatableActions from '../dtmodules/DatatableActions'
import DatatableSingle from '../dtmodules/DatatableSingle'
import DatatableList from '../dtmodules/DatatableList'
import DatatableCheckbox from '../dtmodules/DatatableCheckbox'

export default {
    props: ['event', 'category'],
    data() {
        return {
            query: { sort: 'contact_name', order: 'asc' },
            xprops: {
                module: 'IndividualCompletionsIndex',
                route: 'individualCompletions',
                permission_prefix: 'individualCompletion_'
            }
        }
    },
    created() {
        this.fetchData()
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('IndividualCompletionsIndex', ['data', 'total', 'loading', 'relationships']),
        columns: function () {
            let columns = [
                { title: 'Team', field: 'company_name', sortable: true },
                { title: 'Name', field: 'contact_name', sortable: true },
            ];

            if (!this.event) {
                columns.push({ title: 'Event', field: 'event_name', sortable: true });
            }

            if (!this.category) {
                columns.push({ title: 'Category', field: 'category_name', sortable: true });
            }

            return columns;
        }
    },
    watch: {
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        },
        event: function (newVal, oldVal) {
            this.refresh();
        },
        category: function (newVal, oldVal) {
            this.refresh();
        },
    },
    methods: {
        ...mapActions('IndividualCompletionsIndex', ['fetchData', 'setQuery', 'resetState']),
        refresh: function () {
            let constraints = (this.event || this.category) ? {eventId: null, categoryId: null} : null;
            if (this.event) {
                constraints.eventId = this.event.id;
            }
            if (this.category) {
                constraints.categoryId = this.category.id;
            }
            this.fetchData(constraints);
        }
    }
}</script>

<style lang="css" scoped>
</style>
