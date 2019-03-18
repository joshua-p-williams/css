<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Teams</h1>
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
                                    <label for="name">Team Name *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter Team Name *"
                                            :value="item.name"
                                            @input="updateName"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="category">Category *</label>
                                    <v-select
                                            name="category"
                                            label="name"
                                            @input="updateCategory"
                                            :value="item.category"
                                            :options="categoriesAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="primary_contact_name">Primary Contact Name *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="primary_contact_name"
                                            placeholder="Enter Primary Contact Name *"
                                            :value="item.primary_contact_name"
                                            @input="updatePrimary_contact_name"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="primary_contact_phone">Primary Contact Phone</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="primary_contact_phone"
                                            placeholder="Enter Primary Contact Phone"
                                            :value="item.primary_contact_phone"
                                            @input="updatePrimary_contact_phone"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="primary_contact_email">Primary Contact Email</label>
                                    <input
                                            type="email"
                                            class="form-control"
                                            name="primary_contact_email"
                                            placeholder="Enter Primary Contact Email"
                                            :value="item.primary_contact_email"
                                            @input="updatePrimary_contact_email"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="state"
                                            placeholder="Enter State"
                                            :value="item.state"
                                            @input="updateState"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="county">County</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="county"
                                            placeholder="Enter County"
                                            :value="item.county"
                                            @input="updateCounty"
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
        ...mapGetters('ContactCompaniesSingle', ['item', 'loading', 'categoriesAll']),
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
        ...mapActions('ContactCompaniesSingle', ['fetchData', 'updateData', 'resetState', 'setName', 'setCategory', 'setPrimary_contact_name', 'setPrimary_contact_phone', 'setPrimary_contact_email', 'setState', 'setCounty']),
        updateName(e) {
            this.setName(e.target.value)
        },
        updateCategory(value) {
            this.setCategory(value)
        },
        updatePrimary_contact_name(e) {
            this.setPrimary_contact_name(e.target.value)
        },
        updatePrimary_contact_phone(e) {
            this.setPrimary_contact_phone(e.target.value)
        },
        updatePrimary_contact_email(e) {
            this.setPrimary_contact_email(e.target.value)
        },
        updateState(e) {
            this.setState(e.target.value)
        },
        updateCounty(e) {
            this.setCounty(e.target.value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'contact_companies.index' })
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
