<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Participants</h1>
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
                                    <label for="company">Team *</label>
                                    <v-select
                                            name="company"
                                            label="name"
                                            @input="updateCompany"
                                            :value="item.company"
                                            :options="contactcompaniesAll"
                                            />
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
                                    <label for="name">Name *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter Name *"
                                            :value="item.name"
                                            @input="updateName"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="phone"
                                            placeholder="Enter Phone"
                                            :value="item.phone"
                                            @input="updatePhone"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="email"
                                            placeholder="Enter Email"
                                            :value="item.email"
                                            @input="updateEmail"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="address"
                                            placeholder="Enter Address"
                                            :value="item.address"
                                            @input="updateAddress"
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
        ...mapGetters('ContactsSingle', ['item', 'loading', 'contactcompaniesAll', 'categoriesAll']),
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
        ...mapActions('ContactsSingle', ['fetchData', 'updateData', 'resetState', 'setCompany', 'setCategory', 'setName', 'setPhone', 'setEmail', 'setAddress']),
        updateCompany(value) {
            this.setCompany(value)
        },
        updateCategory(value) {
            this.setCategory(value)
        },
        updateName(e) {
            this.setName(e.target.value)
        },
        updatePhone(e) {
            this.setPhone(e.target.value)
        },
        updateEmail(e) {
            this.setEmail(e.target.value)
        },
        updateAddress(e) {
            this.setAddress(e.target.value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'contacts.index' })
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
