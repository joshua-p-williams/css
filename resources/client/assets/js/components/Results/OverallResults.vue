<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Overall Results</h3><br />
                    <span>See the top scores overall</span>
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
    props: ['category'],
    data() {
        return {
            query: { sort: null, order: null },
            xprops: {
                module: 'OverallResultsIndex',
                route: 'overallResults',
                permission_prefix: 'overallResult_'
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
        ...mapGetters('OverallResultsIndex', ['data', 'total', 'loading', 'relationships']),
        columns: function () {
            let columns = [
                { title: 'Team', field: 'company_name', sortable: false },
                { title: 'Name', field: 'contact_name', sortable: false },
                { title: 'Score', field: 'score', sortable: false },
                { title: 'Tie 1', field: 'tie_breaker_1', sortable: false },
                { title: 'Tie 2', field: 'tie_breaker_2', sortable: false },
                { title: 'Tie 3', field: 'tie_breaker_3', sortable: false },
                { title: 'Tie 4', field: 'tie_breaker_4', sortable: false },
            ];

            if (!this.category) {
                columns.push({ title: 'Category', field: 'category_name', sortable: false });
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
        category: function (newVal, oldVal) {
            this.refresh();
        },
    },
    methods: {
        ...mapActions('OverallResultsIndex', ['fetchData', 'setQuery', 'resetState']),
        refresh: function () {
            let constraints = this.category ? {categoryId: this.category.id} : null;
            this.fetchData(constraints);
        }
    }
}</script>

<style lang="css" scoped>
</style>
