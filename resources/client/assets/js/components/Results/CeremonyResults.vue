<template>
    <div class="row">
        <div class="col-xs-12">
            <!-- div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Ceremony Results</h3><br />
                </div>

                <div class="box-body" v-if="!loading">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" @click="refresh">
                            <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
                        </button>
                    </div>
                </div>
            </div -->

            <div class="box" v-if="!loading && !data">
                <div class="box-body">
                    No Results Submitted
                </div>
            </div>

            <div v-if="!loading && data">
                <div v-for="group in data.groups" v-if="data[group]">

                    <div class="box">
                        <div class="box-header with-border box-header-emphasize">
                            <h3>{{group}}</h3>
                        </div>
                    </div>

                    <div class="box" v-for="(eventDetails, eventName) in data[group].data" :key="eventDetails.id">

                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>{{group}}</strong> - <em>{{eventName}}</em></h3>
                        </div>

                        <span v-if="!eventDetails.categories">No Results</span>

                        <div class="box-body" v-for="(categoryDetails, categoryName) in eventDetails.categories" :key="categoryDetails.id" v-if="categoryDetails.results.length">
                            <h4 class="box-title"><strong><u>{{categoryName}}</u></strong></h4>

                            <span v-if="!categoryDetails.results.length">No Results</span>

                            <table class="table table-striped table-hover" v-if="categoryDetails.results.length">
                                <thead>
                                    <tr>
                                        <th v-for="(columnName, columnHeader) in data[group].columns">
                                            {{columnHeader}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="result in categoryDetails.results">
                                        <td v-for="(columnName, columnHeader) in data[group].columns">
                                            {{result[columnName]}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            query: { sort: null, order: null },
            xprops: {
                module: 'CeremonyResultsIndex',
                route: 'ceremonyResults',
                permission_prefix: 'ceremonyResult_'
            }
        }
    },
    created() {
        this.refresh()
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('CeremonyResultsIndex', ['data', 'loading', 'relationships']),
    },
    watch: {
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        },
    },
    methods: {
        ...mapActions('CeremonyResultsIndex', ['fetchData', 'setQuery', 'resetState']),
        refresh: function () {
            this.fetchData();
        }
    }
}</script>

<style lang="css" scoped>
.box-header.box-header-emphasize {
    background-color: #222d32;
    font-weight: 900;
    color: white;
    text-align: center;
    font-size: 30px;
}
</style>
