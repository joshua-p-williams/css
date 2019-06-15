<template>
    <section class="content-wrapper">
        <section class="content-header no-print">
            <h1>Settings</h1>
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
                                    <label for="score">Top Scores Per Team to Keep *</label>
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="topScoresKeep"
                                            placeholder="Enter the number of top scores per team to keep"
                                            :value="item.top_scores_keep"
                                            @input="updateTopScoresKeep"
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
        ...mapGetters('SettingsIndex', ['item', 'loading', ]),
    },
    created() {
        this.fetchData()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('SettingsIndex', ['fetchData', 'updateData', 'resetState', 'setTopScoresKeep']),
        updateTopScoresKeep(e) {
            this.setTopScoresKeep(e.target.value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
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
