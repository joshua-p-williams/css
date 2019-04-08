<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Individual Completion</h3><br />
                    <span>See what individuals are still awaiting scores</span>
                </div>

                <div class="box-body">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" @click="fetchData">
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
    data() {
        return {
            columns: [
                { title: 'Event', field: 'event_name', sortable: true },
                { title: 'Category', field: 'category_name', sortable: true },
                { title: 'Team', field: 'company_name', sortable: true },
                { title: 'Name', field: 'contact_name', sortable: true },
            ],
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
    },
    watch: {
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        }
    },
    methods: {
        ...mapActions('IndividualCompletionsIndex', ['fetchData', 'setQuery', 'resetState']),
    }
}</script>

<style lang="css" scoped>
</style>
