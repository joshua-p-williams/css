<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Teams</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View</h3>
                        </div>

                        <div class="box-body">
                            <back-buttton></back-buttton>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <th>#</th>
                                            <td>{{ item.id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Team Name</th>
                                            <td>{{ item.name }}</td>
                                            </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>
                                                <span class="label label-info" v-if="item.category !== null">
                                                    {{ item.category.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Primary Contact Name</th>
                                            <td>{{ item.primary_contact_name }}</td>
                                            </tr>
                                        <tr>
                                            <th>Primary Contact Phone</th>
                                            <td>{{ item.primary_contact_phone }}</td>
                                            </tr>
                                        <tr>
                                            <th>Primary Contact Email</th>
                                            <td>{{ item.primary_contact_email }}</td>
                                            </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ item.state }}</td>
                                            </tr>
                                        <tr>
                                            <th>County</th>
                                            <td>{{ item.county }}</td>
                                            </tr>
                                        <tr>
                                            <th>Exclude From Team Rank</th>
                                            <td>{{ item.excludeTeamRank }}</td>
                                            </tr>
                                        <tr>
                                            <th>Exclude From Individual Rank</th>
                                            <td>{{ item.excludeIndRank }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('TeamsSingle', ['item'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('TeamsSingle', ['fetchData', 'resetState'])
    }
}
</script>


<style scoped>

</style>
